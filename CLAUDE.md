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

## El largo de una embarcación se saca de las especificaciones (REGLA DEL DUEÑO)

**Para cotizar, el largo es el LOA del fabricante, buscado en internet con
marca, modelo y año, y manda sobre lo que diga el cliente** (JP, 29-sep-2026).
El cliente se equivoca o redondea («21 pies», y después «perdón, son 22,4»); la
ficha técnica no.

**Redondeo:** hasta ,4 baja al entero anterior; desde ,5 sube al siguiente.
22,4 → 22 · 22,5 → 23 · 24' 6" (24,5) → 25.

Si no hay especificaciones seguras (el modelo no aparece, las fuentes no
coinciden, o el año cambia el largo y no se sabe), vale el largo que **escribió**
el cliente, con el mismo redondeo. Sin ninguno de los dos no se cotiza: se le
pide.

Vive en `wp-content/mu-plugins/deckeva-whatsapp-cotiza.php`
(`deckeva_wa_cotiza_loa`, `deckeva_wa_cotiza_redondear`). El correo a JP con
cada cotización dice de dónde salió el largo y trae el link a la fuente.

Y una cotización por WhatsApp no se crea sin los datos obligatorios
(`deckeva_wa_cotiza_listo`, JP, 29-sep-2026). Lancha: marca, modelo, año (el que
escribió el cliente), largo, color, dónde está, nombre y correo. Moto de agua:
el tamaño, color, dónde está, nombre y correo. Lo que falte se le pide.

## Moto de agua normal o mediana/grande: lo decide el largo (REGLA DEL DUEÑO)

JP, 29-sep-2026: «el criterio es el largo». Con marca y modelo escritos por
el cliente se busca el LOA (`deckeva_wa_cotiza_loa`, el mismo de las
lanchas) y `DECKEVA_MOTO_CORTE_M` (3,25 m) decide la tarifa, aunque el
cliente haya dicho otro tamaño. Sin LOA vale lo que dijo el cliente; sin
nada, se le piden marca y modelo. La tabla que sostiene el corte está en el
docblock de la constante: normal hasta ~3,15 m (Spark, STX 160, EX),
mediana/grande desde ~3,32 m (GTI, Ultra, FX, GTX).

## Muelles flotantes: no se cotizan, se escalan a JP al tiro (REGLA DEL DUEÑO)

Es el único producto que el contestador no cotiza ni le pone precio (JP,
29-sep-2026). `deckeva_wa_es_muelle()` lo reconoce por una lista cerrada:
«muelle flotante/modular», «pantalán flotante», «floating dock», o «muelle»
junto a cotizar, precio, cuánto, quiero, necesito… «La lancha está en el
muelle (flotante)» NO cuenta: eso es dónde está, no lo que pide, y esas
frases se sacan antes de mirar. Sólo cuenta el pedido vigente (las últimas
6 h del cliente): un muelle de la semana pasada no bloquea el piso de hoy.
Si lo reconoce, la respuesta queda en borrador con aviso a JP, la cotización
automática no se arma, y una ya armada (lista o aprobada) antes del pedido
del muelle queda «retenida» y no sale.

## Aprobar desde el WhatsApp de JP (desde el 29-sep-2026)

JP: «¿estas solicitudes me pueden llegar a mi WhatsApp para aprobar desde el
WhatsApp?». Cada borrador (`D-XXXX`) le llega también por WhatsApp, además del
correo, en dos mensajes: el detalle y aparte sólo «ok D-XXXX».

- El tick que manda Tourevo cada minuto recibe de vuelta los borradores que
  esperan (`deckeva_wa_pendientes_para_jp`). Tourevo, que tiene el número, se
  los pide a JP con su ventana de 24 h abierta (`Core/AprobacionWhatsApp`).
- JP contesta «ok D-XXXX» o «D-XXXX: su texto» al número de Tourevo, y Tourevo
  lo trae por la ruta firmada `whatsapp-puerta/aprobar`
  (`deckeva_wa_aprobar_remoto`): mismas reglas que el botón de wp-admin. 409 si
  ya no espera o no pasa las reglas, y no se reintenta.
