<?php /** @var array $t */ ?>
<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/car-server.php'; ?>
<?php include_once CAL_ROOT_WEB . '/config.inc'; ?>
<?php include CAL_ROOT_WEB . '/lang/lang.inc'; ?>
<?php cal_check_login($t); ?>
<?php
	// Parâmetros 
	$user_id = cal_get_session_attribute('user_id', 0);

    // Protegendo a exclusão do usuário master
    if ($user_id == CAL_USER_ID_MASTER) $user_id = 0;

	try {
		// Apagando todos as sessões de estudo
		$sql = sprintf(' delete from car_study_session where stud_id in (select stud_id from car_study where user_id = %d)', $user_id);
		
		$result = $mysqli->query($sql);
		
		// Apagando todos os estudos
		$sql = sprintf(' delete from car_study where user_id = %d', $user_id);
		
		$result = $mysqli->query($sql);
		
		// Apagando todos os cartões do grupo
		$sql = sprintf('delete from car_card where user_id = %d', $user_id);
		
		$result = $mysqli->query($sql);
		 
		if (!$result) throw new Exception($mysqli->sqlstate . ' - ' .$mysqli->error);
		
		// Apagando todos os grupos
		$sql = sprintf('delete from car_group where user_id = %d', $user_id);
		
		$result = $mysqli->query($sql);
		
		if (!$result) throw new Exception($mysqli->sqlstate . ' - ' .$mysqli->error);

        // Apagando o usuário
        $sql = sprintf('delete from car_user where user_id = %d', $user_id);

        $result = $mysqli->query($sql);

        if (!$result) throw new Exception($mysqli->sqlstate . ' - ' .$mysqli->error);
		$mysqli->commit();
	} catch(Exception $e) {
		$mysqli->rollback();
		
		cal_set_session_error_message($e->getMessage());
	}

	$mysqli->close();
	
	cal_redirect(CAL_PATH_WEB . '/login/logoff-act');
?>