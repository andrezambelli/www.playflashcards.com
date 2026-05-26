<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/car-server.php';?>
<?php include_once CAR_ROOT_WEB . '/config.inc';?>
<?php
    $timezone = car_get_parameter('timezone', '+00:00');

    if (!preg_match('/^[+-]\d{2}:\d{2}$/', $timezone)) {
        $timezone = '+00:00';
    }

    car_set_session_attribute('timezone', $timezone);

    $sql = sprintf("set time_zone = '%s'", $mysqli->real_escape_string($timezone));

    $mysqli->query($sql);

    $mysqli->commit();
