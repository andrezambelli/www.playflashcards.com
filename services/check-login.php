<?php
    include_once $_SERVER['DOCUMENT_ROOT'] . '/car-server.php';
    include_once CAR_ROOT_WEB . '/config.inc';

    header('Content-Type: application/json');
    header('Cache-Control: no-store, no-cache');

    echo json_encode(['logged_in' => car_get_session_attribute('session_login', 'off') === 'on']);
