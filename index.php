<?php
/**
 * SkyCert Platform — punct de intrare unic (front controller)
 *
 * Toate cererile trec prin acest fișier datorită .htaccess.
 * Rolul lui:
 *   1. Bootstrap: încarcă config, DB, sesiune, helpers
 *   2. Auto-install: dacă nu există schema DB, o creează
 *   3. Routing: împarte $_GET['route'] la modul potrivit
 */

// 1. BOOTSTRAP
$CONFIG = require __DIR__ . '/config.php';

// Setări de bază
date_default_timezone_set( $CONFIG['app']['timezone'] );

// Afișare erori (doar în development)
if ( $CONFIG['app']['env'] === 'development' ) {
	error_reporting( E_ALL );
	ini_set( 'display_errors', '1' );
} else {
	error_reporting( E_ERROR | E_PARSE );
	ini_set( 'display_errors', '0' );
}

require __DIR__ . '/db.php';
require __DIR__ . '/auth.php';
require __DIR__ . '/helpers.php';

session_start_secure();

// 2. AUTO-INSTALL (rulează o singură dată la prima accesare)
if ( ! db_installed() ) {
	db_install();
	log_event( 'Database installed automatically', 'INFO' );
}

// 3. ROUTING
$route = $_GET['route'] ?? '';
$route = trim( $route, '/' );

// Rute → fișier modul (slug → fișier .php din modules/)
$routes = [
	''           => 'home',         // root → redirect la login/dashboard
	'login'      => 'login',
	'logout'     => 'logout',
	'dashboard'  => 'dashboard',
	'leads'      => 'leads',
	'clients'    => 'clients',
	'documents'  => 'documents',
	'invoicing'  => 'invoicing',
	'payments'   => 'payments',
	'reminders'  => 'reminders',
	'reports'    => 'reports',
	'settings'   => 'settings',
];

// Slug-uri publice (nu cer login)
$public_routes = [ 'login', 'home' ];

// Mapare rută → modul
$module = $routes[ $route ] ?? null;

// 404 dacă ruta nu există
if ( $module === null ) {
	http_response_code( 404 );
	$current_route = '404';
	view( '404', [], 'none' );
	exit;
}

// Cerere autentificare pentru rute private
if ( ! in_array( $module, $public_routes, true ) ) {
	auth_require();
}

// Încarcă modulul
$module_file = __DIR__ . "/modules/{$module}.php";
if ( ! file_exists( $module_file ) ) {
	http_response_code( 500 );
	die( "Modulul lipsește: $module" );
}

require $module_file;
