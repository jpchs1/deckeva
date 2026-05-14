<?php
/**
 * DECKEVA — Webpay return shim
 *
 * Transbank realiza un POST al return_url al finalizar la transaccion (token_ws).
 * Como el JS del cliente solo puede leer query params, este shim recibe el POST,
 * sanitiza el token y emite un HTTP 303 (See Other) a /pago/?webpay_token=...
 * El JS de /pago/ se encarga del commit_transaction contra el backend.
 *
 * Tambien soporta el caso de aborto: TBK_TOKEN sin token_ws.
 */

// Solo aceptamos POST o GET con los parametros esperados.
$token = isset($_POST['token_ws']) ? $_POST['token_ws'] : (isset($_GET['token_ws']) ? $_GET['token_ws'] : '');
$abortToken = isset($_POST['TBK_TOKEN']) ? $_POST['TBK_TOKEN'] : (isset($_GET['TBK_TOKEN']) ? $_GET['TBK_TOKEN'] : '');

// Sanitizar: Transbank usa tokens alfanumericos (letras, numeros, guion bajo, guion).
$clean = function ($v) {
    return preg_replace('/[^A-Za-z0-9_\-]/', '', (string) $v);
};

$token      = $clean($token);
$abortToken = $clean($abortToken);

$base = '/pago/';

if ($token !== '') {
    // Flujo normal: el cliente vuelve con token_ws para commit.
    header('Location: ' . $base . '?webpay_token=' . urlencode($token), true, 303);
    exit;
}

if ($abortToken !== '') {
    // El usuario abort el pago en Webpay.
    header('Location: ' . $base . '?webpay_status=aborted&token=' . urlencode($abortToken), true, 303);
    exit;
}

// Sin parametros relevantes: devolver al portal.
header('Location: ' . $base . '?webpay_status=unknown', true, 303);
exit;
