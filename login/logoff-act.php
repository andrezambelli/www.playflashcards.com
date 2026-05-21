<?php /** @var array $t */ ?>
<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/car-server.php';?>
<?php include_once CAL_ROOT_WEB . '/config.inc' ?>
<?php include CAL_ROOT_WEB . '/lang/lang.inc'; ?>
<?php
	// Unset all of the session variables.
	$_SESSION = [];
	
	// Finally, destroy the session.
	session_destroy();
	
	// Redirecionando
	cal_redirect(CAL_PATH_WEB . '/' . $t['lang']);
?>