<?php
/**
 * SkyCert Platform — autentificare & sesiuni
 *
 * Funcții:
 *   session_start_secure() — pornește sesiunea cu config sigur
 *   auth_login($email, $password) — verifică credențiale, setează sesiunea
 *   auth_logout() — distruge sesiunea
 *   auth_check() — true dacă userul e logat
 *   auth_user() — returnează user-ul curent (sau null)
 *   auth_require() — redirectează la /login dacă nu e logat
 */

function session_start_secure() {
	global $CONFIG;
	$c = $CONFIG['session'];

	if ( session_status() === PHP_SESSION_ACTIVE ) {
		return;
	}

	session_name( $c['name'] );
	session_set_cookie_params( [
		'lifetime' => $c['lifetime'],
		'path'     => '/',
		'domain'   => '',
		'secure'   => $c['secure'],
		'httponly' => $c['httponly'],
		'samesite' => $c['samesite'],
	] );

	session_start();
}

/**
 * Verifică credențiale și setează sesiunea.
 * @return array|false  user array dacă login OK, false altfel
 */
function auth_login( $email, $password ) {
	$email = strtolower( trim( $email ) );
	$user = db_one( "SELECT * FROM users WHERE email = ? AND active = 1", [ $email ] );

	if ( ! $user ) {
		return false;
	}

	if ( ! password_verify( $password, $user['password_hash'] ) ) {
		return false;
	}

	// Regenerează ID-ul de sesiune pentru securitate
	session_regenerate_id( true );

	// Setează sesiunea
	$_SESSION['user_id']    = (int) $user['id'];
	$_SESSION['user_email'] = $user['email'];
	$_SESSION['user_role']  = $user['role'];
	$_SESSION['login_at']   = time();

	// Update last_login
	db_exec( "UPDATE users SET last_login = NOW() WHERE id = ?", [ $user['id'] ] );

	return $user;
}

/**
 * Distruge sesiunea (logout).
 */
function auth_logout() {
	$_SESSION = [];
	if ( ini_get( 'session.use_cookies' ) ) {
		$params = session_get_cookie_params();
		setcookie( session_name(), '', time() - 42000, $params['path'], $params['domain'], $params['secure'], $params['httponly'] );
	}
	session_destroy();
}

/**
 * @return bool  user logat
 */
function auth_check() {
	return isset( $_SESSION['user_id'] ) && $_SESSION['user_id'] > 0;
}

/**
 * @return array|null  user curent sau null
 */
function auth_user() {
	static $cached = null;
	if ( $cached !== null ) {
		return $cached;
	}
	if ( ! auth_check() ) {
		return null;
	}
	$cached = db_one( "SELECT id, email, first_name, last_name, role, active FROM users WHERE id = ?", [ $_SESSION['user_id'] ] );
	if ( ! $cached || ! $cached['active'] ) {
		auth_logout();
		return null;
	}
	return $cached;
}

/**
 * Cere logare. Dacă nu e logat, redirectează la /login.
 */
function auth_require() {
	if ( ! auth_check() || ! auth_user() ) {
		$next = $_SERVER['REQUEST_URI'] ?? '/';
		redirect( '/login?next=' . urlencode( $next ) );
	}
}

/**
 * Generează un token anti-CSRF pentru sesiunea curentă.
 */
function csrf_token() {
	if ( empty( $_SESSION['csrf_token'] ) ) {
		$_SESSION['csrf_token'] = bin2hex( random_bytes( 16 ) );
	}
	return $_SESSION['csrf_token'];
}

/**
 * Verifică un token anti-CSRF trimis prin formular.
 */
function csrf_check( $token ) {
	return isset( $_SESSION['csrf_token'] ) && hash_equals( $_SESSION['csrf_token'], (string) $token );
}
