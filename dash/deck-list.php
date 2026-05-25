<?php /** @var array $t */ ?>
<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/car-server.php'; ?>
<?php include_once CAR_ROOT_WEB . '/config.inc'; ?>
<?php include CAR_ROOT_WEB . '/lang/lang.inc'; ?>
<?php car_check_login($t); ?>
<?php
    car_set_session_attribute('read_database', 'on');

    $user_id = car_get_session_attribute('user_id', 0);

    // remove baralhos que ficaram com o nome padrão
    $_sql = sprintf(" delete from car_deck where user_id = %d and deck_name = '%s'",
                    $user_id,
                    $mysqli->real_escape_string(car_never_null(CAR_DECK_NAME_DEFAULT)));
    $mysqli->query($_sql);
    $mysqli->commit();
?>
<?php
    $header_title    = car_t($t, 'Decks') . ' - Play Flashcards';
    $dash_active     = 'decks';
    $dash_breadcrumb = [[car_t($t, 'Decks')]];
    include_once CAR_ROOT_WEB . '/dash/containers/header.inc';
?>

<div>

    <?php include_once CAR_ROOT_WEB . '/containers/message.inc'; ?>

    <div class="d-flex justify-content-between align-items-center mb-4 gap-3 flex-wrap">
        <div>
            <h1 class="h3 fw-semibold mb-1"><?= car_t($t, 'Decks') ?></h1>
        </div>
        <a href="<?= CAR_PATH_WEB ?>/dash/deck-new-act" class="btn btn-primary flex-shrink-0">
            <i class="bi bi-plus" aria-hidden="true"></i>
            <?= car_t($t, 'New Deck') ?>
        </a>
    </div>

    <?php include CAR_ROOT_WEB . '/dash/deck-grid.inc'; ?>

</div>

<?php include_once CAR_ROOT_WEB . '/dash/containers/footer.inc'; ?>
