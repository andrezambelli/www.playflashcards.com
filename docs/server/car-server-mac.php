<?php
	define('CAL_PROD', false);

	define('CAL_DB_AUTOCOMMIT', false);
	define('CAL_DB_NAME', 'flashcarddb');
	define('CAL_DB_USER', 'root');
	define('CAL_DB_PASSWORD', 'masterkey');
	define('CAL_DB_HOST', '127.0.0.1');
	define('CAL_DB_PORT', '3306');
	define('CAL_DB_CHARSET', 'utf8');

	$_root = '/Users/zambelli/git/www.playflashcards.com';
	define('CAL_ROOT_APP', $_root);
	define('CAL_ROOT_WEB', $_root);
	define('CAL_ROOT_ADMIN', $_root . '/admin');
	define('CAL_ROOT_GENERAL', $_root . '/general');
	define('CAL_ROOT_EXTERNAL_LIB', $_root . '/external-lib');

	define('CAL_PATH_APP', '');
	define('CAL_PATH_WEB', CAL_PATH_APP);
	define('CAL_PATH_ADMIN', CAL_PATH_APP . '/admin');
?>
