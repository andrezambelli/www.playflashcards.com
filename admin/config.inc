<?php
	include_once CAL_ROOT_GENERAL . '/config.inc';

	if (!isset($_SESSION['session_admin_login']) or $_SESSION['session_admin_login'] == '') {
		$_SESSION['session_admin_login'] = 'off';
	}
	
	define('CAL_ADMIN_VERSION', 0.01);
?>