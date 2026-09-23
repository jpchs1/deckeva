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

El hosting es **BanaHosting, plan compartido**: no tiene Git Version Control ni
acceso SSH, y su soporte confirmó (22/09/2026) que no los habilitan porque esa
herramienta depende de SSH externo. Así que `.cpanel.yml` **está en el repo pero
nunca se ejecuta**: se conserva solo como la definición buena de qué archivo va a
qué ruta.

Lo que sí funciona es **FTP**, y de eso se encarga `deploy-ftp.yml` en cada push a
`main-branch`:

1. `.github/deploy/preparar-arbol.sh` arma en local los dos árboles
   (`deckeva.cl` y `deckeva.com`) replicando el mapeo de `.cpanel.yml`. Se puede
   ejecutar suelto para revisar qué se subiría.
2. `lftp` los sube por FTPS, **sin borrar nada** en el servidor: en el servidor
   hay cosas que no están en el repo (uploads, `dompdf/`, el propio WordPress) y
   un espejo con borrado se las llevaría.
3. Después compara por tamaño lo subido con lo que quedó en el servidor. Si algo
   no cuadra, el workflow falla: no hay "publicado" sin verificar.

Las funciones de FTP viven en `.github/deploy/ftp.sh`. Dos trampas de lftp
comprobadas con la 4.9.2, que ese archivo ya sortea y no hay que reintroducir:

- En simulacro de subida escribe cada archivo como `get … file:<local>`, no como
  `put`. Filtrar solo por `put` deja la lista vacía = falso "todo igual".
- Con el servidor inalcanzable, el simulacro **no falla**: lista todo como
  pendiente y sale con 0. Por eso antes se comprueba el acceso con `cls`.

Sin los secretos `FTP_HOST` / `FTP_USER` / `FTP_PASS`, el workflow avisa y no hace
nada. Con ellos, cada merge publica solo si la variable `FTP_ACTIVO = si`; si no,
hace un simulacro. A mano (*Actions → Run workflow*) se elige `modo` (`prueba` o
`real`) y `alcance` (`todo` o solo `mu-plugins`), así que Claude puede lanzar una
publicación controlada con `actions_run_trigger`: primero `prueba`, revisar la
lista, luego `real`.

Mientras no haya secretos, se sube a mano por **cPanel → File Manager** o por FTP.

Si el mapeo cambia, se toca `preparar-arbol.sh` **y** `.cpanel.yml`, para que no
se separen.

Un archivo nuevo en `wp-content/mu-plugins` llega solo, porque se sube la carpeta
entera. Lo que vive únicamente en la base de datos (formularios CF7, CSS de
Elementor, snippets) **no** está en el repo y no se despliega.

Tras cada merge, el simulacro automático y el deploy manual van en serie (mismo
grupo de concurrencia). Si corre prisa, cancelar el simulacro es inofensivo:
solo compara.

### Diagnóstico sin SSH

Si WordPress muestra *"Ha habido un error crítico"*, la causa está en el log de
PHP del servidor: *Actions → Diagnóstico del servidor (FTP)*
(`diagnostico-ftp.yml`, `actions_run_trigger`). Lista lo que cambió hace poco
(mu-plugins, plugins, temas, traducciones), los últimos errores fatales de
`deckeva.cl/error_log` y `wp-admin/error_log` y los avisos `[Deckeva …]` (si la
web no pudo entregar un correo al servidor). Solo lee.

Con `ventana_leads` (dos horas UTC, `AAAA-MM-DDTHH:MM:SSZ/AAAA-MM-DDTHH:MM:SSZ`)
responde además "¿quedó algún cliente sin respuesta en ese rato?". Cuenta los
contactos del registro de leads, sin las pruebas propias. También lista los
correos que llegaron a la casilla interna de la cuenta (`~/mail`): rebotes,
avisos de cPanel u otros. Solo imprime números, horas y tipos, nunca datos de
clientes.

**El repo es público, y sus logs de Actions también.** Nada de datos de
clientes en commits, PRs ni en lo que imprima un workflow.

Precedente (23/09/2026): Elementor se actualizó solo a la 4.3 y tumbó todo
WordPress porque el Elementor Pro del sitio es la 3.12, de 2023. Lo sostiene
`deckeva-compat-elementor.php`. Mientras Pro no se actualice, cada actualización
automática de Elementor es sospechosa ante una caída.

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
  Cualquier envío nuevo pasa por aquí, no reinventarlo. **Regla del dueño:** todo
  correo a un cliente sale de contacto@deckeva.cl con copia oculta a su casilla:
  usar `deckeva_mail_headers_cliente($para)`. Los de Contact Form 7 se ajustan
  solos (`wpcf7_mail_components`). Los avisos internos no llevan copia. El dueño
  revisa contacto@deckeva.cl directamente: no proponer reenviarla a Gmail. El
  remitente del sobre también es contacto@deckeva.cl, para que los rebotes le
  lleguen al dueño.
  **Límite del hosting:** tras unos 25 correos a direcciones externas en una
  hora, el servidor deja de despachar sin dar error, y lo que sobra no se entrega
  (23/09/2026). Todo envío en bloque va espaciado y muy por debajo de ese
  número, contando también los avisos a Gmail y las copias ocultas.
- `deckeva-antispam-security.php` — antispam y endurecimiento. Ojo con los falsos
  positivos: una regla de más aquí deja al negocio sin mensajes y nadie se entera.
- `deckeva-cotizador.php` — cotizador de `/cotizador/` y endpoint del formulario
  de la home (`/cotizador/enviar-international`).
- `deckeva-cotizacion-email.php` — correos del formulario CF7 1031.
- `deckeva-recuperar-leads.php` — panel *Herramientas → Leads perdidos*.
- `deckeva-compat-elementor.php` — evita la caída de Elementor 4.3 con Elementor
  Pro 3.12. Sobra cuando Pro se actualice.
- `deckeva-rescate-cotizaciones.php` — campaña única de reenvío a los clientes
  sin respuesta, gobernada por `DECKEVA_RESCATE_FASE` (`muestra` → `enviar` solo
  con aprobación del dueño). Se borra al terminar.
- `deckeva-assets/` — plantilla y tipografías del PDF de cotización. Está en una
  subcarpeta a propósito: WordPress solo carga los PHP de la raíz de mu-plugins.

`dompdf/` está en `.gitignore`: existe en el servidor, no en el repo.

La zona horaria del WordPress no es la de Chile (va en UTC+2) y los números de
cotización van en UTC: para fechas que lea un cliente, usar `America/Santiago`
explícitamente.

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
