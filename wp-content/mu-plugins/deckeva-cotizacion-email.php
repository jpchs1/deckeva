<?php
/**
 * Plugin Name: Deckeva - Email Automático de Cotización
 * Description: Envía un email de cotización formal al usuario y una notificación al admin cuando se completa el formulario de precio (CF7 ID 1031).
 * Version: 1.1
 * Author: Deckeva
 */

if (!defined('ABSPATH')) exit;

/**
 * Obtiene el mapa de precios dinámicamente desde el contenido del formulario CF7 (ID 1031).
 * Parsea el HTML del formulario para extraer los precios de los grupos condicionales.
 * De esta forma, si se actualizan los precios en el formulario, el email siempre refleja los mismos valores.
 */
function deckeva_get_price_map() {
    // Intentar obtener desde cache transitoria (1 hora)
    $cached = get_transient('deckeva_price_map');
    if ($cached !== false) {
        return $cached;
    }

    $price_map = array();

    // Leer el contenido del formulario CF7 ID 1031 desde la base de datos
    $form_post = get_post(1031);
    if ($form_post && $form_post->post_type === 'wpcf7_contact_form') {
        $form_content = $form_post->post_content;

        // Buscar los grupos condicionales con precios: data-id="pies-XX" ... <p>CLP XXX + IVA</p>
        // También captura el grupo "Otro"
        if (preg_match_all('/data-id=["\']([^"\']+)["\'][^>]*>\s*<p>([^<]+)<\/p>/i', $form_content, $matches, PREG_SET_ORDER)) {
            foreach ($matches as $match) {
                $data_id = trim($match[1]);
                $precio  = trim($match[2]);

                // Convertir data-id a la clave del select:
                // "pies-14" => "14 (Pies)", "pies-30" => "30 (Pies)", "Otro" => "Otro"
                if (preg_match('/^pies-(\d+)$/i', $data_id, $num_match)) {
                    $key = $num_match[1] . ' (Pies)';
                } else {
                    $key = $data_id; // "Otro" u otro valor
                }

                $price_map[$key] = $precio;
            }
        }
    }

    // Si no se pudieron extraer precios (formulario no encontrado, formato cambió, etc.),
    // usar fallback estático para no enviar emails sin precio
    if (empty($price_map)) {
        $price_map = deckeva_get_fallback_price_map();
    }

    // Guardar en cache por 1 hora
    set_transient('deckeva_price_map', $price_map, HOUR_IN_SECONDS);

    return $price_map;
}

/**
 * Fallback estático en caso de que no se pueda leer el formulario CF7.
 */
function deckeva_get_fallback_price_map() {
    return array(
        '14 (Pies)' => 'CLP 626.988 + IVA',
        '15 (Pies)' => 'CLP 742.925 + IVA',
        '16 (Pies)' => 'CLP 787.930 + IVA',
        '17 (Pies)' => 'CLP 836.085 + IVA',
        '18 (Pies)' => 'CLP 887.611 + IVA',
        '19 (Pies)' => 'CLP 942.744 + IVA',
        '20 (Pies)' => 'CLP 1.001.736 + IVA',
        '21 (Pies)' => 'CLP 1.064.858 + IVA',
        '22 (Pies)' => 'CLP 1.132.398 + IVA',
        '23 (Pies)' => 'CLP 1.204.665 + IVA',
        '24 (Pies)' => 'CLP 1.281.992 + IVA',
        '25 (Pies)' => 'CLP 1.364.731 + IVA',
        '26 (Pies)' => 'CLP 1.453.263 + IVA',
        '27 (Pies)' => 'CLP 1.588.589 + IVA',
        '28 (Pies)' => 'CLP 1.737.488 + IVA',
        '29 (Pies)' => 'CLP 1.901.193 + IVA',
        '30 (Pies)' => 'CLP 2.081.312 + IVA',
        'Otro'      => 'A cotizar',
    );
}

/**
 * Limpiar cache de precios cuando se actualiza el formulario CF7.
 * Así los cambios de precio se reflejan inmediatamente en los emails.
 */
