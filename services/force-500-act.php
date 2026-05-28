<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/car-server.php';

http_response_code(500);
readfile(CAR_ROOT_WEB . '/common/error-500.html');
exit;
