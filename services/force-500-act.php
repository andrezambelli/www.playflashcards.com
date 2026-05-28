<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/car-server.php';
include_once CAR_ROOT_WEB . '/config.inc';

// disponível apenas fora de produção
if (car_is_production()) {
    header('Location: ' . CAR_PATH_WEB . '/');
    exit;
}

http_response_code(500);
readfile(CAR_ROOT_WEB . '/common/error-500.html');
exit;
