<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/car-server.php';?>
<?php include_once CAL_ROOT_ADMIN . '/config.inc' ?>
<?php
	// Parâmetros
	$password = trim($_POST['password']);
	$redirect_url = trim($_POST['redirect_url']);
	
	if ($password != 'aluza') {
		cal_set_session_alert_message("Senha inválida.");
	} else {
		cal_set_session_attribute('session_admin_login', 'on'); // logado!
	}
	
	// Redirecionando
	if (cal_get_session_alert_message()) {
		cal_redirect('../login/login.php');
	} else {
		if (empty($redirect_url)) {
			cal_redirect('../home/home.php');
		} else {
			cal_redirect($redirect_url);
		}
	}
?>