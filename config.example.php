<?php
/**
 * SkyCert Platform - exemplu configurare.
 *
 * Nu pune parole reale aici. Copiaza acest fisier in config.local.php
 * si completeaza valorile pentru mediul tau.
 */

return [
	'app' => [
		'name'     => 'SkyCert Platform',
		'company'  => 'SKY Cert Global S.R.L.',
		'domain'   => 'app.skycert.ro',
		'url'      => 'https://app.skycert.ro',
		'timezone' => 'Europe/Bucharest',
		'env'      => 'development',
	],

	'db' => [
		'host'     => 'localhost',
		'name'     => 'skycert_local',
		'user'     => 'skycert_user',
		'password' => 'change-me',
		'charset'  => 'utf8mb4',
	],

	'session' => [
		'name'     => 'skycert_session',
		'lifetime' => 60 * 60 * 24 * 7,
		'secure'   => true,
		'httponly' => true,
		'samesite' => 'Lax',
	],

	'admin' => [
		'email'      => 'admin@example.com',
		'password'   => 'change-me',
		'first_name' => 'Admin',
		'last_name'  => 'User',
	],

	'accreditation' => [
		'body'     => 'International Management Accreditation Board',
		'short'    => 'IMAB',
		'url'      => 'www.imacb.com',
		'location' => 'Singapore',
		'annexure' => 'I.RO.2023.0151.A01',
	],
];