- Si la propuesta no parece castellano, a JP le llega sin texto y sin «ok»: se
  ve en wp-admin. «Nada en otros idiomas en mi WhatsApp».

## Garantía, vida útil y espesor (REGLA DEL DUEÑO)

JP, 29-sep-2026: el piso tiene **6 mm** de espesor, **5 a 7 años** de vida
útil y **1 año de garantía, al costo**. «Al costo» va siempre pegado a la
garantía: decir «1 año de garantía» a secas promete algo que no es. Vive en el
prompt del contestador (`deckeva_wa_sistema`). Qué cubre y qué significa «al
costo» no está definido por escrito, así que si el cliente lo pregunta, lo ve
JP (`necesita_humano`).

## Toma de medidas e instalación: opcionales, fuera del total (REGLA DEL DUEÑO)

**$155.000 + IVA cada uno, mismo valor en todas las regiones y también para motos
de agua** (JP, 29-sep-2026). Son opcionales: el cliente puede medir e instalar él
mismo con el video explicativo que le mandamos, y el PDF se lo dice así, con
cariño («lo puedes hacer tú mismo fácilmente con nuestro video explicativo, como
prefieras»).

- **No se suman al total del piso.** Van en su propia sección «Opcionales», cada
  uno con neto, IVA 19% y total con IVA (155.000 + 29.450 = 184.450).
- **El valor vive en un solo lugar:** `deckeva-00-opcionales.php`
  (`DECKEVA_PRECIO_MEDICION`, `DECKEVA_PRECIO_INSTALACION`, `deckeva_opcionales()`).
  El PDF, el PDF de respaldo y el correo del cotizador lo leen de ahí.
- Ya no se dice en ninguna parte del PDF ni del correo que el cliente contrata
  a un técnico por su cuenta, ni la referencia vieja de $145.000.
- **El chat de WhatsApp no dice montos:** dice que existen y que van en la
  cotización.
- En el PDF no usar `<u>`: con `fontHeightRatio` 0,83 DOMPDF dibuja el
  subrayado a media altura y el texto se lee tachado.

## Tres reglas más de la cotización (REGLA DEL DUEÑO · 30-sep-2026)

- **El logo de la marca de la embarcación se graba sin costo**, incluido en el
  piso (ej. «Cobalt» para una Cobalt 220). El chat dice que sí se puede.
- **Se puede medir en un lugar e instalar en otro** (ej. medir en Rapel e
  instalar en Pucón). El chat lo acepta y anota los dos lugares.
- **Viña del Mar lleva un recargo de $55.000** por traslado. En el chat no se
  dice el monto: va en la cotización. Todavía **no** está en el PDF automático
  (falta que JP defina si es + IVA y cuándo aplica); por ahora lo pone a mano.

## La IA lee el chat entero antes de preguntar (REGLA DEL DUEÑO · 30-sep-2026)

Gustavo (Sea Ray Sundancer 27, Valdivia) cortó la conversación: «Me desagrada
profundamente conversar con una máquina y después volver a cero en las
indicaciones». Se le pidieron los mismos datos varias veces y se le dijo algo
distinto sobre el traslado. Desde ahora:

- Tourevo deriva hasta **80 mensajes** del chat (antes 30) y Deckeva guarda
  80, para que el que redacta vea la conversación completa.
- El prompt obliga a leer todo antes de preguntar, a confirmar en una frase lo
  que ya sabe y a pedir sólo lo que falta.
- Si en el chat se dijeron dos cosas distintas, no elige: `necesita_humano`.
- Si el cliente está molesto con «la máquina», no se le escribe más:
  `responder = false`, `necesita_humano = true`.

## La cotización PDF: una página, y todo lo que dice es cierto

`deckeva-assets/pdf-cotizacion.php`, rediseñada el 29-sep-2026. De arriba a
abajo: total en tarjeta con neto e IVA, ficha de la embarcación, detalle, «Tu
piso incluye», opcionales en tarjetas (o «lo haces tú» fuera de Chile), medios
de pago y el cierre con los pasos numerados y botones clicables (WhatsApp con la
cotización escrita, y correo).

