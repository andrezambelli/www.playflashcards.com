<?php /** @var array $t */ ?>
<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/car-server.php';?>
<?php include_once CAR_ROOT_WEB . '/config.inc';?>
<?php include CAR_ROOT_WEB . '/lang/lang.inc'; ?>
<?php car_check_login($t); ?>
<?php
	// Parâmetros 
	$user_id = car_get_session_attribute('user_id', 0);

    $deck_key = car_get_parameter('k', '');

    // Variáveis
	$deck_id = 0;
    $redirect = CAR_PATH_WEB . '/dash/card-list?k=' . $deck_key;

    try {
        // Procurando informação do grupo
        $sql = sprintf(" select deck_id from car_deck where deck_key = '%s' and user_id = %d",
                                $mysqli->real_escape_string(car_never_null($deck_key)),
                                $user_id);

        $result = $mysqli->query($sql);

        while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
            $deck_id = $row['deck_id'];
        }

        // Apagando todas as sessões desse grupo
        $sql = sprintf('delete from car_study_session where user_id = %d and stud_id in (select stud_id from car_study where deck_id = %d and user_id = %d)', $user_id, $deck_id, $user_id);

        $result = $mysqli->query($sql);

        if (!$result) { error_log($mysqli->sqlstate . ' - ' . $mysqli->error); throw new Exception('error.db'); }

        // Apagando todos os estudos desse grupo
        $sql = sprintf('delete from car_study where deck_id = %d and user_id = %d', $deck_id, $user_id);

        $result = $mysqli->query($sql);

        if (!$result) { error_log($mysqli->sqlstate . ' - ' . $mysqli->error); throw new Exception('error.db'); }

        // Apagando todos os cartões desse estudo
        $sql = sprintf('delete from car_card where deck_id = %d and user_id = %d', $deck_id, $user_id);

        $result = $mysqli->query($sql);

        if (!$result) { error_log($mysqli->sqlstate . ' - ' . $mysqli->error); throw new Exception('error.db'); }

        if (isset($_FILES['input_file']) && $_FILES['input_file']['error'] === UPLOAD_ERR_OK) {
            $file = $_FILES['input_file']['tmp_name'];

            if (($handle = fopen($file, "r")) !== false) {
                while (($line = fgets($handle)) !== false) {
                    $values = str_getcsv($line, ';');

                    $line_import = false;

                    // Verificar se há pelo menos dois valores
                    if (count($values) == 2) {
                        $card_front = trim($values[0]);
                        $card_back = trim($values[1]);

                        if (strlen($card_front) <= 1024 and strlen($card_back) <= 1024) {
                            // Cria a chave do cartão
                            $card_key = null;

                            while ($card_key == null) {
                                $card_key = car_generate_key(12);

                                // A chave do cartão precisa ser única no banco de dados
                                $sql = sprintf(" select count(1) as count from car_card where card_key = '%s'", $mysqli->real_escape_string(car_never_null($card_key)));

                                $result = $mysqli->query($sql);

                                while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
                                    $_count = $row['count'];

                                    if ($_count >= 1) $card_key = null;
                                }
                            }

                            // Inserindo o cartão
                            $sql = sprintf(" 
                                        insert into car_card
                                        (user_id, deck_id, card_front, card_back, card_key)
                                        values (%d, %d, '%s', '%s', '%s')",
                                $user_id,
                                $deck_id,
                                $mysqli->real_escape_string(car_never_null($card_front)),
                                $mysqli->real_escape_string(car_never_null($card_back)),
                                $mysqli->real_escape_string(car_never_null($card_key)));

                            $result = $mysqli->query($sql);

                            if (!$result) { error_log($mysqli->sqlstate . ' - ' . $mysqli->error); throw new Exception('error.db'); }
                        } else {
                            $line_import = true;
                        }
                    }
                }

                fclose($handle);

                $mysqli->commit();

                if ($line_import) {
                    car_set_session_alert_message( 'dash.card.upload-act.success2');
                } else {
                    car_set_session_alert_message('dash.card.upload-act.success1');
                }
            } else {
                car_set_session_error_message('dash.card.upload-act.error1');
            }
        }
    } catch(Exception $e) {
        $mysqli->rollback();

        car_set_session_error_message('dash.card.upload-act.error2');
    }

    $mysqli->close();

    car_redirect($redirect);
