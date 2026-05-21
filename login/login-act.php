<?php /** @var array $t */ ?>
<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/car-server.php';?>
<?php include_once CAL_ROOT_WEB . '/config.inc';?>
<?php include CAL_ROOT_WEB . '/lang/lang.inc'; ?>
<?php
	// Parâmetros
	$redirect_url = cal_get_parameter('redirect_url', '');
	$email = cal_get_parameter('email', '');

	// Variáveis
	$redirect = CAL_PATH_WEB . '/'. $t['lang'] . '/login/login';

	if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
		$pincode = (string) random_int(100000, 999999);

		$payload = (string) json_encode([
			'site_id'  => 'www.playflashcards.com',
			'app_name' => 'Play Flashcards',
			'email'    => $email,
			'pin'      => $pincode,
		]);

		$ch = curl_init(CAL_SERVICE_URL);
		curl_setopt_array($ch, [
			CURLOPT_POST           => true,
			CURLOPT_POSTFIELDS     => $payload,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_TIMEOUT        => 10,
			CURLOPT_HTTPHEADER     => [
				'Content-Type: application/json',
				'Authorization: Bearer ' . CAL_SERVICE_KEY,
			],
		]);
		$response = curl_exec($ch);
		$httpCode = (int) curl_getinfo($ch, CURLINFO_HTTP_CODE);
		curl_close($ch);

		$result = is_string($response) ? json_decode($response, true) : null;

		if ($httpCode === 200 && is_array($result) && !empty($result['ok'])) {
			cal_set_session_attribute('pincode', $pincode);
			cal_set_session_alert_message('login.login-act.sucesso');
			$redirect = CAL_PATH_WEB . '/login/login-pincode';
		} else {
			$error = (is_array($result) && isset($result['error'])) ? $result['error'] : 'login.login-act.error';
			cal_set_session_error_message($error);
			$redirect = CAL_PATH_WEB . '/'. $t['lang'] . '/login/login';
		}
	} else {
		cal_set_session_error_message('login.login-act.invalid');
	}

	cal_set_session_attribute('email', $email);
	cal_set_session_attribute('redirect_url', $redirect_url);

	cal_redirect($redirect);
?>
