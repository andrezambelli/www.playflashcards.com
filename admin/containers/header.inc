<?php
    car_check_admin_login();
    $_login  = car_get_session_attribute('session_admin_login', 'off');
    $asset_v = rawurlencode(car_is_production() ? CAR_ADMIN_VERSION : (string) ($_SERVER['REQUEST_TIME'] ?? time()));
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">
    <link rel="shortcut icon" href="<?= CAR_PATH_ADMIN ?>/assets/img/favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="<?= CAR_PATH_WEB ?>/assets/css/bootstrap-5.3.8.min.css">
    <link rel="stylesheet" href="<?= CAR_PATH_WEB ?>/assets/css/bootstrap-icons-1.13.1.min.css">
    <link rel="stylesheet" href="<?= CAR_PATH_ADMIN ?>/assets/css/styles.css?v=<?= $asset_v ?>">
    <title>Play Flashcards Admin</title>
</head>
<body class="bg-light">
<nav class="navbar navbar-dark bg-dark">
    <div class="container-lg">
        <span class="navbar-brand mb-0">
            Play Flashcards Admin
            <small class="text-secondary fs-6 fw-normal ms-2">v<?= CAR_ADMIN_VERSION ?></small>
        </span>
        <div class="d-flex gap-3">
            <?php if (!empty($_login) && $_login != 'off') { ?>
                <?php include_once "menu-on.inc" ?>
            <?php } else { ?>
                <?php include_once "menu-off.inc" ?>
            <?php } ?>
        </div>
    </div>
</nav>
