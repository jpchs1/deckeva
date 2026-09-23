# Sesión 9: Los mensajes de clientes no llegaban a Deckeva

## Síntoma

Varios clientes aseguran haber escrito desde la web y no haber recibido respuesta.
En Deckeva no aparecía ningún correo de esos contactos.

## Causas encontradas

### 1. El aviso al negocio se borraba solo (causa principal)

El formulario de cotización de la home (deckeva.cl y deckeva.com → endpoint
`/cotizador/enviar-international`) avisaba al negocio **únicamente** con una copia
oculta:

```php
'Bcc: ' . $this->bcc_email,   // jpchs1@gmail.com
```

Y el mu-plugin antispam borraba esa línea antes de enviar, porque descartaba toda
cabecera `Bcc:`/`Cc:` que no contuviera `@deckeva.cl` o `@deckeva.com`:

```php
if (!preg_match('/^(bcc|cc)\s*:/i', $header) || strpos($header, '@deckeva.cl') !== false ...)
```

Resultado: **el cliente recibía su cotización con el PDF** (por eso daba por hecho
que había contactado y se quedaba esperando respuesta) y en Deckeva no entraba
absolutamente nada. Ninguna de las dos partes tenía forma de notarlo.

Además, cuando el cliente elegía **WhatsApp** en vez de email, no se enviaba ningún
aviso: si abría el chat y no llegaba a pulsar enviar, la solicitud se perdía entera.

### 2. El antispam marcaba como spam los mensajes normales

La regla anti *header injection* se aplicaba a **todos** los campos del formulario:

```php
preg_match('/(\r|\n|%0a|%0d|bcc:|cc:|to:|content-type:|mime-version:|subject:)/i', $all_content)
```

Con eso quedaba bloqueado como spam, sin enviar nada:

- cualquier mensaje escrito en **más de una línea** (`\n`);
- cualquier mensaje con palabras tan corrientes como **"Asunto:"**, **"presupuesto:"**,
  **"proyecto:"**, **"contacto:"** o **"esto:"** — todas contienen `to:`.

Un mensaje bloqueado no genera correo: Contact Form 7 lo guarda como spam y el
cliente ve un error genérico.

### 3. Avisos dirigidos a una sola casilla, posiblemente sin revisar

Los otros dos formularios avisaban solo a `get_option('admin_email')` (el correo del
administrador de WordPress). Si esa casilla no se revisa o está mal, el mensaje no
llegaba a nadie aunque el cliente sí recibiera su copia.

### 4. Remitente de otro dominio

El email de cotización de CF7 salía como `no-reply@deckeva.com` desde un servidor que
envía por `deckeva.cl`.

**Comprobado en el DNS**: ambos dominios tienen SPF (`v=spf1 ip4:50.31.188.34 +a +mx
ip4:50.31.188.40 include:relay.mailchannels.net ~all`) y `deckeva.cl` tiene DKIM en
`default._domainkey`. Es decir, el desajuste **no** era la causa de que no llegaran los
mensajes: el correo del servidor funciona — las notificaciones de `contacto@imporlan.cl`
llegan sin problema a la misma casilla de Gmail. Alinear el remitente sigue siendo lo
correcto, pero es higiene, no la causa.

Lo que sí falta es **DMARC**: ninguno de los dos dominios tiene registro `_dmarc`.

## Correcciones aplicadas

| Archivo | Cambio |
|---|---|
| `wp-content/mu-plugins/deckeva-00-mail-core.php` *(nuevo)* | Núcleo único de correo: casillas del negocio, remitente alineado al dominio, aviso con `Reply-To` del cliente y registro en disco de cada contacto. |
| `wp-content/mu-plugins/deckeva-antispam-security.php` | La regla anti *header injection* solo mira los campos que viajan en cabeceras (nombre, email, asunto, teléfono); el cuerpo del mensaje ya no se bloquea por tener saltos de línea. El filtro `wp_mail` conserva las copias a casillas propias y descarta solo las ajenas. Límite por IP de 3 → 6 cada 10 min. Palabras de spam con límite de palabra. Cada bloqueo queda registrado con su motivo y su contenido. |
| `wp-content/mu-plugins/deckeva-cotizador.php` | Aviso interno explícito (ya no por `Bcc`) en **todos** los modos, incluido WhatsApp, con los datos del cliente, el PDF y `Reply-To` para responderle directamente. |
| `wp-content/mu-plugins/deckeva-cotizacion-email.php` | Aviso a todas las casillas del negocio en vez de solo a `admin_email`, con `Reply-To` del cliente, y remitente `contacto@deckeva.cl`. |

### Red de seguridad

Todo contacto queda escrito en `wp-content/uploads/deckeva-leads/leads-AAAA-MM.log`
(una línea JSON por contacto, directorio cerrado al acceso web) **antes** de intentar
el envío, y también cuando el antispam lo bloquea. Aunque el correo falle, el
contacto se puede recuperar de ahí.

## Recuperar los contactos que se perdieron

