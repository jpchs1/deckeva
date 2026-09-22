# Funciones de FTP compartidas por los pasos del workflow de deploy.
#
# Se carga con `source`. Espera en el entorno:
#   FTP_HOST, FTP_USER, LFTP_PASSWORD   credenciales (la contraseña va por
#                                       variable de entorno, no en la línea de
#                                       comandos: así no aparece en ps ni en logs)
#   ALCANCE                             "todo" o "mu-plugins"
#   FTP_VERIFICAR_CERT                  opcional, "no" para no validar el certificado
#   FTP_URL                             opcional, para pruebas: sustituye a la
#                                       conexión FTPS (p. ej. file:///tmp/servidor)

verificar_cert="yes"
[ "${FTP_VERIFICAR_CERT:-}" = "no" ] && verificar_cert="no"

# Pares "directorio local|ruta remota" según el alcance.
if [ "${ALCANCE:-todo}" = "mu-plugins" ]; then
  PARES=("_deploy/deckeva.cl/wp-content/mu-plugins|deckeva.cl/wp-content/mu-plugins")
else
  PARES=("_deploy/deckeva.cl|deckeva.cl" "_deploy/deckeva.com|deckeva.com")
fi

# ftp_ejecutar "<comandos lftp>"
# Abre la conexión y ejecuta los comandos. Devuelve el código de salida de lftp.
ftp_ejecutar() {
  local conexion
  if [ -n "${FTP_URL:-}" ]; then
    conexion="open '${FTP_URL}'"
  else
    conexion="open --env-password -u '${FTP_USER}' '${FTP_HOST}'"
  fi

  lftp -c "
    set ftp:ssl-force true;
    set ftp:ssl-protect-data true;
    set ssl:verify-certificate ${verificar_cert};
    set ftp:passive-mode true;
    set ftp:list-options -a;
    set net:max-retries 3;
    set net:timeout 20;
    ${conexion};
    $1
  "
}

# ftp_comprobar_acceso <ruta-remota>
#
# Falla si no se puede conectar, si las credenciales no sirven o si la carpeta
# no existe. Hace falta porque el simulacro de lftp NO falla en esos casos:
# comprobado con lftp 4.9.2, ante un servidor inalcanzable da por hecho que la
# carpeta remota está vacía, lista "todo por subir" y sale con código 0.
ftp_comprobar_acceso() {
  local remoto="$1" salida
  if ! salida=$(ftp_ejecutar "cls -1 '${remoto}'" 2>&1); then
    echo "No se pudo acceder a '${remoto}' en el servidor." >&2
    echo "Causas habituales: FTP_HOST o credenciales incorrectas, o FTP_BASE mal puesto." >&2
    echo "${salida}" | tail -3 >&2
    return 1
  fi
}

# ftp_diferencias <directorio-local> <ruta-remota>
#
# Lista, relativos al directorio, los archivos que en el servidor faltan o
# tienen otro tamaño. Salida vacía = el servidor tiene lo mismo que el local.
#
# Si no puede mirar, DEVUELVE ERROR en vez de una lista vacía: una lista vacía
# significa "todo igual", y confundir "no pude mirar" con "todo igual" es justo
# el tipo de fallo silencioso que no nos podemos permitir.
ftp_diferencias() {
  local local_dir="$1" remoto="$2" salida

  ftp_comprobar_acceso "${remoto}" || return 1

  if ! salida=$(ftp_ejecutar "mirror --reverse --dry-run --ignore-time --no-perms '${local_dir}' '${remoto}'" 2>&1); then
    echo "No se pudo comparar ${remoto} con el servidor:" >&2
    echo "${salida}" | tail -3 >&2
    return 1
  fi

  # En simulacro lftp imprime el comando de cada transferencia. En una subida
  # (mirror --reverse) lftp 4.9.2 lo escribe como "get -O <destino> file:<local>",
  # no como "put": se aceptan los dos para no depender de la versión. El último
  # campo es el archivo local; se deja relativo al directorio que se sube.
  printf '%s\n' "${salida}" \
    | awk '$1 == "get" || $1 == "put" { print $NF }' \
    | sed -e 's#^file:##' -e "s#^.*${local_dir}/##" \
    | sort
}
