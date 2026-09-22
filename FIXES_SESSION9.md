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
