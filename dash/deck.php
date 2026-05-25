<?php /** @var array $t */ ?>
<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/car-server.php'; ?>
<?php include_once CAR_ROOT_WEB . '/config.inc'; ?>
<?php include CAR_ROOT_WEB . '/lang/lang.inc'; ?>
<?php car_check_login($t); ?>
<?php
    car_set_session_attribute('read_database', 'on');

    $user_id = car_get_session_attribute('user_id', 0);
    $deck_key = car_get_parameter('k', '');

    $deck_id               = 0;
    $deck_name             = '';
    $deck_desc             = '';
    $deck_url              = '';
    $deck_public           = 0;
    $total_cards           = 0;
    $total_private_studies = 0;

    $sql = sprintf("select deck_id, deck_key, deck_name, deck_desc, deck_url, deck_public
                      from car_deck
                     where deck_key = '%s' and user_id = %d",
                    $mysqli->real_escape_string(car_never_null($deck_key)),
                    $user_id);

    $result = $mysqli->query($sql);

    while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
        $deck_id     = $row['deck_id'];
        $deck_name   = $row['deck_name'];
        $deck_desc   = $row['deck_desc'];
        $deck_url    = $row['deck_url'];
        $deck_public = $row['deck_public'];
    }

    if ($deck_id === 0) {
        car_set_session_error_message('dash.deck-info.not-found');
        car_redirect(CAR_PATH_WEB . '/dash/deck-list');
    }

    // apagar cartões em branco
    $sql = sprintf("delete from car_card where deck_id = %d and user_id = %d and (card_front is null or trim(card_front) = '' or card_back is null or trim(card_back) = '')",
                    $deck_id, $user_id);
    $mysqli->query($sql);
    $mysqli->commit();

    // total de cartões
    $sql = sprintf('select count(*) as count from car_card where deck_id = %d and user_id = %d', $deck_id, $user_id);
    $result = $mysqli->query($sql);
    if ($row = $result->fetch_array(MYSQLI_ASSOC)) {
        $total_cards = (int) $row['count'];
    }

    // total de estudos do usuário neste baralho
    $sql = sprintf('select count(*) as count from car_study where deck_id = %d and user_id = %d', $deck_id, $user_id);
    $result = $mysqli->query($sql);
    if ($row = $result->fetch_array(MYSQLI_ASSOC)) {
        $total_private_studies = (int) $row['count'];
    }
?>
<?php
    $header_title    = car_htmlspecialchars($deck_name) . ' - Play Flashcards';
    $dash_active     = 'decks';
    $dash_breadcrumb = [[car_t($t, 'Decks'), CAR_PATH_WEB . '/dash/deck-list'], [$deck_name]];
    include_once CAR_ROOT_WEB . '/dash/containers/header.inc';
?>

