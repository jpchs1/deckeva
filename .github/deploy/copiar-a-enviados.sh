#!/usr/bin/env bash
# Copia a la carpeta Enviados de una casilla del hosting un correo que se mandó
# por Resend, para que quede donde JP lo busca.
#
# Existe porque lo que sale por Resend (deckeva.cl verificado el 27-oct-2026)
# no pasa por el servidor de correo de BanaHosting: no queda en «Enviados» de
# contacto@deckeva.cl. Sí llega a la bandeja de entrada la copia oculta a
# contacto@; este script toma esa copia (por su Message-ID) y la deja también
# en .Sent/cur marcada como leída. No borra ni mueve el original.
#
# El repo y sus logs son públicos: se busca por Message-ID (lo genera Resend,
# no trae datos del cliente) y sólo se imprimen conteos y nombres de carpetas.
#
# Espera en el entorno lo mismo que ftp.sh (FTP_HOST, FTP_USER, LFTP_PASSWORD,
# FTP_BASE, FTP_VERIFICAR_CERT) y además:
#   CASILLA      dominio/usuario, p. ej. deckeva.cl/contacto
#   MESSAGE_ID   el Message-ID del correo, con o sin < >
#   VENTANA      AAAA-MM-DDTHH:MM:SSZ/AAAA-MM-DDTHH:MM:SSZ (UTC, máx. 6 h) en que llegó la copia
set -uo pipefail

source "$(dirname "$0")/ftp.sh"

base="${FTP_BASE:-}"
casilla="${CASILLA:-deckeva.cl/contacto}"
mid="${MESSAGE_ID:-}"
mid="${mid#<}"; mid="${mid%>}"
ventana="${VENTANA:-}"

if [[ ! "${casilla}" =~ ^[a-z0-9.-]+/[a-z0-9._-]+$ ]]; then
  echo "Casilla inválida." >&2; exit 1
fi
if [[ ! "${mid}" =~ ^[A-Za-z0-9._@+=-]{10,200}$ ]]; then
  echo "Message-ID inválido." >&2; exit 1
fi
patron='^[0-9]{4}-[0-9]{2}-[0-9]{2}T[0-9]{2}:[0-9]{2}:[0-9]{2}Z$'
desde="${ventana%%/*}"; hasta="${ventana##*/}"
if [[ ! "${desde}" =~ ${patron} || ! "${hasta}" =~ ${patron} ]]; then
  echo "Ventana inválida." >&2; exit 1
fi
desde_s="$(date -u -d "${desde}" +%s)"; hasta_s="$(date -u -d "${hasta}" +%s)"
if (( hasta_s <= desde_s || hasta_s - desde_s > 6 * 3600 )); then
  echo "Ventana inválida: máximo 6 horas." >&2; exit 1
fi

remoto="${base}mail/${casilla}/"
tmp="$(mktemp -d)"
trap 'rm -rf "${tmp}"' EXIT
ftp_comprobar_acceso "${remoto}" || exit 1

# Las carpetas de la casilla son del negocio, no de clientes: se pueden mostrar.
echo "Carpetas de la casilla: $(ftp_ejecutar "cls -1aF '${remoto}'" 2>/dev/null | grep '/$' | sed 's#/$##; s#.*/##' | grep -v '^\.\.\?$' | tr '\n' ' ')"
if ! ftp_ejecutar "cls -1 '${remoto}.Sent/cur/'" >/dev/null 2>&1; then
  echo "No existe la carpeta Enviados (.Sent/cur) en ${casilla}." >&2; exit 1
fi

# Ya está en Enviados? (si el script corre dos veces no se duplica)
encontrado=""
revisar() {  # carpeta → deja en $encontrado el archivo con ese Message-ID
  local carpeta="$1" nombre llegada f
  while IFS= read -r nombre; do
    llegada="${nombre%%.*}"
    [[ "${llegada}" =~ ^[0-9]+$ ]] || continue
    (( llegada >= desde_s && llegada < hasta_s )) || continue
    f="${tmp}/m"
    rm -f "${f}"
    ftp_ejecutar "get '${remoto}${carpeta}${nombre}' -o '${f}'" </dev/null >/dev/null 2>&1 || continue
    # Dovecot puede guardar el correo comprimido con gzip.
    # Sólo las cabeceras (hasta la primera línea en blanco); 2>/dev/null porque
    # grep -q corta la tubería apenas encuentra y zcat avisa «Broken pipe».
    if zcat -f "${f}" 2>/dev/null | sed '/^\r\?$/q' | grep -qiF "${mid}"; then
      encontrado="${nombre}"
      cp "${f}" "${tmp}/correo"
      return 0
    fi
  done < <(ftp_ejecutar "cls -1 '${remoto}${carpeta}'" 2>/dev/null | sed 's#.*/##')
  return 1
}

if revisar ".Sent/cur/"; then
  echo "El correo ya está en Enviados: no se hace nada."
  exit 0
fi
# La bandeja de entrada primero, y después las otras carpetas: un filtro de la
# casilla puede haber movido la copia (el 27-oct-2026 no estaba en la entrada).
carpetas=("new/" "cur/")
while IFS= read -r c; do
  case "${c}" in .|..|.Sent|.Trash|cur|new|tmp) continue ;; esac
  carpetas+=("${c}/new/" "${c}/cur/")
done < <(ftp_ejecutar "cls -1aF '${remoto}'" 2>/dev/null | grep '/$' | sed 's#/$##; s#.*/##')
donde=""
for carpeta in "${carpetas[@]}"; do
  if revisar "${carpeta}"; then donde="${carpeta}"; break; fi
done
if [ -z "${encontrado}" ]; then
  echo "No se encontró la copia del correo en ninguna carpeta (${#carpetas[@]} revisadas) en esa ventana." >&2
  exit 1
fi
echo "La copia estaba en: ${donde%%/*}"

# Mismo nombre base (con la hora de llegada) y bandera S de leído en Enviados.
base_nombre="${encontrado%%:*}"
destino="${base_nombre}.enviados:2,S"
if ! ftp_ejecutar "put '${tmp}/correo' -o '${remoto}.Sent/cur/${destino}'" >/dev/null 2>"${tmp}/error"; then
  echo "No se pudo copiar a Enviados." >&2
  tail -2 "${tmp}/error" | sed -E 's/[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+/<correo>/g' >&2
  exit 1
fi
echo "Copiado a Enviados (.Sent/cur) de ${casilla}: 1 correo."