Los leads perdidos **no están en el correo** (nunca salieron). Quedaron en el servidor,
en tres sitios distintos, así que se añadió un panel que los reúne:

**WP Admin → Herramientas → Leads perdidos** (`deckeva-recuperar-leads.php`)

| Fuente | Qué contiene |
|---|---|
| Flamingo | Todos los mensajes de formularios, incluidos los que el antispam marcó como spam y por tanto nunca se enviaron. |
| `uploads/cotizaciones-intl/*.pdf` | Cotizaciones del formulario de la home que dejaron su PDF en el servidor (retención 30 días). Nombre, email y teléfono se leen del propio PDF. |
| `uploads/deckeva-leads/` | Registro propio, a partir de esta corrección. |

Desde el panel se filtra por fecha, se descarga un **CSV** y se puede pedir el listado
**por correo**.

### Escribirles de vuelta desde el mismo panel

Debajo del listado hay un bloque **"Escribirles de vuelta"**: se marcan las casillas de
los clientes a contactar, se revisa el texto y se envía. Detalles:

- El correo sale **desde el propio sitio**, o sea con remitente `contacto@deckeva.cl`
  y el SPF/DKIM del dominio. No hace falta dar la contraseña de la casilla a nadie.
- `{nombre}` y `{fecha}` se reemplazan por los datos de cada cliente; si no se conocía
  el nombre, el saludo se ajusta solo.
- Va **uno por persona**, nunca en copia conjunta.
- A nadie se le escribe dos veces: quien ya fue contactado aparece con ✓ y su casilla
  deshabilitada.
- Las filas sin email utilizable no se pueden marcar, y el spam real se queda sin
  marcar porque la selección es manual.
- El texto se guarda para la siguiente tanda.

## Qué conviene revisar en el servidor

1. **Panel de leads perdidos** (arriba): es el punto de partida para retomar contacto.
2. **Carpeta de spam** de la casilla `contacto@deckeva.cl`.
3. **DMARC**: añadir un registro TXT en `_dmarc.deckeva.cl` y `_dmarc.deckeva.com`
   (empezar por `v=DMARC1; p=none; rua=mailto:contacto@deckeva.cl`). SPF y DKIM ya están.
4. **Destinatario de cada formulario CF7**: WP Admin → *Contacto* → pestaña *Correo*,
   revisar que el campo "Para" apunte a una casilla que se lea a diario.
5. Opcional: un plugin SMTP (WP Mail SMTP) deja registro de cada envío y avisa si
   alguno falla.

## Verificación

- `php -l` sin errores en los cuatro mu-plugins.
- Banco de pruebas sobre los filtros reales (15 casos): mensajes multilínea, con
  "Asunto:", "presupuesto:" y "contacto:" pasan; inyección de cabeceras, honeypot,
  exceso de enlaces y palabras de spam siguen bloqueados; el `Bcc` a la casilla del
  negocio se conserva y el dirigido a un tercero se descarta.
- Aviso interno comprobado de extremo a extremo: llega a `contacto@deckeva.cl`,
  `jpchs1@gmail.com` y al correo del administrador, con `Reply-To` del cliente.

## Publicación por FTP (#108 a #110)

BanaHosting no ofrece Git Version Control ni SSH en planes compartidos, así que
`.cpanel.yml` nunca se ejecuta. Publica `deploy-ftp.yml` por FTPS con lftp, sin
borrar nada en el servidor, y después compara por tamaño lo subido con lo que
quedó allí: si algo no cuadra, el workflow falla. Detalles y trampas de lftp en
`CLAUDE.md`.

## Cotización en PDF con diseño nuevo (#112 y #113)

La cotización del formulario de la home sale con `deckeva-assets/pdf-cotizacion.php`
(Barlow, Space Mono, colores de la web, una página) y cae al diseño anterior si
algo falla. Aprobada por el dueño con la toma de medidas e instalación a
CLP $145.000 por ítem (referencia Santiago).

## Caída de WordPress por Elementor 4.3 (23/09, #114 y #115)

**Qué pasó.** A las 01:28 UTC (22:28 en Chile) Elementor se actualizó solo de la
3.x a la 4.3.0 y todo WordPress de deckeva.cl respondió *"Ha habido un error
crítico"* hasta las 02:04 UTC: escritorio, cotizador, el formulario de la home y
los de Contact Form 7. La home estática y deckeva.com siguieron bien.

**Causa** (del `error_log`, leído con el nuevo workflow *Diagnóstico del servidor*):
Elementor Pro 3.12, de 2023 y sin actualizar, registra el experimento `mega-menu`
dependiendo de `nested-elements`. Elementor 4.3 marca `nested-elements` como oculto
y lanza `Dependency_Exception` sin capturar, en cada petición.

**Arreglo.** `deckeva-compat-elementor.php` registra `nested-elements` antes que
Elementor, con los mismos datos pero visible; Elementor ignora el duplicado y la
dependencia de Pro vuelve a ser válida. Reproducido y verificado en un WordPress
local con Elementor 4.3.0, Pro 3.12 y los complementos del sitio. Tras publicarlo,
las 45 páginas del sitemap responden 200.

