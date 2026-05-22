<?php /** @var array $t */ ?>
<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/car-server.php';?>
<?php include_once CAR_ROOT_WEB . '/config.inc';?>
<?php include CAR_ROOT_WEB . '/lang/lang.inc'; ?>
<?php
	// Parâmetros
	$redirect_url = car_get_parameter('redirect_url', '');
	$email = car_get_parameter('email', '');

	// Variáveis
	$redirect = CAR_PATH_WEB . '/'. $t['lang'] . '/login/login';

	// rate limiting: bloqueia reenvio dentro de 60s
	$last_sent = (int) car_get_session_attribute('code_sent_at', 0);
	if ($last_sent > 0 && (time() - $last_sent) < 60) {
		car_set_session_error_message('login.login-act.cooldown');
		$has_pincode = !empty(car_get_session_attribute('pincode', ''));
		car_redirect($has_pincode
			? CAR_PATH_WEB . '/login/login-pincode'
			: CAR_PATH_WEB . '/'. $t['lang'] . '/login/login'
		);
	}

	if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
		$pincode = (string) random_int(100000, 999999);
		$ok      = false;

		if (CAR_SEND_EMAIL) {
			$payload = (string) json_encode([
				'site_id'  => 'www.playflashcards.com',
				'app_name' => 'Play Flashcards',
				'email'    => $email,
				'pin'      => $pincode,
			]);

			$ch = curl_init(CAR_SERVICE_URL);
			curl_setopt_array($ch, [
				CURLOPT_POST           => true,
				CURLOPT_POSTFIELDS     => $payload,
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_TIMEOUT        => 10,
				CURLOPT_HTTPHEADER     => [
					'Content-Type: application/json',
					'Authorization: Bearer ' . CAR_SERVICE_KEY,
				],
			]);
			$response = curl_exec($ch);
			$httpCode = (int) curl_getinfo($ch, CURLINFO_HTTP_CODE);
			curl_close($ch);

			$result = is_string($response) ? json_decode($response, true) : null;
			$ok     = $httpCode === 200 && is_array($result) && !empty($result['ok']);

			if (!$ok) {
				$error = (is_array($result) && isset($result['error'])) ? $result['error'] : 'login.login-act.error';
				car_set_session_error_message($error);
				$redirect = CAR_PATH_WEB . '/'. $t['lang'] . '/login/login';
			}
		} else {
			// modo desenvolvimento: código fixo, sem envio de e-mail
			$pincode = '111111';
			$ok      = true;
		}

		if ($ok) {
			car_set_session_attribute('pincode', password_hash($pincode, PASSWORD_DEFAULT));
			car_set_session_attribute('code_sent_at', time());
			car_set_session_alert_message('login.login-act.sucesso');
			$redirect = CAR_PATH_WEB . '/login/login-pincode';
		}
	} else {
		car_set_session_error_message('login.login-act.invalid');
	}

	car_set_session_attribute('email', $email);
	car_set_session_attribute('redirect_url', $redirect_url);

	car_redirect($redirect);
?>
