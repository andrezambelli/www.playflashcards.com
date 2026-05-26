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

    $sql = sprintf("select deck_id,
                           deck_name
                      from car_deck
                     where deck_key = '%s'
                       and user_id = %d",
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

    // verifica o limite de cartões antes de exibir o formulário
    $user_max_card = car_get_session_attribute('user_max_card', CAR_USER_MAX_CARD);

    $sql = sprintf('select count(*) as count
                      from car_card
                     where user_id = %d
                       and deck_id = %d',
                    $user_id,
                    $deck_id);
    $result = $mysqli->query($sql);
    $user_count_card = 0;
    while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
        $user_count_card = $row['count'];
    }

    if ($user_count_card >= $user_max_card) {
        car_set_session_error_message('dash.card-new.act.error');
        car_redirect(CAR_PATH_WEB . '/dash/card-list?k=' . $deck_key);
    }

    $card_front = car_get_session_attribute('new_card_front', '');
    $card_back  = car_get_session_attribute('new_card_back', '');

    // limpa os valores de repopulação após ler
    $_SESSION['new_card_front'] = null;
    $_SESSION['new_card_back']  = null;
?>
<?php
    $header_title    = car_t($t, 'New Flashcard') . ' - Play Flashcards';
    $dash_active     = 'decks';
    $dash_deck_key   = $deck_key;
    $dash_breadcrumb = [
        [car_t($t, 'Decks'), CAR_PATH_WEB . '/dash/deck-list'],
        [$deck_name, CAR_PATH_WEB . '/dash/deck?k=' . $deck_key],
        [car_t($t, 'Flashcards'), CAR_PATH_WEB . '/dash/card-list?k=' . $deck_key],
        [car_t($t, 'New Flashcard')]
    ];
    include_once CAR_ROOT_WEB . '/dash/header.inc';
?>

<div>

    <?php include_once CAR_ROOT_WEB . '/containers/message.inc'; ?>

    <div class="d-flex justify-content-between align-items-center mb-4 gap-3 flex-wrap">
        <h1 class="h3 fw-semibold mb-0"><?= car_t($t, 'New Flashcard') ?></h1>
    </div>

    <div class="card">
        <div class="card-body">
            <form id="main_form" method="post" action="<?= CAR_PATH_WEB ?>/dash/card-new-act">
                <input type="hidden" name="k" value="<?= car_htmlspecialchars($deck_key) ?>">
                <input type="hidden" id="fwd" name="fwd" value="list">

                <div class="mb-3">
                    <label for="card_front" class="form-label"><?= car_t($t, 'Front') ?></label>
                    <input type="text" id="card_front" name="card_front"
                           value="<?= car_htmlspecialchars($card_front) ?>"
                           maxlength="1024"
                           class="form-control" autofocus>
                </div>

                <div class="mb-4">
                    <label for="card_back" class="form-label"><?= car_t($t, 'Back') ?></label>
                    <input type="text" id="card_back" name="card_back"
                           value="<?= car_htmlspecialchars($card_back) ?>"
                           maxlength="1024"
                           class="form-control">
                </div>

                <div class="d-flex gap-2 flex-wrap">
                    <button type="submit" class="btn btn-primary">
                        <?= car_t($t, 'Save Flashcard') ?>
                    </button>
                    <button type="button" id="save_insert_btn" class="btn btn-outline-secondary">
                        <?= car_t($t, 'Save and Add New Flashcard') ?>
                    </button>
                    <a href="<?= CAR_PATH_WEB . '/dash/card-list?k=' . car_htmlspecialchars($deck_key) ?>"
                       class="btn btn-outline-secondary">
                        <?= car_t($t, 'To Back') ?>
                    </a>
                </div>

            </form>
        </div>
    </div>

</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    document.getElementById('save_insert_btn').addEventListener('click', function () {
        document.getElementById('fwd').value = 'new';
        document.getElementById('main_form').submit();
    });
});
</script>

        </div><!-- .car-app-page -->

    </div><!-- coluna principal -->

</div><!-- .car-app-shell -->

<?php include CAR_ROOT_WEB . '/dash/sidebar.inc'; ?>
<?php include_once CAR_ROOT_WEB . '/containers/footer.inc'; ?>
