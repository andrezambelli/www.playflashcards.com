<?php /** @var array $t */ ?>
<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/car-server.php';?>
<?php include_once CAR_ROOT_WEB . '/config.inc';?>
<?php include CAR_ROOT_WEB . '/lang/lang.inc'; ?>
<?php
	// Parâmetros
	$form_content = car_get_parameter('form_content', '');

	// Variáveis
	$redirect = '';

	if (empty($form_content)) car_set_session_error_message('common.contact-us-act.message1');

	if (!car_has_session_error_message()) {
		try {
			// Inserindo na tabela de formulário
			$sql = sprintf(" insert into car_form
							 (form_type, form_content)
							 values ('%s','%s')",
							'Fale Conosco',
							$mysqli->real_escape_string(car_never_null($form_content)));

			$result = $mysqli->query($sql);

			if (!$result) throw new Exception($mysqli->sqlstate . ' - ' . $mysqli->error);

			$mysqli->commit();

			$redirect = CAR_PATH_WEB . '/contact-us-thanks';
		} catch (Exception $e) {
			$mysqli->rollback();

			car_set_session_error_message($e->getMessage());

			$redirect = CAR_PATH_WEB . '/contact-us-error';
		}
	} else {
		$redirect = CAR_PATH_WEB . '/'. $t['lang'] . '/contact-us';
	}
	
	car_redirect($redirect);
?>
