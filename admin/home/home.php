<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/car-server.php';?>
<?php include_once CAL_ROOT_ADMIN . '/config.inc' ?>
<?php
    $total_users = 0;
    $total_decks = 0;
    $total_studies = 0;
    $total_studies_sessions_public = 0;
    $total_studies_sessions_private = 0;
    $total_sessions = 0;
    $total_cookies = 0;

    // Número de usuários
    $sql = "select count(*) as count from car_user";

    $result = $mysqli->query($sql, MYSQLI_STORE_RESULT);

    while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
        $total_users = $row['count'];
    }

    // Número de grupos
    $sql = "select count(*) as count from car_deck";

    $result = $mysqli->query($sql, MYSQLI_STORE_RESULT);

    while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
        $total_decks = $row['count'];
    }

    // Número de estudos
    $sql = "select count(*) as count from car_study";

    $result = $mysqli->query($sql, MYSQLI_STORE_RESULT);

    while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
        $total_studies = $row['count'];
    }

    // Número de sessões de estudo privado
    $sql = "select count(*) as count from car_study where stud_public = 0";

    $result = $mysqli->query($sql, MYSQLI_STORE_RESULT);

    while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
        $total_studies_sessions_private = $row['count'];
    }

    // Número de sessões de estudo público
    $sql = "select count(*) as count from car_study where stud_public = 1";

    $result = $mysqli->query($sql, MYSQLI_STORE_RESULT);

    while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
        $total_studies_sessions_public = $row['count'];
    }

    // Número de sessões
    $sql = "select count(*) as count from car_session";

    $result = $mysqli->query($sql, MYSQLI_STORE_RESULT);

    while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
        $total_sessions = $row['count'];
    }

    // Número de cookies
    $sql = "select count(*) as count from car_cookie";

    $result = $mysqli->query($sql, MYSQLI_STORE_RESULT);

    while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
        $total_cookies = $row['count'];
    }
?>
<?php include_once CAL_ROOT_ADMIN . '/include/header.inc' ?>
<div class="master">
	<div class="subtitle"><div>Home</div></div>
    <div class="form">
        <strong>Usuários</strong><br/>
        <?= $total_users; ?><br/>
        <br/>
        <strong>Grupos</strong><br/>
        <?= $total_decks; ?><br/>
        <br/>
        <strong>Estudos</strong><br/>
        <?= $total_studies; ?><br/>
        <br/>
        <strong>Sessões de Estudo Privados</strong><br/>
        <?= $total_studies_sessions_private; ?><br/>
        <br/>
        <strong>Sessões de Estudo Públicos</strong><br/>
        <?= $total_studies_sessions_public; ?><br/>
        <br/>
        <strong>Sessões</strong><br/>
        <?= $total_sessions; ?><br/>
        <br/>
        <strong>Cookies</strong><br/>
        <?= $total_cookies; ?><br/>
        <br/>
    </div>
</div>
<?php include_once "../include/footer.inc" ?>
