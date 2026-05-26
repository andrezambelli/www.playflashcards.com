<?php /** @var array $t */ ?>
<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/car-server.php';?>
<?php include_once CAR_ROOT_WEB . '/config.inc';?>
<?php include CAR_ROOT_WEB . '/lang/lang.inc'; ?>
<?php
	// Parâmetros
	$redirect_url = car_get_session_attribute('redirect_url', '');
	$email        = car_get_session_attribute('email', '');
	$pincode_s    = car_get_session_attribute('pincode', '');
	$sent_at      = (int) car_get_session_attribute('code_sent_at', 0);

    $pincode_p = preg_replace('/\D/', '', car_get_parameter('pincode', ''));

    // Variáveis
	$redirect = CAR_PATH_WEB . '/login/login';

    try {
		// código expirado após 10 minutos
		if ($sent_at > 0 && (time() - $sent_at) > 600) {
			car_set_session_attribute('pincode', '');
			car_set_session_attribute('code_sent_at', 0);
			car_set_session_error_message('login.login-pincode-act.expired');
			car_redirect(CAR_PATH_WEB . '/'. $t['lang'] . '/login/login');
		}

		if (!empty($pincode_s) && password_verify($pincode_p, $pincode_s)) {
			$user_email = $email;

			include_once CAR_ROOT_WEB . '/login/user-insert-act.inc';

			if (empty($redirect_url)) {
				$redirect = CAR_PATH_WEB . '/dash/home';
			} else {
				$redirect = car_safe_redirect_url($redirect_url, CAR_PATH_WEB . '/dash/home');
			}
		} else {
			car_set_session_error_message('login.login-pincode-act.invalid');

			$redirect = CAR_PATH_WEB . '/login/login-pincode';
		}
	} catch(Exception $e) {
		$mysqli->rollback();
		
		car_set_session_error_message($e->getMessage());
	
		$redirect = CAR_PATH_WEB . '/login/login';
	}
	
	$mysqli->close();
	
	car_redirect($redirect);
?>
