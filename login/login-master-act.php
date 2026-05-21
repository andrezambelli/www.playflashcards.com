<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/car-server.php';?>
<?php include_once CAR_ROOT_WEB . '/config.inc' ?>
<?php
	car_set_session_attribute('session_login', 'on'); // logado!
    $user_email = CAR_USER_EMAIL_MASTER;
    include_once CAR_ROOT_WEB . '/login/user-insert-act.inc';
	car_redirect(CAR_PATH_WEB . '/dash/deck-list');
?>