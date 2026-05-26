<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/car-server.php';?>
<?php include_once CAR_ROOT_WEB . '/config.inc';?>
<?php
    // Parâmetros
    $user_id = car_get_session_attribute('user_id',CAR_USER_ID_MASTER);

    // Variáveis
    $cook_key = car_generate_key(12);

    // Grava o cookie de 30 dias no navegador
    setcookie('consent_key', $cook_key, time() + (30 * 24 * 60 * 60), '/');

    $sql = sprintf("insert into car_cookie
                        (user_id, cook_key)
                    values (%d, '%s')",
                    $user_id,
                    $mysqli->real_escape_string(car_never_null($cook_key)));

    $mysqli->query($sql);

    $mysqli->commit();
