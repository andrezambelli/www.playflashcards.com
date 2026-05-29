<?php /** @var array $t */ ?>
<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/car-server.php'; ?>
<?php include_once CAR_ROOT_WEB . '/config.inc'; ?>
<?php include CAR_ROOT_WEB . '/lang/lang.inc'; ?>
<?php car_check_login($t); ?>
<?php
    // Parâmetros
    $user_id       = car_get_session_attribute('user_id', 0);
    $user_max_card = car_get_session_attribute('user_max_card', CAR_USER_MAX_CARD);

    $deck_key   = car_get_parameter('k', '');
    $card_front = car_get_parameter('card_front', '');
    $card_back  = car_get_parameter('card_back', '');
    $fwd        = car_get_parameter('fwd', 'list');

    $redirect = CAR_PATH_WEB . '/dash/card-list?k=' . $deck_key;

    // Validação: frente e verso obrigatórios — repopula e volta ao formulário
    if (empty($card_front)) {
        car_set_session_error_message('dash.card-edit-act.front');
        car_set_session_attribute('new_card_front', $card_front);
        car_set_session_attribute('new_card_back', $card_back);
        $redirect = CAR_PATH_WEB . '/dash/card-new?k=' . $deck_key;
    } elseif (empty($card_back)) {
        car_set_session_error_message('dash.card-edit-act.back');
        car_set_session_attribute('new_card_front', $card_front);
        car_set_session_attribute('new_card_back', $card_back);
        $redirect = CAR_PATH_WEB . '/dash/card-new?k=' . $deck_key;
    } else {
        try {
            // Localiza o deck pelo deck_key
            $deck_id = 0;
            $sql = sprintf("select deck_id
                              from car_deck
                             where deck_key = '%s'
                               and user_id = %d",
                            $mysqli->real_escape_string(car_never_null($deck_key)),
                            $user_id);
            $result = $mysqli->query($sql);
            while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
                $deck_id = $row['deck_id'];
            }

            if ($deck_id === 0) {
                include_once CAR_ROOT_WEB . '/common/404.php';
                exit;
            } else {
                // Verifica o limite de cartões do baralho
                $sql = sprintf('select count(*) as count
                                  from car_card
                                 where user_id = %d
                                   and deck_id = %d',
                                $user_id,
                                $deck_id);
                $result = $mysqli->query($sql);
                $user_count_card = 0;
                while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
                    $user_count_card = $row['count'];
                }

                if ($user_count_card >= $user_max_card) {
                    car_set_session_error_message('dash.card-new.act.error');
                } else {
                    // Gera a chave única do cartão
                    $card_key = null;
                    while ($card_key == null) {
                        $card_key = car_generate_card_key();
                        $sql = sprintf("select count(1) as count
                                          from car_card
                                         where card_key = '%s'",
                                        $mysqli->real_escape_string(car_never_null($card_key)));
                        $result = $mysqli->query($sql);
                        while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
                            if ($row['count'] >= 1) $card_key = null;
                        }
                    }

                    // Insere o cartão com os dados reais do formulário
                    $sql = sprintf("insert into car_card
                                        (user_id, deck_id, card_key, card_front, card_back)
                                    values (%d, %d, '%s', '%s', '%s')",
                                    $user_id,
                                    $deck_id,
                                    $mysqli->real_escape_string(car_never_null($card_key)),
                                    $mysqli->real_escape_string(car_never_null($card_front)),
                                    $mysqli->real_escape_string(car_never_null($card_back)));

                    $result = $mysqli->query($sql);
                    if (!$result) { error_log($mysqli->sqlstate . ' - ' . $mysqli->error); throw new Exception('error.db'); }

                    // Invalida sessões de estudo em andamento (baralho foi modificado)
                    $sql = sprintf('delete from car_study_session
                                     where user_id = %d
                                       and stud_id in (
                                           select stud_id
                                             from car_study
                                            where deck_id = %d
                                              and user_id = %d
                                              and stud_end is null
                                       )',
                                    $user_id,
                                    $deck_id,
                                    $user_id);
                    $result = $mysqli->query($sql);
                    if (!$result) { error_log($mysqli->sqlstate . ' - ' . $mysqli->error); throw new Exception('error.db'); }

                    $sql = sprintf('delete from car_study
                                     where deck_id = %d
                                       and user_id = %d
                                       and stud_end is null',
                                    $deck_id,
                                    $user_id);
                    $result = $mysqli->query($sql);
                    if (!$result) { error_log($mysqli->sqlstate . ' - ' . $mysqli->error); throw new Exception('error.db'); }

                    $mysqli->commit();

                    if ($fwd === 'new') {
                        $redirect = CAR_PATH_WEB . '/dash/card-new?k=' . $deck_key;
                    } else {
                        $redirect = CAR_PATH_WEB . '/dash/card-list?k=' . $deck_key;
                    }
                }
            }
        } catch(Exception $e) {
            $mysqli->rollback();
            car_set_session_error_message($e->getMessage());
        }
    }

    $mysqli->close();

    car_redirect($redirect);
?>
