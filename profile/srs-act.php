<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/car-server.php';?>
<?php include_once CAL_ROOT_WEB . '/config.inc';?>
<?php include CAL_ROOT_WEB . '/lang/lang.inc'; ?>
<?php cal_check_login($t); ?>
<?php
    // Parâmetros
    $user_id = cal_get_session_attribute('user_id', 0);

    $srs_limit = cal_get_parameter('srs_limit', 0);
    $srs_rate = cal_get_parameter('srs_rate', 0);
    $srs_sequence = cal_get_parameter('srs_sequence', 0);
    $srs_days = cal_get_parameter('srs_days', 0);

    cal_set_session_attribute('read_database', 'off');

    // Verifica os parâmetros
    if (!is_numeric($srs_limit) or $srs_limit < 1 or $srs_limit > 999) cal_set_session_error_message('profile.srs-act.card_study_value');
    elseif (!is_numeric($srs_rate) or $srs_rate < 1 or $srs_rate > 100) cal_set_session_error_message('profile.srs-act.rate_value');
    elseif (!is_numeric($srs_sequence) or $srs_sequence < 0 or $srs_sequence > 999) cal_set_session_error_message('profile.srs-act.sequence_value');
    elseif (!is_numeric($srs_days) or $srs_days < 0 or $srs_days > 999) cal_set_session_error_message('profile.srs-act.days_value');

    if (!cal_has_session_error_message()) {
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

            if (!$result) throw new Exception($mysqli->sqlstate . ' - ' .$mysqli->error);

            $mysqli->commit();

            cal_set_session_alert_message('profile.srs-act.success');

            cal_set_session_attribute('read_database', 'on');
        } catch(Exception $e) {
            $mysqli->rollback();

            cal_set_session_error_message($e->getMessage());
        }

        $mysqli->close();

        cal_redirect(CAL_PATH_WEB . '/profile/srs');
    } else {
        cal_set_session_attribute('srs_limit', $srs_limit);
        cal_set_session_attribute('srs_rate', $srs_rate);
        cal_set_session_attribute('srs_sequence', $srs_sequence);
        cal_set_session_attribute('srs_days', $srs_days);

        cal_redirect(CAL_PATH_WEB . '/profile/srs');
    }
?>