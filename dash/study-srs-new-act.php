<?php /** @var array $t */ ?>
<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/car-server.php'; ?>
<?php include_once CAR_ROOT_WEB . '/config.inc'; ?>
<?php include CAR_ROOT_WEB . '/lang/lang.inc'; ?>
<?php car_check_login($t); ?>
<?php
	// Parâmetros
	$user_id = car_get_session_attribute('user_id', 0);
    $user_max_study = car_get_session_attribute('user_max_study', CAR_USER_MAX_STUDY);

    $deck_key = car_get_parameter('k', '');

    // Variáveis
	$user_count_study = 0;
	$deck_id = 0;

    $srs_limit = CAR_USER_SRS_LIMIT;
    $srs_sequence = CAR_USER_SRS_SEQUENCE;
    $srs_rate = CAR_USER_SRS_RATE;
    $srs_days = CAR_USER_SRS_DAYS;

	$redirect = CAR_PATH_WEB . '/dash/study-list?k=' . $deck_key;
	
	try {
        // Procurando informações do usuário
        $sql = sprintf("select user_srs_limit, user_srs_rate, user_srs_sequence, user_srs_days from car_user where user_id = %d", $user_id);

        $result = $mysqli->query($sql);

        while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
            $srs_limit = $row['user_srs_limit'];
            $srs_sequence = $row['user_srs_sequence'];
            $srs_rate = $row['user_srs_rate'];
            $srs_days = $row['user_srs_days'];
        }

		// Procurando o identificador do grupo
		$sql = sprintf(" select deck_id from car_deck where deck_key = '%s' and user_id = %d",
                        $mysqli->real_escape_string(car_never_null($deck_key)),
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
			
			if (!$_result) { error_log($mysqli->sqlstate . ' - ' . $mysqli->error); throw new Exception('error.db'); }
			
			// Cria a chave do estudo
			$stud_key = null;
			
			while ($stud_key == null) {
				$stud_key = car_generate_key(12);
				
				// A chave do estudo precisa ser única no banco de dados
				$sql = sprintf(" select count(1) as count from car_study where stud_key = '%s'", $mysqli->real_escape_string(car_never_null($stud_key)));
				
				$result = $mysqli->query($sql);
				
				while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
					$_count = $row['count'];
					
					if ($_count >= 1) $stud_key = null;
				}
			}
			
			// Procurando o total de cartões deste grupo
			$stud_total = 0;
			$sql = sprintf('
                            select count(1) as count 
                              from car_card 
                             where deck_id = %d 
                               and user_id = %d
                               and (card_rate < %d or card_sequence < %d or card_last_study < DATE_SUB(NOW(), INTERVAL %d DAY))',
                $deck_id,
                $user_id,
                $srs_rate,
                $srs_sequence,
                $srs_days
            );
			
			$result = $mysqli->query($sql);
			
			while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
				$stud_total = $row['count'];
			}

            // Se o total de cartões para estudar for maior que o limite, o total será igual ao limite
            if ($stud_total > $srs_limit) $stud_total = $srs_limit;

			if ($stud_total > 0) {
				// Inserindo o estudo
				$sql = sprintf(" 
                                insert into car_study
                                (user_id, deck_id, stud_key, stud_total)
                                values (%d, %d, '%s', %d)",
                                $user_id,
                                $deck_id,
                                $mysqli->real_escape_string(car_never_null($stud_key)),
                                $stud_total);
				
				$result = $mysqli->query($sql);
				
				$stud_id = car_last_insert_id($mysqli);
				
				if (!$result) { error_log($mysqli->sqlstate . ' - ' . $mysqli->error); throw new Exception('error.db'); }
				
				// Inserindo os cartões na sessão do estudo
				$sql = sprintf('
                                insert into car_study_session
                                (stse_order, user_id, stud_id, card_id)
                                select row_number() over (order by RAND()) as stse_order, %d, %d, card_id
                                  from car_card
                                 where deck_id = %d
                                   and (card_rate < %d or card_sequence < %d or card_last_study < DATE_SUB(NOW(), INTERVAL %d DAY))
                                 limit %d',
                                $user_id,
                                $stud_id,
                                $deck_id,
                                $srs_rate,
                                $srs_sequence,
                                $srs_days,
                                $srs_limit);
				
				$result = $mysqli->query($sql);
				
				if (!$result) { error_log($mysqli->sqlstate . ' - ' . $mysqli->error); throw new Exception('error.db'); }
				
				$mysqli->commit();

				$redirect = CAR_PATH_WEB . '/dash/study?k=' . $stud_key;
			} else {
                // Não existem cartões para estudar no modo SRS
                car_set_session_alert_message('dash.study-srs-new-act.error1');
				
				$redirect = CAR_PATH_WEB . '/dash/deck?k=' . $deck_key;
			}
		} else {
			car_set_session_error_message('dash.study-srs-new-act.error2');
			
			$redirect = CAR_PATH_WEB . '/dash/study-list?k=' . $deck_key;
		}
	} catch(Exception $e) {
		$mysqli->rollback();
		
		car_set_session_error_message($e->getMessage());
		
		$redirect = CAR_PATH_WEB . '/dash/study-list?k=' . $deck_key;
	}

	$mysqli->close();
	
	car_redirect($redirect);
?>