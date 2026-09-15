#!/usr/bin/env python3
# -*- coding: utf-8 -*-
"""
Arregla las fotos que envía el cliente por WhatsApp para poder usarlas en una
cotización.

El problema típico: el cliente manda capturas de pantalla del iPhone. La foto
real ocupa una franja al centro y el resto es negro, con la barra de estado
(hora, señal, batería), el contador "3 de 10" y la X de cerrar. Pegar eso tal
cual en una cotización se ve mal.

Qué hace:
  1. Recorta las franjas negras superior e inferior (y de paso se lleva la
     barra de estado y el contador, que viven dentro de esa zona negra).
  2. Recorta también los bordes negros laterales, si los hay.
  3. Endereza el encuadre a una relación 4:3 recortando desde el centro, para
     que todas las fotos entren parejas en la grilla de la cotización.
  4. Corrige un poco contraste y color (las fotos de celular a pleno sol
     suelen salir lavadas) y reescala a un ancho estándar.
  5. Guarda un JPEG optimizado, listo para el HTML y para imprimir a PDF.

Las imágenes que ya vienen bien (por ejemplo el render de referencia) pasan sin
recorte: no encuentra franjas negras y sólo se normaliza el tamaño.

Uso:
    python3 arreglar-fotos.py
    python3 arreglar-fotos.py --entrada fotos/originales --salida fotos/procesadas

Requiere Pillow:  pip install Pillow
"""

import argparse
import sys
from pathlib import Path

try:
    from PIL import Image, ImageEnhance, ImageOps
except ImportError:
    sys.exit("Falta Pillow. Instálalo con:  pip install Pillow")

EXTENSIONES = {".jpg", ".jpeg", ".png", ".webp", ".heic", ".bmp", ".tif", ".tiff"}

# Un píxel se considera "negro de relleno" bajo este nivel de luminancia (0-255).
UMBRAL_NEGRO = 22
# Porcentaje de píxeles negros que debe tener una fila/columna para recortarla.
PROPORCION_NEGRA = 0.985

ANCHO_SALIDA = 1600          # px, suficiente para imprimir la cotización en A4
ASPECTO_SALIDA = 4 / 3       # relación uniforme para la grilla de fotos
CALIDAD_JPEG = 88


def _es_linea_negra(luminancias):
    """True si casi todos los píxeles de la fila/columna son negros."""
    negros = sum(1 for v in luminancias if v <= UMBRAL_NEGRO)
    return negros >= len(luminancias) * PROPORCION_NEGRA


def _banda_mas_larga(es_negra):
    """
    Dada la lista de filas (o columnas) marcadas como negras, devuelve el tramo
    contiguo de NO negras más largo: (inicio, fin) inclusive, o None.

    Buscamos el tramo más largo en vez de recortar desde los bordes porque la
    zona negra del iPhone no es negro puro: lleva la hora, la señal, la batería,
    el contador "3 de 10" y la X. Esas líneas sueltas con texto blanco frenarían
    un recorte por bordes y dejarían medio marco negro dentro de la foto.
    """
    mejor = actual = None
    for i, negra in enumerate(es_negra):
        if negra:
            actual = None
            continue
        actual = (i, i) if actual is None else (actual[0], i)
        if mejor is None or (actual[1] - actual[0]) > (mejor[1] - mejor[0]):
            mejor = actual
    return mejor