- **«Tu piso incluye» sólo repite lo que la web ya publica** (deckeva.com y el
  correo del cotizador): EVA de celdas cerradas, antideslizante, UV y agua
  salada, adhesivo 3M, diseño a medida, absorbe ruido y vibraciones. Ni plazos
  ni garantías: eso lo confirma una persona.
- **Medios de pago, sólo los que están habilitados en los portales:** en Chile
  Webpay Plus, Mercado Pago y PayPal (`deckeva.cl/pago`); afuera PayPal y Wire
  Transfer / ACH (`deckeva.com/wiretransfers`). Si se agrega o se apaga uno en
  el portal, se cambia aquí también.
  Cada medio va con su logo, con los colores de marca del portal de pago
  (`pago/index.html`). Van armados con las tipografías del PDF y no como SVG
  con `<text>`, porque DOMPDF no dibuja bien el texto dentro de un SVG. Los
  íconos (Mercado Pago, banco) sí son SVG, pero sólo formas.
- **«Válida hasta» con fecha**, en la cabecera y en el pie:
  `deckeva_pdf_valida_hasta()`, 15 días hábiles desde la fecha de la
  cotización. No descuenta feriados, a propósito: así la fecha nunca queda
  después del plazo real.
- **Una página siempre.** DOMPDF no parte la hoja cuando el contenido se pasa:
  lo dibuja **debajo del pie**, sin avisar, y el cliente recibe el cierre tapado.
  Con datos largos la plantilla entra en modo compacto (saca la nota en inglés
  de los opcionales). Antes de tocar el alto de cualquier bloque:

  ```
  composer require dompdf/dompdf:2.0.8 -d /tmp/dk
  php .github/pdf/matriz.php /tmp/dk/vendor/autoload.php /tmp/dk/salida
  python3 .github/pdf/medir.py /tmp/dk/salida     # pip install pymupdf
  ```

  Son 256 combinaciones (nombre, contacto, saludo, ≈ USD, medición e
  instalación incluidas y modelo largos × Chile/afuera × precio/a consultar);
  sale en 1 si alguna queda con menos de 4 pt de aire sobre el pie. Con el sello
  «Taller propio» a la peor le quedan 8,8 pt.
- **El sello «Taller propio» es de JP** (29-sep-2026): Deckeva trabaja los pisos
  con su propia máquina especial para pisos de lanchas, y su único foco es la
  calidad del producto y la terminación. Va en la columna del detalle, con fondo
  navy y borde dorado. En modo compacto pierde la línea en inglés (el título ya
  la trae), y medición e instalación incluidas cuentan como dato largo.

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
  de la home (`/cotizador/enviar-international`). El correo con la cotización va
  en el idioma del cliente según el país del formulario
  (`Deckeva_Cotizador::idioma_cliente()`):
  - español para los países de habla hispana;
  - inglés para los de habla inglesa;
  - los dos, con el español primero, para Brasil y "Otro".
- `deckeva-cotizacion-email.php` — correos del formulario CF7 1031.
- `deckeva-recuperar-leads.php` — panel *Herramientas → Leads perdidos*.
- `deckeva-compat-elementor.php` — evita la caída de Elementor 4.3 con Elementor
  Pro 3.12. Sobra cuando Pro se actualice.
- `deckeva-meta-pixel.php` — Pixel de Meta y evento `Lead` por la API de
  Conversiones en cada cotización de deckeva.cl. Se configura en *Ajustes →
  Meta Ads*; sin ID ni token no hace nada. La home estática carga
  `uploads/deckeva-meta/pixel.js`, que se escribe al guardar el ID.
- `deckeva-rescate-cotizaciones.php` — campaña única de reenvío a los clientes
  sin respuesta, gobernada por `DECKEVA_RESCATE_FASE` (`muestra` → `enviar` solo
  con aprobación del dueño). Se borra al terminar.
- `deckeva-00-opcionales.php` — valor de la toma de medidas y la instalación
  (opcionales). Único lugar donde se escribe.
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
