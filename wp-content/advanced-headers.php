<?php
/**
* This file is created by Really Simple SSL
*/

defined('ABSPATH') or die();

if ( isset($_GET["rsssl_header_test"]) && (int) $_GET["rsssl_header_test"] ===  742261914 ) return;

//RULES START

if ( !headers_sent() ) {
header("Content-Security-Policy: upgrade-insecure-requests; ");
header("X-XSS-Protection: 0");
header("X-Content-Type-Options: nosniff");
header("Referrer-Policy: strict-origin-when-cross-origin");
}
