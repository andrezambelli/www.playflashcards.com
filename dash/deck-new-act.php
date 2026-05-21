<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/car-server.php';?>
<?php include_once CAL_ROOT_WEB . '/config.inc';?>
<?php include CAL_ROOT_WEB . '/lang/lang.inc'; ?>
<?php cal_check_login($t); ?>
<?php
    // Parâmetros
    $user_id = cal_get_session_attribute('user_id', 0);
    $user_max_deck = cal_get_session_attribute('user_max_deck', CAL_USER_MAX_DECK);

    // Variáveis
    $deck_bgcolor = CAL_DECK_BGCOLOR_DEFAULT;
    
    $user_count_deck = 0;

    $redirect = CAL_PATH_WEB . '/dash/deck-list';

    try {
        // Antes de criar, contar a quantidade de grupos deste usuário
        $sql = sprintf('select count(*) as count from car_deck where user_id = %d', $user_id);

        $result = $mysqli->query($sql);

        while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
            $user_count_deck = $row['count'];
        }

        // Cria a chave do grupo
        $deck_key = null;

        if ($user_count_deck < $user_max_deck) {
            while ($deck_key == null) {
                $deck_key = cal_generate_key(12);

                // A chave do grupo precisa ser única no banco de dados
                $sql = sprintf(" select count(1) as count from car_deck where deck_key = '%s'", $mysqli->real_escape_string(cal_never_null($deck_key)));

                $result = $mysqli->query($sql);

                while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
                    $_count = $row['count'];

                    if ($_count >= 1) $deck_key = null;
                }
            }

            // Inserindo o grupo
            $sql = sprintf(" insert into car_deck
                                    (user_id, deck_name, deck_key, deck_bgcolor)
                                   values (%d, '%s', '%s', '%s')",
                            $user_id,
                            $mysqli->real_escape_string(cal_never_null(CAL_DECK_NAME_DEFAULT)),
                            $mysqli->real_escape_string(cal_never_null($deck_key)),
                            $mysqli->real_escape_string(cal_never_null($deck_bgcolor)));

            $result = $mysqli->query($sql);

            if (!$result) throw new Exception($mysqli->sqlstate . ' - ' .$mysqli->error);

            $mysqli->commit();

            $redirect = CAL_PATH_WEB . '/dash/deck-edit?k=' . $deck_key;
        } else {
            cal_set_session_error_message('Você não tem permissão para incluir mais um grupo.');

            $redirect = CAL_PATH_WEB . '/dash/deck-list';
        }
    } catch(Exception $e) {
        $mysqli->rollback();

        cal_set_session_error_message($e->getMessage());

        $redirect = CAL_PATH_WEB . '/dash/deck-list';
    }

    $mysqli->close();

    cal_redirect($redirect);
?>