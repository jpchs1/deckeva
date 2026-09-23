# Sesión 10: La galería de Proyectos pasa a mostrar nuestras propias fotos

## Punto de partida

`/proyectos/` enseñaba nueve tarjetas y las nueve tiraban de recortes de Elementor
(`wp-content/uploads/elementor/thumbs/…`): miniaturas de unos 400 px de lado, una
foto por embarcación y sin forma de ver el trabajo por dentro. Para una página que
se titula «Proyectos realizados» y que remata con «¿Listo para que tu lancha esté
en esta galería?», eso es poco: el visitante que duda no llega a ver un piso
terminado de cerca.

El dueño compartió el álbum de Google Fotos del taller — 300 imágenes tomadas
entre diciembre de 2020 y febrero de 2025, todas mezcladas.

## Qué se hizo

### 1. Separar el álbum por embarcación

Las 300 fotos se agruparon **por trabajo**, no por fecha: un mismo proyecto puede
repartirse en semanas (la Starcraft tiene el casco rayado del 8 de octubre, la
pintura del 15 y el piso del 26 de noviembre) y dos lanchas distintas pueden
pasar por el taller el mismo día. La fecha de captura ordenó el álbum; la revisión
foto a foto decidió los cortes.

Salieron 23 proyectos. De ellos se publican 12: los que muestran trabajo
terminado. Quedan fuera las tomas de medidas, los desarmes sin resultado a la
vista y nueve capturas de pantalla y planos que no son fotos de obra.

Tres de los proyectos del álbum ya tenían tarjeta en la página, y se supo por la
fecha del archivo de Elementor, que calza al minuto con la foto del álbum:

| Tarjeta publicada | Archivo de Elementor | Foto del álbum |
|---|---|---|
| Lancha Starcraft · Pintado, Chile | `20211114_150407` | 14-11-2021 15:04 |
| Embarcación a medida · Lago Rapel | `20211206_164209` | 06-12-2021 16:42 |
| Semirrígido · Lago Ranco | `WhatsApp-…-2022-10-18-at-11.52.38` | 18-10-2022 11:46–11:54 |

Esas tres conservan **nombre, lugar y etiqueta tal cual estaban** y solo cambian
de foto. Las seis tarjetas restantes (Yamaha 242, Velero Dufour, Sea Ray Sundancer
240, Yamaha AR190, Semirrígido de Vichuquén y Monterey 258SS) se quedan intactas:
sus embarcaciones no aparecen en el álbum y no hay con qué sustituirlas.

A los nueve proyectos nuevos se les puso un nombre descriptivo y verdadero
(«Bowrider — piso teca», «Velero — cubierta completa»). **No se inventó ningún
modelo ni ninguna ubicación**: donde no consta el dato, dice «Chile».

### 2. Revelar las fotos sin disfrazarlas

La propia página promete «Sin filtros, sin retoques», así que el proceso
(`staging/img/proyectos/`, 87 fotos + 12 portadas) se limita a lo que haría
cualquiera al revelar una foto de celular:

- niveles automáticos con recorte del 0,5 % en cada extremo;
- corrección de exposición **solo** si la foto está claramente oscura o quemada, y
  con tope del 12 % para que no se note la mano;
- 6 % de saturación, porque la teca se ve más viva en persona que en la foto;
- reducción a 1200 px de lado largo y máscara de enfoque para devolver el filo que
  se pierde al reducir.

Nada de virados, recortes creativos ni cielos cambiados.

**Se borra el EXIF de todas.** Estas fotos se tomaron en casas de clientes y
varias llevaban coordenadas GPS: eso no puede acabar publicado. La rotación se
aplica antes de descartarlo, para que las verticales no salgan tumbadas.

### 3. Un visor para entrar en cada proyecto

Las tarjetas con galería pasan de `<div>` a `<button>` y abren un visor con las
fotos de esa embarcación: flechas, teclado (`Esc`, ←, →), deslizar en el teléfono
y cierre al tocar fuera. Las imágenes se piden **al abrir el visor**, no al cargar
la página: la grilla sigue bajando solo las 12 portadas. Las seis tarjetas
antiguas siguen siendo `<div>` y no abren nada, que es lo correcto: tienen una
sola foto.

## Despliegue

Las imágenes viven en `staging/img/proyectos/` y se sirven desde **deckeva.com**,
igual que las de `lifestyle`, aunque la página esté en deckeva.cl. Por eso se
referencian con URL absoluta.

El mapeo se añadió **en los dos sitios**, como manda la casa: `.cpanel.yml` y
`.github/deploy/preparar-arbol.sh`.

## Verificación

- `preparar-arbol.sh` arma el árbol completo: 140 archivos en deckeva.com, con las
  99 imágenes dentro.
- La página renderizada en Chromium: 18 tarjetas (12 con galería, 6 antiguas), el
  visor abre, avanza y cierra.
- Sin errores de JavaScript nuevos. El `TypeError: … reading 'addEventListener'`
  que aparece en consola **ya estaba** en la página publicada: se reproduce igual
  en la versión de `main-branch` sin tocar. No se arregla aquí para no mezclar
  cosas; queda anotado.

## Pendiente

- Los nombres de los nueve proyectos nuevos son descriptivos. Si el dueño sabe el
  modelo y el lago de cada uno, cambiarlos es editar una línea por tarjeta en
  `staging/page-proyectos.html`.
- Quedan 11 proyectos del álbum sin publicar (tomas de medidas, desarmes). Sirven
  para un futuro apartado de «cómo trabajamos», no para «proyectos realizados».
- El `addEventListener` sobre un elemento que no existe, en la propia página.
