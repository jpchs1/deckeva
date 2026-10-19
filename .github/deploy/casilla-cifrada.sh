#!/usr/bin/env bash
# Baja por FTP los correos que llegaron a una casilla del hosting en una ventana
# corta de tiempo y los entrega cifrados, para que una sesión de Claude los lea.
#
# Existe porque contacto@deckeva.cl vive en el cPanel de BanaHosting (Maildir en
# ~/mail/<dominio>/<usuario>) y no se reenvía a Gmail, y el conector de Gmail
# lee el texto de un correo pero no baja sus adjuntos. El caso (19-oct-2026):
# un cliente mandó 18 planos .dwg de su embarcación para cotizar el piso, y hacía
# falta abrirlos para sacar las medidas de cada pieza.
#
# Se pide por ventana de llegada y no "todo lo de los últimos días" a propósito:
# así sale sólo el correo que hace falta y no los de otros clientes. Tope: 6 h.
#
# El repo, sus logs y sus artefactos son públicos, así que los correos NUNCA
# salen en claro: se empaquetan y se cifran con `age` para la clave pública que
# se pasa al lanzar el workflow; la clave privada vive sólo en quien lo pidió.
# En el log sólo se imprime cuántos correos son y cuánto pesa el paquete, nunca
# nombres, asuntos ni remitentes.
#
# Espera en el entorno lo mismo que ftp.sh (FTP_HOST, FTP_USER, LFTP_PASSWORD,
# FTP_BASE, FTP_VERIFICAR_CERT) y además:
#   CASILLA        dominio/usuario, p. ej. deckeva.cl/contacto
#   VENTANA        AAAA-MM-DDTHH:MM:SSZ/AAAA-MM-DDTHH:MM:SSZ (UTC, hora de llegada)
#   DESTINATARIO   clave pública age (age1…)
#   SALIDA         ruta del archivo cifrado a escribir
set -uo pipefail

source "$(dirname "$0")/ftp.sh"

base="${FTP_BASE:-}"
casilla="${CASILLA:-deckeva.cl/contacto}"
ventana="${VENTANA:-}"
destinatario="${DESTINATARIO:-}"
salida="${SALIDA:-correos.tar.gz.age}"

# Se validan antes de meterlos en un comando de lftp: van entre comillas
# simples y un valor raro podría colar otro comando.
if [[ ! "${casilla}" =~ ^[a-z0-9.-]+/[a-z0-9._-]+$ ]]; then
  echo "Casilla inválida: se espera dominio/usuario, p. ej. deckeva.cl/contacto." >&2
  exit 1
fi
patron='^[0-9]{4}-[0-9]{2}-[0-9]{2}T[0-9]{2}:[0-9]{2}:[0-9]{2}Z$'
desde="${ventana%%/*}"
hasta="${ventana##*/}"
if [[ ! "${desde}" =~ ${patron} || ! "${hasta}" =~ ${patron} ]]; then
  echo "Ventana inválida: se espera AAAA-MM-DDTHH:MM:SSZ/AAAA-MM-DDTHH:MM:SSZ." >&2
  exit 1
fi
desde_s="$(date -u -d "${desde}" +%s)" || exit 1
hasta_s="$(date -u -d "${hasta}" +%s)" || exit 1
if (( hasta_s <= desde_s || hasta_s - desde_s > 6 * 3600 )); then
  echo "Ventana inválida: el final va después del inicio y caben 6 horas como máximo." >&2
  exit 1
fi
if [[ ! "${destinatario}" =~ ^age1[0-9a-z]{58}$ ]]; then
  echo "Destinatario inválido: se espera una clave pública age (age1…)." >&2
  exit 1
fi

remoto="${base}mail/${casilla}/"
tmp="$(mktemp -d)"
trap 'rm -rf "${tmp}"' EXIT
mkdir -p "${tmp}/casilla"

ftp_comprobar_acceso "${remoto}" || exit 1

# En Maildir la hora de llegada va al principio del nombre de cada archivo
# (lo mismo que usa diagnostico.sh). Sólo la bandeja de entrada: cur/ y new/.
total=0
for carpeta in new cur; do
  while IFS= read -r nombre; do
    llegada="${nombre%%.*}"
    [[ "${llegada}" =~ ^[0-9]+$ ]] || continue
    (( llegada >= desde_s && llegada < hasta_s )) || continue
    total=$((total + 1))
    mkdir -p "${tmp}/casilla/${carpeta}"
    if ! ftp_ejecutar "get '${remoto}${carpeta}/${nombre}' -o '${tmp}/casilla/${carpeta}/${total}.eml'" </dev/null >/dev/null 2>&1; then
      echo "No se pudo bajar uno de los correos de la ventana." >&2
      exit 1
    fi
  done < <(ftp_ejecutar "cls -1 '${remoto}${carpeta}/'" 2>/dev/null | sed 's#.*/##')
done

echo "Correos que llegaron a ${casilla} en la ventana: ${total}"
if [ "${total}" -eq 0 ]; then
  echo "No hay correos en esa ventana." >&2
  exit 1
fi

tar -C "${tmp}" -czf - casilla | age -r "${destinatario}" -o "${salida}"
echo "Paquete cifrado: $(du -h "${salida}" | cut -f1)"
