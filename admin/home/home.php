<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/car-server.php';?>
<?php include_once CAR_ROOT_ADMIN . '/config.inc' ?>
<?php
    $total_users = 0;
    $total_decks = 0;
    $total_studies = 0;
    $total_studies_sessions_public = 0;
    $total_studies_sessions_private = 0;
    $total_sessions = 0;
    $total_cookies = 0;

    $sql = 'select count(*) as count from car_user';
    $result = $mysqli->query($sql, MYSQLI_STORE_RESULT);
    while ($row = $result->fetch_array(MYSQLI_ASSOC)) { $total_users = $row['count']; }

    $sql = 'select count(*) as count from car_deck';
    $result = $mysqli->query($sql, MYSQLI_STORE_RESULT);
    while ($row = $result->fetch_array(MYSQLI_ASSOC)) { $total_decks = $row['count']; }

    $sql = 'select count(*) as count from car_study';
    $result = $mysqli->query($sql, MYSQLI_STORE_RESULT);
    while ($row = $result->fetch_array(MYSQLI_ASSOC)) { $total_studies = $row['count']; }

    $sql = 'select count(*) as count from car_study where stud_public = 0';
    $result = $mysqli->query($sql, MYSQLI_STORE_RESULT);
    while ($row = $result->fetch_array(MYSQLI_ASSOC)) { $total_studies_sessions_private = $row['count']; }

    $sql = 'select count(*) as count from car_study where stud_public = 1';
    $result = $mysqli->query($sql, MYSQLI_STORE_RESULT);
    while ($row = $result->fetch_array(MYSQLI_ASSOC)) { $total_studies_sessions_public = $row['count']; }

    $sql = 'select count(*) as count from car_session';
    $result = $mysqli->query($sql, MYSQLI_STORE_RESULT);
    while ($row = $result->fetch_array(MYSQLI_ASSOC)) { $total_sessions = $row['count']; }

    $sql = 'select count(*) as count from car_cookie';
    $result = $mysqli->query($sql, MYSQLI_STORE_RESULT);
    while ($row = $result->fetch_array(MYSQLI_ASSOC)) { $total_cookies = $row['count']; }
?>
<?php include_once CAR_ROOT_ADMIN . '/containers/header.inc' ?>
<div class="container-lg py-4">
    <h5 class="mb-4">Home</h5>
    <div class="row g-3">
        <div class="col-6 col-md-4 col-lg-3">
            <div class="card text-center h-100">
                <div class="card-body">
                    <div class="display-5 fw-semibold"><?= $total_users ?></div>
                    <div class="text-muted small mt-1">Usuários</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-3">
            <div class="card text-center h-100">
                <div class="card-body">
                    <div class="display-5 fw-semibold"><?= $total_decks ?></div>
                    <div class="text-muted small mt-1">Baralhos</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-3">
            <div class="card text-center h-100">
                <div class="card-body">
                    <div class="display-5 fw-semibold"><?= $total_studies ?></div>
                    <div class="text-muted small mt-1">Estudos</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-3">
            <div class="card text-center h-100">
                <div class="card-body">
                    <div class="display-5 fw-semibold"><?= $total_studies_sessions_private ?></div>
                    <div class="text-muted small mt-1">Estudos privados</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-3">
            <div class="card text-center h-100">
                <div class="card-body">
                    <div class="display-5 fw-semibold"><?= $total_studies_sessions_public ?></div>
                    <div class="text-muted small mt-1">Estudos públicos</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-3">
            <div class="card text-center h-100">
                <div class="card-body">
                    <div class="display-5 fw-semibold"><?= $total_sessions ?></div>
                    <div class="text-muted small mt-1">Sessões</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-3">
            <div class="card text-center h-100">
                <div class="card-body">
                    <div class="display-5 fw-semibold"><?= $total_cookies ?></div>
                    <div class="text-muted small mt-1">Cookies</div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include_once CAR_ROOT_ADMIN . '/containers/footer.inc' ?>
