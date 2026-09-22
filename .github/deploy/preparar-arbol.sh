#!/usr/bin/env bash
#
# Arma, en local, los dos árboles que se van a subir por FTP: uno por dominio.
#
# Replica exactamente lo que hace .cpanel.yml, que es el mapeo bueno de qué
# archivo del repo va a qué ruta del servidor. Se separa del workflow para poder
# ejecutarlo y revisar el resultado sin tocar nada remoto.
#
#   uso: .github/deploy/preparar-arbol.sh <directorio-destino>
#
# Deja <destino>/deckeva.cl y <destino>/deckeva.com listos para subir.

set -euo pipefail

DESTINO="${1:-_deploy}"
CL="${DESTINO}/deckeva.cl"
COM="${DESTINO}/deckeva.com"

rm -rf "${DESTINO}"
mkdir -p "${CL}" "${COM}"

copiados=0
faltan=0

# copiar <origen> <destino-completo>
copiar() {
  local origen="$1" destino="$2"
  if [ ! -e "$origen" ]; then
    echo "  FALTA: ${origen}" >&2
    faltan=$((faltan + 1))
    return
  fi
  mkdir -p "$(dirname "$destino")"
  cp "$origen" "$destino"
  copiados=$((copiados + 1))
}

# copiar_dir <directorio-origen> <directorio-destino>
copiar_dir() {
  local origen="$1" destino="$2"
  if [ ! -d "$origen" ]; then
    echo "  FALTA (directorio): ${origen}" >&2
    faltan=$((faltan + 1))
    return
  fi
  mkdir -p "$destino"
  cp -R "${origen}/." "${destino}/"
  copiados=$((copiados + 1))
}

echo "── deckeva.com ──"

# Home internacional. En este servidor el DirectoryIndex prefiere
# deckeva-international.html sobre index.html, así que van los dos con el mismo
# contenido para que / y ambos nombres sirvan lo mismo.
copiar staging/index-com.html "${COM}/index.html"
copiar staging/index-com.html "${COM}/deckeva-international.html"

# Favicons e iconos web-app, en la raíz de los dos dominios.
copiar_dir assets/icons "${COM}"

copiar guia/index.html          "${COM}/guia/index.html"
copiar guia/styles.css          "${COM}/guia/styles.css"
copiar guia/script.js           "${COM}/guia/script.js"
copiar guia/medir/index.html    "${COM}/guia/medir/index.html"
copiar guia/instalar/index.html "${COM}/guia/instalar/index.html"

copiar wiretransfers/index.html "${COM}/wiretransfers/index.html"

copiar pago/index.html        "${COM}/pago/index.html"
copiar pago/deckeva-pago.css  "${COM}/pago/deckeva-pago.css"
copiar pago/deckeva-pago.js   "${COM}/pago/deckeva-pago.js"
copiar pago/webpay-return.php "${COM}/pago/webpay-return.php"

copiar staging/index.html "${COM}/staging/index.html"
copiar staging/.htaccess  "${COM}/staging/.htaccess"
copiar staging/robots.txt "${COM}/staging/robots.txt"
copiar_dir staging/img/lifestyle "${COM}/staging/img/lifestyle"

copiar staging/index-com.html "${COM}/preview-2026/index.html"

echo "── deckeva.cl ──"

copiar_dir assets/icons "${CL}"

copiar pago/index.html        "${CL}/pago/index.html"
copiar pago/deckeva-pago.css  "${CL}/pago/deckeva-pago.css"
copiar pago/deckeva-pago.js   "${CL}/pago/deckeva-pago.js"
copiar pago/webpay-return.php "${CL}/pago/webpay-return.php"

copiar staging/index-cl.html "${CL}/preview-2026/index.html"

# WordPress: tema hijo y nuestros mu-plugins.
copiar wp-content/themes/dt-the7-child/functions.php \
       "${CL}/wp-content/themes/dt-the7-child/functions.php"
copiar_dir wp-content/mu-plugins "${CL}/wp-content/mu-plugins"

# Home estática: reemplaza el render de WordPress en /. WP sigue sirviendo
# /wp-admin/, /blog/*, etc. por mod_rewrite.
copiar staging/index-cl.html "${CL}/index.html"

# Artículos y páginas estáticas. Al existir index.html en la carpeta, el
# mod_rewrite de WordPress ya no captura esa URL.
copiar staging/post-imporlan.html \
       "${CL}/conoce-imporlan-importacion-de-lanchas-y-embarcaciones-desde-usa-a-chile/index.html"
copiar staging/post-servicio-tecnico-electrico-nautico-para-lanchas-y-embarcaciones-deckeva-chile.html \
       "${CL}/servicio-tecnico-electrico-nautico-para-lanchas-y-embarcaciones-deckeva-chile/index.html"
copiar staging/post-restauracion-de-lanchas-en-santiago-chile.html \
       "${CL}/restauracion-de-lanchas-en-santiago-chile/index.html"
copiar staging/post-que-es-sea-dek.html \
       "${CL}/que-es-sea-dek/index.html"
copiar staging/post-por-que-elegir-pisos-de-goma-eva-para-mi-lancha.html \
       "${CL}/por-que-elegir-pisos-de-goma-eva-para-mi-lancha/index.html"
copiar staging/post-por-que-necesitas-un-piso-antideslizante-para-tu-lancha.html \
       "${CL}/por-que-necesitas-un-piso-antideslizante-para-tu-lancha/index.html"
copiar staging/page-blog.html      "${CL}/blog/index.html"
copiar staging/page-imporlan.html  "${CL}/imporlan/index.html"
copiar staging/page-proyectos.html "${CL}/proyectos/index.html"

# dompdf vive solo en el servidor (está en .gitignore). Si se subiera el árbol
# con borrado, se lo llevaría por delante: por eso el envío nunca borra nada.
echo
echo "Entradas copiadas: ${copiados}"
echo "Archivos de la web:"
echo "  deckeva.cl  → $(find "${CL}" -type f | wc -l)"
echo "  deckeva.com → $(find "${COM}" -type f | wc -l)"

if [ "${faltan}" -gt 0 ]; then
  echo
  echo "ERROR: faltan ${faltan} origen(es) en el repo. No se sube un árbol incompleto." >&2
  exit 1
fi
