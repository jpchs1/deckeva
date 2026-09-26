# Sesión 11: Medición de Meta Ads (Pixel + API de Conversiones)

## Punto de partida

Se va a invertir en publicidad de Meta para Chile (CLP 200.000 al mes). Sin
medición, Meta solo sabe de clics y optimiza por clics: gente que mira y se va.
Lo que interesa es la cotización enviada, y eso ocurre en tres formularios:
el de la home (`/cotizador/enviar-international`), el de `/cotizador/` y los de
Contact Form 7. Todos terminan en `deckeva_record_lead()`.

## Qué se hizo

- **`deckeva-meta-pixel.php`** (mu-plugin nuevo), configurable en
  *Ajustes → Meta Ads*:
  - **Pixel (PageView)** en las páginas de WordPress, en `/cotizador/` y en la
    home estática. La home no pasa por WordPress, así que al guardar el ID se
    escribe `uploads/deckeva-meta/pixel.js` y la home lo carga. Sin ID ese
    archivo no existe: la home pide un 404 inofensivo y no mide nada.
  - **Evento `Lead` desde el servidor** (API de Conversiones) por cada contacto
    real. Un solo punto cubre los tres formularios y no lo tapan los
    bloqueadores. Email y teléfono van cifrados (SHA-256); el teléfono chileno
    se completa con el 56. Se manda al final de la petición, después de
    responder al cliente, para que Meta no retrase el formulario.
  - Descarta: deckeva.com (misma ruta de formulario, pero la campaña es de
    Chile), el antispam, los reenvíos propios (rescate, reactivación) y las
    pruebas con las casillas del negocio. El formulario 1031 se registra dos
    veces por envío; se cuenta un solo Lead por petición.
  - **Código de prueba** para la pestaña *Probar eventos* y botón para mandar un
    Lead de prueba. Mientras el código está puesto, los eventos no cuentan para
    las campañas.
- **`deckeva-00-mail-core.php`**: `deckeva_record_lead()` dispara
  `do_action('deckeva_lead_registrado', $source, $data)`.
- **`deckeva-cotizador.php`** y **`staging/index-cl.html`**: cargan el Pixel.

El ID del Pixel es público. El token no: vive en la base de datos (o en
`wp-config.php` como `DECKEVA_META_CAPI_TOKEN`), nunca en el repo.

## Verificación

- `php -l` de los tres PHP.
- Prueba con WordPress simulado: sin ID no hay etiqueta ni `pixel.js`; con ID se
  escribe; la etiqueta solo sale en deckeva.cl; teléfonos normalizados; email y
  teléfono sin datos en claro; sin token no se envía; un envío del formulario
  1031 = 1 Lead; deckeva.com, casilla propia y antispam = 0.

## Para activarlo

1. *Ajustes → Meta Ads*: ID del Pixel y token (Administrador de eventos →
   Configuración → API de Conversiones → Generar token).
2. Poner el código de *Probar eventos*, pulsar «Enviar un Lead de prueba» y
   verlo llegar. Abrir la home y ver el PageView.
3. **Borrar el código de prueba.**
