<?php /** @var array $t */ ?>
<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/car-server.php';?>
<?php include_once CAR_ROOT_WEB . '/config.inc';?>
<?php include CAR_ROOT_WEB . '/lang/lang.inc'; ?>
<?php car_check_login($t); ?>
<?php
    // Parâmetros
    $user_id = car_get_session_attribute('user_id', 0);

    $srs_limit = car_get_parameter('srs_limit', 0);
    $srs_rate = car_get_parameter('srs_rate', 0);
    $srs_sequence = car_get_parameter('srs_sequence', 0);
    $srs_days = car_get_parameter('srs_days', 0);

    car_set_session_attribute('read_database', 'off');

    // Verifica os parâmetros
    if (!is_numeric($srs_limit) or $srs_limit < 1 or $srs_limit > 999) car_set_session_error_message('profile.srs-act.card_study_value');
    elseif (!is_numeric($srs_rate) or $srs_rate < 1 or $srs_rate > 100) car_set_session_error_message('profile.srs-act.rate_value');
    elseif (!is_numeric($srs_sequence) or $srs_sequence < 0 or $srs_sequence > 999) car_set_session_error_message('profile.srs-act.sequence_value');
    elseif (!is_numeric($srs_days) or $srs_days < 0 or $srs_days > 999) car_set_session_error_message('profile.srs-act.days_value');

    if (!car_has_session_error_message()) {
        try {
            // Atualizando as informações na tabela do usuário
            $sql = sprintf(' 
                                update car_user
                                   set user_srs_limit = %d,
                                       user_srs_rate = %d,
                                       user_srs_sequence = %d,
                                       user_srs_days = %d,
                                       user_update = now() 
                                 where user_id = %d',
                                $srs_limit,
                                $srs_rate,
                                $srs_sequence,
                                $srs_days,
                                $user_id);

            $result = $mysqli->query($sql);

            if (!$result) error_log($mysqli->sqlstate . ' - ' . $mysqli->error); throw new Exception('error.db');

            $mysqli->commit();

            car_set_session_alert_message('profile.srs-act.success');

            car_set_session_attribute('read_database', 'on');
        } catch(Exception $e) {
            $mysqli->rollback();

            car_set_session_error_message($e->getMessage());
        }

        $mysqli->close();

        car_redirect(CAR_PATH_WEB . '/profile/srs');
    } else {
        car_set_session_attribute('srs_limit', $srs_limit);
        car_set_session_attribute('srs_rate', $srs_rate);
        car_set_session_attribute('srs_sequence', $srs_sequence);
        car_set_session_attribute('srs_days', $srs_days);

        car_redirect(CAR_PATH_WEB . '/profile/srs');
    }
?>