<?php
    // Parâmetros
    $user_id = cal_get_session_attribute('user_id',CAL_USER_ID_MASTER);

    if ($user_id != CAL_USER_ID_MASTER) {
        $sql = sprintf(' update car_user set user_last_access = now() where user_id = %d', $user_id);

        $mysqli->query($sql);

        $mysqli->commit();
    }
