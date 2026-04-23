<?php
/**
 * Plugin Name: Deckeva - Cotizador de Servicios Náuticos
 * Description: Herramienta de cotización profesional para servicios náuticos Deckeva.
 *              Accesible en /cotizador/ — wizard multi-paso, generación de PDF con DOMPDF,
 *              envío de email con cotización adjunta vía wp_mail().
 * Version: 1.0.0
 * Author: Deckeva
 */

if (!defined('ABSPATH')) {
    exit;
}

class Deckeva_Cotizador {

    private $site_url   = 'https://deckeva.cl';
    private $email_from = 'contacto@deckeva.cl';
    private $bcc_email  = 'jpchs1@gmail.com';
    private $logo_url;
    private $whatsapp   = '+56940211459';

    /* Supported currencies. 'rate' is reference CLP per 1 unit of currency.
       Used by the international (deckeva.com) endpoint for on-quote display
       only; the real quote is confirmed by the Deckeva team afterwards. */
    private $currencies = [
        'CLP' => ['symbol' => '$',  'thousands' => '.', 'rate' => 1,    'label' => 'Pesos Chilenos (CLP)'],
        'USD' => ['symbol' => '$',  'thousands' => ',', 'rate' => 970,  'label' => 'US Dollars (USD)'],
        'EUR' => ['symbol' => '€',  'thousands' => '.', 'rate' => 1050, 'label' => 'Euros (EUR)'],
        'ARS' => ['symbol' => '$',  'thousands' => '.', 'rate' => 0.90, 'label' => 'Pesos Argentinos (ARS)'],
        'MXN' => ['symbol' => '$',  'thousands' => ',', 'rate' => 55,   'label' => 'Pesos Mexicanos (MXN)'],
        'BRL' => ['symbol' => 'R$', 'thousands' => '.', 'rate' => 180,  'label' => 'Reales Brasileños (BRL)'],
        'UYU' => ['symbol' => '$U', 'thousands' => '.', 'rate' => 24,   'label' => 'Pesos Uruguayos (UYU)'],
        'PEN' => ['symbol' => 'S/', 'thousands' => ',', 'rate' => 260,  'label' => 'Soles Peruanos (PEN)'],
        'COP' => ['symbol' => '$',  'thousands' => '.', 'rate' => 0.25, 'label' => 'Pesos Colombianos (COP)'],
        'GBP' => ['symbol' => '£',  'thousands' => ',', 'rate' => 1230, 'label' => 'Libras Esterlinas (GBP)'],
    ];

    private function get_currency($code) {
        return isset($this->currencies[$code]) ? $this->currencies[$code] : $this->currencies['CLP'];
    }

    private function format_money($amount, $code) {
        $c = $this->get_currency($code);
        return $c['symbol'] . number_format(intval($amount), 0, ',', $c['thousands']);
    }

    /* Convert a CLP amount to the target currency using the configured rate
       and format with the target currency's symbol & thousands separator. */
    private function convert_and_format_from_clp($clp, $code) {
        $c = $this->get_currency($code);
        $rate = isset($c['rate']) && $c['rate'] > 0 ? (float)$c['rate'] : 1.0;
        $converted = (int) round(((float)$clp) / $rate);
        return $c['symbol'] . number_format($converted, 0, ',', $c['thousands']);
    }

    public function __construct() {
        $this->logo_url = $this->site_url . '/wp-content/uploads/2024/08/WhatsApp-Image-2023-08-03-at-11.27.49-AM.jpeg.webp';
        add_action('init', [$this, 'intercept_route'], 1);
    }

    /* ──────────────────────────────────────────
       ROUTE INTERCEPTION
    ────────────────────────────────────────── */
    public function intercept_route() {
        $uri = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');

        if ($uri === 'cotizador/enviar-email' && $_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->handle_send_email();
            return;
        }

        if ($uri === 'cotizador/enviar-international') {
            $this->handle_send_international();
            return;
        }

        if ($uri === 'cotizador') {
            if (!defined('DONOTCACHEPAGE')) {
                define('DONOTCACHEPAGE', true);
            }
            status_header(200);
            header('Content-Type: text/html; charset=UTF-8');
            header('Cache-Control: no-cache, no-store, must-revalidate');
            echo $this->render_page();
            exit;
        }
    }

    /* ──────────────────────────────────────────
       EMAIL HANDLER (AJAX POST)
    ────────────────────────────────────────── */
    private function handle_send_email() {
        header('Content-Type: application/json; charset=UTF-8');
        header('Cache-Control: no-cache, no-store, must-revalidate');

        if (!isset($_POST['_cotizador_nonce']) || !wp_verify_nonce($_POST['_cotizador_nonce'], 'deckeva_cotizador_email')) {
            wp_send_json_error(['message' => 'Nonce inválido.']);
            return;
        }

        // Rate limiting: max 5 emails per IP per hour
        $ip = $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
        $rate_key = 'cotiz_rate_' . md5($ip);
        $rate_count = intval(get_transient($rate_key));
        if ($rate_count >= 5) {
            wp_send_json_error(['message' => 'Demasiados envíos. Intente de nuevo en una hora.']);
            return;
        }
        set_transient($rate_key, $rate_count + 1, HOUR_IN_SECONDS);

        $client_name    = sanitize_text_field($_POST['client_name'] ?? '');
        $client_email   = sanitize_email($_POST['client_email'] ?? '');
        $client_phone   = sanitize_text_field($_POST['client_phone'] ?? '');
        $client_company = sanitize_text_field($_POST['client_company'] ?? '');
        $client_rut     = sanitize_text_field($_POST['client_rut'] ?? '');

        $boat_type     = sanitize_text_field($_POST['boat_type'] ?? '');
        $boat_brand    = sanitize_text_field($_POST['boat_brand'] ?? '');
        $boat_model    = sanitize_text_field($_POST['boat_model'] ?? '');
        $boat_year     = sanitize_text_field($_POST['boat_year'] ?? '');
        $boat_marina   = sanitize_text_field($_POST['boat_marina'] ?? '');

        $services_json = stripslashes($_POST['services'] ?? '[]');
        $services      = json_decode($services_json, true);
        if (!is_array($services)) $services = [];

        $subtotal      = intval($_POST['subtotal'] ?? 0);
        $discount_value = intval($_POST['discount_value'] ?? 0);
        $discount_type  = sanitize_text_field($_POST['discount_type'] ?? 'amount');
        $total          = intval($_POST['total'] ?? 0);
        $quote_number   = sanitize_text_field($_POST['quote_number'] ?? '');
        $currency_code  = strtoupper(sanitize_text_field($_POST['currency_code'] ?? 'CLP'));
        if (!isset($this->currencies[$currency_code])) {
            $currency_code = 'CLP';
        }
        // pdf_html is no longer used from client; PDF is generated server-side

        if (empty($client_email) || empty($client_name)) {
            wp_send_json_error(['message' => 'Nombre y email son requeridos.']);
            return;
        }

        // Build PDF server-side with DOMPDF (no client-supplied HTML)
        $pdf_path = null;
        $dompdf_autoload = __DIR__ . '/dompdf/autoload.php';
        if (file_exists($dompdf_autoload)) {
            require_once $dompdf_autoload;
            try {
                $dompdf = new \Dompdf\Dompdf([
                    'isRemoteEnabled' => false,
                    'isPhpEnabled'    => false,
                ]);
                $pdf_html = $this->build_pdf_html($client_name, $client_email, $client_phone, $client_company, $client_rut, $boat_type, $boat_brand, $boat_model, $boat_year, $boat_marina, $services, $subtotal, $discount_value, $discount_type, $total, $quote_number, $currency_code);
                $dompdf->loadHtml($pdf_html);
                $dompdf->setPaper('A4', 'portrait');
                $dompdf->render();
                $pdf_output = $dompdf->output();
                $upload_dir = wp_upload_dir();
                $pdf_dir = $upload_dir['basedir'] . '/cotizaciones';
                if (!is_dir($pdf_dir)) {
                    wp_mkdir_p($pdf_dir);
                }
                $pdf_filename = 'Cotizacion-DECKEVA-' . preg_replace('/[^A-Za-z0-9\-]/', '', $quote_number) . '.pdf';
                $pdf_path = $pdf_dir . '/' . $pdf_filename;
                file_put_contents($pdf_path, $pdf_output);
            } catch (\Exception $e) {
                error_log('[Deckeva Cotizador] DOMPDF error: ' . $e->getMessage());
                $pdf_path = null;
            }
        }

        // Build HTML email body
        $email_html = $this->build_email_html($client_name, $client_email, $client_phone, $client_company, $client_rut, $boat_type, $boat_brand, $boat_model, $boat_year, $boat_marina, $services, $subtotal, $discount_value, $discount_type, $total, $quote_number, $currency_code);

        $headers = [
            'Content-Type: text/html; charset=UTF-8',
            'From: Deckeva <' . $this->email_from . '>',
            'Bcc: ' . $this->bcc_email,
        ];

        $subject = 'Cotización Deckeva N° ' . $quote_number . ' - Servicios Náuticos';
        $attachments = [];
        if ($pdf_path && file_exists($pdf_path)) {
            $attachments[] = $pdf_path;
        }

        $sent = wp_mail($client_email, $subject, $email_html, $headers, $attachments);

        // Also send admin notification
        $admin_email = get_option('admin_email');
        $admin_headers = [
            'Content-Type: text/html; charset=UTF-8',
            'From: Deckeva Cotizador <' . $this->email_from . '>',
        ];
        $admin_subject = 'Nueva Cotización N° ' . $quote_number . ' - ' . $client_name;
        wp_mail($admin_email, $admin_subject, $email_html, $admin_headers, $attachments);

        // Clean up PDF file after sending
        if ($pdf_path && file_exists($pdf_path)) {
            @unlink($pdf_path);
        }

        if ($sent) {
            wp_send_json_success(['message' => 'Cotización enviada exitosamente a ' . $client_email]);
        } else {
            wp_send_json_error(['message' => 'Error al enviar el email. Intente nuevamente.']);
        }
    }

    /* ──────────────────────────────────────────
       INTERNATIONAL (deckeva.com) — send quote endpoint
       POST /cotizador/enviar-international
       Accepts from deckeva.com / www.deckeva.com (CORS), returns JSON.
       mode: "email" | "whatsapp" | "both"
    ────────────────────────────────────────── */
    private $whatsapp_retention_days = 30;

    private function set_intl_cors_headers() {
        $allowed = ['https://deckeva.com', 'https://www.deckeva.com', 'https://deckeva.cl', 'https://www.deckeva.cl'];
        $origin = $_SERVER['HTTP_ORIGIN'] ?? '';
        if (in_array($origin, $allowed, true)) {
            header('Access-Control-Allow-Origin: ' . $origin);
            header('Vary: Origin');
        }
        header('Access-Control-Allow-Methods: POST, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type');
    }

    private function cleanup_intl_quotes() {
        $upload_dir = wp_upload_dir();
        $pdf_dir = $upload_dir['basedir'] . '/cotizaciones-intl';
        if (!is_dir($pdf_dir)) return;
        $max_age = intval($this->whatsapp_retention_days) * DAY_IN_SECONDS;
        $now = time();
        foreach (glob($pdf_dir . '/DECKEVA-Quote-*.pdf') as $file) {
            if (($now - @filemtime($file)) > $max_age) {
                @unlink($file);
            }
        }
    }

    private function handle_send_international() {
        $this->set_intl_cors_headers();

        if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
            status_header(204);
            exit;
        }

