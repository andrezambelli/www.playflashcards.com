<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/car-server.php';?>
<?php include_once CAR_ROOT_WEB . '/config.inc';?>
<?php
    // Guarda o timezone +03:00 na sessão
    $timezone = car_get_parameter('timezone', '00:00');

    car_set_session_attribute('timezone', $timezone);

    $sql = sprintf("SET time_zone = '%s'", $timezone);

    $mysqli->query($sql);

    $mysqli->commit;

