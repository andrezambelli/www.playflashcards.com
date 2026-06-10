<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/car-server.php'; ?>
<?php include_once CAR_ROOT_ADMIN . '/config.inc' ?>
<?php
    $stats = [
        'users'            => 0,
        'decks'            => 0,
        'studies'          => 0,
        'studies_public'   => 0,
        'studies_private'  => 0,
        'sessions'         => 0,
        'cookies'          => 0,
    ];

    $queries = [
        'users'           => 'select count(*) as n from car_user',
        'decks'           => 'select count(*) as n from car_deck',
        'studies'         => 'select count(*) as n from car_study',
        'studies_public'  => 'select count(*) as n from car_study where stud_public = 1',
        'studies_private' => 'select count(*) as n from car_study where stud_public = 0',
        'sessions'        => 'select count(*) as n from car_session',
        'cookies'         => 'select count(*) as n from car_cookie',
    ];

    foreach ($queries as $key => $sql) {
        $result = $mysqli->query($sql, MYSQLI_STORE_RESULT);
        $row    = $result->fetch_array(MYSQLI_ASSOC);
        $stats[$key] = (int) $row['n'];
    }

    $labels = [
        'users'           => 'Usuários',
        'decks'           => 'Baralhos',
        'studies'         => 'Estudos',
        'studies_public'  => 'Estudos públicos',
        'studies_private' => 'Estudos privados',
        'sessions'        => 'Sessões',
        'cookies'         => 'Cookies',
    ];

    $asset_v = rawurlencode(car_is_production() ? CAR_ADMIN_VERSION : (string) ($_SERVER['REQUEST_TIME'] ?? time()));
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">
    <link rel="icon" type="image/png" href="<?= CAR_PATH_WEB ?>/assets/img/favicon.png">
    <link rel="stylesheet" href="<?= CAR_PATH_WEB ?>/assets/css/bootstrap-5.3.8.min.css">
    <link rel="stylesheet" href="<?= CAR_PATH_ADMIN ?>/assets/css/styles.css?v=<?= $asset_v ?>">
    <title>Play Flashcards Status</title>
</head>
<body class="bg-light">
<div class="container py-4">

    <div class="d-flex justify-content-between align-items-baseline mb-4">
        <span class="fw-semibold">Play Flashcards</span>
        <small class="text-secondary"><?= date('d/m/Y H:i') ?></small>
    </div>

    <div class="row g-3">
        <?php foreach ($stats as $key => $value) { ?>
        <div class="col-6 col-md-4 col-lg-3">
            <div class="card text-center h-100">
                <div class="card-body py-3">
                    <div class="fs-2 fw-semibold"><?= number_format($value, 0, ',', '.') ?></div>
                    <div class="text-muted small mt-1"><?= $labels[$key] ?></div>
                </div>
            </div>
        </div>
        <?php } ?>
    </div>

</div>
</body>
</html>
