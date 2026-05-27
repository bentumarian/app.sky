<?php
/**
 * Modul: login — formular + validare + setare sesiune
 */

// Dacă deja logat, du-l la dashboard
if ( auth_check() ) {
	redirect( '/dashboard' );
}

$error = '';
$email = '';
$next  = isset( $_GET['next'] ) ? $_GET['next'] : '/dashboard';

// Procesare submit
if ( $_SERVER['REQUEST_METHOD'] === 'POST' ) {
	$email    = trim( $_POST['email'] ?? '' );
	$password = $_POST['password'] ?? '';
	$next     = $_POST['next'] ?? '/dashboard';

	if ( ! csrf_check( $_POST['_csrf'] ?? '' ) ) {
		$error = 'Sesiunea a expirat. Reîncarcă pagina și încearcă din nou.';
	} elseif ( ! $email || ! $password ) {
		$error = 'Completează email și parola.';
	} else {
		$user = auth_login( $email, $password );
		if ( $user ) {
			log_event( "Login OK: $email", 'INFO' );
			// Verifică next să fie un path local
			if ( $next && strpos( $next, '/' ) === 0 && strpos( $next, '//' ) !== 0 ) {
				redirect( $next );
			}
			redirect( '/dashboard' );
		}
		$error = 'Email sau parolă greșite.';
		log_event( "Login FAIL: $email", 'WARN' );
	}
}

view( 'login', [
	'error' => $error,
	'email' => $email,
	'next'  => $next,
], 'none' );