def recortar_bordes_negros(img):
    """Aísla la foto real dentro de la captura, descartando el relleno negro."""
    gris = img.convert("L")
    ancho, alto = gris.size
    px = gris.load()

    # Muestreamos columnas/filas en vez de leerlas enteras: es igual de fiable
    # para detectar relleno sólido y mucho más rápido en fotos grandes.
    cols = list(range(0, ancho, max(1, ancho // 160)))
    filas = list(range(0, alto, max(1, alto // 160)))

    banda_v = _banda_mas_larga([_es_linea_negra([px[c, f] for c in cols]) for f in filas])
    if banda_v is None:
        return img, False
    # Si la banda llega al primer/último muestreo, la foto sigue hasta el borde:
    # ajustamos a la imagen real para no perder píxeles por el paso de muestreo.
    arriba = 0 if banda_v[0] == 0 else filas[banda_v[0]]
    abajo = alto - 1 if banda_v[1] == len(filas) - 1 else filas[banda_v[1]]

    # Las columnas se evalúan sólo dentro de la banda vertical ya encontrada,
    # para que el negro de arriba y abajo no contamine la medición.
    filas_banda = [f for f in filas if arriba <= f <= abajo]
    banda_h = _banda_mas_larga(
        [_es_linea_negra([px[c, f] for f in filas_banda]) for c in cols]
    )
    if banda_h is None:
        return img, False
    izq = 0 if banda_h[0] == 0 else cols[banda_h[0]]
    der = ancho - 1 if banda_h[1] == len(cols) - 1 else cols[banda_h[1]]

    # Si el recorte deja menos del 15% de la imagen algo salió mal (una foto
    # genuinamente oscura, por ejemplo): en ese caso no tocamos nada.
    if (abajo - arriba) < alto * 0.15 or (der - izq) < ancho * 0.15:
        return img, False

    recorte = (izq, arriba, min(der + 1, ancho), min(abajo + 1, alto))
    if recorte == (0, 0, ancho, alto):
        return img, False
    return img.crop(recorte), True


def encuadrar(img, aspecto=ASPECTO_SALIDA):
    """Recorta desde el centro hasta dejar la relación de aspecto pedida."""
    ancho, alto = img.size
    actual = ancho / alto
    if abs(actual - aspecto) < 0.01:
        return img
    if actual > aspecto:            # demasiado ancha -> recortamos a los lados
        nuevo_ancho = int(alto * aspecto)
        x = (ancho - nuevo_ancho) // 2
        return img.crop((x, 0, x + nuevo_ancho, alto))
    nuevo_alto = int(ancho / aspecto)   # demasiado alta -> recortamos arriba/abajo
    y = (alto - nuevo_alto) // 2
    return img.crop((0, y, ancho, y + nuevo_alto))


def realzar(img):
    """Contraste, color y nitidez suaves. Sin exagerar: es una foto, no un filtro."""
    img = ImageEnhance.Contrast(img).enhance(1.07)
    img = ImageEnhance.Color(img).enhance(1.06)
    img = ImageEnhance.Sharpness(img).enhance(1.15)
    return img


def preparar(origen):
    """Abre, recorta y encuadra. Devuelve (imagen, medidas originales, recortada)."""
    img = Image.open(origen)
    img = ImageOps.exif_transpose(img)      # respeta la orientación del celular
    img = img.convert("RGB")
    medidas_originales = img.size

    img, recortada = recortar_bordes_negros(img)
    img = encuadrar(img)

    if img.width != ANCHO_SALIDA:
        alto = round(img.height * ANCHO_SALIDA / img.width)
        img = img.resize((ANCHO_SALIDA, alto), Image.LANCZOS)

    return realzar(img), medidas_originales, recortada


def guardar(img, destino):
    destino.parent.mkdir(parents=True, exist_ok=True)
    img.save(destino, "JPEG", quality=CALIDAD_JPEG, optimize=True, progressive=True)


# Los cuatro huecos que muestra index.html, en orden.
HUECOS = [
    ("referencia-piso-gris-claro", "referencia de acabado"),
    ("four-winns-338-babor",       "vista de babor"),
    ("four-winns-338-estribor",    "vista de estribor"),
    ("four-winns-338-popa",        "popa y plataforma"),
]
NOMBRES = [h[0] for h in HUECOS]


def repartir(analizadas):
    """
    Decide qué foto va en cada hueco de la cotización.

    No hace falta renombrar nada antes: la referencia se distingue sola porque
    es la única que NO es una captura de pantalla — las tres de la lancha vienen
    con franjas negras del visor del iPhone y la referencia no. Las capturas se
    reparten en orden de nombre, que es el orden en que las mandó el cliente
    ("1 de 10", "2 de 10", "3 de 10").

    Un archivo ya bautizado con el nombre de un hueco se respeta tal cual.
    """
    asignado = {}
    libres = []

    for datos in analizadas:                      # 1) nombres explícitos
        if datos["ruta"].stem in NOMBRES and datos["ruta"].stem not in asignado:
            asignado[datos["ruta"].stem] = datos
        else:
            libres.append(datos)

    # 2) la referencia: la que no traía franjas negras
    if NOMBRES[0] not in asignado:
        limpias = [d for d in libres if not d["recortada"]]
        if limpias:
            asignado[NOMBRES[0]] = limpias[0]
            libres.remove(limpias[0])

    # 3) el resto, a los huecos de la lancha que queden
    for nombre in NOMBRES[1:]:
        if nombre in asignado or not libres:
            continue
        asignado[nombre] = libres.pop(0)

    return asignado, libres


def main():
    base = Path(__file__).resolve().parent
    ap = argparse.ArgumentParser(
        description="Limpia las fotos del cliente y las deja listas para la cotización.",
        epilog="Los nombres de archivo dan igual: la referencia se reconoce sola.",
    )
    ap.add_argument("fotos", nargs="*", type=Path,
                    help="Fotos a procesar. Si no indicas ninguna, toma las de fotos/originales/.")
    ap.add_argument("--entrada", default=base / "fotos" / "originales", type=Path)
    ap.add_argument("--salida", default=base / "fotos" / "procesadas", type=Path)
    args = ap.parse_args()

    if args.fotos:
        archivos = [f for f in args.fotos if f.is_file() and f.suffix.lower() in EXTENSIONES]
        faltan = [f for f in args.fotos if not f.is_file()]
        for f in faltan:
            print(f"  · no existe, se omite: {f}")
    else:
        if not args.entrada.is_dir():
            sys.exit(f"No existe la carpeta de entrada: {args.entrada}")
        archivos = [f for f in args.entrada.iterdir()
                    if f.is_file() and f.suffix.lower() in EXTENSIONES]

    # Dos comodines que se solapan (*.png y *Image*.png) cuelan el mismo archivo
    # dos veces y descuadran el reparto. Nos quedamos con la primera aparición.
    vistos, unicos = set(), []
    for f in archivos:
        clave = f.resolve()
        if clave not in vistos:
            vistos.add(clave)
            unicos.append(f)
    archivos = sorted(unicos, key=lambda f: f.name.lower())
    if not archivos:
        sys.exit(
            f"No hay imágenes en {args.entrada}.\n\n"
            "Copia ahí las cuatro fotos que mandó el cliente —con el nombre que sea—\n"
            "y vuelve a ejecutar. También puedes pasarlas directamente:\n"
            "    python3 arreglar-fotos.py ~/Descargas/IMG_*.jpg"
        )

    print(f"Analizando {len(archivos)} imagen(es)…\n")
    analizadas = []
    for archivo in archivos:
        try:
            img, antes, recortada = preparar(archivo)
        except Exception as exc:                      # noqa: BLE001
            print(f"  ✗ {archivo.name}: {exc}")
            continue
        analizadas.append({"ruta": archivo, "img": img, "antes": antes, "recortada": recortada})

    if not analizadas:
        sys.exit("Ninguna imagen se pudo abrir.")

    asignado, sobrantes = repartir(analizadas)

    for nombre, rotulo in HUECOS:
        datos = asignado.get(nombre)
        if datos is None:
            print(f"  · {rotulo}: sin foto — la cotización mostrará el recuadro vacío")
            continue
        destino = args.salida / f"{nombre}.jpg"
        guardar(datos["img"], destino)
        a, d = datos["antes"], datos["img"].size
        origen = "recortada" if datos["recortada"] else "ya venía limpia"
        print(f"  ✓ {rotulo}: {datos['ruta'].name}")
        print(f"      {a[0]}x{a[1]} → {d[0]}x{d[1]} ({origen})  →  {nombre}.jpg")

    for datos in sobrantes:
        print(f"  · sobra (la cotización sólo usa cuatro): {datos['ruta'].name}")

    print(f"\nListo. Abre index.html: las fotos ya están puestas.")


if __name__ == "__main__":
    main()
