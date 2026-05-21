<?php /** @var array $t */ ?>
<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/car-server.php';?>
<?php include_once CAR_ROOT_WEB . '/config.inc';?>
<?php include CAR_ROOT_WEB . '/lang/lang.inc'; ?>
<?php car_check_login($t); ?>
<?php
	// Parâmetros 
	$user_id = car_get_session_attribute('user_id', 0);

    $deck_key = car_get_parameter('k', '');
	$deck_name = car_get_parameter('deck_name', '');
	$deck_desc = car_get_parameter('deck_desc', '');
    $deck_bgcolor = car_get_parameter('deck_bgcolor', CAR_DECK_BGCOLOR_DEFAULT);
    $deck_public = car_get_parameter('deck_public', 0);

	car_set_session_attribute('read_database', 'off');
	
	// Verifica os parâmetros
	if (empty($deck_name)) car_set_session_error_message('dash.deck-edit-act.name');

	if (!car_has_session_error_message()) {
		try {
            $dech_url = car_text_to_url($deck_name);

			// Atualizando o grupo
			$sql = sprintf(" 
                            update car_deck
                            set deck_name = '%s',
                                deck_desc = '%s',
                                deck_url = '%s',
                                deck_bgcolor = '%s',
                                deck_public = %d,
                                deck_update = now()
                            where deck_key = '%s'
                              and user_id = %d",
                            $mysqli->real_escape_string(car_never_null($deck_name)),
                            $mysqli->real_escape_string(car_never_null($deck_desc)),
                            $mysqli->real_escape_string(car_never_null($dech_url)),
                            $mysqli->real_escape_string(car_never_null($deck_bgcolor)),
                            $mysqli->real_escape_string($deck_public),
                            $mysqli->real_escape_string(car_never_null($deck_key)),
                            $user_id);
	
			$result = $mysqli->query($sql);
		               
			if (!$result) { error_log($mysqli->sqlstate . ' - ' . $mysqli->error); throw new Exception('error.db'); }
						
			$mysqli->commit();
			
			car_set_session_attribute('read_database', 'on');
		} catch(Exception $e) {
			$mysqli->rollback();
			
			car_set_session_error_message($e->getMessage());
		}
		
		$mysqli->close();
	
		car_redirect(CAR_PATH_WEB . '/dash/deck?k=' . $deck_key);
	} else {
		car_set_session_attribute('deck_name', $deck_name);
        car_set_session_attribute('deck_desc', $deck_desc);
        car_set_session_attribute('deck_bgcolor', $deck_bgcolor);
        car_set_session_attribute('deck_public', $deck_public);

		car_redirect(CAR_PATH_WEB . '/dash/deck-edit?k=' . $deck_key);
	}
?>