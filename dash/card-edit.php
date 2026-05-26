<?php /** @var array $t */ ?>
<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/car-server.php'; ?>
<?php include_once CAR_ROOT_WEB . '/config.inc'; ?>
<?php include CAR_ROOT_WEB . '/lang/lang.inc'; ?>
<?php car_check_login($t); ?>
<?php
    $user_id       = car_get_session_attribute('user_id', 0);
    $read_database = car_get_session_attribute('read_database', 'on');

    $card_key = car_get_parameter('k', '');

    $card_front      = '';
    $card_back       = '';
    $card_true       = 0;
    $card_false      = 0;
    $card_sequence   = 0;
    $card_last_study = '';
    $deck_key        = '';
    $deck_name       = '';

    // ajustar timezone
    $timezone = car_get_session_attribute('timezone', CAR_TIMEZONE_DEFAULT);
    $sql = sprintf("set time_zone = '%s'", $timezone);
    $mysqli->query($sql);

    if ($read_database == 'on') {
        $sql = sprintf("select card_id,
                               card_front,
                               card_back
                          from car_card
                         where card_key = '%s'
                           and user_id = %d",
                        $mysqli->real_escape_string(car_never_null($card_key)),
                        $user_id);

        $result = $mysqli->query($sql);

        while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
            $card_front = $row['card_front'];
            $card_back  = $row['card_back'];
        }
    } else {
        $card_front = car_get_session_attribute('card_front', '');
        $card_back  = car_get_session_attribute('card_back', '');
    }

    // stats e info do baralho
    $sql = sprintf("select a.card_true,
                           a.card_false,
                           a.card_sequence,
                           b.deck_key,
                           b.deck_name,
                           a.card_last_study
                      from car_card a,
                           car_deck b
                     where a.card_key = '%s'
                       and a.user_id = %d
                       and a.deck_id = b.deck_id
                       and b.user_id = %d",
                    $mysqli->real_escape_string(car_never_null($card_key)),
                    $user_id,
                    $user_id);

    $result = $mysqli->query($sql);

    while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
        $deck_key        = $row['deck_key'];
        $deck_name       = $row['deck_name'];
        $card_true       = $row['card_true'];
        $card_false      = $row['card_false'];
        $card_sequence   = $row['card_sequence'];
        $card_last_study = $row['card_last_study'];
    }

    if (empty($deck_key)) {
        car_set_session_error_message('dash.deck-info.not-found');
        car_redirect(CAR_PATH_WEB . '/dash/deck-list');
    }
?>
<?php
    $header_title    = car_t($t, 'Edit Flashcard') . ' - Play Flashcards';
    $dash_active     = 'decks';
    $dash_deck_key   = $deck_key;
    $dash_breadcrumb = [
        [car_t($t, 'Decks'), CAR_PATH_WEB . '/dash/deck-list'],
        [$deck_name, CAR_PATH_WEB . '/dash/deck?k=' . $deck_key],
        [car_t($t, 'Flashcards'), CAR_PATH_WEB . '/dash/card-list?k=' . $deck_key],
        [car_t($t, 'Edit Flashcard')]
    ];
    include_once CAR_ROOT_WEB . '/dash/header.inc';
?>

<div>

    <?php include_once CAR_ROOT_WEB . '/containers/message.inc'; ?>

    <div class="d-flex justify-content-between align-items-center mb-4 gap-3 flex-wrap">
        <h1 class="h3 fw-semibold mb-0"><?= car_t($t, 'Edit Flashcard') ?></h1>
    </div>

    <div class="row g-4">

        <!-- Formulário -->
        <div class="col-lg-7">
            <div class="card">
                <div class="card-body">
                    <form id="main_form" method="post" action="<?= CAR_PATH_WEB ?>/dash/card-edit-act">
                        <input type="hidden" name="k" value="<?= car_htmlspecialchars($card_key) ?>">
                        <input type="hidden" id="fwd" name="fwd" value="view">
                        <input type="hidden" name="card_true" value="<?= (int) $card_true ?>">
                        <input type="hidden" name="card_false" value="<?= (int) $card_false ?>">
                        <input type="hidden" name="card_sequence" value="<?= (int) $card_sequence ?>">

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

                        <div class="form-check mb-4">
                            <input type="checkbox" id="delete_stats" name="delete_stats" value="true"
                                   class="form-check-input">
                            <label for="delete_stats" class="form-check-label small text-secondary">
                                <?= car_t($t, 'dash.card-edit.reset') ?>
                            </label>
                        </div>

                        <div class="d-flex gap-2 flex-wrap">
                            <button type="submit" id="save_finish_btn" class="btn btn-primary">
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

        <!-- Stats -->
        <div class="col-lg-5">
            <div class="card mb-3">
                <div class="card-body">
                    <div class="car-label-uc mb-3"><?= car_t($t, 'Stats') ?></div>
                    <div class="d-flex flex-column gap-3">

                        <div class="d-flex justify-content-between align-items-center">
                            <div class="small text-secondary"><?= car_t($t, 'Accuracy Rate') ?></div>
                            <div class="car-text-mono fw-medium"><?= car_percent($card_true, $card_true + $card_false) ?>%</div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center">
                            <div class="small text-secondary"><?= car_t($t, 'Correctly Answered') ?></div>
                            <div class="car-text-mono"><?= (int) $card_true ?></div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center">
                            <div class="small text-secondary"><?= car_t($t, 'Correct Answers in Sequence') ?></div>
                            <div class="car-text-mono"><?= (int) $card_sequence ?></div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center">
                            <div class="small text-secondary"><?= car_t($t, 'Incorrectly Answered') ?></div>
                            <div class="car-text-mono"><?= (int) $card_false ?></div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center">
                            <div class="small text-secondary"><?= car_t($t, 'Last Study') ?></div>
                            <div class="car-text-mono"><?= car_htmlspecialchars($card_last_study) ?: '&mdash;' ?></div>
                        </div>

                    </div>
                </div>
            </div>

            <!-- Excluir cartão -->
            <div class="card border-danger">
                <div class="card-body d-flex justify-content-between align-items-center gap-3">
                    <div>
                        <div class="fw-medium text-danger small"><?= car_t($t, 'Delete Flashcard') ?></div>
                        <div class="small text-secondary"><?= car_t($t, 'dash.card-edit.delete') ?></div>
                    </div>
                    <a href="<?= CAR_PATH_WEB ?>/dash/card-delete-act?k=<?= car_htmlspecialchars($card_key) ?>"
                       class="btn btn-outline-danger btn-sm flex-shrink-0">
                        <?= car_t($t, 'Delete') ?>
                    </a>
                </div>
            </div>
        </div>

    </div>

</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    document.getElementById('save_insert_btn').addEventListener('click', function () {
        document.getElementById('fwd').value = 'insert-card-action';
        document.getElementById('main_form').submit();
    });
});
</script>

        </div><!-- .car-app-page -->

    </div><!-- coluna principal -->

</div><!-- .car-app-shell -->

<?php include CAR_ROOT_WEB . '/dash/sidebar.inc'; ?>
<?php include_once CAR_ROOT_WEB . '/containers/footer.inc'; ?>
