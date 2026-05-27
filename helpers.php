<?php
/**
 * SkyCert Platform — funcții utilitare globale
 */

/**
 * Escape HTML — folosește la TOATE valorile dinamice afișate în HTML.
 */
function e( $value ) {
	return htmlspecialchars( (string) $value, ENT_QUOTES | ENT_HTML5, 'UTF-8' );
}

/**
 * Construiește un URL absolut pe baza domeniului din config.
 */
function url( $path = '' ) {
	global $CONFIG;
	$base = rtrim( $CONFIG['app']['url'], '/' );
	$path = '/' . ltrim( $path, '/' );
	return $base . $path;
}

/**
 * Redirect HTTP cu exit.
 */
function redirect( $path ) {
	header( 'Location: ' . url( $path ) );
	exit;
}

/**
 * Randează un view cu layout.
 *
 * @param string $template  numele view-ului fără extensie (ex: 'dashboard')
 * @param array  $data      variabilele disponibile în view
 * @param string $layout    layout-ul de folosit (default: 'layout', sau 'none' pentru pagini standalone gen login)
 */
function view( $template, $data = [], $layout = 'layout' ) {
	global $CONFIG;
	$user = auth_user();

	extract( $data, EXTR_SKIP );

	$view_path = __DIR__ . "/views/{$template}.html.php";
	if ( ! file_exists( $view_path ) ) {
		http_response_code( 500 );
		die( "View lipsește: $template" );
	}

	if ( $layout === 'none' ) {
		require $view_path;
		return;
	}

	// Capturează conținutul în $content, apoi randează layout-ul
	ob_start();
	require $view_path;
	$content = ob_get_clean();

	$layout_path = __DIR__ . "/views/{$layout}.php";
	if ( ! file_exists( $layout_path ) ) {
		echo $content;
		return;
	}
	require $layout_path;
}

/**
 * Înregistrează un eveniment în log-ul aplicației.
 */
function log_event( $message, $level = 'INFO' ) {
	$line = sprintf( "[%s] [%s] %s\n", date( 'Y-m-d H:i:s' ), $level, $message );
	$file = __DIR__ . '/storage/logs/app.log';
	if ( is_writable( dirname( $file ) ) ) {
		file_put_contents( $file, $line, FILE_APPEND );
	}
}

/**
 * Format numeric pentru afișare în lei (1.234,56 lei).
 */
function fmt_money( $value, $currency = 'lei' ) {
	return number_format( (float) $value, 2, ',', '.' ) . ' ' . $currency;
}

/**
 * Format data pentru afișare (27.05.2026).
 */
function fmt_date( $datetime, $format = 'd.m.Y' ) {
	if ( ! $datetime ) return '—';
	$ts = is_numeric( $datetime ) ? $datetime : strtotime( $datetime );
	return date( $format, $ts );
}

/**
 * Inițialele utilizatorului pentru avatar.
 */
function user_initials( $user ) {
	$first = $user['first_name'] ?? '';
	$last  = $user['last_name']  ?? '';
	$initials = strtoupper( substr( $first, 0, 1 ) . substr( $last, 0, 1 ) );
	if ( strlen( $initials ) < 2 ) {
		$initials = strtoupper( substr( $user['email'] ?? '??', 0, 2 ) );
	}
	return $initials;
}

/**
 * Modulele platformei — sursa unică de adevăr pentru sidebar.
 */
function modules_list() {
	return [
		'dashboard' => [ 'label' => 'Dashboard',  'icon' => 'ti-layout-dashboard', 'url' => '/dashboard' ],
		'leads'     => [ 'label' => 'Leads',      'icon' => 'ti-mail-share',       'url' => '/leads',     'badge' => 0 ],
		'clients'   => [ 'label' => 'Clienți',    'icon' => 'ti-building',         'url' => '/clients' ],
		'documents' => [ 'label' => 'Documente',  'icon' => 'ti-file-certificate', 'url' => '/documents' ],
		'invoicing' => [ 'label' => 'Facturare',  'icon' => 'ti-receipt',          'url' => '/invoicing' ],
		'payments'  => [ 'label' => 'Încasări',   'icon' => 'ti-cash',             'url' => '/payments' ],
		'reminders' => [ 'label' => 'Reminders',  'icon' => 'ti-bell',             'url' => '/reminders' ],
		'reports'   => [ 'label' => 'Rapoarte',   'icon' => 'ti-chart-bar',        'url' => '/reports' ],
	];
}
