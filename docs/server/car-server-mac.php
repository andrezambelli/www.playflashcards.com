<?php
	define('CAR_PROD', false);

	define('CAR_DB_AUTOCOMMIT', false);
	define('CAR_DB_NAME', 'flashcarddb');
	define('CAR_DB_USER', 'root');
	define('CAR_DB_PASSWORD', 'masterkey');
	define('CAR_DB_HOST', '127.0.0.1');
	define('CAR_DB_PORT', '3306');
	define('CAR_DB_CHARSET', 'utf8');

	$_root = '/Users/zambelli/git/www.playflashcards.com';
	define('CAR_ROOT_APP', $_root);
	define('CAR_ROOT_WEB', $_root);
	define('CAR_ROOT_ADMIN', $_root . '/admin');
	define('CAR_ROOT_GENERAL', $_root . '/general');
	define('CAR_ROOT_EXTERNAL_LIB', $_root . '/external-lib');

	define('CAR_PATH_APP', '');
	define('CAR_PATH_WEB', CAR_PATH_APP);
	define('CAR_PATH_ADMIN', CAR_PATH_APP . '/admin');

	define('CAR_SERVICE_KEY', 'op_7c4f2a9d1e8b3f6a0c5d2e9b4f1a7c3e');
?>
