<?php /** @var array $t */ ?>
<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/car-server.php'; ?>
<?php include_once CAR_ROOT_WEB . '/config.inc'; ?>
<?php include CAR_ROOT_WEB . '/lang/lang.inc'; ?>
<?php car_check_login($t); ?>
<?php
	// Parâmetros 
	$user_id = car_get_session_attribute('user_id', 0);

    $deck_key = car_get_parameter('k', '');

    // Variáveis
	$deck_id = 0;
	
	try {
		// Procurando o identificador do grupo
		$sql = sprintf("select deck_id
                          from car_deck
                         where deck_key = '%s'
                           and user_id = %d",
                        $mysqli->real_escape_string(car_never_null($deck_key)),
                        $user_id);
		
		$result = $mysqli->query($sql);
		
		while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
			$deck_id = $row['deck_id'];
		}

        if ($deck_id === 0) {
            car_set_session_error_message('dash.deck-info.not-found');
            car_redirect(CAR_PATH_WEB . '/dash/deck-list');
        }

		// Apagando todos as sessões de estudo
		$sql = sprintf('delete from car_study_session
                         where user_id = %d
                           and stud_id in (
                               select stud_id
                                 from car_study
                                where deck_id = %d
                                  and user_id = %d
                           )',
                        $user_id,
                        $deck_id,
                        $user_id);
		
		$result = $mysqli->query($sql);
		
		// Apagando todos os estudos
		$sql = sprintf('delete from car_study
                         where deck_id = %d
                           and user_id = %d',
                        $deck_id,
                        $user_id);
		
		$result = $mysqli->query($sql);
		
		// Apagando todos os cartões do grupo
		$sql = sprintf('delete from car_card
                         where deck_id = %d
                           and user_id = %d',
                        $deck_id,
                        $user_id);
		
		$result = $mysqli->query($sql);
		 
		if (!$result) { error_log($mysqli->sqlstate . ' - ' . $mysqli->error); throw new Exception('error.db'); }
		
		// Apagando o grupo
		$sql = sprintf('delete from car_deck
                         where deck_id = %d
                           and user_id = %d',
                        $deck_id,
                        $user_id);
		
		$result = $mysqli->query($sql);
		
		if (!$result) { error_log($mysqli->sqlstate . ' - ' . $mysqli->error); throw new Exception('error.db'); }
		
		$mysqli->commit();

		car_set_session_alert_message('dash.deck-delete.success');
	} catch(Exception $e) {
		$mysqli->rollback();
		
		car_set_session_error_message($e->getMessage());
	}

	$mysqli->close();
	
	car_redirect(CAR_PATH_WEB . '/dash/deck-list');
?>
