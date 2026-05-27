<?php
/**
 * SkyCert Platform — conexiune MySQL (PDO)
 *
 * Două funcții:
 *   db()       → returnează instanța PDO (singleton)
 *   db_query() → shortcut: prepare + execute + fetch (helper)
 */

function db() {
	static $pdo = null;
	if ( $pdo !== null ) {
		return $pdo;
	}

	global $CONFIG;
	$c = $CONFIG['db'];

	$dsn = "mysql:host={$c['host']};dbname={$c['name']};charset={$c['charset']}";

	try {
		$pdo = new PDO( $dsn, $c['user'], $c['password'], [
			PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
			PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
			PDO::ATTR_EMULATE_PREPARES   => false,
		] );
	} catch ( PDOException $e ) {
		http_response_code( 500 );
		if ( $CONFIG['app']['env'] === 'development' ) {
			die( '<h2>DB connection failed</h2><pre>' . htmlspecialchars( $e->getMessage() ) . '</pre>' );
		}
		die( '<h2>Eroare de conectare la baza de date</h2><p>Verifică datele din config.php (host / nume DB / user / parolă).</p>' );
	}

	return $pdo;
}

/**
 * Shortcut: rulează un SELECT și întoarce toate rândurile.
 */
function db_all( $sql, $params = [] ) {
	$stmt = db()->prepare( $sql );
	$stmt->execute( $params );
	return $stmt->fetchAll();
}

/**
 * Shortcut: rulează un SELECT și întoarce primul rând (sau null).
 */
function db_one( $sql, $params = [] ) {
	$stmt = db()->prepare( $sql );
	$stmt->execute( $params );
	$row = $stmt->fetch();
	return $row ?: null;
}

/**
 * Shortcut: INSERT/UPDATE/DELETE și întoarce nr. de rânduri afectate.
 */
function db_exec( $sql, $params = [] ) {
	$stmt = db()->prepare( $sql );
	$stmt->execute( $params );
	return $stmt->rowCount();
}

/**
 * Shortcut: INSERT și întoarce ID-ul rândului nou.
 */
function db_insert( $table, $data ) {
	$cols = implode( ',', array_keys( $data ) );
	$placeholders = implode( ',', array_map( fn( $k ) => ":$k", array_keys( $data ) ) );
	$sql = "INSERT INTO `$table` ($cols) VALUES ($placeholders)";
	$stmt = db()->prepare( $sql );
	$stmt->execute( $data );
	return (int) db()->lastInsertId();
}

/**
 * Verifică dacă schema bază a fost instalată (tabelul `users` există).
 */
function db_installed() {
	try {
		db()->query( "SELECT 1 FROM users LIMIT 1" );
		return true;
	} catch ( PDOException $e ) {
		return false;
	}
}

/**
 * Creează schema inițială (apelat o singură dată).
 */
function db_install() {
	global $CONFIG;
	$pdo = db();

	$pdo->exec( "CREATE TABLE IF NOT EXISTS users (
		id INT UNSIGNED NOT NULL AUTO_INCREMENT,
		email VARCHAR(255) NOT NULL,
		password_hash VARCHAR(255) NOT NULL,
		first_name VARCHAR(100) DEFAULT NULL,
		last_name VARCHAR(100) DEFAULT NULL,
		role VARCHAR(30) NOT NULL DEFAULT 'operator',
		active TINYINT(1) NOT NULL DEFAULT 1,
		last_login DATETIME DEFAULT NULL,
		created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
		updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
		PRIMARY KEY (id),
		UNIQUE KEY uk_email (email),
		KEY idx_role (role)
	) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci" );

	// Creează user-ul admin inițial
	$admin = $CONFIG['admin'];
	$existing = db_one( "SELECT id FROM users WHERE email = ?", [ $admin['email'] ] );
	if ( ! $existing ) {
		db_insert( 'users', [
			'email'         => $admin['email'],
			'password_hash' => password_hash( $admin['password'], PASSWORD_DEFAULT ),
			'first_name'    => $admin['first_name'],
			'last_name'     => $admin['last_name'],
			'role'          => 'admin',
		] );
	}
}
