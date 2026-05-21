<?php /** @var array $t */ ?>
<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/car-server.php'; ?>
<?php include_once CAL_ROOT_WEB . '/config.inc'; ?>
<?php include CAL_ROOT_WEB . '/lang/lang.inc'; ?>
<?php cal_check_login($t); ?>
<?php
	// Parâmetros
	$user_id = cal_get_session_attribute('user_id', 0);
	$user_max_card = cal_get_session_attribute('user_max_card', CAL_USER_MAX_CARD);

    $deck_key = cal_get_parameter('k', '');

    // Variáveis
	$user_count_card = 0;
	$deck_id = 0;
	
	$redirect = CAL_PATH_WEB . '/dash/card-list?k=' . $deck_key;
	
	try {
		// Procurando o identificar do grupo
		$sql = sprintf(" select deck_id from car_deck where deck_key = '%s' and user_id = %d",
                        $mysqli->real_escape_string(cal_never_null($deck_key)),
                        $user_id);
		
		$result = $mysqli->query($sql);
		
		while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
			$deck_id = $row['deck_id'];
		}
		
		// Antes de criar, contar a quantidade de grupos deste usuário
		$sql = sprintf(' select count(*) as count from car_card where user_id = %d and deck_id = %d', $user_id, $deck_id);
		
		$result = $mysqli->query($sql);
		
		while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
			$user_count_card = $row['count'];
		}
		
		if ($user_count_card < $user_max_card) {
			// Apaga todos os cartões em branco do usuarios
			$_sql = sprintf(" delete from car_card where deck_id = %d and user_id = %d and (card_front is null or trim(card_front) = '' or card_back is null or trim(card_back) = '');", $deck_id, $user_id);
			
			$_result = $mysqli->query($_sql);
			
			if (!$_result) throw new Exception($mysqli->sqlstate . ' - ' .$mysqli->error);
			
			// Cria a chave do cartão
			$card_key = null;
			
			while ($card_key == null) {
				$card_key = cal_generate_key(12);
				
				// A chave do cartão precisa ser única no banco de dados
				$sql = sprintf(" select count(1) as count from car_card where card_key = '%s'", $mysqli->real_escape_string(cal_never_null($card_key)));
				
				$result = $mysqli->query($sql);
				
				while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
					$_count = $row['count'];
					
					if ($_count >= 1) $card_key = null;
				}
			}
			
			// Inserindo o cartão
			$sql = sprintf(" 
                            insert into car_card
                            (user_id, deck_id, card_key)
                            values (%d, %d, '%s')",
                            $user_id,
                            $deck_id,
                            $mysqli->real_escape_string(cal_never_null($card_key)));
			
			$result = $mysqli->query($sql);
			
			if (!$result) throw new Exception($mysqli->sqlstate . ' - ' .$mysqli->error);
			
			// Apagando todos as sessões de estudo deste grupo que ainda não foram finalizados
			$sql = sprintf('
                            delete from car_study_session
                             where stud_id in 
                            (select stud_id
                               from car_study
                              where deck_id = %d
                                and user_id = %d
                                and stud_end is null)',
                            $deck_id,
                            $user_id);
			
			$result = $mysqli->query($sql);
			
			if (!$result) throw new Exception($mysqli->sqlstate . ' - ' .$mysqli->error);

            // Apagando todos os estudos deste grupo que ainda não foram finalizados
			$sql = sprintf('delete from car_study where deck_id = %d and user_id = %d and stud_end is null',
                            $deck_id,
                            $user_id);
			
			$result = $mysqli->query($sql);
			
			if (!$result) throw new Exception($mysqli->sqlstate . ' - ' .$mysqli->error);
			
			$mysqli->commit();

			$redirect = CAL_PATH_WEB . '/dash/card-edit?k=' . $card_key;
		} else {
			cal_set_session_error_message('dash.card-new.act.error');

			$redirect = CAL_PATH_WEB . '/dash/card-list?k=' . $deck_key;
		}
	} catch(Exception $e) {
		$mysqli->rollback();
		
		cal_set_session_error_message($e->getMessage());
	}

	$mysqli->close();
	
	cal_redirect($redirect);
?>