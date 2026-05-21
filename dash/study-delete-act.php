<?php /** @var array $t */ ?>
<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/car-server.php'; ?>
<?php include_once CAR_ROOT_WEB . '/config.inc'; ?>
<?php include CAR_ROOT_WEB . '/lang/lang.inc'; ?>
<?php car_check_login($t); ?>
<?php
	// Parâmetros 
	$user_id = car_get_session_attribute('user_id', 0);

    $stud_key = car_get_parameter('k', '');

    // Variáveis
	$stud_id = 0;
	$deck_key = '';
	
	try {
		// Procurando o identificador do estudo
		$sql = sprintf(" select a.stud_id, b.deck_key
                           from car_study a,
								car_deck b
                          where a.stud_key = '%s'
                            and a.user_id = %d
							and a.deck_id = b.deck_id",
		 				    $mysqli->real_escape_string(car_never_null($stud_key)),
		 					$user_id);
		
		$result = $mysqli->query($sql);
		
		while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
			$stud_id = $row['stud_id'];
			$deck_key = $row['deck_key'];
		}
		
		// Apagando a sessão do estudo
		$sql = sprintf('delete from car_study_session where stud_id = %d and user_id = %d', $stud_id, $user_id);
		
		$result = $mysqli->query($sql);
		 
		if (!$result) throw new Exception($mysqli->sqlstate . ' - ' .$mysqli->error);
		
		// Apagando o estudo
		$sql = sprintf('delete from car_study where stud_id = %d and user_id = %d', $stud_id, $user_id);
		
		$result = $mysqli->query($sql);
		
		if (!$result) throw new Exception($mysqli->sqlstate . ' - ' .$mysqli->error);
		
		$mysqli->commit();
	} catch(Exception $e) {
		$mysqli->rollback();
		
		car_set_session_error_message($e->getMessage());
	}

	$mysqli->close();
	
	car_redirect(CAR_PATH_WEB . '/dash/study-list?k=' . $deck_key);
?>