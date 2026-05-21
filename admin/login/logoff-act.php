<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/car-server.php';?>
<?php include_once CAL_ROOT_ADMIN . '/config.inc' ?>
<?php
	// Unset all of the session variables.
	$_SESSION = array();
	
	// Finally, destroy the session.
	session_destroy();
	
	// Redirecionando
	cal_redirect('../login/login.php');
?>