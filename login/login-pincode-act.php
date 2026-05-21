<?php /** @var array $t */ ?>
<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/car-server.php';?>
<?php include_once CAR_ROOT_WEB . '/config.inc';?>
<?php include CAR_ROOT_WEB . '/lang/lang.inc'; ?>
<?php
	// Parâmetros
	$redirect_url = car_get_session_attribute('redirect_url', '');
	$email = car_get_session_attribute('email', '');
	$pincode_s = car_get_session_attribute('pincode', ''); // pincode da sessão

    $pincode_p = car_get_parameter('pincode', ''); // pincode do parâmetro

    // Variáveis
	$redirect = CAR_PATH_WEB . '/login/login';

    try {
		if ($pincode_s == $pincode_p) {
			$user_email = $email;

			include_once CAR_ROOT_WEB . '/login/user-insert-act.inc';

			if (empty($redirect_url)) {
				$redirect = CAR_PATH_WEB . '/dash/deck-list';
			} else {
				$redirect = $redirect_url;
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