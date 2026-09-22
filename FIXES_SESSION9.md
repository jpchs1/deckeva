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
envía por `deckeva.cl`. Con SPF/DKIM de por medio, ese desajuste hace que Gmail y
Outlook manden el correo a spam o lo rechacen.

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

## Qué conviene revisar en el servidor

1. **Mensajes atrapados**: WP Admin → *Flamingo* → *Mensajes entrantes* → carpeta
   **Spam**. Ahí deberían estar los mensajes que el antispam descartó por error.
2. **Carpeta de spam de la casilla** `contacto@deckeva.cl` y de la de Gmail.
3. **SPF y DKIM** del dominio: sin ellos, los correos que el sitio envía a Gmail
   entran a spam. Un plugin SMTP (WP Mail SMTP, con la casilla de cPanel o con un
   servicio tipo Brevo/SendGrid) resuelve esto de raíz y además deja registro de
   cada envío.
4. **Destinatario de cada formulario CF7**: WP Admin → *Contacto* → pestaña *Correo*,
   revisar que el campo "Para" apunte a una casilla que se lea a diario.

## Verificación

- `php -l` sin errores en los cuatro mu-plugins.
- Banco de pruebas sobre los filtros reales (15 casos): mensajes multilínea, con
  "Asunto:", "presupuesto:" y "contacto:" pasan; inyección de cabeceras, honeypot,
  exceso de enlaces y palabras de spam siguen bloqueados; el `Bcc` a la casilla del
  negocio se conserva y el dirigido a un tercero se descarta.
- Aviso interno comprobado de extremo a extremo: llega a `contacto@deckeva.cl`,
  `jpchs1@gmail.com` y al correo del administrador, con `Reply-To` del cliente.
