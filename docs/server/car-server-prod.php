<?php
	define('CAR_PROD', true);

	define('CAR_DB_AUTOCOMMIT', false);
	define('CAR_DB_NAME', 'flashcarddb');
	define('CAR_DB_USER', '');
	define('CAR_DB_PASSWORD', '');
	define('CAR_DB_HOST', '');
	define('CAR_DB_PORT', '3306');
	define('CAR_DB_CHARSET', 'utf8');

	define('CAR_ROOT_APP', $_SERVER['DOCUMENT_ROOT']);
	define('CAR_ROOT_WEB', CAR_ROOT_APP);
	define('CAR_ROOT_ADMIN', CAR_ROOT_APP . '/admin');
	define('CAR_ROOT_GENERAL', CAR_ROOT_APP . '/general');
	define('CAR_ROOT_EXTERNAL_LIB', CAR_ROOT_APP . '/external-lib');

	define('CAR_PATH_APP', '');
	define('CAR_PATH_WEB', CAR_PATH_APP);
	define('CAR_PATH_ADMIN', CAR_PATH_APP . '/admin');

	define('CAR_SERVICE_KEY', '');
?>
