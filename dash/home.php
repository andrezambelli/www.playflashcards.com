<?php /** @var array $t */ ?>
<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/car-server.php'; ?>
<?php include_once CAR_ROOT_WEB . '/config.inc'; ?>
<?php include CAR_ROOT_WEB . '/lang/lang.inc'; ?>
<?php car_check_login($t); ?>
<?php
    $user_id   = car_get_session_attribute('user_id', 0);
    $timezone  = car_get_session_attribute('timezone', CAR_TIMEZONE_DEFAULT);

    $sql = sprintf("set time_zone = '%s'", $timezone);
    $mysqli->query($sql);

    // data formatada
    $date_label = date('l, F j');

    // contagem de baralhos para o stat card
    $total_decks = 0;
    $sql = sprintf('select count(*) as count
                      from car_deck
                     where user_id = %d',
                    $user_id);
    $result = $mysqli->query($sql);
    if ($row = $result->fetch_array(MYSQLI_ASSOC)) {
        $total_decks = (int) $row['count'];
    }
?>
<?php
    $header_title    = 'Play Flashcards';
    $dash_active     = 'home';
    $dash_breadcrumb = [];
    include_once CAR_ROOT_WEB . '/dash/header.inc';
?>

<div>

    <?php include_once CAR_ROOT_WEB . '/containers/message.inc'; ?>

    <!-- Cabeçalho da home -->
    <div class="d-flex justify-content-between align-items-end mb-4 gap-3 flex-wrap">
        <div>
            <div class="car-label-uc mb-2"><?= car_htmlspecialchars($date_label) ?></div>
            <p class="text-secondary small mb-0">— <?= car_t($t, 'dash.home.cards-due') ?></p>
        </div>
        <div class="d-flex gap-2">
            <a href="<?= CAR_PATH_WEB ?>/dash/deck-new" class="btn btn-outline-secondary">
                <i class="bi bi-plus" aria-hidden="true"></i>
                <?= car_t($t, 'New Deck') ?>
            </a>
            <a href="<?= CAR_PATH_WEB ?>/dash/study-srs-new-act" class="btn btn-primary">
                <i class="bi bi-play-fill" aria-hidden="true"></i>
                <?= car_t($t, 'Start Session') ?>
            </a>
        </div>
    </div>

    <!-- Stats -->
    <div class="row g-3 mb-4">
        <div class="col-md-3 col-6">
            <div class="card h-100">
                <div class="card-body">
                    <div class="car-label-uc mb-2"><?= car_t($t, 'dash.home.due-today') ?></div>
                    <div class="h4 fw-semibold mb-0 car-text-mono text-secondary">&mdash;</div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="card h-100">
                <div class="card-body">
                    <div class="car-label-uc mb-2"><?= car_t($t, 'Accuracy') ?></div>
                    <div class="h4 fw-semibold mb-0 car-text-mono text-secondary">&mdash;</div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="card h-100">
                <div class="card-body">
                    <div class="car-label-uc mb-2"><?= car_t($t, 'dash.home.streak') ?></div>
                    <div class="h4 fw-semibold mb-0 car-text-mono text-secondary">&mdash;</div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <a href="<?= CAR_PATH_WEB ?>/dash/deck-list"
               class="card h-100 text-decoration-none text-body car-card-link">
                <div class="card-body">
                    <div class="car-label-uc mb-2"><?= car_t($t, 'Decks') ?></div>
                    <div class="h4 fw-semibold mb-1 car-text-mono"><?= $total_decks ?></div>
                    <div class="small text-secondary"><?= car_t($t, 'dash.home.view-decks') ?></div>
                </div>
            </a>
        </div>
    </div>

    <!-- Estudo de hoje -->
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center gap-3">
            <div>
                <div class="fw-medium"><?= car_t($t, 'dash.home.today-session') ?></div>
                <div class="form-text mt-1"><?= car_t($t, 'dash.home.session-subtitle') ?></div>
            </div>
            <span class="badge text-bg-primary flex-shrink-0">SRS</span>
        </div>
        <div class="card-body d-flex justify-content-between align-items-center gap-3 flex-wrap">
            <div>
                <div class="car-label-uc mb-1"><?= car_t($t, 'profile.srs.unit-cards') ?></div>
                <div class="car-text-mono" style="font-size: 1.75rem; font-weight: 500">—</div>
            </div>
            <a href="<?= CAR_PATH_WEB ?>/dash/study-srs-new-act"
               class="btn btn-primary d-inline-flex align-items-center gap-2 flex-shrink-0">
                <i class="bi bi-play-fill" aria-hidden="true"></i>
                <?= car_t($t, 'dash.home.begin-session') ?>
            </a>
        </div>
    </div>

    <!-- Baralhos -->
    <h2 class="h6 fw-semibold mb-3"><?= car_t($t, 'Decks') ?></h2>

    <?php include CAR_ROOT_WEB . '/dash/deck-grid.inc'; ?>

</div>

<?php include_once CAR_ROOT_WEB . '/dash/footer.inc'; ?>
