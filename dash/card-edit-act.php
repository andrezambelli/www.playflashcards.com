<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/car-server.php';?>
<?php include_once CAL_ROOT_WEB . '/config.inc';?>
<?php include CAL_ROOT_WEB . '/lang/lang.inc'; ?>
<?php cal_check_login($t); ?>
<?php
	// Parâmetros 
	$user_id = cal_get_session_attribute('user_id', 0);

    $card_key = cal_get_parameter('k', '');
	$card_front = cal_get_parameter('card_front', '');
	$card_back = cal_get_parameter('card_back', '');
    $delete_stats = cal_get_parameter('delete_stats', 'false');
	$fwd = cal_get_parameter('fwd', 'view'); // pode ser "view" ou pode ser "insert-card-action"

    // Variáveis
	$deck_id = 0;
	$deck_key = '';
	
	cal_set_session_attribute('read_database', 'off');
	
	// Verifica os parâmetros
	if (empty($card_front)) cal_set_session_error_message('dash.card-edit-act.front');
	elseif (empty($card_back)) cal_set_session_error_message('dash.card-edit-act.back');
	
	if (!cal_has_session_error_message()) {
		try {
			// Procurando a chave do grupo pela chave do cartão
			$sql = sprintf(" 
                            select b.deck_id, b.deck_key
                              from car_card a, car_deck b
                             where a.card_key = '%s'
                               and a.user_id = %d
                               and a.deck_id = b.deck_id",
                            $mysqli->real_escape_string(cal_never_null($card_key)),
                            $user_id);
				
			$result = $mysqli->query($sql);
				
			while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
				$deck_id = $row['deck_id'];
				$deck_key = $row['deck_key'];
			}

            // Atualizando o cartão
            $sql = sprintf(" 
                            update car_card
                               set card_front = '%s',
                                   card_back = '%s',
                                   card_update = now()
                             where card_key = '%s'
                               and user_id = %d",
                $mysqli->real_escape_string(cal_never_null($card_front)),
                $mysqli->real_escape_string(cal_never_null($card_back)),
                $mysqli->real_escape_string(cal_never_null($card_key)),
                $user_id);

            $result = $mysqli->query($sql);

            if (!$result) throw new Exception($mysqli->sqlstate . ' - ' .$mysqli->error);

            if ($delete_stats == 'true') {
                // Apagando as estatísticas
                $sql = sprintf(" 
                            update car_card
                               set card_true = 0,
                                   card_false = 0,
                                   card_sequence = 0
                             where card_key = '%s'
                               and user_id = %d",
                            $mysqli->real_escape_string(cal_never_null($card_key)),
                            $user_id);

                $result = $mysqli->query($sql);

                if (!$result) throw new Exception($mysqli->sqlstate . ' - ' .$mysqli->error);

                // Apagando todos os estudos deste grupo que ainda não foram finalizados
                $sql = sprintf('
                                delete from car_study_session
                                 where stud_id in (
                                 select stud_id 
                                   from car_study 
                                  where deck_id = %d 
                                    and user_id = %d 
                                    and stud_end is null)',
                                $deck_id,
                                $user_id);

                $result = $mysqli->query($sql);

                if (!$result) throw new Exception($mysqli->sqlstate . ' - ' .$mysqli->error);

                $sql = sprintf('delete from car_study where deck_id = %d and user_id = %d and stud_end is null',
                    $deck_id,
                    $user_id);

                $result = $mysqli->query($sql);

                if (!$result) throw new Exception($mysqli->sqlstate . ' - ' .$mysqli->error);
            }

			$mysqli->commit();
			
			cal_set_session_attribute('read_database', 'on');
		} catch(Exception $e) {
			$mysqli->rollback();
			
			cal_set_session_error_message($e->getMessage());
		}
		
		$mysqli->close();
		
		if ($fwd == 'view') {
			cal_redirect(CAL_PATH_WEB . '/dash/card-list?k=' . $deck_key); // direciona para a view de grupo
		} else {
			cal_redirect(CAL_PATH_WEB . '/dash/card-new-act?k=' . $deck_key); // adiciona um novo card
		}
	} else {
		cal_redirect(CAL_PATH_WEB . '/dash/card-edit?k=' . $card_key); // volta para a view do card
		
		cal_set_session_attribute('card_front', $card_front);
        cal_set_session_attribute('card_back', $card_back);
	}
?>