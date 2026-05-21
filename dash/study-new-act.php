<?php /** @var array $t */ ?>
<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/car-server.php'; ?>
<?php include_once CAL_ROOT_WEB . '/config.inc'; ?>
<?php include CAL_ROOT_WEB . '/lang/lang.inc'; ?>
<?php cal_check_login($t); ?>
<?php
	// Parâmetros
	$user_id = cal_get_session_attribute('user_id', 0);
    $user_max_study = cal_get_session_attribute('user_max_study', CAL_USER_MAX_STUDY);

    $deck_key = cal_get_parameter('k', '');

    // Variáveis
	$user_count_study = 0;
	$deck_id = 0;
	
	$redirect = CAL_PATH_WEB . '/dash/study-list?k=' . $deck_key;
	
	try {
		// Procurando o identificador do grupo
		$sql = sprintf(" select deck_id from car_deck where deck_key = '%s' and user_id = %d",
                        $mysqli->real_escape_string(cal_never_null($deck_key)),
                        $user_id);
		
		$result = $mysqli->query($sql);
		
		while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
			$deck_id = $row['deck_id'];
		}
		
		// Antes de criar, contar a quantidade de estudos pendentes desde usuario e grupo
		$sql = sprintf(' select count(*) as count from car_study where user_id = %d and deck_id = %d and stud_end is null', $user_id, $deck_id);
		
		$result = $mysqli->query($sql);
		
		while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
			$user_count_study = $row['count'];
		}
		
		if ($user_count_study < $user_max_study) {
			// Apaga todos os cards em branco do usuarios
			$_sql = sprintf(" delete from car_card where deck_id = %d and (card_front is null or trim(card_front) = '' or card_back is null or trim(card_back) = '');", $deck_id);
			
			$_result = $mysqli->query($_sql);
			
			if (!$_result) throw new Exception($mysqli->sqlstate . ' - ' .$mysqli->error);
			
			// Cria a chave do estudo
			$stud_key = null;
			
			while ($stud_key == null) {
				$stud_key = cal_generate_key(12);
				
				// A chave do estudo precisa ser única no banco de dados
				$sql = sprintf(" select count(1) as count from car_study where stud_key = '%s'", $mysqli->real_escape_string(cal_never_null($stud_key)));
				
				$result = $mysqli->query($sql);
				
				while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
					$_count = $row['count'];
					
					if ($_count >= 1) $stud_key = null;
				}
			}
			
			// Procurando o total de cartões deste grupo
			$stud_total = 0;
			$sql = sprintf('select count(1) as count from car_card where deck_id = %d and user_id = %d', $deck_id, $user_id);
			
			$result = $mysqli->query($sql);
			
			while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
				$stud_total = $row['count'];
			}
			
			if ($stud_total > 0) {
				// Inserindo o estudo
				$sql = sprintf(" 
                                insert into car_study
                                (user_id, deck_id, stud_key, stud_total)
                                values (%d, %d, '%s', %d)",
                                $user_id,
                                $deck_id,
                                $mysqli->real_escape_string(cal_never_null($stud_key)),
                                $stud_total);
				
				$result = $mysqli->query($sql);
				
				$stud_id = cal_last_insert_id($mysqli);
				
				if (!$result) throw new Exception($mysqli->sqlstate . ' - ' .$mysqli->error);
				
				// Inserindo os cartões na sessão do estudo
				$sql = sprintf('
                                insert into car_study_session
                                (stse_order, user_id, stud_id, card_id)
                                select row_number() over (order by RAND()) as stse_order, %d, %d, card_id
                                  from car_card
                                 where deck_id = %d',
                                $user_id,
                                $stud_id,
                                $deck_id);
				
				$result = $mysqli->query($sql);
				
				if (!$result) throw new Exception($mysqli->sqlstate . ' - ' .$mysqli->error);
				
				$mysqli->commit();

				$redirect = CAL_PATH_WEB . '/dash/study?k=' . $stud_key;
			} else {
				cal_set_session_error_message('The deck has no flashcards.');
				
				$redirect = CAL_PATH_WEB . '/dash/study-list?k=' . $deck_key;
			}
		} else {
			cal_set_session_error_message('dash.study-new-act.error1');
			
			$redirect = CAL_PATH_WEB . '/dash/study-list?k=' . $deck_key;
		}
	} catch(Exception $e) {
		$mysqli->rollback();
		
		cal_set_session_error_message($e->getMessage());
		
		$redirect = CAL_PATH_WEB . '/dash/study-list?k=' . $deck_key;
	}

	$mysqli->close();
	
	cal_redirect($redirect);
?>