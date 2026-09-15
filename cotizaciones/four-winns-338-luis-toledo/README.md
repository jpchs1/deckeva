# Cotización DK-2026-0915-FW338 — Four Winns 338 · Luis Toledo

Cotización a medida para el crucero **Four Winns 338** de Luis Toledo (Rancagua),
piso de goma EVA color **Gris Náutico**, con toma de medidas e instalación en terreno.

## Archivos

| Archivo | Para qué sirve |
|---|---|
| `index.html` | La cotización. Se abre en el navegador y se imprime a PDF para enviar por WhatsApp. |
| `arreglar-fotos.py` | Limpia las fotos que mandó el cliente por WhatsApp. |
| `fotos/originales/` | Aquí van las fotos tal como llegaron. |
| `fotos/procesadas/` | Aquí salen las fotos limpias que usa `index.html`. |

## Paso 1 — Arreglar las fotos del cliente

El cliente mandó capturas de pantalla del iPhone: la foto real ocupa una franja
al centro y el resto es negro, con la hora, la señal, la batería, el contador
"3 de 10" y la X de cerrar. Pegadas tal cual se ven mal en una cotización.

Copie las cuatro imágenes a `fotos/originales/` **con estos nombres exactos**,
que son los que busca el HTML:

| Nombre del archivo | Qué imagen es |
|---|---|
| `referencia-piso-gris-nautico` | La referencia de cómo quiere que quede la cubierta (piso EVA gris). |
| `four-winns-338-babor` | La lancha completa de lado — "1 de 10". |
| `four-winns-338-estribor` | La lancha completa del otro lado — "2 de 10". |
| `four-winns-338-popa` | La popa con la plataforma y la escalerilla — "3 de 10". |

La extensión da lo mismo (`.jpg`, `.png`, `.heic`…): el script siempre entrega `.jpg`.

Luego ejecute:

```bash
pip install Pillow          # solo la primera vez
python3 arreglar-fotos.py
```

El script, sobre cada imagen:

1. Detecta la franja de foto real dentro de la captura y descarta todo el negro
   de relleno. De paso se lleva la barra de estado, el contador y la X, porque
   viven dentro de esa zona negra.
2. Recorta a 4:3 desde el centro para que las tres fotos entren parejas en la grilla.
3. Sube un poco contraste, color y nitidez, y reescala a 1600 px de ancho.
4. Guarda un JPEG optimizado en `fotos/procesadas/`.

La imagen de referencia no tiene franjas negras, así que pasa sin recorte: solo
se normaliza el tamaño. El script avisa en pantalla cuál recortó y cuál no.

> Si el HTML no encuentra una foto, muestra un recuadro gris con el nombre de la
> vista en vez de un ícono roto. La cotización se puede enseñar igual mientras
> las fotos no estén listas.

## Paso 2 — Generar el PDF

Abra `index.html` en el navegador → Imprimir → Guardar como PDF.
Ya viene configurado para A4 con márgenes, colores de fondo y cortes de página
en los lugares correctos. Active **"Gráficos de fondo"** en el diálogo de impresión.

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
