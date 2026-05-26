<?php /** @var array $t */ ?>
<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/car-server.php';?>
<?php include_once CAR_ROOT_WEB . '/config.inc';?>
<?php include CAR_ROOT_WEB . '/lang/lang.inc'; ?>
<?php car_check_login($t); ?>
<?php
	// Parâmetros
	$user_id = car_get_session_attribute('user_id', 0);

    $card_key = car_get_parameter('k', '');

    // Variáveis
	$card_id = 0;
	$deck_id = 0;
	$deck_key = '';
	
	try {
		// Procurando a chave do grupo
		$sql = sprintf(" 
                        select a.card_id, b.deck_id, b.deck_key
                          from car_card a, 
                               car_deck b 
                         where a.card_key = '%s'
                           and a.user_id = %d
                           and a.deck_id = b.deck_id
                           and b.user_id = %d",
                        $mysqli->real_escape_string(car_never_null($card_key)),
                        $user_id,
                        $user_id);

		$result = $mysqli->query($sql);
		
		while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
			$card_id = $row['card_id'];
			$deck_id = $row['deck_id'];
			$deck_key = $row['deck_key'];
		}
		
		// Apagando todos as sessões de estudos deste grupo que ainda não foram finalizados
		$sql = sprintf('
                        delete from car_study_session
                         where user_id = %d
                           and stud_id in (
                        select stud_id
                          from car_study
                         where deck_id = %d
                           and user_id = %d)',
                        $user_id,
                        $deck_id,
                        $user_id);

		$result = $mysqli->query($sql);

		if (!$result) { error_log($mysqli->sqlstate . ' - ' . $mysqli->error); throw new Exception('error.db'); }

        // Apagando todos os estudos deste grupo que ainda não foram finalizados
		$sql = sprintf('delete from car_study where deck_id = %d and user_id = %d and stud_end is null',
                        $deck_id,
                        $user_id);
		
		$result = $mysqli->query($sql);
		
		if (!$result) { error_log($mysqli->sqlstate . ' - ' . $mysqli->error); throw new Exception('error.db'); }
		
		// Apagando o cartão
		$sql = sprintf('delete from car_card where card_id = %d and user_id = %d', $card_id, $user_id);
		
		$result = $mysqli->query($sql);
		 
		if (!$result) { error_log($mysqli->sqlstate . ' - ' . $mysqli->error); throw new Exception('error.db'); }
				
		$mysqli->commit();
	} catch(Exception $e) {
		$mysqli->rollback();
		
		car_set_session_error_message($e->getMessage());
	}

	$mysqli->close();
	
	car_redirect(CAR_PATH_WEB . '/dash/card-list?k=' . $deck_key);
?>