<div>

    <?php include_once CAR_ROOT_WEB . '/containers/message.inc'; ?>

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-start mb-4 gap-3 flex-wrap">
        <div>
            <div class="car-label-uc d-flex align-items-center gap-1 mb-1">
                <?php if ($deck_public) { ?>
                    <i class="bi bi-globe2" aria-hidden="true"></i>
                    <?= car_t($t, 'dash.home.public') ?>
                <?php } else { ?>
                    <i class="bi bi-lock" aria-hidden="true"></i>
                    <?= car_t($t, 'dash.home.private') ?>
                <?php } ?>
            </div>
            <h1 class="h3 fw-semibold mb-1"><?= car_htmlspecialchars($deck_name) ?></h1>
            <?php if (!empty($deck_desc)) { ?>
                <p class="text-secondary small mb-0"><?= car_htmlspecialchars($deck_desc) ?></p>
            <?php } ?>
        </div>
        <a href="<?= CAR_PATH_WEB ?>/dash/deck-edit?k=<?= car_htmlspecialchars($deck_key) ?>"
           class="btn btn-outline-secondary flex-shrink-0">
            <i class="bi bi-pencil" aria-hidden="true"></i>
            <?= car_t($t, 'Edit Deck') ?>
        </a>
    </div>

    <!-- Cartões -->
    <div class="card mb-3">
        <div class="card-body d-flex justify-content-between align-items-center gap-3 flex-wrap">
            <div class="d-flex align-items-center gap-3">
                <i class="bi bi-collection text-primary fs-4 flex-shrink-0" aria-hidden="true"></i>
                <div>
                    <div class="fw-medium"><?= car_t($t, 'Flashcards') ?></div>
                    <div class="car-text-mono small text-secondary"><?= $total_cards ?> <?= car_t($t, 'profile.srs.unit-cards') ?></div>
                </div>
            </div>
            <div class="d-flex gap-2 flex-shrink-0">
                <a href="<?= CAR_PATH_WEB ?>/dash/card-new?k=<?= car_htmlspecialchars($deck_key) ?>"
                   class="btn btn-outline-secondary btn-sm">
                    <i class="bi bi-plus" aria-hidden="true"></i>
                    <?= car_t($t, 'New Flashcard') ?>
                </a>
                <a href="<?= CAR_PATH_WEB ?>/dash/card-list?k=<?= car_htmlspecialchars($deck_key) ?>"
                   class="btn btn-outline-secondary btn-sm">
                    <?= car_t($t, 'Edit') ?>
                </a>
            </div>
        </div>
    </div>

    <!-- Estudar -->
    <div class="card mb-4">
        <div class="card-body d-flex justify-content-between align-items-center gap-3 flex-wrap">
            <div class="d-flex align-items-center gap-3">
                <i class="bi bi-play-circle text-success fs-4 flex-shrink-0" aria-hidden="true"></i>
                <div>
                    <div class="fw-medium"><?= car_t($t, 'Study') ?></div>
                    <div class="car-text-mono small text-secondary"><?= $total_private_studies ?> <?= car_t($t, 'profile.srs.unit-sessions') ?></div>
                </div>
            </div>
            <div class="d-flex gap-2 flex-shrink-0">
                <a href="<?= CAR_PATH_WEB ?>/dash/study-list?k=<?= car_htmlspecialchars($deck_key) ?>"
                   class="btn btn-outline-secondary btn-sm">
                    <?= car_t($t, 'Studies') ?>
                </a>
                <a href="<?= CAR_PATH_WEB ?>/dash/study-srs-new-act?k=<?= car_htmlspecialchars($deck_key) ?>"
                   class="btn btn-outline-secondary btn-sm">
                    SRS
                </a>
                <a href="<?= CAR_PATH_WEB ?>/dash/study-new-act?k=<?= car_htmlspecialchars($deck_key) ?>"
                   class="btn btn-primary btn-sm">
                    <i class="bi bi-play-fill" aria-hidden="true"></i>
                    <?= car_t($t, 'Study') ?>
                </a>
            </div>
        </div>
    </div>

    <?php if ($deck_public) { ?>
    <!-- URL pública -->
    <div class="card mb-4">
        <div class="card-body">
            <div class="car-label-uc mb-2"><?= car_t($t, 'Public Study URL') ?></div>
            <div class="text-truncate small">
                <a href="<?= car_get_base_url(CAR_PATH_WEB) . '/deck/' . $deck_key . '/' . $deck_url ?>"
                   class="text-decoration-none" target="_blank" rel="noopener noreferrer">
                    <?= car_htmlspecialchars(car_get_base_url(CAR_PATH_WEB) . '/deck/' . $deck_key . '/' . $deck_url) ?>
                </a>
            </div>
        </div>
    </div>
    <?php } ?>

    <!-- Zona de perigo -->
    <div class="card border-danger">
        <div class="card-body d-flex justify-content-between align-items-center gap-3 flex-wrap">
            <div>
                <div class="fw-medium text-danger"><?= car_t($t, 'Delete Deck') ?></div>
                <div class="small text-secondary"><?= car_t($t, 'dash.deck.delete') ?></div>
            </div>
            <a href="<?= CAR_PATH_WEB ?>/dash/deck-delete?k=<?= car_htmlspecialchars($deck_key) ?>"
               class="btn btn-outline-danger btn-sm flex-shrink-0">
                <?= car_t($t, 'Delete') ?>
            </a>
        </div>
    </div>

</div>

<?php include_once CAR_ROOT_WEB . '/dash/containers/footer.inc'; ?>