**Pendiente del dueño.** Mientras Elementor Pro siga en la 3.12, cada actualización
automática de Elementor puede traer otra incompatibilidad. Opciones: renovar la
licencia y actualizar Pro, o pausar las actualizaciones automáticas de Elementor.

**Diagnóstico sin SSH.** *Actions → Diagnóstico del servidor (FTP)* lista lo que
cambió hace poco en el servidor y los últimos errores fatales de PHP, con correos,
IPs y teléfonos tapados (el repo y sus logs de Actions son públicos).

## Reenvío a los 12 clientes sin respuesta

`deckeva-rescate-cotizaciones.php`, campaña única controlada por
`DECKEVA_RESCATE_FASE`:

- **muestra**: manda a las casillas internas dos correos exactos (uno en español y
  el del cliente de EE. UU. en inglés) y la lista completa. No escribe a clientes.
- **enviar** (solo con aprobación del dueño, en su propio PR): de a 3 por visita a
  WordPress, una vez por cliente, con su cotización reemitida en el diseño nuevo y
  **el mismo valor que se le cotizó**. Al final, resumen interno.

El archivo solo tiene números de cotización. Los datos de cada cliente se leen de
los PDF originales en el servidor y se guardan en `uploads/deckeva-leads` (cerrada
a la web), porque el cotizador borra a veces los PDF de más de 30 días.

Salvaguardas: cerrojo `flock` contra visitas simultáneas; "enviando" se anota antes
de mandar y no se reintenta (mejor revisarlo a mano que escribir dos veces); nunca
a quien ya se contactó desde el panel; sin PDF no sale el correo; un estado
ilegible detiene todo. Fechas en hora de Chile (el WordPress está en UTC+2 y los
números de cotización van en UTC).

Probado en un WordPress local con los mu-plugins reales, DOMPDF 2.0.8 y los PDF
originales, con el correo interceptado. Siete escenarios: sin muestra no envía; de
a 3 por visita y resumen al final; fallo de envío con 3 intentos; ya contactado;
proceso muerto a mitad; visitas simultáneas sin duplicados; estado corrupto. Los 12
correos llevan la cotización de su destinatario, con su total, en una página y en
su idioma.

**Resultado.** El dueño revisó la muestra y aprobó el envío (#119). Salieron los
12 correos el 23/09/2026 entre las 00:01 y las 00:02 (hora de Chile), de a 3 por
visita, sin fallos ni omisiones; el resumen "12 de 12 clientes contactados"
llegó a las casillas del negocio. La campaña queda inerte: la marca de fase
terminada evita que vuelva a enviar nada. Las respuestas llegan a
`contacto@deckeva.cl`.

## Después del incidente (#120)

- **Elementor sin actualizaciones automáticas** mientras Pro siga en la 3.x
  (decisión del dueño). Se puede actualizar a mano; al pasar Pro a la 4.x, las
  automáticas vuelven solas.
- **Fechas del cotizador en hora de Chile**: con el WordPress en UTC+2, las
  cotizaciones pedidas después de las 19:00 en Chile salían con la fecha del
  día siguiente.

## Copia oculta al dueño de todo correo a un cliente

Pedido del dueño (23/09/2026): los correos a clientes salen de
`contacto@deckeva.cl` **y con copia oculta a su casilla**, para ver exactamente
lo que recibe cada cliente.

- `deckeva_mail_headers_cliente($para)` en el núcleo de correo: remitente
  contacto@deckeva.cl y `Bcc` al dueño (sin duplicarlo si el destinatario ya es
  él). La usan el cotizador (home y `/cotizador/`), el correo formal de CF7, el
  panel de reactivación y el reenvío.
- Contact Form 7: `wpcf7_mail_components` fuerza el remitente contacto@deckeva.cl
  en todos los formularios y añade la copia oculta cuando el destinatario es un
  cliente (la respuesta automática). Si un formulario usaba la dirección del
  cliente como remitente, esa dirección pasa a `Reply-To`.
- Los avisos internos no llevan copia: ya van al dueño.
- Los 12 correos del reenvío salieron antes de esta regla: el plugin del reenvío
  le manda al dueño, una sola vez, la copia de cada uno (mismo correo y PDF,
  asunto "[Copia para …]", con `Reply-To` del cliente). Nunca a los clientes.

Ojo: la copia oculta es de lo que **sale**. Las respuestas de los clientes
siguen llegando solo a `contacto@deckeva.cl`; para verlas en Gmail hace falta el
reenviador de cPanel.

Probado en el WordPress local, con los filtros reales (incluido el del
antispam) y el correo interceptado: cotización de la home, `/cotizador/`, panel
de reactivación y un envío real de Contact Form 7 con respuesta automática.
Todos los correos a clientes llevan la copia; los internos no. Las copias de los
12 salen solo al dueño, y una campaña nueva no las duplica. Los 7 escenarios del
reenvío siguen pasando.
