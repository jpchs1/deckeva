# Deckeva — guía para Claude

WordPress en producción en **deckeva.cl** (canónico) con una home estática, más el
sitio internacional **deckeva.com**. Hay clientes reales entrando por los
formularios todos los días: lo que se rompe aquí, se rompe de cara al público.

## Flujo de trabajo (instrucción permanente del dueño)

Cuando se pida un cambio, llevarlo **hasta producción sin ir preguntando paso a
paso**:

1. Trabajar en la rama `claude/<lo-que-sea>` (crearla desde `origin/main-branch`).
2. Verificar antes de commitear: `php -l` sobre todo PHP tocado, y pruebas
   propias si el cambio tiene lógica.
3. Commit con mensaje que explique **por qué**, no solo qué.
4. Abrir el PR contra `main-branch`, describiendo el problema y la verificación.
5. Esperar a que el workflow **Verificación** esté en verde.
6. Mergear con **squash** (es la convención del repo: `feat(x): … (#107)`).
7. El merge dispara el deploy solo. Confirmar que salió bien.

Si el PR de la rama ya está mergeado, el trabajo siguiente parte de cero:
rehacer la rama desde `origin/main-branch`, nunca apilar encima de lo ya mergeado.

### Lo que sí se consulta antes

Publicar solo cuesta un clic; deshacer, no. Preguntar antes de:

- **Escribir a clientes** o a cualquier tercero, y de publicar hacia fuera.
- **Borrar o sobrescribir** datos del servidor: leads, uploads, tablas, backups.
- **Cambiar precios**, textos comerciales o condiciones que nadie pidió cambiar.
- Cualquier cosa **difícil de revertir** que no estuviera en el encargo.

Y decirlo claro cuando algo salga mal o quede a medias. Un fallo silencioso aquí
son clientes perdidos: es exactamente lo que pasó con los avisos de cotización.

## Despliegue

`.cpanel.yml` copia los archivos a `/home/wwimpo/deckeva.cl/` y
`/home/wwimpo/deckeva.com/`. Lo dispara el workflow `deploy-cpanel.yml` en cada
push a `main-branch`.

Si faltan los secretos `CPANEL_HOST` / `CPANEL_USER` / `CPANEL_TOKEN`, el workflow
avisa y no hace nada: entonces toca a mano en **cPanel → Git Version Control →
Update from Remote → Deploy HEAD Commit**.

El deploy copia `wp-content/mu-plugins` **entero**, así que un archivo nuevo ahí
llega solo. Lo que vive únicamente en la base de datos (formularios CF7, CSS de
Elementor, snippets) **no** está en el repo y no se despliega.

## Estructura

| Ruta | Qué es |
|---|---|
| `wp-content/mu-plugins/deckeva-*.php` | Código propio. Es lo que de verdad mantenemos. |
| `wp-content/themes/dt-the7-child/` | Tema hijo. |
| `staging/index-cl.html`, `index-com.html` | Homes estáticas que reemplazan el render de WordPress en `/`. |
| `staging/post-*.html`, `page-*.html` | Artículos y páginas estáticas. |
| `pago/` | Portal de pago (Webpay, Mercado Pago, PayPal). |
| `guia/` | Guías de medición e instalación. |
| `FIXES_SESSION*.md` | Bitácora de cada intervención. Añadir una por trabajo serio. |

El resto —core de WordPress y los ~69 plugins— es de terceros: no se toca.

### Los mu-plugins propios

Cargan por orden alfabético, por eso el núcleo va con `00`:

- `deckeva-00-mail-core.php` — **punto único** del correo: casillas del negocio,
  remitente, avisos con `Reply-To` del cliente y registro en disco de cada lead.
  Cualquier envío nuevo pasa por aquí, no reinventarlo.
- `deckeva-antispam-security.php` — antispam y endurecimiento. Ojo con los falsos
  positivos: una regla de más aquí deja al negocio sin mensajes y nadie se entera.
- `deckeva-cotizador.php` — cotizador de `/cotizador/` y endpoint del formulario
  de la home (`/cotizador/enviar-international`).
- `deckeva-cotizacion-email.php` — correos del formulario CF7 1031.
- `deckeva-recuperar-leads.php` — panel *Herramientas → Leads perdidos*.

`dompdf/` está en `.gitignore`: existe en el servidor, no en el repo.

## Convenciones

- **Comentarios y textos en español**, como el resto del código. Los comentarios
  explican el porqué y el caso real que cubren, no repiten la línea siguiente.
- PHP compatible con 7.4 en adelante (el servidor no siempre va al día).
- Escapar siempre la salida (`esc_html`, `esc_attr`, `esc_url`), `nonce` y
  comprobación de permisos en todo lo que escriba o envíe.
- Nada de datos de clientes en sitios accesibles por web: si se guarda algo en
  `uploads/`, va con su `.htaccess` cerrado.
- No meter credenciales en el repo. Las del correo y cPanel viven en el servidor
  o en los secretos de GitHub.
