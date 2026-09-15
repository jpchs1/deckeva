# Cotización DK-2026-0915-FW338 — Four Winns 338 · Luis Toledo

Cotización a medida para el crucero **Four Winns 338** de Luis Toledo (Rancagua),
piso de goma EVA **Gris Claro con líneas negras**, con toma de medidas e instalación en terreno.

## Archivos

| Archivo | Para qué sirve |
|---|---|
| `index.html` | La cotización. Se abre en el navegador y se imprime a PDF para enviar por WhatsApp. |
| `arreglar-fotos.py` | Limpia las fotos que mandó el cliente por WhatsApp. |
| `fotos/originales/` | Aquí van las fotos tal como llegaron. |
| `fotos/procesadas/` | Aquí salen las fotos limpias que usa `index.html`. |

## Paso 1 — Que se vean las fotos

Copie las cuatro fotos del cliente a `fotos/originales/` y ejecute:

```bash
pip install Pillow          # solo la primera vez
python3 arreglar-fotos.py
```

Eso es todo: abra `index.html` y las fotos ya están puestas.

**No hace falta renombrar nada.** Los nombres pueden ser `IMG_4471.jpg`,
`WhatsApp Image 2026-09-14.jpeg` o lo que traigan; el script decide solo qué
foto va en cada hueco. La extensión también da igual (`.jpg`, `.png`, `.heic`…):
siempre entrega `.jpg`.

También puede pasarlas directamente, sin copiarlas antes:

```bash
python3 arreglar-fotos.py ~/Descargas/IMG_*.jpg
```

### Qué hace con cada foto

El cliente mandó capturas de pantalla del iPhone: la foto real ocupa una franja
al centro y el resto es negro, con la hora, la señal, la batería, el contador
"3 de 10" y la X de cerrar. Pegadas tal cual se ven mal en una cotización.

1. Aísla la franja de foto real y descarta todo el negro de relleno. De paso se
   lleva la barra de estado, el contador y la X, porque viven en esa zona negra.
2. Recorta a 4:3 desde el centro, para que las cuatro entren parejas en la grilla.
3. Sube un poco contraste, color y nitidez, y reescala a 1600 px de ancho.
4. Guarda un JPEG optimizado en `fotos/procesadas/`.

### Cómo sabe cuál es cuál

La referencia del piso se distingue sola: es la única que **no** es una captura
de pantalla, así que es la única sin franjas negras. Las tres de la lancha se
reparten en orden de nombre, que es el orden en que las mandó el cliente
("1 de 10", "2 de 10", "3 de 10") → babor, estribor, popa.

Si el reparto no le calza, renombre el archivo con el nombre del hueco y el
script lo respeta: `referencia-piso-gris-claro`, `four-winns-338-babor`,
`four-winns-338-estribor`, `four-winns-338-popa`.

> Mientras falte una foto, el HTML muestra un recuadro rayado en su lugar, nunca
> un ícono roto. La cotización se puede enseñar igual.

## Paso 2 — Generar el PDF

Abra `index.html` en el navegador → Imprimir → Guardar como PDF.
Ya viene configurado para A4 y sale en **2 páginas**. Active **"Gráficos de fondo"**
en el diálogo de impresión, o los fondos oscuros salen en blanco.

## De dónde salen los valores

El tarifario publicado en la web llega hasta 30 pies. El Four Winns 338 queda por
encima, así que se proyectó la misma curva hasta 35 pies **sin cambiar la regla**.

La regla que sigue el tarifario actual (`staging/index-cl.html`, objeto `prices`)
es que el incremento entre un pie y el siguiente crece un porcentaje fijo:

- de 16 a 26 pies, el incremento crece **7%** por pie;
- de 27 pies en adelante, crece **10%** por pie.

Partiendo del último valor real (30 pies = $2.081.312, incremento $180.119) y
aplicando ×1,10 por pie:

| Eslora | Incremento | Valor neto | Origen |
|---|---|---|---|
| 30 pies | $180.119 | $2.081.312 | Tarifario web |
| 31 pies | $198.131 | $2.279.443 | Proyectado |
| 32 pies | $217.944 | $2.497.387 | Proyectado |
| 33 pies | $239.738 | $2.737.125 | Proyectado |
| 34 pies | $263.712 | $3.000.838 | Proyectado |
| **35 pies** | **$290.083** | **$3.290.921** | **Proyectado — el de esta cotización** |

### Total cotizado

| Ítem | Neto |
|---|---|
| Piso EVA a medida, 35 pies | $3.290.921 |
| Toma de medidas en terreno (Rancagua) | $245.000 |
| Instalación en terreno (Rancagua) | $345.000 |
| **Subtotal neto** | **$3.880.921** |
| IVA 19% | $737.375 |
| **Total** | **$4.618.296** |

Los dos ítems de Rancagua se tomaron como **valores netos** y se les aplicó IVA,
igual que al tarifario. Van cobrados aparte porque el tarifario web incluye
traslado solo dentro de la Región Metropolitana, y Rancagua queda fuera.

## Si cambia la eslora

Si en la toma de medidas la lancha resulta de otra eslora, el valor sale de la
misma regla. Para recalcular:

```bash
python3 -c "
d, v = 180119.0, 2081312.0          # incremento y valor a 30 pies
for pie in range(31, 41):
    d *= 1.10; v += d
    print(pie, 'pies: neto \$', f'{round(v):,}'.replace(',', '.'))
"
```
