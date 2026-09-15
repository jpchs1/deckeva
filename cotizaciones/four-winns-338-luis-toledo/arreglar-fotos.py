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


def procesar(origen, destino):
    img = Image.open(origen)
    img = ImageOps.exif_transpose(img)      # respeta la orientación del celular
    img = img.convert("RGB")
    medidas_originales = img.size

    img, recortada = recortar_bordes_negros(img)
    img = encuadrar(img)

    if img.width != ANCHO_SALIDA:
        alto = round(img.height * ANCHO_SALIDA / img.width)
        img = img.resize((ANCHO_SALIDA, alto), Image.LANCZOS)

    img = realzar(img)
    destino.parent.mkdir(parents=True, exist_ok=True)
    img.save(destino, "JPEG", quality=CALIDAD_JPEG, optimize=True, progressive=True)

    return medidas_originales, img.size, recortada


def main():
    base = Path(__file__).resolve().parent
    ap = argparse.ArgumentParser(description="Limpia fotos de WhatsApp para la cotización.")
    ap.add_argument("--entrada", default=base / "fotos" / "originales", type=Path)
    ap.add_argument("--salida", default=base / "fotos" / "procesadas", type=Path)
    args = ap.parse_args()

    if not args.entrada.is_dir():
        sys.exit(f"No existe la carpeta de entrada: {args.entrada}")

    archivos = sorted(
        p for p in args.entrada.iterdir()
        if p.is_file() and p.suffix.lower() in EXTENSIONES
    )
    if not archivos:
        sys.exit(
            f"No hay imágenes en {args.entrada}.\n"
            "Copia ahí las fotos que mandó el cliente y vuelve a ejecutar."
        )

    print(f"Procesando {len(archivos)} imagen(es)…\n")
    for archivo in archivos:
        destino = args.salida / (archivo.stem + ".jpg")
        try:
            antes, despues, recortada = procesar(archivo, destino)
        except Exception as exc:                      # noqa: BLE001
            print(f"  ✗ {archivo.name}: {exc}")
            continue
        nota = "franjas negras recortadas" if recortada else "sin franjas que recortar"
        print(f"  ✓ {archivo.name}")
        print(f"      {antes[0]}x{antes[1]} → {despues[0]}x{despues[1]} ({nota})")
        try:
            print(f"      {destino.relative_to(base)}")
        except ValueError:          # salida fuera de la carpeta del script
            print(f"      {destino}")

    print(f"\nListo. Fotos limpias en: {args.salida}")


if __name__ == "__main__":
    main()
