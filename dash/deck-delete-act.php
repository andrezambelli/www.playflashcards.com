<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/car-server.php'; ?>
<?php include_once CAL_ROOT_WEB . '/config.inc'; ?>
<?php include CAL_ROOT_WEB . '/lang/lang.inc'; ?>
<?php cal_check_login($t); ?>
<?php
	// Parâmetros 
	$user_id = cal_get_session_attribute('user_id', 0);

    $deck_key = cal_get_parameter('k', '');

    // Variáveis
	$deck_id = 0;
	
	try {
		// Procurando o identificador do grupo
		$sql = sprintf(" 
                        select deck_id 
                          from car_deck 
                         where deck_key = '%s'
                           and user_id = %d",
                        $mysqli->real_escape_string(cal_never_null($deck_key)),
                        $user_id);
		
		$result = $mysqli->query($sql);
		
		while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
			$deck_id = $row['deck_id'];
		}
		
		// Apagando todos as sessões de estudo
		$sql = sprintf(' delete from car_study_session where stud_id in (select stud_id from car_study where deck_id = %d)', $deck_id);
		
		$result = $mysqli->query($sql);
		
		// Apagando todos os estudos
		$sql = sprintf(' delete from car_study where deck_id = %d', $deck_id);
		
		$result = $mysqli->query($sql);
		
		// Apagando todos os cartões do grupo
		$sql = sprintf('delete from car_card where deck_id = %d and user_id = %d', $deck_id, $user_id);
		
		$result = $mysqli->query($sql);
		 
		if (!$result) throw new Exception($mysqli->sqlstate . ' - ' .$mysqli->error);
		
		// Apagando o grupo
		$sql = sprintf('delete from car_deck where deck_id = %d and user_id = %d', $deck_id, $user_id);
		
		$result = $mysqli->query($sql);
		
		if (!$result) throw new Exception($mysqli->sqlstate . ' - ' .$mysqli->error);
		
		$mysqli->commit();
	} catch(Exception $e) {
		$mysqli->rollback();
		
		cal_set_session_error_message($e->getMessage());
	}

	$mysqli->close();
	
	cal_redirect(CAL_PATH_WEB . '/dash/deck-list');
?>