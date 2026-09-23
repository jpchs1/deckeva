#!/usr/bin/env bash
# Diagnóstico del servidor por FTP: qué hay en mu-plugins, qué cambió hace poco,
# cuáles son los últimos errores fatales de PHP y si la web registró fallos al
# enviar correo.
#
# Existe porque el hosting no da SSH: cuando WordPress muestra "Ha habido un
# error crítico", la causa solo está en los logs del servidor.
#
# El repo es público y los logs de Actions también, así que de los logs de PHP
# solo se imprimen errores fatales y avisos propios recortados, con correos e IPs
# tapados.
#
# Espera en el entorno lo mismo que ftp.sh (FTP_HOST, FTP_USER, LFTP_PASSWORD,
# FTP_BASE, FTP_VERIFICAR_CERT) y, opcional, LINEAS.
set -uo pipefail

source "$(dirname "$0")/ftp.sh"

base="${FTP_BASE:-}"
lineas="${LINEAS:-30}"
[[ "${lineas}" =~ ^[0-9]+$ ]] || lineas=30
tmp="$(mktemp -d)"
trap 'rm -rf "${tmp}"' EXIT

tapar() {
  sed -E \
    -e 's/[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,}/<correo>/g' \
    -e 's/([0-9]{1,3}\.){3}[0-9]{1,3}/<ip>/g' \
    -e 's/\+[0-9][0-9 ]{7,}[0-9]/<telefono>/g' \
    | cut -c1-600
}

listar() {
  local titulo="$1" ruta="$2" cuantas="$3"
  echo
  echo "── ${titulo} (${ruta}) ──"
  ftp_ejecutar "cls -l --sort=date '${base}${ruta}'" 2>&1 | head -n "${cuantas}" | tapar
}

ftp_comprobar_acceso "${base}deckeva.cl" || exit 1

listar "mu-plugins, lo más reciente primero" "deckeva.cl/wp-content/mu-plugins/" 30
listar "Plugins modificados hace poco" "deckeva.cl/wp-content/plugins/" 12
listar "Temas" "deckeva.cl/wp-content/themes/" 10
listar "Traducciones modificadas hace poco" "deckeva.cl/wp-content/languages/" 12
listar "Traducciones de plugins modificadas hace poco" "deckeva.cl/wp-content/languages/plugins/" 12
listar "Raíz de deckeva.cl" "deckeva.cl/" 40
listar "Logs del usuario" "logs/" 20

# Candidatos: los error_log que PHP deja junto al script y los de cPanel.
candidatos=(
  "deckeva.cl/error_log"
  "deckeva.cl/wp-admin/error_log"
  "deckeva.cl/wp-content/debug.log"
)
while IFS= read -r nombre; do
  [ -n "${nombre}" ] && candidatos+=("logs/${nombre}")
done < <(ftp_ejecutar "cls -1 '${base}logs/'" 2>/dev/null | sed 's#.*/##' | grep -i 'error' || true)

for remoto in "${candidatos[@]}"; do
  local_f="${tmp}/log"
  rm -f "${local_f}"
  echo
  echo "── Errores fatales en ${remoto} (últimos ${lineas}) ──"
  if ! ftp_ejecutar "get '${base}${remoto}' -o '${local_f}'" >/dev/null 2>&1 || [ ! -s "${local_f}" ]; then
    echo "(no existe o está vacío)"
    continue
  fi
  echo "Tamaño: $(wc -c < "${local_f}") bytes · última línea: $(tail -n 1 "${local_f}" | cut -c1-40 | tapar)"
  grep -E 'PHP (Fatal|Parse) error|Uncaught|critical|Allowed memory' "${local_f}" \
    | tail -n "${lineas}" | tapar || echo "(sin errores fatales)"

  # Avisos propios ([Deckeva Correo], [Deckeva INT PDF]…) y fallos de mail() de
  # PHP: responden a "¿la web llegó a entregar el correo al servidor?". De los
  # propios se imprime solo la fecha, la etiqueta y el texto fijo hasta el primer
  # "(" o ":", porque lo que sigue es el asunto o los destinatarios, con nombres
  # de clientes.
  echo
  echo "── Avisos de correo y PDF en ${remoto} (últimos ${lineas}) ──"
  avisos="$(perl -ne '
      if (/^(\[[^\]]*\] )?.*?(\[Deckeva [^\]]+\] )([^(:\r\n]*)/) { print "$1$2$3\n"; }
      elsif (/PHP Warning:\s+mail\(\)/) { print; }
    ' "${local_f}" | tail -n "${lineas}" | tapar)"
  echo "${avisos:-(ninguno)}"
done

# Contactos en una ventana de tiempo (UTC), para saber si una caída del correo
# dejó clientes sin respuesta. Solo se imprime cuántos hubo por origen: el
# registro de leads tiene datos de clientes y no sale del runner.
if [ -n "${VENTANA_LEADS:-}" ]; then
  echo
  echo "── Contactos en la ventana ${VENTANA_LEADS} (UTC) ──"
  patron='^[0-9]{4}-[0-9]{2}-[0-9]{2}T[0-9]{2}:[0-9]{2}:[0-9]{2}Z$'
  desde="${VENTANA_LEADS%%/*}"
  hasta="${VENTANA_LEADS##*/}"
  if [[ ! "${desde}" =~ ${patron} || ! "${hasta}" =~ ${patron} ]]; then
    echo "Ventana inválida: se espera AAAA-MM-DDTHH:MM:SSZ/AAAA-MM-DDTHH:MM:SSZ."
    exit 1
  fi
  # Un archivo por mes (leads-AAAA-MM.log); la ventana puede cruzar un cambio de mes.
  archivos=()
  for mes in $(printf '%s\n%s\n' "${desde:0:7}" "${hasta:0:7}" | sort -u); do
    local_f="${tmp}/leads-${mes}.log"
    if ftp_ejecutar "get '${base}deckeva.cl/wp-content/uploads/deckeva-leads/leads-${mes}.log' -o '${local_f}'" >/dev/null 2>&1 \
       && [ -s "${local_f}" ]; then
      archivos+=("${local_f}")
    fi
  done
  if [ "${#archivos[@]}" -eq 0 ]; then
    echo "(no se pudo leer el registro de leads)"
  else
    python3 "$(dirname "$0")/contar-leads.py" "${desde}" "${hasta}" "${archivos[@]}"
  fi
fi
