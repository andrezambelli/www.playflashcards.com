<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/car-server.php';?>
<?php include_once CAL_ROOT_WEB . '/config.inc' ?>
<?php
	cal_set_session_attribute('session_login', 'on'); // logado!
    $user_email = CAL_USER_EMAIL_MASTER;
    include_once CAL_ROOT_WEB . '/login/user-insert-act.inc';
	cal_redirect(CAL_PATH_WEB . '/dash/deck-list');
?>