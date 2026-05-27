<?php
/**
 * SkyCert Platform - configurare.
 *
 * Valorile reale stau in config.local.php, fisier ignorat de Git.
 * Pentru un server nou, copiaza config.example.php in config.local.php
 * si completeaza credentialele locale.
 */

$local_config = __DIR__ . '/config.local.php';

if ( file_exists( $local_config ) ) {
	return require $local_config;
}

return require __DIR__ . '/config.example.php';