add_action('wpcf7_save_contact_form', 'deckeva_clear_price_cache');
function deckeva_clear_price_cache($contact_form) {
    if ($contact_form->id() == 1031) {
        delete_transient('deckeva_price_map');
    }
}

/**
 * Hook principal: se dispara cuando CF7 envía el formulario exitosamente.
 */
add_action('wpcf7_mail_sent', 'deckeva_send_cotizacion_emails');

function deckeva_send_cotizacion_emails($contact_form) {
    // Solo actuar en el formulario de cotización (ID 1031)
    if ($contact_form->id() != 1031) {
        return;
    }

    $submission = WPCF7_Submission::get_instance();
    if (!$submission) {
        return;
    }

    $data = $submission->get_posted_data();

    // Extraer campos
    $nombre    = isset($data['your-name']) ? sanitize_text_field($data['your-name']) : '';
    $apellido  = isset($data['your-lastname']) ? sanitize_text_field($data['your-lastname']) : '';
    $email     = isset($data['your-email']) ? sanitize_email($data['your-email']) : '';
    $telefono  = isset($data['your-tel']) ? sanitize_text_field($data['your-tel']) : '';
    $tamano    = isset($data['menu-size']) ? sanitize_text_field($data['menu-size']) : '';
    $marca     = isset($data['lancha-marca']) ? sanitize_text_field($data['lancha-marca']) : '';
    $modelo    = isset($data['lancha-modelo']) ? sanitize_text_field($data['lancha-modelo']) : '';
    $year      = isset($data['lancha-year']) ? sanitize_text_field($data['lancha-year']) : '';
    $color     = isset($data['lancha-color']) ? sanitize_text_field($data['lancha-color']) : '';

    // Obtener precio
    $price_map = deckeva_get_price_map();
    $precio    = isset($price_map[$tamano]) ? $price_map[$tamano] : 'A cotizar';

    $nombre_completo = trim($nombre . ' ' . $apellido);
    $fecha = date_i18n('d/m/Y');
    $numero_cotizacion = 'DCK-' . date('Ymd') . '-' . wp_rand(1000, 9999);

    // Headers para enviar HTML
    $headers = array(
        'Content-Type: text/html; charset=UTF-8',
        'From: Deckeva <no-reply@deckeva.com>',
    );

    // ─── EMAIL AL USUARIO (CLIENTE) ───
    if (!empty($email)) {
        $asunto_cliente = "Cotización Formal Deckeva - Piso para tu " . ($marca ? $marca : 'Lancha') . " " . $modelo . " | N° " . $numero_cotizacion;
        $body_cliente   = deckeva_build_client_email($nombre, $nombre_completo, $tamano, $marca, $modelo, $year, $color, $precio, $numero_cotizacion, $fecha);
        wp_mail($email, $asunto_cliente, $body_cliente, $headers);
    }

    // ─── EMAIL AL ADMIN ───
    $admin_email   = get_option('admin_email');
    $asunto_admin  = "Nueva Cotización Deckeva N° " . $numero_cotizacion . " - " . $nombre_completo;
    $body_admin    = deckeva_build_admin_email($nombre_completo, $email, $telefono, $tamano, $marca, $modelo, $year, $color, $precio, $numero_cotizacion, $fecha);
    wp_mail($admin_email, $asunto_admin, $body_admin, $headers);
}

/**
 * Construye el email HTML para el cliente.
 */
