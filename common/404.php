<?php /** @var array $t */ ?>
<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/car-server.php';?>
<?php include_once CAR_ROOT_WEB . '/config.inc';?>
<?php include CAR_ROOT_WEB . '/lang/lang.inc'; ?>
<?php
    http_response_code(404);
    $header_title        = car_t($t, 'common.404.title') . ' - Play Flashcards';
    $header_description  = car_t($t, 'common.404.desc');
    $header_index_follow = 'noindex,nofollow';
    include_once CAR_ROOT_WEB . '/containers/header.inc';
?>

<main class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6 text-center py-5">
            <div class="display-1 fw-bold text-secondary mb-3">404</div>
            <h1 class="h3 fw-semibold mb-2"><?= car_t($t, 'common.404.title') ?></h1>
            <p class="text-secondary mb-4"><?= car_t($t, 'common.404.desc') ?></p>
            <a href="<?= CAR_PATH_WEB ?>/" class="btn btn-primary">
                <?= car_t($t, 'Home') ?>
            </a>
        </div>
    </div>
</main>

<?php include_once CAR_ROOT_WEB . '/containers/footer.inc';?>
