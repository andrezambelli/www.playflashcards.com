<?php /** @var array $t */ ?>
<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/car-server.php';?>
<?php include_once CAR_ROOT_WEB . '/config.inc';?>
<?php include CAR_ROOT_WEB . '/lang/lang.inc'; ?>
<?php car_check_login($t); ?>
<?php
    // Parâmetros
    $user_id = car_get_session_attribute('user_id', 0);
    $user_max_deck = car_get_session_attribute('user_max_deck', CAR_USER_MAX_DECK);

    // Variáveis
    $deck_bgcolor = CAR_DECK_BGCOLOR_DEFAULT;
    
    $user_count_deck = 0;

    $redirect = CAR_PATH_WEB . '/dash/deck-list';

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
                $deck_key = car_generate_key(12);

                // A chave do grupo precisa ser única no banco de dados
                $sql = sprintf(" select count(1) as count from car_deck where deck_key = '%s'", $mysqli->real_escape_string(car_never_null($deck_key)));

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
                            $mysqli->real_escape_string(car_never_null(CAR_DECK_NAME_DEFAULT)),
                            $mysqli->real_escape_string(car_never_null($deck_key)),
                            $mysqli->real_escape_string(car_never_null($deck_bgcolor)));

            $result = $mysqli->query($sql);

            if (!$result) { error_log($mysqli->sqlstate . ' - ' . $mysqli->error); throw new Exception('error.db'); }

            $mysqli->commit();

            $redirect = CAR_PATH_WEB . '/dash/deck-edit?k=' . $deck_key;
        } else {
            car_set_session_error_message('dash.deck-new-act.error');

            $redirect = CAR_PATH_WEB . '/dash/deck-list';
        }
    } catch(Exception $e) {
        $mysqli->rollback();

        car_set_session_error_message($e->getMessage());

        $redirect = CAR_PATH_WEB . '/dash/deck-list';
    }

    $mysqli->close();

    car_redirect($redirect);
?>