        header('Content-Type: application/json; charset=UTF-8');
        header('Cache-Control: no-cache, no-store, must-revalidate');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            wp_send_json_error(['message' => 'Method not allowed.']);
            return;
        }

        // Probabilistic cleanup (~1% of requests trigger)
        if (mt_rand(1, 100) === 1) {
            $this->cleanup_intl_quotes();
        }

        // Rate limit: 5 requests/hour per IP
        $ip = $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
        $rate_key = 'cotiz_intl_' . md5($ip);
        $rate_count = intval(get_transient($rate_key));
        if ($rate_count >= 5) {
            wp_send_json_error(['message' => 'Demasiados envíos. Intente de nuevo en una hora.']);
            return;
        }
        set_transient($rate_key, $rate_count + 1, HOUR_IN_SECONDS);

        // Honeypot (if present, bot)
        if (!empty($_POST['website'])) {
            wp_send_json_error(['message' => 'Bot detected.']);
            return;
        }

        $mode = sanitize_text_field($_POST['mode'] ?? '');
        if (!in_array($mode, ['email', 'whatsapp', 'both'], true)) {
            wp_send_json_error(['message' => 'Modo inválido.']);
            return;
        }

        $first   = sanitize_text_field($_POST['client_first_name'] ?? '');
        $last    = sanitize_text_field($_POST['client_last_name'] ?? '');
        $email   = sanitize_email($_POST['client_email'] ?? '');
        $phone   = sanitize_text_field($_POST['client_phone'] ?? '');
        $country = sanitize_text_field($_POST['client_country'] ?? '');

        $boat_size  = sanitize_text_field($_POST['boat_size'] ?? '');
        $boat_brand = sanitize_text_field($_POST['boat_brand'] ?? '');
        $boat_model = sanitize_text_field($_POST['boat_model'] ?? '');
        $boat_year  = sanitize_text_field($_POST['boat_year'] ?? '');
        $boat_color = sanitize_text_field($_POST['boat_color'] ?? '');

        $price_clp = max(0, intval($_POST['price_clp'] ?? 0));
        $currency_code = strtoupper(sanitize_text_field($_POST['currency_code'] ?? 'CLP'));
        if (!isset($this->currencies[$currency_code])) $currency_code = 'CLP';

        if (empty($first) || empty($email) || empty($country)) {
            wp_send_json_error(['message' => 'Nombre, email y país son requeridos.']);
            return;
        }
        if (!is_email($email)) {
            wp_send_json_error(['message' => 'Email inválido.']);
            return;
        }

        // IVA 19% always (regardless of country)
        $iva_clp = intval(round($price_clp * 0.19));
        $total_clp = $price_clp + $iva_clp;

        $quote_number = 'DCK-INT-' . date('YmdHis') . '-' . strtoupper(substr(md5(uniqid('', true)), 0, 5));

        // Build PDF via DOMPDF (if available)
        $pdf_path = null;
        $pdf_url = null;
        $dompdf_autoload = __DIR__ . '/dompdf/autoload.php';
        if (file_exists($dompdf_autoload)) {
            require_once $dompdf_autoload;
            try {
                $dompdf = new \Dompdf\Dompdf([
                    'isRemoteEnabled' => false,
                    'isPhpEnabled'    => false,
                ]);
                $pdf_html = $this->build_international_pdf_html(
                    $first, $last, $email, $phone, $country,
                    $boat_size, $boat_brand, $boat_model, $boat_year, $boat_color,
                    $price_clp, $iva_clp, $total_clp, $currency_code, $quote_number
                );
                $dompdf->loadHtml($pdf_html, 'UTF-8');
                $dompdf->setPaper('A4', 'portrait');
                $dompdf->render();
                $pdf_output = $dompdf->output();

                $upload_dir = wp_upload_dir();
                $pdf_dir = $upload_dir['basedir'] . '/cotizaciones-intl';
                $pdf_url_base = $upload_dir['baseurl'] . '/cotizaciones-intl';
                if (!is_dir($pdf_dir)) wp_mkdir_p($pdf_dir);
                // Prevent search indexing of the directory
                $htaccess = $pdf_dir . '/.htaccess';
                if (!file_exists($htaccess)) {
                    @file_put_contents($htaccess, "<IfModule mod_headers.c>\nHeader set X-Robots-Tag \"noindex, nofollow\"\n</IfModule>\n");
                }
                // Unguessable filename
                $uuid = bin2hex(random_bytes(16));
                $pdf_filename = 'DECKEVA-Quote-' . $quote_number . '-' . $uuid . '.pdf';
                $pdf_path = $pdf_dir . '/' . $pdf_filename;
                file_put_contents($pdf_path, $pdf_output);
                $pdf_url = $pdf_url_base . '/' . $pdf_filename;
            } catch (\Exception $e) {
                error_log('[Deckeva INT PDF] ' . $e->getMessage());
                $pdf_path = null;
                $pdf_url = null;
            }
        }

        $email_sent = false;
        $email_error = null;
        if ($mode === 'email' || $mode === 'both') {
            $email_html = $this->build_international_email_html(
                $first, $last, $email, $phone, $country,
                $boat_size, $boat_brand, $boat_model, $boat_year, $boat_color,
                $price_clp, $iva_clp, $total_clp, $currency_code, $quote_number
            );
            $headers = [
                'Content-Type: text/html; charset=UTF-8',
                'From: Deckeva <' . $this->email_from . '>',
                'Bcc: ' . $this->bcc_email,
            ];
            $subject = 'DECKEVA — Cotización / Quote ' . $quote_number;
            $attachments = ($pdf_path && file_exists($pdf_path)) ? [$pdf_path] : [];
            $email_sent = wp_mail($email, $subject, $email_html, $headers, $attachments);
            if (!$email_sent) {
                $email_error = 'No pudimos enviar el email. Intente por WhatsApp.';
            }
        }

        // Email-only: delete server copy after sending. WhatsApp/Both: keep
        // for the client to download via the link in WhatsApp.
        if ($mode === 'email' && $pdf_path && file_exists($pdf_path)) {
            @unlink($pdf_path);
            $pdf_url = null;
        }

        $response = [
            'mode'         => $mode,
            'quote_number' => $quote_number,
            'email_sent'   => $email_sent,
        ];
        if ($email_error) $response['email_error'] = $email_error;
        if ($pdf_url)     $response['pdf_url'] = $pdf_url;

        // Failure only if email requested and send failed.
        if (($mode === 'email' || $mode === 'both') && !$email_sent) {
            wp_send_json_error($response);
            return;
        }
        wp_send_json_success($response);
    }

    /* ──────────────────────────────────────────
       INTERNATIONAL — PDF builder (DOMPDF HTML)
    ────────────────────────────────────────── */
    private function build_international_pdf_html($first, $last, $email, $phone, $country, $boat_size, $boat_brand, $boat_model, $boat_year, $boat_color, $price_clp, $iva_clp, $total_clp, $currency_code, $quote_number) {
        $fecha = date_i18n('d/m/Y');
        $currency = $this->get_currency($currency_code);
        $fm = function ($clp) use ($currency_code) { return $this->convert_and_format_from_clp($clp, $currency_code); };

        $size_label = ($boat_size && $boat_size !== 'otro') ? esc_html($boat_size) . ' ft / pies' : 'Otro / Other';
        $boat_desc  = trim($boat_brand . ' ' . $boat_model . ' ' . ($boat_year ? '(' . $boat_year . ')' : ''));
        $rate_line  = ($currency_code === 'CLP')
            ? ''
            : '<p style="margin:2px 0 0;font-size:10px;color:#888;">Ref: 1 ' . esc_html($currency_code) . ' ≈ ' . esc_html(number_format($currency['thousands'] === ',' ? (float)$currency['thousands'] : 0, 0)) . '</p>';
        // Build rate line precisely from the in-memory currency definition
        $rate_str = '';
        if ($currency_code !== 'CLP' && isset($this->currency_rates[$currency_code])) {
            $r = $this->currency_rates[$currency_code];
            if ($r >= 1) $rate_str = '1 ' . $currency_code . ' ≈ ' . number_format($r, 0, ',', '.') . ' CLP';
            else         $rate_str = '1 CLP ≈ ' . number_format(1 / $r, 2, ',', '.') . ' ' . $currency_code;
        }

        return '<!DOCTYPE html><html><head><meta charset="UTF-8">
<style>
body { font-family: Helvetica, Arial, sans-serif; margin: 0; padding: 22px; color: #1a2a3a; font-size: 12px; line-height: 1.5; }
h1 { font-size: 20px; color: #0d2137; margin: 0 0 4px; }
h2 { font-size: 12px; color: #0d2137; margin: 18px 0 6px; text-transform: uppercase; letter-spacing: 1px; }
.header { text-align: center; padding: 14px 0; border-bottom: 3px solid #0d2137; margin-bottom: 14px; }
.badge { display: inline-block; background: #e8a735; color: #fff; padding: 5px 14px; border-radius: 16px; font-size: 10px; font-weight: 700; letter-spacing: 1px; }
table { width: 100%; border-collapse: collapse; }
td { padding: 4px 10px; vertical-align: top; }
.lbl { color: #666; width: 28%; }
.val { font-weight: 600; color: #1a2a3a; }
.price-box { margin-top: 8px; border: 1px solid #e5e7eb; border-radius: 8px; padding: 12px 14px; background: #f8faff; }
.price-row { display: flex; justify-content: space-between; padding: 3px 0; font-size: 13px; }
.price-row.total { margin-top: 8px; padding-top: 8px; border-top: 2px solid #0d2137; font-size: 15px; font-weight: 800; }
.notice { margin-top: 16px; padding: 14px 16px; border: 1px solid #e8a735; border-radius: 8px; background: #fffbee; }
.notice h3 { font-size: 12px; color: #a56a00; margin: 0 0 6px; text-transform: uppercase; letter-spacing: 1px; }
.notice ul { margin: 6px 0 0 18px; padding: 0; font-size: 11px; color: #4a4a4a; }
.notice li { margin-bottom: 3px; }
.footer { margin-top: 18px; padding-top: 10px; border-top: 1px solid #ddd; text-align: center; font-size: 10px; color: #888; }
</style>
</head><body>
<div class="header">
  <h1>DECKEVA</h1>
  <p style="margin:2px 0;color:#666;font-size:10px;letter-spacing:2px;">CUSTOM MARINE EVA FLOORING · PISOS NÁUTICOS A MEDIDA</p>
  <div class="badge">QUOTE · COTIZACIÓN ' . esc_html($quote_number) . '</div>
  <p style="margin:6px 0 0;color:#999;font-size:11px;">Date / Fecha: ' . esc_html($fecha) . '</p>
</div>

<h2>Client / Cliente</h2>
<table>
<tr><td class="lbl">Name / Nombre</td><td class="val">' . esc_html(trim($first . ' ' . $last)) . '</td></tr>
<tr><td class="lbl">Email</td><td class="val">' . esc_html($email) . '</td></tr>
' . ($phone ? '<tr><td class="lbl">Phone / Teléfono</td><td class="val">' . esc_html($phone) . '</td></tr>' : '') . '
<tr><td class="lbl">Shipping / Envío</td><td class="val">' . esc_html($country) . '</td></tr>
</table>

<h2>Vessel / Embarcación</h2>
<table>
<tr><td class="lbl">Size / Tamaño</td><td class="val">' . $size_label . '</td></tr>
' . ($boat_desc ? '<tr><td class="lbl">Make &amp; Model</td><td class="val">' . esc_html($boat_desc) . '</td></tr>' : '') . '
' . ($boat_color ? '<tr><td class="lbl">Color</td><td class="val">' . esc_html($boat_color) . '</td></tr>' : '') . '
</table>

<h2>Pricing / Precios</h2>
<div class="price-box">
  <div class="price-row"><span>Base / Subtotal</span><span>' . esc_html($fm($price_clp)) . '</span></div>
  <div class="price-row"><span>IVA / VAT 19%</span><span>' . esc_html($fm($iva_clp)) . '</span></div>
  <div class="price-row total"><span>TOTAL</span><span>' . esc_html($fm($total_clp)) . '</span></div>
  ' . ($rate_str ? '<p style="margin:6px 0 0;font-size:10px;color:#888;">Reference rate / Tipo de cambio ref: ' . esc_html($rate_str) . '</p>' : '') . '
  <p style="margin:4px 0 0;font-size:10px;color:#888;">* Precio referencial / Reference quote · Final confirmation upon order.</p>
</div>

<div class="notice">
  <h3>📐 Toma de Medidas &amp; 🛠️ Instalación — Importante / Important</h3>
  <p style="margin:0 0 6px;font-size:11px;color:#4a4a4a;"><strong>ES:</strong> La <strong>toma de medidas</strong> (para envíos dentro de Chile) y la <strong>instalación</strong> del piso deben ser contratadas por el cliente con un técnico o persona de su confianza. Deckeva no realiza estas tareas presencialmente. Estos costos <u>no están incluidos</u> en la cotización y deben ser considerados aparte.</p>
  <table style="width:100%;margin-top:6px;border-collapse:collapse;font-size:11px;">
    <tr style="background:#fff4d6;"><td style="padding:6px 10px;font-weight:700;color:#7a4a00;">Ítem / Item</td><td style="padding:6px 10px;font-weight:700;color:#7a4a00;">Costo ref. / Ref. cost</td><td style="padding:6px 10px;font-weight:700;color:#7a4a00;">Tiempo / Time</td></tr>
    <tr><td style="padding:6px 10px;color:#4a4a4a;">📐 Toma de medidas · Measurement</td><td style="padding:6px 10px;color:#4a4a4a;font-weight:600;">USD $120</td><td style="padding:6px 10px;color:#4a4a4a;">4–6 hrs aprox.</td></tr>
    <tr><td style="padding:6px 10px;color:#4a4a4a;">🛠️ Instalación · Installation</td><td style="padding:6px 10px;color:#4a4a4a;font-weight:600;">USD $120</td><td style="padding:6px 10px;color:#4a4a4a;">3–5 hrs aprox.</td></tr>
  </table>
  <p style="margin:8px 0 4px;font-size:11px;color:#4a4a4a;">Para acompañarte en ambos procesos, Deckeva entrega <strong>sin costo</strong>:</p>
  <ul>
    <li>Video explicativo paso a paso para la <strong>toma de medidas</strong>.</li>
    <li>Video explicativo paso a paso para la <strong>instalación</strong>.</li>
    <li>Soporte <strong>24/7 por WhatsApp y teléfono (+56 9 4021 1459)</strong> para resolver dudas o asesorar a tu técnico en vivo.</li>
  </ul>
  <p style="margin:8px 0 4px;font-size:11px;color:#4a4a4a;"><strong>EN:</strong> Measurement (shipments to Chile) and installation must be arranged by the customer with a technician or trusted person. These costs are <u>not included</u> in the quote. Reference: <strong>USD $120</strong> each, measurement ~4–6 hrs, installation ~3–5 hrs (varies per vessel). Deckeva provides <strong>step-by-step explainer videos</strong> and <strong>24/7 WhatsApp &amp; phone support (+56 9 4021 1459)</strong> at no extra cost.</p>
</div>

<div class="footer">
  <p>This quote is valid for 15 business days. / Esta cotización es válida por 15 días hábiles.<br>
  WhatsApp: +56 9 4021 1459 · contacto@deckeva.cl · deckeva.com · deckeva.cl</p>
</div>
</body></html>';
    }

    /* ──────────────────────────────────────────
       INTERNATIONAL — Email HTML builder
    ────────────────────────────────────────── */
    private function build_international_email_html($first, $last, $email, $phone, $country, $boat_size, $boat_brand, $boat_model, $boat_year, $boat_color, $price_clp, $iva_clp, $total_clp, $currency_code, $quote_number) {
        $fecha = date_i18n('d/m/Y');
        $fm = function ($clp) use ($currency_code) { return $this->convert_and_format_from_clp($clp, $currency_code); };
        $size_label = ($boat_size && $boat_size !== 'otro') ? esc_html($boat_size) . ' ft / pies' : 'Otro / Other';
        $boat_desc  = trim($boat_brand . ' ' . $boat_model . ' ' . ($boat_year ? '(' . $boat_year . ')' : ''));

        $html = '<!DOCTYPE html><html><head><meta charset="UTF-8"></head>
<body style="margin:0;padding:0;background:#f0f2f5;font-family:Helvetica,Arial,sans-serif;color:#1a2a3a;">
<table width="100%" cellpadding="0" cellspacing="0" style="background:#f0f2f5;">
<tr><td align="center" style="padding:30px 15px;">
<table width="600" cellpadding="0" cellspacing="0" style="background:#fff;border-radius:16px;overflow:hidden;box-shadow:0 4px 24px rgba(0,40,80,0.12);">
<tr><td style="background:linear-gradient(135deg,#0d2137 0%,#1a3a5c 50%,#2a5a8c 100%);padding:28px 36px;text-align:center;color:#fff;">
<h1 style="margin:0;font-size:28px;letter-spacing:3px;">DECKEVA</h1>
<p style="margin:4px 0 0;color:rgba(255,255,255,0.75);font-size:11px;letter-spacing:2px;text-transform:uppercase;">Custom Marine EVA Flooring · Pisos a medida</p>
</td></tr>
<tr><td style="padding:28px 36px 10px;">
<h2 style="margin:0 0 4px;font-size:18px;color:#0d2137;">Hi ' . esc_html($first) . ',</h2>
<p style="margin:0;color:#6b7280;font-size:14px;line-height:1.7;">Thanks for reaching out! Attached is your custom quote from Deckeva. We will follow up via WhatsApp or email within 24 hours to confirm details.</p>
<p style="margin:12px 0 0;color:#6b7280;font-size:14px;line-height:1.7;">Hola ' . esc_html($first) . ', adjuntamos tu cotización. Te contactaremos en menos de 24 horas para confirmar los detalles.</p>
<p style="margin:10px 0 0;color:#9ca3af;font-size:12px;">Quote Nº ' . esc_html($quote_number) . ' · ' . esc_html($fecha) . '</p>
</td></tr>
<tr><td style="padding:6px 36px 0;">
<table width="100%" cellpadding="0" cellspacing="0" style="background:#f8faff;border-radius:10px;border:1px solid #e5e7eb;padding:14px 18px;">
<tr><td style="padding:0 0 8px;font-size:10px;color:#0d2137;font-weight:700;letter-spacing:2px;text-transform:uppercase;">Vessel / Embarcación</td></tr>
<tr><td style="font-size:13px;color:#1a2a3a;"><strong>' . $size_label . '</strong>' . ($boat_desc ? ' · ' . esc_html($boat_desc) : '') . ($boat_color ? ' · ' . esc_html($boat_color) : '') . '</td></tr>
</table>
</td></tr>
<tr><td style="padding:14px 36px 0;">
<table width="100%" cellpadding="0" cellspacing="0" style="border-radius:10px;border:1px solid #e5e7eb;">
<tr><td style="padding:10px 16px;font-size:13px;color:#6b7280;">Base / Subtotal</td><td style="padding:10px 16px;font-size:13px;text-align:right;color:#1a2a3a;font-weight:600;">' . esc_html($fm($price_clp)) . '</td></tr>
<tr><td style="padding:10px 16px;font-size:13px;color:#6b7280;">IVA / VAT 19%</td><td style="padding:10px 16px;font-size:13px;text-align:right;color:#1a2a3a;font-weight:600;">' . esc_html($fm($iva_clp)) . '</td></tr>
<tr><td colspan="2" style="padding:6px 16px;"><div style="border-top:2px dashed #e5e7eb;"></div></td></tr>
<tr><td style="padding:12px 16px;font-size:16px;color:#1a2a3a;font-weight:800;">TOTAL</td><td style="padding:12px 16px;text-align:right;"><span style="background:#e8a735;color:#fff;padding:6px 16px;border-radius:8px;font-size:16px;font-weight:800;">' . esc_html($fm($total_clp)) . '</span></td></tr>
</table>
</td></tr>
<tr><td style="padding:16px 36px 10px;">
<table width="100%" cellpadding="0" cellspacing="0" style="background:#fffbee;border:1px solid #e8a735;border-radius:10px;padding:14px 18px;">
<tr><td style="padding:0 0 6px;font-size:10px;color:#a56a00;font-weight:700;letter-spacing:2px;text-transform:uppercase;">📐 Toma de Medidas &amp; 🛠️ Instalación · Importante</td></tr>
<tr><td style="font-size:12px;color:#4a4a4a;line-height:1.6;">
<strong>ES:</strong> La <strong>toma de medidas</strong> (envíos a Chile) y la <strong>instalación</strong> del piso deben ser contratadas por el cliente con un técnico o persona de su confianza. Nosotros no realizamos estas tareas presencialmente. Estos costos <u>no están incluidos</u> en la cotización y deben ser considerados aparte.
</td></tr>
<tr><td style="padding-top:8px;">
<table width="100%" cellpadding="0" cellspacing="0" style="border:1px solid #f0d89a;border-radius:6px;font-size:12px;">
<tr style="background:#fff4d6;"><td style="padding:7px 10px;font-weight:700;color:#7a4a00;">Ítem / Item</td><td style="padding:7px 10px;font-weight:700;color:#7a4a00;">Costo ref.</td><td style="padding:7px 10px;font-weight:700;color:#7a4a00;">Tiempo</td></tr>
<tr><td style="padding:7px 10px;color:#4a4a4a;">📐 Toma de medidas · Measurement</td><td style="padding:7px 10px;color:#1a2a3a;font-weight:600;">USD $120</td><td style="padding:7px 10px;color:#4a4a4a;">4–6 hrs</td></tr>
<tr><td style="padding:7px 10px;color:#4a4a4a;border-top:1px solid #f0d89a;">🛠️ Instalación · Installation</td><td style="padding:7px 10px;color:#1a2a3a;font-weight:600;border-top:1px solid #f0d89a;">USD $120</td><td style="padding:7px 10px;color:#4a4a4a;border-top:1px solid #f0d89a;">3–5 hrs</td></tr>
</table>
</td></tr>
<tr><td style="padding-top:10px;font-size:12px;color:#4a4a4a;line-height:1.6;">
Deckeva entrega <strong>sin costo</strong>: videos explicativos paso a paso para ambos procesos + <strong>soporte 24/7 por WhatsApp y teléfono (+56 9 4021 1459)</strong> para resolver dudas o asesorar a tu técnico en vivo durante el trabajo.
<br><br>
<strong>EN:</strong> <strong>Measurement (shipments to Chile)</strong> and <strong>installation</strong> must be arranged by the customer with a technician or trusted person. These are <u>not included</u> in the quote. Reference: USD $120 each · ~4–6 hrs measurement · ~3–5 hrs installation. Deckeva provides free step-by-step videos + 24/7 WhatsApp &amp; phone support.
</td></tr>
</table>
</td></tr>
<tr><td style="padding:24px 36px;background:#f8faff;text-align:center;border-top:1px solid #e5e7eb;">
<p style="margin:0 0 6px;font-size:13px;color:#6b7280;">Quote valid for 15 business days / Cotización válida 15 días hábiles.</p>
<p style="margin:0;font-size:12px;color:#0d2137;font-weight:600;">WhatsApp: +56 9 4021 1459 · contacto@deckeva.cl · deckeva.com</p>
</td></tr>
</table>
</td></tr></table>
</body></html>';
        return $html;
    }

    /* ──────────────────────────────────────────
       BUILD PDF HTML (server-side, no client input)
    ────────────────────────────────────────── */
    private function build_pdf_html($name, $email, $phone, $company, $rut, $boat_type, $boat_brand, $boat_model, $boat_year, $boat_marina, $services, $subtotal, $discount_value, $discount_type, $total, $quote_number, $currency_code = 'CLP') {
        $fecha = date_i18n('d/m/Y');
        $currency = $this->get_currency($currency_code);

        $services_rows = '';
        foreach ($services as $s) {
            $sname  = esc_html($s['name'] ?? '');
            $sprice = esc_html($this->format_money(intval($s['price'] ?? 0), $currency_code));
            $services_rows .= '<tr><td style="padding:8px 12px;border-bottom:1px solid #ddd;">' . $sname . '</td><td style="padding:8px 12px;border-bottom:1px solid #ddd;text-align:right;font-weight:bold;">' . $sprice . '</td></tr>';
        }

        $discount_row = '';
        if ($discount_value > 0) {
            $disc_label = ($discount_type === 'percent') ? $discount_value . '%' : esc_html($this->format_money($discount_value, $currency_code));
            $disc_amount = $subtotal - $total;
            $discount_row = '<tr><td style="padding:8px 12px;color:#888;">Descuento (' . $disc_label . ')</td><td style="padding:8px 12px;text-align:right;color:#e53e3e;font-weight:bold;">-' . esc_html($this->format_money($disc_amount, $currency_code)) . '</td></tr>';
        }

        $boat_info = '';
        if ($boat_type) $boat_info .= '<tr><td style="padding:4px 12px;color:#666;width:35%;">Tipo</td><td style="padding:4px 12px;font-weight:600;">' . esc_html($boat_type) . '</td></tr>';
        if ($boat_brand) $boat_info .= '<tr><td style="padding:4px 12px;color:#666;">Marca</td><td style="padding:4px 12px;font-weight:600;">' . esc_html($boat_brand) . '</td></tr>';
        if ($boat_model) $boat_info .= '<tr><td style="padding:4px 12px;color:#666;">Modelo</td><td style="padding:4px 12px;font-weight:600;">' . esc_html($boat_model) . '</td></tr>';
        if ($boat_year) $boat_info .= '<tr><td style="padding:4px 12px;color:#666;">Año</td><td style="padding:4px 12px;font-weight:600;">' . esc_html($boat_year) . '</td></tr>';
        if ($boat_marina) $boat_info .= '<tr><td style="padding:4px 12px;color:#666;">Marina</td><td style="padding:4px 12px;font-weight:600;">' . esc_html($boat_marina) . '</td></tr>';

        return '<!DOCTYPE html><html><head><meta charset="UTF-8">
<style>
body { font-family: Helvetica, Arial, sans-serif; margin: 0; padding: 20px; color: #1a2a3a; font-size: 13px; }
* { box-sizing: border-box; }
h1 { font-size: 20px; color: #1a3a5c; margin: 0 0 5px; }
h2 { font-size: 14px; color: #1a3a5c; margin: 20px 0 8px; text-transform: uppercase; letter-spacing: 1px; }
.header { text-align: center; padding: 20px 0; border-bottom: 3px solid #1a3a5c; margin-bottom: 20px; }
.badge { display: inline-block; background: #e8a735; color: #fff; padding: 6px 18px; border-radius: 20px; font-size: 11px; font-weight: 700; letter-spacing: 1px; }
table { width: 100%; border-collapse: collapse; }
.total-row td { padding: 12px; font-size: 16px; font-weight: 800; border-top: 2px solid #1a3a5c; }
.footer { margin-top: 30px; padding-top: 15px; border-top: 1px solid #ddd; text-align: center; font-size: 11px; color: #888; }
</style>
</head><body>
<div class="header">
<h1>DECKEVA</h1>
<p style="margin:4px 0;color:#666;font-size:11px;letter-spacing:2px;">SERVICIOS NÁUTICOS PROFESIONALES</p>
<div class="badge">COTIZACIÓN N° ' . esc_html($quote_number) . '</div>
<p style="margin:8px 0 0;color:#999;font-size:12px;">Fecha: ' . esc_html($fecha) . '</p>
</div>

<h2>Datos del Cliente</h2>
<table>
<tr><td style="padding:4px 12px;color:#666;width:35%;">Nombre</td><td style="padding:4px 12px;font-weight:600;">' . esc_html($name) . '</td></tr>
<tr><td style="padding:4px 12px;color:#666;">Email</td><td style="padding:4px 12px;">' . esc_html($email) . '</td></tr>'
. ($phone ? '<tr><td style="padding:4px 12px;color:#666;">Teléfono</td><td style="padding:4px 12px;">' . esc_html($phone) . '</td></tr>' : '')
. ($company ? '<tr><td style="padding:4px 12px;color:#666;">Empresa</td><td style="padding:4px 12px;">' . esc_html($company) . '</td></tr>' : '')
. ($rut ? '<tr><td style="padding:4px 12px;color:#666;">RUT</td><td style="padding:4px 12px;">' . esc_html($rut) . '</td></tr>' : '')
. '</table>

<h2>Datos de la Embarcación</h2>
<table>' . $boat_info . '</table>

<h2>Servicios Cotizados</h2>
<table>
<tr style="background:#1a3a5c;color:#fff;"><td style="padding:8px 12px;font-weight:700;">Servicio</td><td style="padding:8px 12px;font-weight:700;text-align:right;">Precio</td></tr>
' . $services_rows . '
</table>

<table style="margin-top:10px;">
<tr><td style="padding:8px 12px;color:#666;">Sub Total</td><td style="padding:8px 12px;text-align:right;font-weight:600;">' . esc_html($this->format_money($subtotal, $currency_code)) . '</td></tr>
' . $discount_row . '
<tr class="total-row"><td>TOTAL</td><td style="text-align:right;color:#e8a735;">' . esc_html($this->format_money($total, $currency_code)) . '</td></tr>
</table>

<div class="footer">
<p>Esta cotización es válida por 15 días hábiles. Precios en ' . esc_html($currency['label']) . '.</p>
<p>WhatsApp: +56 9 4021 1459 | contacto@deckeva.cl | deckeva.cl</p>
</div>
</body></html>';
    }

    /* ──────────────────────────────────────────
       BUILD EMAIL HTML
    ────────────────────────────────────────── */
    private function build_email_html($name, $email, $phone, $company, $rut, $boat_type, $boat_brand, $boat_model, $boat_year, $boat_marina, $services, $subtotal, $discount_value, $discount_type, $total, $quote_number, $currency_code = 'CLP') {
        $fecha = date_i18n('d/m/Y');
        $logo = esc_url($this->logo_url);
        $currency = $this->get_currency($currency_code);

        $services_rows = '';
        foreach ($services as $s) {
            $sname = esc_html($s['name'] ?? '');
            $sprice = esc_html($this->format_money(intval($s['price'] ?? 0), $currency_code));
            $services_rows .= '<tr><td style="padding:10px 16px;border-bottom:1px solid #eee;font-size:14px;color:#333;">' . $sname . '</td><td style="padding:10px 16px;border-bottom:1px solid #eee;font-size:14px;color:#1a3a5c;font-weight:700;text-align:right;">' . $sprice . '</td></tr>';
        }

        $discount_display = '';
        if ($discount_value > 0) {
            if ($discount_type === 'percent') {
                $discount_display = $discount_value . '%';
            } else {
                $discount_display = esc_html($this->format_money($discount_value, $currency_code));
            }
        }

        $html = '<!DOCTYPE html><html lang="es"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1.0"></head>
<body style="margin:0;padding:0;background:#f0f2f5;font-family:Helvetica,Arial,sans-serif;">
<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background:#f0f2f5;">
<tr><td align="center" style="padding:30px 15px;">
<table role="presentation" width="600" cellpadding="0" cellspacing="0" style="background:#ffffff;border-radius:16px;overflow:hidden;box-shadow:0 4px 24px rgba(0,40,80,0.12);">

<!-- Header -->
<tr><td style="background:linear-gradient(135deg,#0d2137 0%,#1a3a5c 50%,#2a5a8c 100%);padding:35px 40px;text-align:center;">
<img src="' . $logo . '" alt="Deckeva" width="180" style="display:inline-block;max-width:180px;margin-bottom:12px;" />
<p style="color:rgba(255,255,255,0.8);font-size:11px;letter-spacing:2px;text-transform:uppercase;margin:0;">Servicios Náuticos Profesionales</p>
</td></tr>

<!-- Quote badge -->
<tr><td style="padding:0;text-align:center;">
<table role="presentation" cellpadding="0" cellspacing="0" style="margin:-16px auto 0;background:#e8a735;border-radius:30px;">
<tr><td style="padding:9px 26px;color:#ffffff;font-size:12px;font-weight:700;letter-spacing:1px;">COTIZACIÓN N° ' . esc_html($quote_number) . '</td></tr>
</table>
</td></tr>

<!-- Greeting -->
<tr><td style="padding:30px 40px 10px;">
<h1 style="margin:0 0 8px;font-size:22px;color:#1a2a3a;font-weight:700;">Estimado/a ' . esc_html($name) . ',</h1>
<p style="margin:0;color:#6b7280;font-size:14px;line-height:1.7;">Gracias por su interés en nuestros servicios náuticos. A continuación encontrará el detalle de su cotización.</p>
<p style="margin:8px 0 0;color:#9ca3af;font-size:12px;">Fecha: ' . esc_html($fecha) . '</p>
</td></tr>

<!-- Boat info -->
<tr><td style="padding:15px 40px;">
<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background:#f8faff;border-radius:12px;border:1px solid #e5e7eb;">
<tr><td colspan="2" style="padding:16px 20px 10px;"><p style="margin:0;font-size:11px;color:#1a3a5c;font-weight:700;letter-spacing:2px;text-transform:uppercase;">Datos de la Embarcación</p></td></tr>';

        if ($boat_type) $html .= '<tr><td style="padding:6px 20px;color:#6b7280;font-size:13px;width:40%;">Tipo</td><td style="padding:6px 20px;color:#1a2a3a;font-size:13px;font-weight:600;">' . esc_html($boat_type) . '</td></tr>';
        if ($boat_brand) $html .= '<tr><td style="padding:6px 20px;color:#6b7280;font-size:13px;">Marca</td><td style="padding:6px 20px;color:#1a2a3a;font-size:13px;font-weight:600;">' . esc_html($boat_brand) . '</td></tr>';
        if ($boat_model) $html .= '<tr><td style="padding:6px 20px;color:#6b7280;font-size:13px;">Modelo</td><td style="padding:6px 20px;color:#1a2a3a;font-size:13px;font-weight:600;">' . esc_html($boat_model) . '</td></tr>';
        if ($boat_year) $html .= '<tr><td style="padding:6px 20px;color:#6b7280;font-size:13px;">Año</td><td style="padding:6px 20px;color:#1a2a3a;font-size:13px;font-weight:600;">' . esc_html($boat_year) . '</td></tr>';
        if ($boat_marina) $html .= '<tr><td style="padding:6px 20px;color:#6b7280;font-size:13px;">Marina</td><td style="padding:6px 20px;color:#1a2a3a;font-size:13px;font-weight:600;">' . esc_html($boat_marina) . '</td></tr>';

        $html .= '</table></td></tr>

<!-- Services -->
<tr><td style="padding:15px 40px;">
<p style="margin:0 0 10px;font-size:11px;color:#1a3a5c;font-weight:700;letter-spacing:2px;text-transform:uppercase;">Servicios Cotizados</p>
<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="border-radius:12px;overflow:hidden;border:1px solid #e5e7eb;">
<tr><td style="padding:10px 16px;background:#1a3a5c;color:#fff;font-size:12px;font-weight:700;">Servicio</td><td style="padding:10px 16px;background:#1a3a5c;color:#fff;font-size:12px;font-weight:700;text-align:right;">Precio</td></tr>
' . $services_rows . '
</table>
</td></tr>

<!-- Totals -->
<tr><td style="padding:10px 40px 25px;">
<table role="presentation" width="100%" cellpadding="0" cellspacing="0">
<tr><td style="padding:8px 16px;font-size:14px;color:#6b7280;">Sub Total</td><td style="padding:8px 16px;font-size:14px;color:#1a2a3a;font-weight:600;text-align:right;">' . esc_html($this->format_money($subtotal, $currency_code)) . '</td></tr>';

        if ($discount_value > 0) {
            $html .= '<tr><td style="padding:8px 16px;font-size:14px;color:#6b7280;">Descuento (' . $discount_display . ')</td><td style="padding:8px 16px;font-size:14px;color:#e53e3e;font-weight:600;text-align:right;">-' . esc_html($this->format_money($subtotal - $total, $currency_code)) . '</td></tr>';
        }

        $html .= '<tr><td colspan="2" style="padding:8px 16px;"><div style="border-top:2px dashed #e5e7eb;"></div></td></tr>
<tr><td style="padding:12px 16px;font-size:18px;color:#1a2a3a;font-weight:800;">TOTAL</td><td style="padding:12px 16px;text-align:right;"><span style="background:#e8a735;color:#fff;padding:8px 20px;border-radius:8px;font-size:18px;font-weight:800;">' . esc_html($this->format_money($total, $currency_code)) . '</span></td></tr>
</table>
</td></tr>

<!-- Footer -->
<tr><td style="padding:25px 40px;background:#f8faff;text-align:center;border-top:1px solid #e5e7eb;">
<p style="margin:0 0 8px;font-size:13px;color:#6b7280;line-height:1.6;">Esta cotización es válida por 15 días hábiles. Precios en ' . esc_html($currency['label']) . '.<br>Para consultas, contáctenos directamente.</p>
<p style="margin:0;font-size:12px;color:#1a3a5c;font-weight:600;">WhatsApp: +56 9 4021 1459 | contacto@deckeva.cl | deckeva.com</p>
</td></tr>

</table>
</td></tr></table>
</body></html>';

        return $html;
    }

    /* ──────────────────────────────────────────
       RENDER FULL PAGE
    ────────────────────────────────────────── */
    private function render_page() {
        $nonce = wp_create_nonce('deckeva_cotizador_email');
        $logo  = esc_url($this->logo_url);
        $year  = date('Y');

        ob_start();
        ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cotizador de Servicios Náuticos | DECKEVA</title>
    <meta name="description" content="Cree cotizaciones profesionales para servicios náuticos con Deckeva. Detailing, reparaciones, pisos y más.">
    <meta name="robots" content="noindex, nofollow">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        /* ============================================
           DECKEVA COTIZADOR - PREMIUM NAUTICAL v1.0
           ============================================ */
        *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }
        html { scroll-behavior: smooth; }
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: #f0f2f5;
            color: #1a2a3a;
            line-height: 1.6;
            min-height: 100vh;
        }

        /* --- Header --- */
        .dc-header {
            background: #ffffff;
            border-bottom: 1px solid rgba(26,58,92,0.08);
            padding: 14px 0;
            position: sticky;
            top: 0;
            z-index: 100;
            box-shadow: 0 2px 20px rgba(0,20,50,0.06);
        }
        .dc-header-inner {
            max-width: 1100px;
            margin: 0 auto;
            padding: 0 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .dc-logo { display: flex; align-items: center; gap: 12px; text-decoration: none; }
        .dc-logo img { height: 44px; width: auto; }
        .dc-logo-text { font-size: 22px; font-weight: 800; color: #1a3a5c; letter-spacing: 1px; }
        .dc-header-contact { display: flex; align-items: center; gap: 18px; }
        .dc-header-contact a {
            display: inline-flex; align-items: center; gap: 6px;
            font-size: 13px; font-weight: 500; color: #1a3a5c;
            text-decoration: none; transition: color .3s;
        }
        .dc-header-contact a:hover { color: #e8a735; }
        .dc-header-contact svg { width: 16px; height: 16px; flex-shrink: 0; }

        /* --- Hero --- */
        .dc-hero {
            background: linear-gradient(135deg, #0a1929 0%, #0d2137 30%, #1a3a5c 60%, #234b6e 100%);
            padding: 60px 24px 52px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        .dc-hero::before {
            content: ''; position: absolute; top: -50%; right: -25%;
            width: 600px; height: 600px; border-radius: 50%;
            background: radial-gradient(circle, rgba(232,167,53,0.06) 0%, transparent 70%);
            pointer-events: none;
        }
        .dc-hero-badge {
            display: inline-block;
            background: rgba(232,167,53,0.15);
            border: 1px solid rgba(232,167,53,0.3);
            color: #e8a735;
            font-size: 11px; font-weight: 700; letter-spacing: 3px;
            text-transform: uppercase; padding: 9px 26px;
            border-radius: 30px; margin-bottom: 20px;
        }
        .dc-hero h1 {
            color: #ffffff; font-size: 40px; font-weight: 300;
            line-height: 1.15; margin-bottom: 14px; letter-spacing: -0.5px;
        }
        .dc-hero h1 strong {
            font-weight: 800;
            background: linear-gradient(135deg, #e8a735 0%, #f0c060 100%);
            -webkit-background-clip: text; -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .dc-hero-sub {
            color: rgba(255,255,255,0.7); font-size: 16px; font-weight: 300;
            max-width: 560px; margin: 0 auto; line-height: 1.7;
        }

        /* --- Steps --- */
        .dc-steps {
            display: flex; justify-content: center; align-items: center;
            gap: 0; margin: 40px auto 0; max-width: 580px; position: relative;
        }
        .dc-step-item {
            display: flex; flex-direction: column; align-items: center;
            position: relative; z-index: 2; flex: 1; cursor: default;
        }
        .dc-step-circle {
            width: 40px; height: 40px; border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-size: 14px; font-weight: 700;
            background: rgba(255,255,255,0.08); color: rgba(255,255,255,0.4);
            border: 2px solid rgba(255,255,255,0.12);
            transition: all .4s; margin-bottom: 8px;
        }
        .dc-step-item.active .dc-step-circle {
            background: #e8a735; color: #fff; border-color: #e8a735;
            box-shadow: 0 4px 20px rgba(232,167,53,0.4);
        }
        .dc-step-item.completed .dc-step-circle {
            background: #22c55e; color: #fff; border-color: #22c55e;
            box-shadow: 0 4px 16px rgba(34,197,94,0.3);
        }
        .dc-step-label {
            font-size: 11px; font-weight: 500;
            color: rgba(255,255,255,0.35); transition: color .4s; text-align: center;
        }
        .dc-step-item.active .dc-step-label,
        .dc-step-item.completed .dc-step-label { color: rgba(255,255,255,0.85); }
        .dc-step-line {
            flex: 1; height: 2px; background: rgba(255,255,255,0.1);
            position: relative; top: -18px; z-index: 1;
        }
        .dc-step-line.completed { background: #22c55e; }

        /* --- Main content --- */
        .dc-main {
            max-width: 820px; margin: -28px auto 0;
            padding: 0 24px 60px; position: relative; z-index: 10;
        }
        .dc-card {
            background: #ffffff; border-radius: 20px;
            box-shadow: 0 8px 40px rgba(0,20,50,0.08), 0 2px 8px rgba(0,20,50,0.04);
            border: 1px solid rgba(0,20,50,0.06); overflow: hidden;
        }
        .dc-card-body { padding: 44px 40px; }

        /* --- Panels --- */
        .dc-panel { display: none; animation: dcFadeIn .4s ease; }
        .dc-panel.active { display: block; }
        @keyframes dcFadeIn { from { opacity:0; transform:translateY(10px); } to { opacity:1; transform:translateY(0); } }

        .dc-panel-title {
            font-size: 24px; font-weight: 700; color: #1a2a3a;
            margin-bottom: 4px; letter-spacing: -0.3px;
        }
        .dc-panel-subtitle {
            font-size: 14px; color: #6b7280; margin-bottom: 32px; line-height: 1.6;
        }

        /* --- Form Fields --- */
        .dc-field-row {
            display: grid; grid-template-columns: 1fr 1fr;
            gap: 18px; margin-bottom: 18px;
        }
        .dc-field-row.single { grid-template-columns: 1fr; }
        .dc-field-row.triple { grid-template-columns: 1fr 1fr 1fr; }
        .dc-field { display: flex; flex-direction: column; }
        .dc-field label {
            font-size: 12px; font-weight: 600; color: #374151;
            margin-bottom: 6px; letter-spacing: 0.2px;
        }
        .dc-field label .req { color: #e53e3e; margin-left: 2px; }
        .dc-field input, .dc-field select, .dc-field textarea {
            width: 100%; padding: 12px 16px;
            border: 2px solid #e5e7eb; border-radius: 12px;
            font-size: 14px; font-family: inherit; color: #1a2a3a;
            background: #fff; transition: all .3s; outline: none;
        }
        .dc-field input:focus, .dc-field select:focus, .dc-field textarea:focus {
            border-color: #1a3a5c; box-shadow: 0 0 0 3px rgba(26,58,92,0.1);
        }
        .dc-field input::placeholder, .dc-field textarea::placeholder { color: #9ca3af; }
        .dc-field textarea { min-height: 80px; resize: vertical; }
        .dc-field select {
            appearance: none; cursor: pointer; padding-right: 40px;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='%236b7280'%3E%3Cpath d='M7 10l5 5 5-5z'/%3E%3C/svg%3E");
            background-repeat: no-repeat; background-position: right 14px center; background-size: 16px;
        }

        /* --- Service Items --- */
        .dc-services-list { display: flex; flex-direction: column; gap: 10px; margin-bottom: 24px; }
        .dc-service-item {
            display: flex; align-items: center; gap: 14px;
            padding: 14px 18px; background: #f8faff;
            border: 2px solid #e5e7eb; border-radius: 14px;
            transition: all .3s;
        }
        .dc-service-item.checked {
            border-color: #1a3a5c; background: linear-gradient(135deg, #f0f5ff 0%, #e8f0fe 100%);
            box-shadow: 0 2px 12px rgba(26,58,92,0.08);
        }
        .dc-service-item input[type="checkbox"] {
            width: 20px; height: 20px; accent-color: #1a3a5c;
            cursor: pointer; flex-shrink: 0;
        }
        .dc-service-info { flex: 1; min-width: 0; }
        .dc-service-name { font-size: 14px; font-weight: 600; color: #1a2a3a; }
        .dc-service-desc-field {
            margin-top: 6px; width: 100%; padding: 8px 12px;
            border: 1px solid #d1d5db; border-radius: 8px;
            font-size: 13px; font-family: inherit; color: #1a2a3a;
            background: #fff; outline: none;
        }
        .dc-service-desc-field:focus { border-color: #1a3a5c; }
        .dc-service-price {
            display: flex; align-items: center; gap: 4px; flex-shrink: 0;
        }
        .dc-service-price-prefix {
            font-size: 13px; font-weight: 600; color: #6b7280;
        }
        .dc-service-price input {
            width: 130px; padding: 10px 12px; border: 2px solid #e5e7eb;
            border-radius: 10px; font-size: 14px; font-weight: 700;
            color: #1a3a5c; text-align: right; font-family: inherit;
            background: #fff; outline: none; transition: all .3s;
        }
        .dc-service-price input:focus {
            border-color: #e8a735; box-shadow: 0 0 0 3px rgba(232,167,53,0.15);
        }

        /* --- Totals --- */
        .dc-totals {
            background: #f8faff; border-radius: 14px;
            border: 1px solid #e5e7eb; padding: 20px 22px;
        }
        .dc-total-row {
            display: flex; justify-content: space-between; align-items: center;
            padding: 8px 0; font-size: 14px;
        }
        .dc-total-row.main {
            padding: 14px 0 0; margin-top: 8px;
            border-top: 2px dashed #d1d5db;
        }
        .dc-total-label { color: #6b7280; font-weight: 500; }
        .dc-total-value { font-weight: 700; color: #1a2a3a; font-size: 15px; }
        .dc-total-row.main .dc-total-label { color: #1a2a3a; font-size: 18px; font-weight: 800; }
        .dc-total-row.main .dc-total-value {
            background: #e8a735; color: #fff; padding: 8px 20px;
            border-radius: 10px; font-size: 20px; font-weight: 800;
        }

        /* Discount row */
        .dc-discount-row {
            display: flex; align-items: center; gap: 10px; padding: 10px 0;
        }
        .dc-discount-row label { font-size: 13px; color: #6b7280; font-weight: 500; white-space: nowrap; }
        .dc-discount-row input {
            width: 110px; padding: 8px 12px; border: 2px solid #e5e7eb;
            border-radius: 10px; font-size: 14px; font-weight: 600;
            color: #1a2a3a; text-align: right; font-family: inherit;
            outline: none; transition: all .3s;
        }
        .dc-discount-row input:focus { border-color: #1a3a5c; }
        .dc-discount-toggle {
            display: flex; background: #e5e7eb; border-radius: 8px; overflow: hidden;
        }
        .dc-discount-toggle button {
            padding: 7px 14px; border: none; background: transparent;
            font-size: 12px; font-weight: 600; cursor: pointer;
            color: #6b7280; transition: all .2s; font-family: inherit;
        }
        .dc-discount-toggle button.active {
            background: #1a3a5c; color: #fff;
        }

        /* --- Buttons --- */
        .dc-actions {
            display: flex; justify-content: space-between;
            align-items: center; margin-top: 32px; gap: 12px;
        }
        .dc-btn {
            display: inline-flex; align-items: center; gap: 8px;
            padding: 14px 32px; border-radius: 14px;
            font-size: 14px; font-weight: 600; font-family: inherit;
            cursor: pointer; transition: all .3s; border: none;
            text-decoration: none;
        }
        .dc-btn-primary {
            background: linear-gradient(135deg, #e8a735 0%, #d4952e 100%);
            color: #fff; box-shadow: 0 4px 16px rgba(232,167,53,0.3);
        }
        .dc-btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 24px rgba(232,167,53,0.4);
        }
        .dc-btn-secondary {
            background: #f0f2f5; color: #374151;
            border: 2px solid #e5e7eb;
        }
        .dc-btn-secondary:hover { background: #e5e7eb; }
        .dc-btn-outline {
            background: transparent; color: #1a3a5c;
            border: 2px solid #1a3a5c;
        }
        .dc-btn-outline:hover { background: #f0f5ff; }
        .dc-btn-success {
            background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%);
            color: #fff; box-shadow: 0 4px 16px rgba(34,197,94,0.3);
        }
        .dc-btn-success:hover { box-shadow: 0 6px 24px rgba(34,197,94,0.4); }

        .dc-btn svg { width: 18px; height: 18px; flex-shrink: 0; }

        /* --- Summary (Step 4) --- */
        .dc-summary-section {
            margin-bottom: 24px; padding: 20px;
            background: #f8faff; border-radius: 14px;
            border: 1px solid #e5e7eb;
        }
        .dc-summary-title {
            font-size: 11px; font-weight: 700; letter-spacing: 2px;
            text-transform: uppercase; color: #1a3a5c;
            margin-bottom: 12px; padding-bottom: 8px;
            border-bottom: 1px solid #e5e7eb;
        }
        .dc-summary-grid {
            display: grid; grid-template-columns: 1fr 1fr;
            gap: 8px 16px;
        }
        .dc-summary-item { font-size: 13px; }
        .dc-summary-label { color: #6b7280; font-weight: 500; }
        .dc-summary-value { color: #1a2a3a; font-weight: 600; }
        .dc-summary-service {
            display: flex; justify-content: space-between;
            align-items: center; padding: 8px 0;
            border-bottom: 1px solid #f0f0f5;
            font-size: 13px;
        }
        .dc-summary-service:last-child { border-bottom: none; }
        .dc-summary-service-name { font-weight: 600; color: #1a2a3a; }
        .dc-summary-service-price { font-weight: 700; color: #1a3a5c; }

        /* Action buttons row in step 4 */
        .dc-summary-actions {
            display: flex; flex-wrap: wrap; gap: 10px;
            margin-top: 20px; justify-content: center;
        }

        /* --- Preview Modal --- */
        .dc-preview-overlay {
            display: none; position: fixed; top: 0; left: 0;
            width: 100%; height: 100%; background: rgba(0,0,0,0.6);
            z-index: 1000; justify-content: center; align-items: flex-start;
            padding: 30px 20px; overflow-y: auto;
        }
        .dc-preview-overlay.visible { display: flex; }
        .dc-preview-container {
            background: #fff; border-radius: 16px; max-width: 700px;
            width: 100%; position: relative; box-shadow: 0 20px 60px rgba(0,0,0,0.3);
        }
        .dc-preview-toolbar {
            display: flex; align-items: center; justify-content: space-between;
            padding: 14px 20px; background: #1a3a5c; border-radius: 16px 16px 0 0;
            color: #fff;
        }
        .dc-preview-toolbar-title { font-size: 14px; font-weight: 600; }
        .dc-preview-toolbar-actions { display: flex; gap: 8px; }
        .dc-preview-toolbar-actions button {
            padding: 8px 16px; border-radius: 8px; border: none;
            font-size: 12px; font-weight: 600; cursor: pointer;
            font-family: inherit; transition: all .2s;
        }
        .dc-preview-close {
            background: rgba(255,255,255,0.15); color: #fff;
        }
        .dc-preview-close:hover { background: rgba(255,255,255,0.25); }
        .dc-preview-content { padding: 30px; }

        /* --- Loading spinner --- */
        .dc-spinner {
            display: inline-block; width: 18px; height: 18px;
            border: 2px solid rgba(255,255,255,0.3);
            border-radius: 50%; border-top-color: #fff;
            animation: dcSpin .8s linear infinite;
        }
        @keyframes dcSpin { to { transform: rotate(360deg); } }

        /* --- Toast --- */
        .dc-toast {
            position: fixed; bottom: 30px; right: 30px;
            padding: 16px 24px; border-radius: 12px;
            font-size: 14px; font-weight: 600; color: #fff;
            z-index: 2000; box-shadow: 0 8px 30px rgba(0,0,0,0.2);
            transform: translateY(100px); opacity: 0;
            transition: all .4s ease;
        }
        .dc-toast.visible { transform: translateY(0); opacity: 1; }
        .dc-toast.success { background: #22c55e; }
        .dc-toast.error { background: #e53e3e; }

        /* --- Footer --- */
        .dc-footer {
            text-align: center; padding: 30px 24px;
            color: #9ca3af; font-size: 12px;
        }
        .dc-footer a { color: #1a3a5c; text-decoration: none; font-weight: 600; }

        /* --- Responsive --- */
        @media (max-width: 768px) {
            .dc-hero { padding: 44px 20px 36px; }
            .dc-hero h1 { font-size: 28px; }
            .dc-hero-sub { font-size: 14px; }
            .dc-card-body { padding: 28px 20px; }
            .dc-field-row { grid-template-columns: 1fr; }
            .dc-field-row.triple { grid-template-columns: 1fr; }
            .dc-service-item { flex-wrap: wrap; gap: 10px; }
            .dc-service-price { width: 100%; }
            .dc-service-price input { width: 100%; }
            .dc-actions { flex-direction: column; }
            .dc-actions .dc-btn { width: 100%; justify-content: center; }
            .dc-summary-grid { grid-template-columns: 1fr; }
            .dc-header-contact { display: none; }
            .dc-steps { max-width: 100%; }
            .dc-step-label { font-size: 10px; }
            .dc-discount-row { flex-wrap: wrap; }
            .dc-summary-actions { flex-direction: column; }
            .dc-summary-actions .dc-btn { width: 100%; justify-content: center; }
            .dc-preview-content { padding: 16px; }
        }

        /* --- Print styles --- */
        @media print {
            body { background: #fff !important; }
            .dc-header, .dc-hero, .dc-footer, .dc-actions,
            .dc-preview-toolbar, .dc-summary-actions { display: none !important; }
            .dc-preview-overlay { position: static !important; display: block !important; background: none !important; padding: 0 !important; }
            .dc-preview-container { box-shadow: none !important; border-radius: 0 !important; max-width: 100% !important; }
            .dc-preview-content { padding: 10px !important; }
        }
    </style>
</head>
<body>

<!-- Header -->
<header class="dc-header">
    <div class="dc-header-inner">
        <a class="dc-logo" href="<?php echo esc_url($this->site_url); ?>">
            <img src="<?php echo $logo; ?>" alt="Deckeva">
            <span class="dc-logo-text">DECKEVA</span>
        </a>
        <div class="dc-header-contact">
            <a href="https://wa.me/56940211459" target="_blank">
                <svg viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/><path d="M12 0C5.373 0 0 5.373 0 12c0 2.625.846 5.059 2.284 7.034L.789 23.492a.5.5 0 00.611.611l4.458-1.495A11.96 11.96 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 22c-2.37 0-4.567-.68-6.434-1.852l-.45-.28-3.098 1.038 1.038-3.098-.28-.45A9.96 9.96 0 012 12C2 6.486 6.486 2 12 2s10 4.486 10 10-4.486 10-10 10z"/></svg>
                +56 9 4021 1459
            </a>
            <a href="mailto:contacto@deckeva.cl">
                <svg viewBox="0 0 24 24" fill="currentColor"><path d="M20 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/></svg>
                contacto@deckeva.cl
            </a>
        </div>
    </div>
</header>

<!-- Hero -->
<section class="dc-hero">
    <div class="dc-hero-badge">⚓ Cotizador de Servicios</div>
    <h1>Cotización de<br><strong>Servicios Náuticos</strong></h1>
    <p class="dc-hero-sub">Cree una cotización profesional para sus clientes de manera rápida y sencilla.</p>

    <!-- Steps indicator -->
    <div class="dc-steps">
        <div class="dc-step-item active" data-step="1">
            <div class="dc-step-circle">1</div>
            <span class="dc-step-label">Cliente</span>
        </div>
        <div class="dc-step-line" data-line="1"></div>
        <div class="dc-step-item" data-step="2">
            <div class="dc-step-circle">2</div>
            <span class="dc-step-label">Embarcación</span>
        </div>
        <div class="dc-step-line" data-line="2"></div>
        <div class="dc-step-item" data-step="3">
            <div class="dc-step-circle">3</div>
            <span class="dc-step-label">Servicios</span>
        </div>
        <div class="dc-step-line" data-line="3"></div>
        <div class="dc-step-item" data-step="4">
            <div class="dc-step-circle">4</div>
            <span class="dc-step-label">Resumen</span>
        </div>
    </div>
</section>

<!-- Main -->
<main class="dc-main">
    <div class="dc-card">
        <div class="dc-card-body">

            <!-- ═══════ STEP 1: Client Data ═══════ -->
            <div class="dc-panel active" id="dcStep1">
                <h2 class="dc-panel-title">Datos del Cliente</h2>
                <p class="dc-panel-subtitle">Ingrese la información del cliente para la cotización.</p>

                <div class="dc-field-row">
                    <div class="dc-field">
                        <label>Nombre Completo <span class="req">*</span></label>
                        <input type="text" id="dcClientName" placeholder="Ej: Juan Pérez" required>
                    </div>
                    <div class="dc-field">
                        <label>Email <span class="req">*</span></label>
                        <input type="email" id="dcClientEmail" placeholder="cliente@email.com" required>
                    </div>
                </div>
                <div class="dc-field-row">
                    <div class="dc-field">
                        <label>Teléfono <span class="req">*</span></label>
                        <input type="tel" id="dcClientPhone" placeholder="+56 9 1234 5678" required>
                    </div>
                    <div class="dc-field">
                        <label>Empresa <small style="color:#9ca3af;">(opcional)</small></label>
                        <input type="text" id="dcClientCompany" placeholder="Nombre de empresa">
                    </div>
                </div>
                <div class="dc-field-row">
                    <div class="dc-field">
                        <label>RUT <small style="color:#9ca3af;">(opcional)</small></label>
                        <input type="text" id="dcClientRut" placeholder="12.345.678-9">
                    </div>
                    <div class="dc-field">
                        <label>Moneda / Currency <span class="req">*</span></label>
                        <select id="dcCurrency" onchange="dcSetCurrency(this.value)">
                            <option value="CLP">🇨🇱 CLP — Peso Chileno ($)</option>
                            <option value="USD">🇺🇸 USD — US Dollar ($)</option>
                            <option value="EUR">🇪🇺 EUR — Euro (€)</option>
                            <option value="ARS">🇦🇷 ARS — Peso Argentino ($)</option>
                            <option value="MXN">🇲🇽 MXN — Peso Mexicano ($)</option>
                            <option value="BRL">🇧🇷 BRL — Real (R$)</option>
                            <option value="UYU">🇺🇾 UYU — Peso Uruguayo ($U)</option>
                            <option value="PEN">🇵🇪 PEN — Sol Peruano (S/)</option>
                            <option value="COP">🇨🇴 COP — Peso Colombiano ($)</option>
                            <option value="GBP">🇬🇧 GBP — Libra Esterlina (£)</option>
                        </select>
                    </div>
                </div>

                <div class="dc-actions">
                    <div></div>
                    <button class="dc-btn dc-btn-primary" onclick="dcNextStep(2)">
                        Siguiente
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M9 18l6-6-6-6"/></svg>
                    </button>
                </div>
            </div>

            <!-- ═══════ STEP 2: Boat Data ═══════ -->
            <div class="dc-panel" id="dcStep2">
                <h2 class="dc-panel-title">Datos de la Embarcación</h2>
                <p class="dc-panel-subtitle">Información del barco o embarcación a cotizar.</p>

                <div class="dc-field-row">
                    <div class="dc-field">
                        <label>Tipo de Embarcación <span class="req">*</span></label>
                        <select id="dcBoatType">
                            <option value="">Seleccione...</option>
                            <option value="Lancha">Lancha</option>
                            <option value="Moto de Agua">Moto de Agua</option>
                            <option value="Velero">Velero</option>
                            <option value="Yate">Yate</option>
                            <option value="Bote">Bote</option>
                        </select>
                    </div>
                    <div class="dc-field">
                        <label>Marca</label>
                        <input type="text" id="dcBoatBrand" placeholder="Ej: Bayliner, Yamaha...">
                    </div>
                </div>
                <div class="dc-field-row triple">
                    <div class="dc-field">
                        <label>Modelo</label>
                        <input type="text" id="dcBoatModel" placeholder="Ej: VR5">
                    </div>
                    <div class="dc-field">
                        <label>Año</label>
                        <input type="number" id="dcBoatYear" placeholder="2024" min="1950" max="2030">
                    </div>
                    <div class="dc-field">
                        <label>Marina / Ubicación</label>
                        <input type="text" id="dcBoatMarina" placeholder="Ej: Marina Rapel">
                    </div>
                </div>

                <div class="dc-actions">
                    <button class="dc-btn dc-btn-secondary" onclick="dcNextStep(1)">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M15 18l-6-6 6-6"/></svg>
                        Anterior
                    </button>
                    <button class="dc-btn dc-btn-primary" onclick="dcNextStep(3)">
                        Siguiente
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M9 18l6-6-6-6"/></svg>
                    </button>
                </div>
            </div>

            <!-- ═══════ STEP 3: Services & Pricing ═══════ -->
            <div class="dc-panel" id="dcStep3">
                <h2 class="dc-panel-title">Servicios y Cotización</h2>
                <p class="dc-panel-subtitle">Seleccione los servicios e ingrese los precios correspondientes.</p>

                <div class="dc-services-list" id="dcServicesList">
                    <!-- Service 1 -->
                    <div class="dc-service-item" id="dcSvc1">
                        <input type="checkbox" id="dcSvcCheck1" onchange="dcToggleService(this)">
                        <div class="dc-service-info">
                            <div class="dc-service-name">Detailing Náutico</div>
                        </div>
                        <div class="dc-service-price">
                            <span class="dc-service-price-prefix">$</span>
                            <input type="text" id="dcSvcPrice1" placeholder="0" oninput="dcFormatPrice(this); dcUpdateTotals();">
                        </div>
                    </div>
                    <!-- Service 2 -->
                    <div class="dc-service-item" id="dcSvc2">
                        <input type="checkbox" id="dcSvcCheck2" onchange="dcToggleService(this)">
                        <div class="dc-service-info">
                            <div class="dc-service-name">Revisión Sistema Eléctrico &amp; Diagnóstico</div>
                        </div>
                        <div class="dc-service-price">
                            <span class="dc-service-price-prefix">$</span>
                            <input type="text" id="dcSvcPrice2" placeholder="0" oninput="dcFormatPrice(this); dcUpdateTotals();">
                        </div>
                    </div>
                    <!-- Service 3 -->
                    <div class="dc-service-item" id="dcSvc3">
                        <input type="checkbox" id="dcSvcCheck3" onchange="dcToggleService(this)">
                        <div class="dc-service-info">
                            <div class="dc-service-name">Revisión de Motor &amp; Diagnóstico</div>
                        </div>
                        <div class="dc-service-price">
                            <span class="dc-service-price-prefix">$</span>
                            <input type="text" id="dcSvcPrice3" placeholder="0" oninput="dcFormatPrice(this); dcUpdateTotals();">
                        </div>
                    </div>
                    <!-- Service 4 -->
                    <div class="dc-service-item" id="dcSvc4">
                        <input type="checkbox" id="dcSvcCheck4" onchange="dcToggleService(this)">
                        <div class="dc-service-info">
                            <div class="dc-service-name">Pintado de Embarcación</div>
                        </div>
                        <div class="dc-service-price">
                            <span class="dc-service-price-prefix">$</span>
                            <input type="text" id="dcSvcPrice4" placeholder="0" oninput="dcFormatPrice(this); dcUpdateTotals();">
                        </div>
                    </div>
                    <!-- Service 5 -->
                    <div class="dc-service-item" id="dcSvc5">
                        <input type="checkbox" id="dcSvcCheck5" onchange="dcToggleService(this)">
                        <div class="dc-service-info">
                            <div class="dc-service-name">Piso DECKEVA</div>
                        </div>
                        <div class="dc-service-price">
                            <span class="dc-service-price-prefix">$</span>
                            <input type="text" id="dcSvcPrice5" placeholder="0" oninput="dcFormatPrice(this); dcUpdateTotals();">
                        </div>
                    </div>
                    <!-- Service 6 -->
                    <div class="dc-service-item" id="dcSvc6">
                        <input type="checkbox" id="dcSvcCheck6" onchange="dcToggleService(this)">
                        <div class="dc-service-info">
                            <div class="dc-service-name">Reparaciones Casco</div>
                        </div>
                        <div class="dc-service-price">
                            <span class="dc-service-price-prefix">$</span>
                            <input type="text" id="dcSvcPrice6" placeholder="0" oninput="dcFormatPrice(this); dcUpdateTotals();">
                        </div>
                    </div>
                    <!-- Service 7 -->
                    <div class="dc-service-item" id="dcSvc7">
                        <input type="checkbox" id="dcSvcCheck7" onchange="dcToggleService(this)">
                        <div class="dc-service-info">
                            <div class="dc-service-name">Reparaciones Varias</div>
                        </div>
                        <div class="dc-service-price">
                            <span class="dc-service-price-prefix">$</span>
                            <input type="text" id="dcSvcPrice7" placeholder="0" oninput="dcFormatPrice(this); dcUpdateTotals();">
                        </div>
                    </div>
                    <!-- Service 8: Otros -->
                    <div class="dc-service-item" id="dcSvc8">
                        <input type="checkbox" id="dcSvcCheck8" onchange="dcToggleService(this)">
                        <div class="dc-service-info">
                            <div class="dc-service-name">Otros</div>
                            <input type="text" class="dc-service-desc-field" id="dcSvcDesc8" placeholder="Describa el servicio adicional...">
                        </div>
                        <div class="dc-service-price">
                            <span class="dc-service-price-prefix">$</span>
                            <input type="text" id="dcSvcPrice8" placeholder="0" oninput="dcFormatPrice(this); dcUpdateTotals();">
                        </div>
                    </div>
                </div>

                <!-- Totals -->
                <div class="dc-totals">
                    <div class="dc-total-row">
                        <span class="dc-total-label">Sub Total</span>
                        <span class="dc-total-value" id="dcSubtotal">$0</span>
                    </div>
                    <div class="dc-discount-row">
                        <label>Descuento:</label>
                        <input type="text" id="dcDiscountValue" placeholder="0" oninput="dcFormatPrice(this); dcUpdateTotals();">
                        <div class="dc-discount-toggle">
                            <button class="active" id="dcDiscountAmount" onclick="dcSetDiscountType('amount')">CLP $</button>
                            <button id="dcDiscountPct" onclick="dcSetDiscountType('percent')">%</button>
                        </div>
                    </div>
                    <div class="dc-total-row main">
                        <span class="dc-total-label">TOTAL</span>
                        <span class="dc-total-value" id="dcTotal">$0</span>
                    </div>
                </div>

                <div class="dc-actions">
                    <button class="dc-btn dc-btn-secondary" onclick="dcNextStep(2)">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M15 18l-6-6 6-6"/></svg>
                        Anterior
                    </button>
                    <button class="dc-btn dc-btn-primary" onclick="dcNextStep(4)">
                        Siguiente
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M9 18l6-6-6-6"/></svg>
                    </button>
                </div>
            </div>

            <!-- ═══════ STEP 4: Summary ═══════ -->
            <div class="dc-panel" id="dcStep4">
                <h2 class="dc-panel-title">Resumen y Envío</h2>
                <p class="dc-panel-subtitle">Revise la cotización antes de descargar o enviar.</p>

                <div id="dcSummaryContent">
                    <!-- Populated by JS -->
                </div>

                <div class="dc-summary-actions">
                    <button class="dc-btn dc-btn-outline" onclick="dcShowPreview()">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                        Vista Previa
                    </button>
                    <button class="dc-btn dc-btn-primary" onclick="dcDownloadPDF()">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                        Descargar PDF
                    </button>
                    <button class="dc-btn dc-btn-success" id="dcSendEmailBtn" onclick="dcSendEmail()">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 2L11 13"/><path d="M22 2l-7 20-4-9-9-4 20-7z"/></svg>
                        Enviar por Email
                    </button>
                </div>

                <div class="dc-actions" style="margin-top: 20px;">
                    <button class="dc-btn dc-btn-secondary" onclick="dcNextStep(3)">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M15 18l-6-6 6-6"/></svg>
                        Anterior
                    </button>
                    <div></div>
                </div>
            </div>

        </div>
    </div>
</main>

<!-- Preview Modal -->
<div class="dc-preview-overlay" id="dcPreviewOverlay">
    <div class="dc-preview-container">
        <div class="dc-preview-toolbar">
            <span class="dc-preview-toolbar-title">Vista Previa de Cotización</span>
            <div class="dc-preview-toolbar-actions">
                <button class="dc-preview-close" onclick="dcClosePreview()">Cerrar ✕</button>
            </div>
        </div>
        <div class="dc-preview-content" id="dcPreviewContent">
            <!-- Populated by JS -->
        </div>
    </div>
</div>

<!-- Toast -->
<div class="dc-toast" id="dcToast"></div>

<!-- Footer -->
<footer class="dc-footer">
    &copy; <?php echo $year; ?> <a href="<?php echo esc_url($this->site_url); ?>">DECKEVA</a> — Servicios Náuticos Profesionales. Todos los derechos reservados.
</footer>

<script>
(function() {
    'use strict';

    var currentStep = 1;
    var discountType = 'amount';
    var siteUrl = <?php echo json_encode($this->site_url); ?>;
    var logoUrl = <?php echo json_encode($this->logo_url); ?>;
    var nonce = <?php echo json_encode($nonce); ?>;

    var serviceNames = {
        1: 'Detailing Náutico',
        2: 'Revisión Sistema Eléctrico & Diagnóstico',
        3: 'Revisión de Motor & Diagnóstico',
        4: 'Pintado de Embarcación',
        5: 'Piso DECKEVA',
        6: 'Reparaciones Casco',
        7: 'Reparaciones Varias',
        8: 'Otros'
    };

    /* ─── Currency Map ─── */
    var currencyMap = {
        'CLP': { symbol: '$',  thousands: '.', label: 'Pesos Chilenos (CLP)' },
        'USD': { symbol: '$',  thousands: ',', label: 'US Dollars (USD)' },
        'EUR': { symbol: '€',  thousands: '.', label: 'Euros (EUR)' },
        'ARS': { symbol: '$',  thousands: '.', label: 'Pesos Argentinos (ARS)' },
        'MXN': { symbol: '$',  thousands: ',', label: 'Pesos Mexicanos (MXN)' },
        'BRL': { symbol: 'R$', thousands: '.', label: 'Reales Brasileños (BRL)' },
        'UYU': { symbol: '$U', thousands: '.', label: 'Pesos Uruguayos (UYU)' },
        'PEN': { symbol: 'S/', thousands: ',', label: 'Soles Peruanos (PEN)' },
        'COP': { symbol: '$',  thousands: '.', label: 'Pesos Colombianos (COP)' },
        'GBP': { symbol: '£',  thousands: ',', label: 'Libras Esterlinas (GBP)' }
    };

    /* Country → default currency (ISO 3166-1 alpha-2) */
    var countryToCurrency = {
        'CL': 'CLP',
        'US': 'USD', 'CA': 'USD',
        'MX': 'MXN',
        'AR': 'ARS',
        'UY': 'UYU',
        'PE': 'PEN',
        'CO': 'COP',
        'BR': 'BRL',
        'GB': 'GBP', 'UK': 'GBP',
        'ES': 'EUR', 'FR': 'EUR', 'DE': 'EUR', 'IT': 'EUR',
        'PT': 'EUR', 'NL': 'EUR', 'BE': 'EUR', 'IE': 'EUR',
        'AT': 'EUR', 'FI': 'EUR', 'GR': 'EUR'
    };

    var currentCurrency = 'CLP';

    function detectInitialCurrency() {
        try {
            var langs = (navigator.languages && navigator.languages.length) ? navigator.languages : [navigator.language || 'es-CL'];
            for (var i = 0; i < langs.length; i++) {
                var parts = String(langs[i]).toUpperCase().split(/[-_]/);
                var country = parts[1] || '';
                if (country && countryToCurrency[country]) return countryToCurrency[country];
            }
        } catch (e) {}
        return 'CLP';
    }

    /* ─── Price Formatting (currency-aware) ─── */
    function formatPrice(num) {
        var cur = currencyMap[currentCurrency] || currencyMap.CLP;
        var n = Math.round(Number(num) || 0);
        return cur.symbol + n.toString().replace(/\B(?=(\d{3})+(?!\d))/g, cur.thousands);
    }

    function parsePrice(str) {
        if (!str) return 0;
        return parseInt(String(str).replace(/\D/g, '')) || 0;
    }

    /* Format price input on typing (uses current currency's thousands separator) */
    window.dcFormatPrice = function(input) {
        var cur = currencyMap[currentCurrency] || currencyMap.CLP;
        var raw = input.value.replace(/\D/g, '');
        if (raw === '') { input.value = ''; return; }
        var num = parseInt(raw) || 0;
        input.value = num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, cur.thousands);
    };

    /* ─── Set active currency: reformat all price inputs, update symbol prefixes and totals ─── */
    window.dcSetCurrency = function(code) {
        if (!currencyMap[code]) code = 'CLP';
        currentCurrency = code;
        var cur = currencyMap[code];

        // Update price prefixes (service rows)
        document.querySelectorAll('.dc-service-price-prefix').forEach(function(el) {
            el.textContent = cur.symbol;
        });

        // Update discount amount button label (e.g. "USD $", "EUR €")
        var discBtn = document.getElementById('dcDiscountAmount');
        if (discBtn) discBtn.textContent = code + ' ' + cur.symbol;

        // Re-format all numeric inputs (service prices + discount amount) with new thousands separator
        for (var i = 1; i <= 8; i++) {
            var pInput = document.getElementById('dcSvcPrice' + i);
            if (pInput) window.dcFormatPrice(pInput);
        }
        var dInput = document.getElementById('dcDiscountValue');
        if (dInput) window.dcFormatPrice(dInput);

        window.dcUpdateTotals();
    };

    /* ─── Toggle Service ─── */
    window.dcToggleService = function(cb) {
        var item = cb.closest('.dc-service-item');
        if (cb.checked) {
            item.classList.add('checked');
        } else {
            item.classList.remove('checked');
        }
        dcUpdateTotals();
    };

    /* ─── Update Totals ─── */
    window.dcUpdateTotals = function() {
        var subtotal = 0;
        for (var i = 1; i <= 8; i++) {
            var cb = document.getElementById('dcSvcCheck' + i);
            var priceInput = document.getElementById('dcSvcPrice' + i);
            if (cb && cb.checked && priceInput) {
                subtotal += parsePrice(priceInput.value);
            }
        }

        document.getElementById('dcSubtotal').textContent = formatPrice(subtotal);

        var discountInput = document.getElementById('dcDiscountValue');
        var discountRaw = parsePrice(discountInput.value);
        var discountAmount = 0;

        if (discountType === 'percent') {
            discountAmount = Math.round(subtotal * discountRaw / 100);
        } else {
            discountAmount = discountRaw;
        }

        var total = Math.max(0, subtotal - discountAmount);
        document.getElementById('dcTotal').textContent = formatPrice(total);
    };

    /* ─── Discount Type Toggle ─── */
    window.dcSetDiscountType = function(type) {
        discountType = type;
        var btnAmount = document.getElementById('dcDiscountAmount');
        var btnPct = document.getElementById('dcDiscountPct');
        btnAmount.classList.toggle('active', type === 'amount');
        btnPct.classList.toggle('active', type === 'percent');
        dcUpdateTotals();
    };

    /* ─── Step Navigation ─── */
    window.dcNextStep = function(step) {
        // Validation
        if (step > currentStep) {
            if (currentStep === 1) {
                var name = document.getElementById('dcClientName').value.trim();
                var email = document.getElementById('dcClientEmail').value.trim();
                var phone = document.getElementById('dcClientPhone').value.trim();
                if (!name || !email || !phone) {
                    dcToast('Complete los campos requeridos (Nombre, Email, Teléfono)', 'error');
                    return;
                }
                if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
                    dcToast('Ingrese un email válido', 'error');
                    return;
                }
            }
            if (currentStep === 2) {
                var boatType = document.getElementById('dcBoatType').value;
                if (!boatType) {
                    dcToast('Seleccione el tipo de embarcación', 'error');
                    return;
                }
            }
        }

        currentStep = step;

        // Update panels
        document.querySelectorAll('.dc-panel').forEach(function(p) { p.classList.remove('active'); });
        document.getElementById('dcStep' + step).classList.add('active');

        // Update step indicators
        document.querySelectorAll('.dc-step-item').forEach(function(s) {
            var sNum = parseInt(s.getAttribute('data-step'));
            s.classList.remove('active', 'completed');
            if (sNum === step) s.classList.add('active');
            if (sNum < step) s.classList.add('completed');
        });
        document.querySelectorAll('.dc-step-line').forEach(function(l) {
            var lNum = parseInt(l.getAttribute('data-line'));
            l.classList.toggle('completed', lNum < step);
        });

        // Build summary on step 4
        if (step === 4) {
            buildSummary();
        }

        // Scroll to top of form
        document.querySelector('.dc-main').scrollIntoView({ behavior: 'smooth', block: 'start' });
    };

    /* ─── Collect Form Data ─── */
    function collectData() {
        var services = [];
        var subtotal = 0;
        for (var i = 1; i <= 8; i++) {
            var cb = document.getElementById('dcSvcCheck' + i);
            var priceInput = document.getElementById('dcSvcPrice' + i);
            if (cb && cb.checked) {
                var price = parsePrice(priceInput.value);
                var name = serviceNames[i];
                if (i === 8) {
                    var desc = document.getElementById('dcSvcDesc8').value.trim();
                    if (desc) name = 'Otros: ' + desc;
                }
                services.push({ name: name, price: price });
                subtotal += price;
            }
        }

        var discountRaw = parsePrice(document.getElementById('dcDiscountValue').value);
        var discountAmount = 0;
        if (discountType === 'percent') {
            discountAmount = Math.round(subtotal * discountRaw / 100);
        } else {
            discountAmount = discountRaw;
        }
        var total = Math.max(0, subtotal - discountAmount);

        return {
            client_name: document.getElementById('dcClientName').value.trim(),
            client_email: document.getElementById('dcClientEmail').value.trim(),
            client_phone: document.getElementById('dcClientPhone').value.trim(),
            client_company: document.getElementById('dcClientCompany').value.trim(),
            client_rut: document.getElementById('dcClientRut').value.trim(),
            boat_type: document.getElementById('dcBoatType').value,
            boat_brand: document.getElementById('dcBoatBrand').value.trim(),
            boat_model: document.getElementById('dcBoatModel').value.trim(),
            boat_year: document.getElementById('dcBoatYear').value.trim(),
            boat_marina: document.getElementById('dcBoatMarina').value.trim(),
            services: services,
            subtotal: subtotal,
            discount_value: discountRaw,
            discount_type: discountType,
            discount_amount: discountAmount,
            total: total,
            currency_code: currentCurrency
        };
    }

    /* ─── Generate Quote Number ─── */
    function generateQuoteNumber() {
        var now = new Date();
        return 'DCK-' + now.getFullYear() +
            String(now.getMonth()+1).padStart(2,'0') +
            String(now.getDate()).padStart(2,'0') + '-' +
            String(now.getHours()).padStart(2,'0') +
            String(now.getMinutes()).padStart(2,'0') +
            String(now.getSeconds()).padStart(2,'0');
    }

    /* ─── Build Summary (Step 4) ─── */
    function buildSummary() {
        var d = collectData();
        var html = '';

        // Client section
        html += '<div class="dc-summary-section">';
        html += '<div class="dc-summary-title">Datos del Cliente</div>';
        html += '<div class="dc-summary-grid">';
        html += '<div class="dc-summary-item"><span class="dc-summary-label">Nombre:</span> <span class="dc-summary-value">' + esc(d.client_name) + '</span></div>';
        html += '<div class="dc-summary-item"><span class="dc-summary-label">Email:</span> <span class="dc-summary-value">' + esc(d.client_email) + '</span></div>';
        html += '<div class="dc-summary-item"><span class="dc-summary-label">Teléfono:</span> <span class="dc-summary-value">' + esc(d.client_phone) + '</span></div>';
        if (d.client_company) html += '<div class="dc-summary-item"><span class="dc-summary-label">Empresa:</span> <span class="dc-summary-value">' + esc(d.client_company) + '</span></div>';
        if (d.client_rut) html += '<div class="dc-summary-item"><span class="dc-summary-label">RUT:</span> <span class="dc-summary-value">' + esc(d.client_rut) + '</span></div>';
        html += '</div></div>';

        // Boat section
        html += '<div class="dc-summary-section">';
        html += '<div class="dc-summary-title">Datos de la Embarcación</div>';
        html += '<div class="dc-summary-grid">';
        html += '<div class="dc-summary-item"><span class="dc-summary-label">Tipo:</span> <span class="dc-summary-value">' + esc(d.boat_type) + '</span></div>';
        if (d.boat_brand) html += '<div class="dc-summary-item"><span class="dc-summary-label">Marca:</span> <span class="dc-summary-value">' + esc(d.boat_brand) + '</span></div>';
        if (d.boat_model) html += '<div class="dc-summary-item"><span class="dc-summary-label">Modelo:</span> <span class="dc-summary-value">' + esc(d.boat_model) + '</span></div>';
        if (d.boat_year) html += '<div class="dc-summary-item"><span class="dc-summary-label">Año:</span> <span class="dc-summary-value">' + esc(d.boat_year) + '</span></div>';
        if (d.boat_marina) html += '<div class="dc-summary-item"><span class="dc-summary-label">Marina:</span> <span class="dc-summary-value">' + esc(d.boat_marina) + '</span></div>';
        html += '</div></div>';

        // Services section
        html += '<div class="dc-summary-section">';
        html += '<div class="dc-summary-title">Servicios Cotizados</div>';
        if (d.services.length === 0) {
            html += '<p style="color:#9ca3af;font-size:13px;">No se han seleccionado servicios.</p>';
        } else {
            d.services.forEach(function(s) {
                html += '<div class="dc-summary-service">';
                html += '<span class="dc-summary-service-name">' + esc(s.name) + '</span>';
                html += '<span class="dc-summary-service-price">' + formatPrice(s.price) + '</span>';
                html += '</div>';
            });
        }
        html += '<div style="margin-top:14px;padding-top:14px;border-top:2px dashed #e5e7eb;">';
        html += '<div style="display:flex;justify-content:space-between;padding:4px 0;font-size:14px;"><span style="color:#6b7280;">Sub Total</span><span style="font-weight:700;color:#1a2a3a;">' + formatPrice(d.subtotal) + '</span></div>';
        if (d.discount_amount > 0) {
            var discLabel = d.discount_type === 'percent' ? d.discount_value + '%' : formatPrice(d.discount_value);
            html += '<div style="display:flex;justify-content:space-between;padding:4px 0;font-size:14px;"><span style="color:#e53e3e;">Descuento (' + discLabel + ')</span><span style="font-weight:700;color:#e53e3e;">-' + formatPrice(d.discount_amount) + '</span></div>';
        }
        html += '<div style="display:flex;justify-content:space-between;padding:10px 0 0;font-size:18px;"><span style="font-weight:800;color:#1a2a3a;">TOTAL</span><span style="font-weight:800;background:#e8a735;color:#fff;padding:6px 18px;border-radius:8px;">' + formatPrice(d.total) + '</span></div>';
        html += '</div></div>';

        document.getElementById('dcSummaryContent').innerHTML = html;
    }

    /* ─── Build Quote Document HTML (for preview & PDF) ─── */
    function buildQuoteHTML() {
        var d = collectData();
        var quoteNum = generateQuoteNumber();
        var now = new Date();
        var dateStr = String(now.getDate()).padStart(2,'0') + '/' + String(now.getMonth()+1).padStart(2,'0') + '/' + now.getFullYear();

        var h = '';
        // Header
        h += '<div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:24px;padding-bottom:18px;border-bottom:3px solid #1a3a5c;">';
        h += '<img src="' + esc(logoUrl) + '" alt="DECKEVA" style="height:50px;width:auto;" crossorigin="anonymous">';
        h += '<div style="text-align:right;">';
        h += '<div style="font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:2px;color:#6b7280;margin-bottom:2px;">Cotización</div>';
        h += '<div style="font-size:18px;font-weight:800;color:#1a3a5c;">' + quoteNum + '</div>';
        h += '<div style="font-size:11px;color:#6b7280;margin-top:2px;">' + dateStr + '</div>';
        h += '</div></div>';

        // Title
        h += '<div style="font-size:20px;font-weight:800;color:#1a3a5c;margin-bottom:3px;">Cotización de Servicios Náuticos</div>';
        h += '<div style="font-size:13px;color:#6b7280;margin-bottom:22px;">Preparado para: <strong style="color:#1a2a3a;">' + esc(d.client_name) + '</strong></div>';

        // Client Info
        h += '<div style="margin-bottom:18px;">';
        h += '<div style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:1.5px;color:#1a3a5c;margin-bottom:8px;padding-bottom:5px;border-bottom:1px solid #e5e7eb;">Datos del Cliente</div>';
        h += '<table style="width:100%;border-collapse:collapse;">';
        h += '<tr><td style="padding:5px 0;font-size:12px;font-weight:600;color:#374151;width:130px;">Nombre</td><td style="padding:5px 0;font-size:12px;color:#1a2a3a;">' + esc(d.client_name) + '</td></tr>';
        h += '<tr><td style="padding:5px 0;font-size:12px;font-weight:600;color:#374151;">Email</td><td style="padding:5px 0;font-size:12px;color:#1a2a3a;">' + esc(d.client_email) + '</td></tr>';
        h += '<tr><td style="padding:5px 0;font-size:12px;font-weight:600;color:#374151;">Teléfono</td><td style="padding:5px 0;font-size:12px;color:#1a2a3a;">' + esc(d.client_phone) + '</td></tr>';
        if (d.client_company) h += '<tr><td style="padding:5px 0;font-size:12px;font-weight:600;color:#374151;">Empresa</td><td style="padding:5px 0;font-size:12px;color:#1a2a3a;">' + esc(d.client_company) + '</td></tr>';
        if (d.client_rut) h += '<tr><td style="padding:5px 0;font-size:12px;font-weight:600;color:#374151;">RUT</td><td style="padding:5px 0;font-size:12px;color:#1a2a3a;">' + esc(d.client_rut) + '</td></tr>';
        h += '</table></div>';

        // Boat Info
        h += '<div style="margin-bottom:18px;">';
        h += '<div style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:1.5px;color:#1a3a5c;margin-bottom:8px;padding-bottom:5px;border-bottom:1px solid #e5e7eb;">Datos de la Embarcación</div>';
        h += '<table style="width:100%;border-collapse:collapse;">';
        h += '<tr><td style="padding:5px 0;font-size:12px;font-weight:600;color:#374151;width:130px;">Tipo</td><td style="padding:5px 0;font-size:12px;color:#1a2a3a;">' + esc(d.boat_type) + '</td></tr>';
        if (d.boat_brand) h += '<tr><td style="padding:5px 0;font-size:12px;font-weight:600;color:#374151;">Marca</td><td style="padding:5px 0;font-size:12px;color:#1a2a3a;">' + esc(d.boat_brand) + '</td></tr>';
        if (d.boat_model) h += '<tr><td style="padding:5px 0;font-size:12px;font-weight:600;color:#374151;">Modelo</td><td style="padding:5px 0;font-size:12px;color:#1a2a3a;">' + esc(d.boat_model) + '</td></tr>';
        if (d.boat_year) h += '<tr><td style="padding:5px 0;font-size:12px;font-weight:600;color:#374151;">Año</td><td style="padding:5px 0;font-size:12px;color:#1a2a3a;">' + esc(d.boat_year) + '</td></tr>';
        if (d.boat_marina) h += '<tr><td style="padding:5px 0;font-size:12px;font-weight:600;color:#374151;">Marina</td><td style="padding:5px 0;font-size:12px;color:#1a2a3a;">' + esc(d.boat_marina) + '</td></tr>';
        h += '</table></div>';

        // Services
        h += '<div style="margin-bottom:18px;">';
        h += '<div style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:1.5px;color:#1a3a5c;margin-bottom:8px;padding-bottom:5px;border-bottom:1px solid #e5e7eb;">Servicios Cotizados</div>';
        d.services.forEach(function(s) {
            h += '<div style="display:flex;justify-content:space-between;align-items:center;padding:9px 14px;background:#f8faff;border-radius:8px;margin-bottom:5px;border:1px solid #e5e7eb;">';
            h += '<span style="font-size:13px;font-weight:600;color:#1a2a3a;">' + esc(s.name) + '</span>';
            h += '<span style="font-size:14px;font-weight:700;color:#1a3a5c;white-space:nowrap;">' + formatPrice(s.price) + '</span>';
            h += '</div>';
        });

        // Totals
        h += '<div style="margin-top:12px;padding-top:10px;border-top:2px dashed #e5e7eb;">';
        h += '<div style="display:flex;justify-content:space-between;padding:5px 14px;font-size:13px;"><span style="color:#6b7280;">Sub Total</span><span style="font-weight:700;color:#1a2a3a;">' + formatPrice(d.subtotal) + '</span></div>';
        if (d.discount_amount > 0) {
            var discLabel = d.discount_type === 'percent' ? d.discount_value + '%' : formatPrice(d.discount_value);
            h += '<div style="display:flex;justify-content:space-between;padding:5px 14px;font-size:13px;"><span style="color:#e53e3e;">Descuento (' + discLabel + ')</span><span style="font-weight:700;color:#e53e3e;">-' + formatPrice(d.discount_amount) + '</span></div>';
        }
        h += '<div style="display:flex;justify-content:space-between;align-items:center;padding:12px 16px;background:#1a3a5c;border-radius:10px;margin-top:8px;">';
        h += '<span style="font-size:13px;font-weight:600;color:rgba(255,255,255,0.85);">TOTAL</span>';
        h += '<span style="font-size:20px;font-weight:800;color:#ffffff;">' + formatPrice(d.total) + '</span>';
        h += '</div>';
        h += '</div></div>';

        // Footer
        h += '<div style="margin-top:24px;padding-top:18px;border-top:2px solid #e5e7eb;text-align:center;">';
        var curLabel = (currencyMap[currentCurrency] || currencyMap.CLP).label;
        h += '<div style="font-size:11px;color:#6b7280;line-height:1.5;">Esta cotización es válida por 15 días hábiles.<br>Los precios están en ' + esc(curLabel) + '.</div>';
        h += '<div style="display:flex;justify-content:center;gap:20px;margin-top:10px;flex-wrap:wrap;">';
        h += '<span style="font-size:12px;font-weight:600;color:#1a3a5c;">+56 9 4021 1459</span>';
        h += '<span style="font-size:12px;font-weight:600;color:#1a3a5c;">contacto@deckeva.cl</span>';
        h += '<span style="font-size:12px;font-weight:600;color:#1a3a5c;">deckeva.com</span>';
        h += '</div>';
        h += '<div style="font-size:10px;color:#9ca3af;margin-top:10px;font-style:italic;">* Los precios pueden variar según la complejidad del trabajo y condiciones de la embarcación.</div>';
        h += '</div>';

        return h;
    }

    /* ─── Show Preview ─── */
    window.dcShowPreview = function() {
        document.getElementById('dcPreviewContent').innerHTML = '<div style="padding:20px;font-family:Inter,Helvetica,Arial,sans-serif;color:#1a2a3a;font-size:13px;line-height:1.6;">' + buildQuoteHTML() + '</div>';
        document.getElementById('dcPreviewOverlay').classList.add('visible');
        document.body.style.overflow = 'hidden';
    };

    /* ─── Close Preview ─── */
    window.dcClosePreview = function() {
        document.getElementById('dcPreviewOverlay').classList.remove('visible');
        document.body.style.overflow = '';
    };

    document.getElementById('dcPreviewOverlay').addEventListener('click', function(e) {
        if (e.target === this) dcClosePreview();
    });
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') dcClosePreview();
    });

    /* ─── Download PDF (window.print approach) ─── */
    window.dcDownloadPDF = function() {
        var printContent = buildQuoteHTML();
        var printWin = window.open('', '_blank', 'width=800,height=600');
        printWin.document.write('<!DOCTYPE html><html><head><meta charset="UTF-8"><title>Cotización DECKEVA</title>');
        printWin.document.write('<style>body{font-family:Helvetica,Arial,sans-serif;padding:30px 36px;color:#1a2a3a;font-size:13px;line-height:1.6;margin:0;}img{max-height:50px;}@media print{body{padding:20px;}}</style>');
        printWin.document.write('</head><body>');
        printWin.document.write(printContent);
        printWin.document.write('</body></html>');
        printWin.document.close();
        setTimeout(function() { printWin.print(); }, 500);
    };

    /* ─── Send Email via AJAX ─── */
    window.dcSendEmail = function() {
        var d = collectData();
        if (d.services.length === 0) {
            dcToast('Seleccione al menos un servicio', 'error');
            return;
        }

        var btn = document.getElementById('dcSendEmailBtn');
        btn.disabled = true;
        btn.innerHTML = '<span class="dc-spinner"></span> Enviando...';

        var quoteNum = generateQuoteNumber();

        var formData = new FormData();
        formData.append('_cotizador_nonce', nonce);
        formData.append('client_name', d.client_name);
        formData.append('client_email', d.client_email);
        formData.append('client_phone', d.client_phone);
        formData.append('client_company', d.client_company);
        formData.append('client_rut', d.client_rut);
        formData.append('boat_type', d.boat_type);
        formData.append('boat_brand', d.boat_brand);
        formData.append('boat_model', d.boat_model);
        formData.append('boat_year', d.boat_year);
        formData.append('boat_marina', d.boat_marina);
        formData.append('services', JSON.stringify(d.services));
        formData.append('subtotal', d.subtotal);
        formData.append('discount_value', d.discount_value);
        formData.append('discount_type', d.discount_type);
        formData.append('total', d.total);
        formData.append('quote_number', quoteNum);
        formData.append('currency_code', d.currency_code);

        fetch(siteUrl + '/cotizador/enviar-email', {
            method: 'POST',
            body: formData
        })
        .then(function(resp) { return resp.json(); })
        .then(function(result) {
            btn.disabled = false;
            btn.innerHTML = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 2L11 13"/><path d="M22 2l-7 20-4-9-9-4 20-7z"/></svg> Enviar por Email';
            if (result.success) {
                dcToast(result.data.message || 'Cotización enviada exitosamente', 'success');
            } else {
                dcToast(result.data.message || 'Error al enviar. Intente nuevamente.', 'error');
            }
        })
        .catch(function(err) {
            btn.disabled = false;
            btn.innerHTML = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 2L11 13"/><path d="M22 2l-7 20-4-9-9-4 20-7z"/></svg> Enviar por Email';
            dcToast('Error de conexión. Intente nuevamente.', 'error');
        });
    };

    /* ─── Toast Notification ─── */
    function dcToast(msg, type) {
        var toast = document.getElementById('dcToast');
        toast.textContent = msg;
        toast.className = 'dc-toast ' + type;
        setTimeout(function() { toast.classList.add('visible'); }, 10);
        setTimeout(function() { toast.classList.remove('visible'); }, 4000);
    }
    window.dcToast = dcToast;

    /* ─── HTML Escape ─── */
    function esc(text) {
        var div = document.createElement('div');
        div.textContent = text || '';
        return div.innerHTML;
    }

    /* ─── Init: detect currency from browser locale & apply ─── */
    function dcInit() {
        var detected = detectInitialCurrency();
        var select = document.getElementById('dcCurrency');
        if (select && currencyMap[detected]) {
            select.value = detected;
        }
        window.dcSetCurrency(detected);
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', dcInit);
    } else {
        dcInit();
    }

})();
</script>

</body>
</html>
        <?php
        return ob_get_clean();
    }
}

new Deckeva_Cotizador();
