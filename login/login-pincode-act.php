<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/car-server.php';?>
<?php include_once CAL_ROOT_WEB . '/config.inc';?>
<?php include CAL_ROOT_WEB . '/lang/lang.inc'; ?>
<?php
	// Parâmetros
	$redirect_url = cal_get_session_attribute('redirect_url', '');
	$email = cal_get_session_attribute('email', '');
	$pincode_s = cal_get_session_attribute('pincode', ''); // pincode da sessão

    $pincode_p = cal_get_parameter('pincode', ''); // pincode do parâmetro

    // Variáveis
	$redirect = CAL_PATH_WEB . '/login/login';

    try {
		if ($pincode_s == $pincode_p) {
			$user_email = $email;

			include_once CAL_ROOT_WEB . '/login/user-insert-act.inc';

			if (empty($redirect_url)) {
				$redirect = CAL_PATH_WEB . '/dash/deck-list';
			} else {
				$redirect = $redirect_url;
			}
		} else {
			cal_set_session_error_message('login.login-pincode-act.invalid');

			$redirect = CAL_PATH_WEB . '/login/login-pincode';
		}
	} catch(Exception $e) {
		$mysqli->rollback();
		
		cal_set_session_error_message($e->getMessage());
	
		$redirect = CAL_PATH_WEB . '/login/login';
	}
	
	$mysqli->close();
	
	cal_redirect($redirect);
?>