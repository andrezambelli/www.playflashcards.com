<?php
	define('CAL_PROD', true);

	define('CAL_DB_AUTOCOMMIT', false);
	define('CAL_DB_NAME', 'flashcarddb');
	define('CAL_DB_USER', '');
	define('CAL_DB_PASSWORD', '');
	define('CAL_DB_HOST', '');
	define('CAL_DB_PORT', '3306');
	define('CAL_DB_CHARSET', 'utf8');

	define('CAL_ROOT_APP', $_SERVER['DOCUMENT_ROOT']);
	define('CAL_ROOT_WEB', CAL_ROOT_APP);
	define('CAL_ROOT_ADMIN', CAL_ROOT_APP . '/admin');
	define('CAL_ROOT_GENERAL', CAL_ROOT_APP . '/general');
	define('CAL_ROOT_EXTERNAL_LIB', CAL_ROOT_APP . '/external-lib');

	define('CAL_PATH_APP', '');
	define('CAL_PATH_WEB', CAL_PATH_APP);
	define('CAL_PATH_ADMIN', CAL_PATH_APP . '/admin');
?>
