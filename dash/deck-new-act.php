<?php /** @var array $t */ ?>
<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/car-server.php';?>
<?php include_once CAR_ROOT_WEB . '/config.inc';?>
<?php include CAR_ROOT_WEB . '/lang/lang.inc'; ?>
<?php car_check_login($t); ?>
<?php
    // Parâmetros
    $user_id       = car_get_session_attribute('user_id', 0);
    $user_max_deck = car_get_session_attribute('user_max_deck', CAR_USER_MAX_DECK);

    $deck_name    = car_get_parameter('deck_name', '');
    $deck_desc    = car_get_parameter('deck_desc', '');
    $deck_bgcolor = car_get_parameter('deck_bgcolor', CAR_DECK_BGCOLOR_DEFAULT);
    $deck_public  = car_get_parameter('deck_public', 0);
    $deck_lang    = car_get_parameter('deck_lang', 'en');

    $redirect = CAR_PATH_WEB . '/dash/deck-list';

    // Validação: nome obrigatório — repopula e volta ao formulário
    if (empty($deck_name)) {
        car_set_session_error_message('dash.deck-edit-act.name');
        car_set_session_attribute('new_deck_name', $deck_name);
        car_set_session_attribute('new_deck_desc', $deck_desc);
        car_set_session_attribute('new_deck_bgcolor', $deck_bgcolor);
        car_set_session_attribute('new_deck_public', $deck_public);
        car_set_session_attribute('new_deck_lang', $deck_lang);
        $redirect = CAR_PATH_WEB . '/dash/deck-new';
    } else {
        try {
            // Verifica o limite de grupos do usuário
            $sql = sprintf('select count(*) as count
                              from car_deck
                             where user_id = %d',
                            $user_id);
            $result = $mysqli->query($sql);
            $user_count_deck = 0;
            while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
                $user_count_deck = $row['count'];
            }

            if ($user_count_deck >= $user_max_deck) {
                car_set_session_error_message('dash.deck-new-act.error');
            } else {
                // Gera a chave única do grupo
                $deck_key = null;
                while ($deck_key == null) {
                    $deck_key = car_generate_deck_key();
                    $sql = sprintf("select count(1) as count
                                      from car_deck
                                     where deck_key = '%s'",
                                    $mysqli->real_escape_string(car_never_null($deck_key)));
                    $result = $mysqli->query($sql);
                    while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
                        if ($row['count'] >= 1) $deck_key = null;
                    }
                }

                $deck_url = car_text_to_url($deck_name);

                // Insere o grupo com os dados reais do formulário
                $sql = sprintf("insert into car_deck
                                    (user_id, deck_name, deck_desc, deck_key, deck_url, deck_bgcolor, deck_public, deck_lang)
                                values (%d, '%s', '%s', '%s', '%s', '%s', %d, '%s')",
                                $user_id,
                                $mysqli->real_escape_string(car_never_null($deck_name)),
                                $mysqli->real_escape_string(car_never_null($deck_desc)),
                                $mysqli->real_escape_string(car_never_null($deck_key)),
                                $mysqli->real_escape_string(car_never_null($deck_url)),
                                $mysqli->real_escape_string(car_never_null($deck_bgcolor)),
                                $deck_public,
                                $mysqli->real_escape_string(car_never_null($deck_lang)));

                $result = $mysqli->query($sql);

                if (!$result) { error_log($mysqli->sqlstate . ' - ' . $mysqli->error); throw new Exception('error.db'); }

                $mysqli->commit();

                $redirect = CAR_PATH_WEB . '/dash/deck?k=' . $deck_key;
            }
        } catch(Exception $e) {
            $mysqli->rollback();
            car_set_session_error_message($e->getMessage());
        }
    }

    $mysqli->close();

    car_redirect($redirect);
?>
