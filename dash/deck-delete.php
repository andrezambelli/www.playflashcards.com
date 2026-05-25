<?php /** @var array $t */ ?>
<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/car-server.php'; ?>
<?php include_once CAR_ROOT_WEB . '/config.inc'; ?>
<?php include CAR_ROOT_WEB . '/lang/lang.inc'; ?>
<?php car_check_login($t); ?>
<?php
    $user_id  = car_get_session_attribute('user_id', 0);
    $deck_key = car_get_parameter('k', '');

    $deck_id   = 0;
    $deck_name = '';

    $sql = sprintf("select deck_id, deck_name from car_deck where deck_key = '%s' and user_id = %d",
                    $mysqli->real_escape_string(car_never_null($deck_key)),
                    $user_id);

    $result = $mysqli->query($sql);

    while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
        $deck_id   = $row['deck_id'];
        $deck_name = $row['deck_name'];
    }

    if ($deck_id === 0) {
        car_set_session_error_message('dash.deck-info.not-found');
        car_redirect(CAR_PATH_WEB . '/dash/deck-list');
    }
?>
<?php
    $header_title    = car_t($t, 'Delete Deck') . ' - Play Flashcards';
    $dash_active     = 'decks';
    $dash_deck_key   = $deck_key;
    $dash_breadcrumb = [
        [car_t($t, 'Decks'), CAR_PATH_WEB . '/dash/deck-list'],
        [$deck_name, CAR_PATH_WEB . '/dash/deck?k=' . $deck_key],
        [car_t($t, 'Delete Deck')]
    ];
    include_once CAR_ROOT_WEB . '/dash/containers/header.inc';
?>

<div style="max-width: 560px">

    <?php include_once CAR_ROOT_WEB . '/containers/message.inc'; ?>

    <h1 class="h3 fw-semibold mb-1"><?= car_t($t, 'Delete Deck') ?></h1>
    <p class="text-secondary small mb-4"><?= car_t($t, 'dash.deck-delete-question') ?></p>

    <div class="card border-danger-subtle">
        <div class="card-body">
            <p class="small text-secondary mb-4">
                <span class="fw-semibold text-danger-emphasis"><?= car_t($t, 'Warning') ?>:</span>
                <?= car_t($t, 'dash.deck-delete.warning') ?>
            </p>
            <div class="d-flex gap-2">
                <a href="<?= CAR_PATH_WEB ?>/dash/deck?k=<?= car_htmlspecialchars($deck_key) ?>"
                   class="btn btn-outline-secondary">
                    <?= car_t($t, 'Cancel') ?>
                </a>
                <form method="post" action="<?= CAR_PATH_WEB ?>/dash/deck-delete-act">
                    <input type="hidden" name="k" value="<?= car_htmlspecialchars($deck_key) ?>">
                    <button type="submit" class="btn btn-danger">
                        <i class="bi bi-trash" aria-hidden="true"></i>
                        <?= car_t($t, 'Yes') ?>, <?= car_t($t, 'Delete') ?>
                    </button>
                </form>
            </div>
        </div>
    </div>

</div>

<?php include_once CAR_ROOT_WEB . '/dash/containers/footer.inc'; ?>
