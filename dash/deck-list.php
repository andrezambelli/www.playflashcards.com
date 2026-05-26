<?php /** @var array $t */ ?>
<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/car-server.php'; ?>
<?php include_once CAR_ROOT_WEB . '/config.inc'; ?>
<?php include CAR_ROOT_WEB . '/lang/lang.inc'; ?>
<?php car_check_login($t); ?>
<?php
    car_set_session_attribute('read_database', 'on');

    $user_id = car_get_session_attribute('user_id', 0);
?>
<?php
    $header_title    = car_t($t, 'Decks') . ' - Play Flashcards';
    $dash_active     = 'decks';
    $dash_breadcrumb = [[car_t($t, 'Decks')]];
    include_once CAR_ROOT_WEB . '/dash/header.inc';
?>

<div>

    <?php include_once CAR_ROOT_WEB . '/containers/message.inc'; ?>

    <div class="d-flex justify-content-between align-items-center mb-4 gap-3 flex-wrap">
        <div>
            <h1 class="h3 fw-semibold mb-1"><?= car_t($t, 'Decks') ?></h1>
        </div>
        <a href="<?= CAR_PATH_WEB ?>/dash/deck-new" class="btn btn-primary flex-shrink-0">
            <i class="bi bi-plus" aria-hidden="true"></i>
            <?= car_t($t, 'New Deck') ?>
        </a>
    </div>

    <?php include CAR_ROOT_WEB . '/dash/deck-grid.inc'; ?>

</div>

        </div><!-- .car-app-page -->

    </div><!-- coluna principal -->

</div><!-- .car-app-shell -->

<?php include CAR_ROOT_WEB . '/dash/sidebar.inc'; ?>
<?php include_once CAR_ROOT_WEB . '/containers/footer.inc'; ?>
