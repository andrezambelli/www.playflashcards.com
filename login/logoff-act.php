<?php /** @var array $t */ ?>
<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/car-server.php';?>
<?php include_once CAR_ROOT_WEB . '/config.inc' ?>
<?php include CAR_ROOT_WEB . '/lang/lang.inc'; ?>
<?php
	// Unset all of the session variables.
	$_SESSION = [];

	// Invalida o cookie de sessão no navegador.
	$params = session_get_cookie_params();
	setcookie(session_name(), '', time() - 42000, $params['path'], $params['domain'], $params['secure'], $params['httponly']);

	// Finally, destroy the session.
	session_destroy();
	
	// Redirecionando
	car_redirect(CAR_PATH_WEB . '/' . $t['lang']);
?>