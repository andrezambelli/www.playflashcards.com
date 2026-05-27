<?php
	include_once CAR_ROOT_GENERAL . '/db.inc';

	if (!isset($_SESSION['session_admin_login']) or $_SESSION['session_admin_login'] == '') {
		$_SESSION['session_admin_login'] = 'off';
	}
	
	define('CAR_ADMIN_VERSION', 0.01);
?>
