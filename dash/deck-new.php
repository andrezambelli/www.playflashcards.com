<?php /** @var array $t */ ?>
<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/car-server.php'; ?>
<?php include_once CAR_ROOT_WEB . '/config.inc'; ?>
<?php include CAR_ROOT_WEB . '/lang/lang.inc'; ?>
<?php car_check_login($t); ?>
<?php
    $user_id       = car_get_session_attribute('user_id', 0);
    $user_max_deck = car_get_session_attribute('user_max_deck', CAR_USER_MAX_DECK);

    // verifica o limite antes de exibir o formulário
    $sql = sprintf('select count(*) as count
                      from car_deck
                     where user_id = %d',
                    $user_id);
    $result = $mysqli->query($sql);
    $user_count_deck = 0;
    while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
        $user_count_deck = $row['count'];
    }

    if ($user_count_deck >= $user_max_deck) {
        car_set_session_error_message('dash.deck-new-act.error');
        car_redirect(CAR_PATH_WEB . '/dash/deck-list');
    }

    $deck_name    = car_get_session_attribute('new_deck_name', '');
    $deck_desc    = car_get_session_attribute('new_deck_desc', '');
    $deck_bgcolor = car_get_session_attribute('new_deck_bgcolor', CAR_DECK_BGCOLOR_DEFAULT);
    $deck_public  = car_get_session_attribute('new_deck_public', '0');
    $deck_lang    = car_get_session_attribute('new_deck_lang', $t['lang']);

    // limpa os valores de repopulação após ler
    $_SESSION['new_deck_name']    = null;
    $_SESSION['new_deck_desc']    = null;
    $_SESSION['new_deck_bgcolor'] = null;
    $_SESSION['new_deck_public']  = null;
    $_SESSION['new_deck_lang']    = null;
?>
<?php
    $header_title    = car_t($t, 'New Deck') . ' - Play Flashcards';
    $dash_active     = 'decks';
    $dash_breadcrumb = [
        [car_t($t, 'Decks'), CAR_PATH_WEB . '/dash/deck-list'],
        [car_t($t, 'New Deck')]
    ];
    include_once CAR_ROOT_WEB . '/dash/header.inc';
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
                    <label for="deck_lang" class="form-label"><?= car_t($t, 'Language') ?></label>
                    <select id="deck_lang" name="deck_lang" class="form-select" style="max-width: 280px">
                        <option value="de"    <?= $deck_lang === 'de'    ? 'selected' : '' ?>>Deutsch</option>
                        <option value="en"    <?= $deck_lang === 'en'    ? 'selected' : '' ?>>English</option>
                        <option value="es"    <?= $deck_lang === 'es'    ? 'selected' : '' ?>>Español</option>
                        <option value="fr"    <?= $deck_lang === 'fr'    ? 'selected' : '' ?>>Français</option>
                        <option value="hi"    <?= $deck_lang === 'hi'    ? 'selected' : '' ?>>हिंदी</option>
                        <option value="it"    <?= $deck_lang === 'it'    ? 'selected' : '' ?>>Italiano</option>
                        <option value="ja"    <?= $deck_lang === 'ja'    ? 'selected' : '' ?>>日本語</option>
                        <option value="nl"    <?= $deck_lang === 'nl'    ? 'selected' : '' ?>>Nederlands</option>
                        <option value="pl"    <?= $deck_lang === 'pl'    ? 'selected' : '' ?>>Polski</option>
                        <option value="pt-br" <?= $deck_lang === 'pt-br' ? 'selected' : '' ?>>Português (Brasil)</option>
                        <option value="ru"    <?= $deck_lang === 'ru'    ? 'selected' : '' ?>>Русский</option>
                        <option value="zh"    <?= $deck_lang === 'zh'    ? 'selected' : '' ?>>中文</option>
                    </select>
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

        </div><!-- .car-app-page -->

    </div><!-- coluna principal -->

</div><!-- .car-app-shell -->

<?php include CAR_ROOT_WEB . '/dash/sidebar.inc'; ?>
<?php include_once CAR_ROOT_WEB . '/containers/footer.inc'; ?>
