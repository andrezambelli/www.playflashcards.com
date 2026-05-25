<?php /** @var array $t */ ?>
<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/car-server.php'; ?>
<?php include_once CAR_ROOT_WEB . '/config.inc'; ?>
<?php include CAR_ROOT_WEB . '/lang/lang.inc'; ?>
<?php car_check_login($t); ?>
<?php
    $deck_name    = car_get_session_attribute('new_deck_name', '');
    $deck_desc    = car_get_session_attribute('new_deck_desc', '');
    $deck_bgcolor = car_get_session_attribute('new_deck_bgcolor', CAR_DECK_BGCOLOR_DEFAULT);
    $deck_public  = car_get_session_attribute('new_deck_public', '0');

    // limpa os valores de repopulação após ler
    $_SESSION['new_deck_name']    = null;
    $_SESSION['new_deck_desc']    = null;
    $_SESSION['new_deck_bgcolor'] = null;
    $_SESSION['new_deck_public']  = null;
?>
<?php
    $header_title    = car_t($t, 'New Deck') . ' - Play Flashcards';
    $dash_active     = 'decks';
    $dash_breadcrumb = [
        [car_t($t, 'Decks'), CAR_PATH_WEB . '/dash/deck-list'],
        [car_t($t, 'New Deck')]
    ];
    include_once CAR_ROOT_WEB . '/dash/containers/header.inc';
?>

<div>

    <?php include_once CAR_ROOT_WEB . '/containers/message.inc'; ?>

    <div class="d-flex justify-content-between align-items-center mb-4 gap-3 flex-wrap">
        <h1 class="h3 fw-semibold mb-0"><?= car_t($t, 'New Deck') ?></h1>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="<?= CAR_PATH_WEB ?>/dash/deck-new-act" method="post">
                <input type="hidden" name="deck_bgcolor" value="<?= car_htmlspecialchars($deck_bgcolor) ?>">

                <div class="mb-3">
                    <label for="deck_name" class="form-label"><?= car_t($t, 'Name') ?></label>
                    <input type="text" id="deck_name" name="deck_name"
                           value="<?= car_htmlspecialchars($deck_name) ?>"
                           maxlength="255"
                           placeholder="<?= car_t($t, 'Deck Name') ?>"
                           class="form-control" autofocus>
                </div>

                <div class="mb-3">
                    <label for="deck_desc" class="form-label"><?= car_t($t, 'Description') ?></label>
                    <input type="text" id="deck_desc" name="deck_desc"
                           value="<?= car_htmlspecialchars($deck_desc) ?>"
                           maxlength="1024"
                           placeholder="<?= car_t($t, 'Deck Description') ?>"
                           class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label"><?= car_t($t, 'Public Access Settings') ?></label>
                    <div class="form-check">
                        <input type="checkbox" id="deck_public" name="deck_public" value="1"
                               class="form-check-input" <?php if ($deck_public) { ?>checked<?php } ?>>
                        <label for="deck_public" class="form-check-label">
                            <?= car_t($t, 'dash.deck-edit.public') ?>
                        </label>
                    </div>
                    <div class="form-text"><?= car_t($t, 'dash.deck-edit.message1') ?></div>
                </div>

                <div class="alert alert-warning small mb-4" role="alert">
                    <strong><?= car_t($t, 'Note') ?>:</strong>
                    <?= car_t($t, 'dash.deck-edit.message2') ?>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <?= car_t($t, 'Save Deck') ?>
                    </button>
                    <a href="<?= CAR_PATH_WEB ?>/dash/deck-list"
                       class="btn btn-outline-secondary">
                        <?= car_t($t, 'To Back') ?>
                    </a>
                </div>

            </form>
        </div>
    </div>

</div>

<?php include_once CAR_ROOT_WEB . '/dash/containers/footer.inc'; ?>