function deckeva_build_client_email($nombre, $nombre_completo, $tamano, $marca, $modelo, $year, $color, $precio, $numero_cotizacion, $fecha) {
    $lancha_info = '';
    if (!empty($marca)) {
        $lancha_info .= $marca;
    }
    if (!empty($modelo)) {
        $lancha_info .= ' ' . $modelo;
    }
    if (!empty($year)) {
        $lancha_info .= ' (' . $year . ')';
    }
    $lancha_info = trim($lancha_info);
    if (empty($lancha_info)) {
        $lancha_info = 'Tu embarcación';
    }

    $html = '<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Cotización Deckeva</title>
</head>
<body style="margin:0; padding:0; background-color:#f4f1ee; font-family: \'Helvetica Neue\', Helvetica, Arial, sans-serif;">

<!-- Wrapper -->
<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color:#f4f1ee;">
<tr><td align="center" style="padding: 30px 15px;">

<!-- Main Card -->
<table role="presentation" width="600" cellpadding="0" cellspacing="0" style="background-color:#ffffff; border-radius:16px; overflow:hidden; box-shadow: 0 4px 24px rgba(136,74,57,0.12);">

<!-- Header con gradiente -->
<tr>
<td style="background: linear-gradient(135deg, #5C3D2E 0%, #884A39 50%, #6d3a2d 100%); padding: 40px 40px 30px; text-align:center;">
    <img src="https://deckeva.com/wp-content/uploads/2020/12/WhatsApp-Image-2023-08-03-at-11.27.49-AM.jpeg" alt="Deckeva" width="200" style="display:inline-block; max-width:200px; margin-bottom:15px;" />
    <p style="color: rgba(255,255,255,0.8); font-size:12px; letter-spacing:2px; text-transform:uppercase; margin:0;">Pisos para Lanchas Antideslizantes</p>
</td>
</tr>

<!-- Badge de cotización -->
<tr>
<td style="padding: 0; text-align:center;">
    <table role="presentation" cellpadding="0" cellspacing="0" style="margin: -18px auto 0; background:#884A39; border-radius:30px; padding:0;">
    <tr>
        <td style="padding: 10px 28px; color:#ffffff; font-size:13px; font-weight:700; letter-spacing:1px;">
            COTIZACIÓN N° ' . esc_html($numero_cotizacion) . '
        </td>
    </tr>
    </table>
</td>
</tr>

<!-- Saludo -->
<tr>
<td style="padding: 35px 45px 10px;">
    <h1 style="margin:0 0 8px; font-size:24px; color:#2d2d2d; font-weight:700;">¡Hola ' . esc_html($nombre) . '!</h1>
    <p style="margin:0; color:#6b7280; font-size:15px; line-height:1.7;">
        Gracias por tu interés en los pisos <strong style="color:#884A39;">Deckeva</strong>. Hemos preparado esta cotización formal para el piso de tu <strong>' . esc_html($lancha_info) . '</strong>. A continuación encontrarás el detalle completo:
    </p>
</td>
</tr>

<!-- Fecha -->
<tr>
<td style="padding: 5px 45px 20px;">
    <p style="margin:0; color:#9ca3af; font-size:13px;">Fecha: ' . esc_html($fecha) . '</p>
</td>
</tr>

<!-- Resumen de la cotización -->
<tr>
<td style="padding: 0 45px;">
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background: linear-gradient(135deg, #fdf8f5 0%, #f9f0ea 100%); border-radius:14px; border: 1px solid rgba(136,74,57,0.12);">
    
    <!-- Título -->
    <tr>
    <td colspan="2" style="padding: 22px 25px 15px;">
        <p style="margin:0; font-size:11px; color:#884A39; font-weight:700; letter-spacing:2px; text-transform:uppercase;">Detalle de tu Cotización</p>
    </td>
    </tr>

    <!-- Tamaño -->
    <tr>
    <td style="padding: 8px 25px; color:#6b7280; font-size:14px; width:45%;">Tamaño Embarcación</td>
    <td style="padding: 8px 25px; color:#2d2d2d; font-size:14px; font-weight:600;">' . esc_html($tamano) . '</td>
    </tr>';

    if (!empty($marca)) {
        $html .= '
    <tr>
    <td style="padding: 8px 25px; color:#6b7280; font-size:14px;">Marca</td>
    <td style="padding: 8px 25px; color:#2d2d2d; font-size:14px; font-weight:600;">' . esc_html($marca) . '</td>
    </tr>';
    }

    if (!empty($modelo)) {
        $html .= '
    <tr>
    <td style="padding: 8px 25px; color:#6b7280; font-size:14px;">Modelo</td>
    <td style="padding: 8px 25px; color:#2d2d2d; font-size:14px; font-weight:600;">' . esc_html($modelo) . '</td>
    </tr>';
    }

    if (!empty($year)) {
        $html .= '
    <tr>
    <td style="padding: 8px 25px; color:#6b7280; font-size:14px;">Año</td>
    <td style="padding: 8px 25px; color:#2d2d2d; font-size:14px; font-weight:600;">' . esc_html($year) . '</td>
    </tr>';
    }

    if (!empty($color)) {
        $html .= '
    <tr>
    <td style="padding: 8px 25px; color:#6b7280; font-size:14px;">Color Piso</td>
    <td style="padding: 8px 25px; color:#2d2d2d; font-size:14px; font-weight:600;">' . esc_html($color) . '</td>
    </tr>';
    }

    $html .= '
    <!-- Separador -->
    <tr>
    <td colspan="2" style="padding: 12px 25px 0;">
        <div style="border-top: 2px dashed rgba(136,74,57,0.15);"></div>
    </td>
    </tr>

    <!-- Precio destacado -->
    <tr>
    <td style="padding: 18px 25px 22px; color:#2d2d2d; font-size:16px; font-weight:700;">Precio Estimado</td>
    <td style="padding: 18px 25px 22px;">
        <span style="background:#884A39; color:#ffffff; padding:8px 18px; border-radius:8px; font-size:16px; font-weight:700; display:inline-block;">' . esc_html($precio) . '</span>
    </td>
    </tr>
    </table>
</td>
</tr>

<!-- Mensaje de confianza -->
<tr>
<td style="padding: 30px 45px 10px;">
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background:#f0fdf4; border-radius:12px; border-left:4px solid #22c55e;">
    <tr>
    <td style="padding: 20px 22px;">
        <p style="margin:0 0 6px; font-size:15px; font-weight:700; color:#15803d;">Tu lancha merece el mejor piso</p>
        <p style="margin:0; font-size:14px; color:#4b5563; line-height:1.6;">
            Con <strong>Deckeva</strong>, tu embarcación lucirá impecable con un look moderno y elegante. 
            Nuestros pisos antideslizantes de <strong>Goma Eva de alta calidad</strong> no solo transforman la apariencia 
            de tu lancha, sino que ofrecen máxima <strong>seguridad, comodidad y durabilidad</strong>.
        </p>
    </td>
    </tr>
    </table>
</td>
</tr>

<!-- Beneficios -->
<tr>
<td style="padding: 20px 45px 5px;">
    <p style="margin:0 0 15px; font-size:13px; color:#884A39; font-weight:700; letter-spacing:1.5px; text-transform:uppercase;">Por qué elegir Deckeva</p>
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
    <tr>
        <td style="padding:6px 0; font-size:14px; color:#4b5563; line-height:1.5;">
            &#10003;&nbsp;&nbsp;<strong>Antideslizante superior</strong> — Máxima seguridad incluso mojado
        </td>
    </tr>
    <tr>
        <td style="padding:6px 0; font-size:14px; color:#4b5563; line-height:1.5;">
            &#10003;&nbsp;&nbsp;<strong>Absorción de choque</strong> — Mayor comodidad en navegación
        </td>
    </tr>
    <tr>
        <td style="padding:6px 0; font-size:14px; color:#4b5563; line-height:1.5;">
            &#10003;&nbsp;&nbsp;<strong>Resistente a UV y agua salada</strong> — Durabilidad garantizada
        </td>
    </tr>
    <tr>
        <td style="padding:6px 0; font-size:14px; color:#4b5563; line-height:1.5;">
            &#10003;&nbsp;&nbsp;<strong>Diseño personalizado</strong> — Se adapta a tu embarcación
        </td>
    </tr>
    <tr>
        <td style="padding:6px 0; font-size:14px; color:#4b5563; line-height:1.5;">
            &#10003;&nbsp;&nbsp;<strong>Instalación profesional</strong> — Resultado impecable garantizado
        </td>
    </tr>
    </table>
</td>
</tr>

<!-- CTA -->
<tr>
<td style="padding: 30px 45px; text-align:center;">
    <p style="margin:0 0 18px; font-size:15px; color:#4b5563;">
        ¿Listo para darle un <strong>nuevo look</strong> a tu lancha? Coordina la toma de medidas y asegura tu piso.
    </p>
    <table role="presentation" cellpadding="0" cellspacing="0" style="margin:0 auto;">
    <tr>
        <td style="background:#884A39; border-radius:10px;">
            <a href="https://deckeva.com/#precio" style="display:inline-block; padding:14px 35px; color:#ffffff; font-size:15px; font-weight:700; text-decoration:none; letter-spacing:0.5px;">
                Confirmar Mi Pedido
            </a>
        </td>
    </tr>
    </table>
    <p style="margin:15px 0 0; font-size:13px; color:#9ca3af;">
        O escríbenos directamente por WhatsApp
    </p>
</td>
</tr>

<!-- Contacto rápido -->
<tr>
<td style="padding: 0 45px 30px; text-align:center;">
    <table role="presentation" cellpadding="0" cellspacing="0" style="margin:0 auto;">
    <tr>
        <td style="background:#25D366; border-radius:10px;">
            <a href="https://wa.me/56962180599?text=Hola%2C%20recib%C3%AD%20la%20cotizaci%C3%B3n%20N%C2%B0%20' . esc_attr($numero_cotizacion) . '%20y%20me%20gustar%C3%ADa%20coordinar%20la%20confección." style="display:inline-block; padding:12px 30px; color:#ffffff; font-size:14px; font-weight:600; text-decoration:none;">
                Escribir por WhatsApp
            </a>
        </td>
    </tr>
    </table>
</td>
</tr>

<!-- Nota de validez -->
<tr>
<td style="padding: 0 45px 25px;">
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background:#fffbeb; border-radius:10px; border:1px solid #fcd34d;">
    <tr>
    <td style="padding: 14px 18px;">
        <p style="margin:0; font-size:13px; color:#92400e; line-height:1.5;">
            <strong>Nota:</strong> Esta cotización tiene una validez de <strong>15 días</strong> a partir de la fecha de emisión. 
            Los precios pueden variar según disponibilidad de stock. ¡Te recomendamos asegurar tu pedido pronto!
        </p>
    </td>
    </tr>
    </table>
</td>
</tr>

<!-- Footer -->
<tr>
<td style="background: linear-gradient(135deg, #5C3D2E 0%, #884A39 50%, #6d3a2d 100%); padding: 30px 45px; text-align:center;">
    <img src="https://deckeva.com/wp-content/uploads/2020/12/WhatsApp-Image-2023-08-03-at-11.27.49-AM.jpeg" alt="Deckeva" width="140" style="display:inline-block; max-width:140px; margin-bottom:12px; opacity:0.9;" />
    <p style="margin:0 0 6px; color:rgba(255,255,255,0.9); font-size:13px;">Pisos para Lanchas y Embarcaciones Antideslizantes</p>
    <p style="margin:0 0 12px; color:rgba(255,255,255,0.6); font-size:12px;">Santiago, Chile | +56 9 6218 0599</p>
    <p style="margin:0;">
        <a href="https://deckeva.com" style="color:#D4956A; font-size:13px; text-decoration:none; font-weight:600;">www.deckeva.com</a>
    </p>
</td>
</tr>

</table>
<!-- /Main Card -->

</td></tr>
</table>
<!-- /Wrapper -->

</body>
</html>';

    return $html;
}

/**
 * Construye el email HTML para el administrador.
 */
function deckeva_build_admin_email($nombre_completo, $email, $telefono, $tamano, $marca, $modelo, $year, $color, $precio, $numero_cotizacion, $fecha) {
    $html = '<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Nueva Cotización</title>
</head>
<body style="margin:0; padding:0; background-color:#f1f5f9; font-family: \'Helvetica Neue\', Helvetica, Arial, sans-serif;">

<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color:#f1f5f9;">
<tr><td align="center" style="padding: 30px 15px;">

<table role="presentation" width="600" cellpadding="0" cellspacing="0" style="background-color:#ffffff; border-radius:14px; overflow:hidden; box-shadow: 0 2px 12px rgba(0,0,0,0.08);">

<!-- Header Admin -->
<tr>
<td style="background:#1e293b; padding: 25px 35px; text-align:center;">
    <p style="margin:0 0 4px; color:#ffffff; font-size:18px; font-weight:700;">Nueva Solicitud de Cotización</p>
    <p style="margin:0; color:#94a3b8; font-size:13px;">Formulario de precio completado en deckeva.com</p>
</td>
</tr>

<!-- Badge -->
<tr>
<td style="padding: 0; text-align:center;">
    <table role="presentation" cellpadding="0" cellspacing="0" style="margin: -14px auto 0; background:#884A39; border-radius:20px;">
    <tr>
        <td style="padding: 8px 22px; color:#ffffff; font-size:12px; font-weight:700; letter-spacing:1px;">
            N° ' . esc_html($numero_cotizacion) . ' &mdash; ' . esc_html($fecha) . '
        </td>
    </tr>
    </table>
</td>
</tr>

<!-- Datos del cliente -->
<tr>
<td style="padding: 30px 35px 15px;">
    <p style="margin:0 0 15px; font-size:12px; color:#884A39; font-weight:700; letter-spacing:2px; text-transform:uppercase;">Datos del Cliente</p>
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="border:1px solid #e2e8f0; border-radius:10px; overflow:hidden;">
    <tr style="background:#f8fafc;">
        <td style="padding:10px 16px; color:#64748b; font-size:13px; width:35%; border-bottom:1px solid #e2e8f0;">Nombre</td>
        <td style="padding:10px 16px; color:#1e293b; font-size:14px; font-weight:600; border-bottom:1px solid #e2e8f0;">' . esc_html($nombre_completo) . '</td>
    </tr>
    <tr>
        <td style="padding:10px 16px; color:#64748b; font-size:13px; border-bottom:1px solid #e2e8f0;">Email</td>
        <td style="padding:10px 16px; border-bottom:1px solid #e2e8f0;">
            <a href="mailto:' . esc_attr($email) . '" style="color:#884A39; font-size:14px; text-decoration:none; font-weight:600;">' . esc_html($email) . '</a>
        </td>
    </tr>
    <tr style="background:#f8fafc;">
        <td style="padding:10px 16px; color:#64748b; font-size:13px; border-bottom:1px solid #e2e8f0;">Teléfono</td>
        <td style="padding:10px 16px; border-bottom:1px solid #e2e8f0;">
            <a href="tel:' . esc_attr($telefono) . '" style="color:#884A39; font-size:14px; text-decoration:none; font-weight:600;">' . esc_html($telefono) . '</a>
        </td>
    </tr>
    </table>
</td>
</tr>

<!-- Datos de la embarcación -->
<tr>
<td style="padding: 15px 35px;">
    <p style="margin:0 0 15px; font-size:12px; color:#884A39; font-weight:700; letter-spacing:2px; text-transform:uppercase;">Datos de la Embarcación</p>
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="border:1px solid #e2e8f0; border-radius:10px; overflow:hidden;">
    <tr style="background:#f8fafc;">
        <td style="padding:10px 16px; color:#64748b; font-size:13px; width:35%; border-bottom:1px solid #e2e8f0;">Tamaño</td>
        <td style="padding:10px 16px; color:#1e293b; font-size:14px; font-weight:600; border-bottom:1px solid #e2e8f0;">' . esc_html($tamano) . '</td>
    </tr>';

    if (!empty($marca)) {
        $html .= '
    <tr>
        <td style="padding:10px 16px; color:#64748b; font-size:13px; border-bottom:1px solid #e2e8f0;">Marca</td>
        <td style="padding:10px 16px; color:#1e293b; font-size:14px; font-weight:600; border-bottom:1px solid #e2e8f0;">' . esc_html($marca) . '</td>
    </tr>';
    }

    if (!empty($modelo)) {
        $html .= '
    <tr style="background:#f8fafc;">
        <td style="padding:10px 16px; color:#64748b; font-size:13px; border-bottom:1px solid #e2e8f0;">Modelo</td>
        <td style="padding:10px 16px; color:#1e293b; font-size:14px; font-weight:600; border-bottom:1px solid #e2e8f0;">' . esc_html($modelo) . '</td>
    </tr>';
    }

    if (!empty($year)) {
        $html .= '
    <tr>
        <td style="padding:10px 16px; color:#64748b; font-size:13px; border-bottom:1px solid #e2e8f0;">Año</td>
        <td style="padding:10px 16px; color:#1e293b; font-size:14px; font-weight:600; border-bottom:1px solid #e2e8f0;">' . esc_html($year) . '</td>
    </tr>';
    }

    if (!empty($color)) {
        $html .= '
    <tr style="background:#f8fafc;">
        <td style="padding:10px 16px; color:#64748b; font-size:13px; border-bottom:1px solid #e2e8f0;">Color Piso</td>
        <td style="padding:10px 16px; color:#1e293b; font-size:14px; font-weight:600; border-bottom:1px solid #e2e8f0;">' . esc_html($color) . '</td>
    </tr>';
    }

    $html .= '
    <!-- Precio -->
    <tr style="background:#fef3c7;">
        <td style="padding:12px 16px; color:#92400e; font-size:14px; font-weight:700;">Precio Cotizado</td>
        <td style="padding:12px 16px; color:#92400e; font-size:16px; font-weight:700;">' . esc_html($precio) . '</td>
    </tr>
    </table>
</td>
</tr>

<!-- Acciones rápidas -->
<tr>
<td style="padding: 20px 35px; text-align:center;">
    <p style="margin:0 0 15px; font-size:14px; color:#64748b;">Acciones rápidas para contactar al cliente:</p>
    <table role="presentation" cellpadding="0" cellspacing="0" style="margin:0 auto;">
    <tr>
        <td style="padding-right:10px;">
            <a href="mailto:' . esc_attr($email) . '?subject=Cotización%20Deckeva%20' . esc_attr($numero_cotizacion) . '" style="display:inline-block; padding:10px 22px; background:#884A39; color:#ffffff; font-size:13px; font-weight:600; text-decoration:none; border-radius:8px;">
                Responder Email
            </a>
        </td>
        <td style="padding-left:10px;">
            <a href="https://wa.me/' . esc_attr(preg_replace('/[^0-9]/', '', $telefono)) . '?text=Hola%20' . rawurlencode($nombre_completo) . '%2C%20gracias%20por%20tu%20cotización%20Deckeva%20N°%20' . esc_attr($numero_cotizacion) . '." style="display:inline-block; padding:10px 22px; background:#25D366; color:#ffffff; font-size:13px; font-weight:600; text-decoration:none; border-radius:8px;">
                WhatsApp
            </a>
        </td>
    </tr>
    </table>
</td>
</tr>

<!-- Nota -->
<tr>
<td style="padding: 10px 35px 25px;">
    <p style="margin:0; font-size:12px; color:#94a3b8; text-align:center; line-height:1.5;">
        Este email fue generado automáticamente al completar el formulario de cotización en deckeva.com.<br>
        El cliente ya recibió una copia de esta cotización en su correo.
    </p>
</td>
</tr>

<!-- Footer Admin -->
<tr>
<td style="background:#f8fafc; padding: 18px 35px; text-align:center; border-top:1px solid #e2e8f0;">
    <p style="margin:0; color:#94a3b8; font-size:12px;">Deckeva - Sistema de Cotizaciones Automáticas</p>
</td>
</tr>

</table>
</td></tr>
</table>

</body>
</html>';

    return $html;
}
