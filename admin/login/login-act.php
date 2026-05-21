<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/car-server.php';?>
<?php include_once CAR_ROOT_ADMIN . '/config.inc' ?>
<?php
	// Parâmetros
	$password = trim($_POST['password']);
	$redirect_url = trim($_POST['redirect_url']);
	
	if ($password != 'aluza') {
		car_set_session_alert_message("Senha inválida.");
	} else {
		car_set_session_attribute('session_admin_login', 'on'); // logado!
	}
	
	// Redirecionando
	if (car_get_session_alert_message()) {
		car_redirect('../login/login.php');
	} else {
		if (empty($redirect_url)) {
			car_redirect('../home/home.php');
		} else {
			car_redirect($redirect_url);
		}
	}
?>