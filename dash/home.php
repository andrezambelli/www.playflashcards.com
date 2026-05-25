<?php /** @var array $t */ ?>
<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/car-server.php'; ?>
<?php include_once CAR_ROOT_WEB . '/config.inc'; ?>
<?php include CAR_ROOT_WEB . '/lang/lang.inc'; ?>
<?php car_check_login($t); ?>
<?php
    $user_id   = car_get_session_attribute('user_id', 0);
    $timezone  = car_get_session_attribute('timezone', CAR_TIMEZONE_DEFAULT);

    $sql = sprintf("SET time_zone = '%s'", $timezone);
    $mysqli->query($sql);

    // data formatada
    $date_label = date('l, F j');

    // lista de baralhos com total de cartões
    $decks = [];
    $sql = sprintf('
        select d.deck_key, d.deck_name, d.deck_desc, d.deck_public,
               count(c.card_id) as total_cards
          from car_deck d
          left join car_card c on c.deck_id = d.deck_id and c.user_id = d.user_id
         where d.user_id = %d
         group by d.deck_id, d.deck_key, d.deck_name, d.deck_desc, d.deck_public
         order by d.deck_name',
        $user_id);
    $result = $mysqli->query($sql);
    while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
        $decks[] = $row;
    }
?>
<?php
    $header_title    = 'Play Flashcards';
    $dash_active     = '';
    $dash_breadcrumb = [];
    include_once CAR_ROOT_WEB . '/dash/containers/header.inc';
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
            <a href="<?= CAR_PATH_WEB ?>/dash/deck-new-act" class="btn btn-outline-secondary">
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
            <div class="card">
                <div class="card-body">
                    <div class="car-label-uc mb-2"><?= car_t($t, 'dash.home.due-today') ?></div>
                    <div class="car-text-mono" style="font-size: 1.75rem; font-weight: 500">—</div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="card">
                <div class="card-body">
                    <div class="car-label-uc mb-2"><?= car_t($t, 'Accuracy') ?></div>
                    <div class="car-text-mono" style="font-size: 1.75rem; font-weight: 500">—</div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="card">
                <div class="card-body">
                    <div class="car-label-uc mb-2"><?= car_t($t, 'dash.home.streak') ?></div>
                    <div class="car-text-mono" style="font-size: 1.75rem; font-weight: 500">—</div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="card">
                <div class="card-body">
                    <div class="car-label-uc mb-2"><?= car_t($t, 'Decks') ?></div>
                    <div class="car-text-mono" style="font-size: 1.75rem; font-weight: 500"><?= count($decks) ?></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Sessão de hoje -->
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

    <?php if (empty($decks)) { ?>

        <div class="text-center py-5 text-secondary">
            <i class="bi bi-layers fs-1 mb-3 d-block" aria-hidden="true"></i>
            <p class="mb-3"><?= car_t($t, 'dash.home.no-decks') ?></p>
            <a href="<?= CAR_PATH_WEB ?>/dash/deck-new-act" class="btn btn-primary">
                <i class="bi bi-plus" aria-hidden="true"></i>
                <?= car_t($t, 'New Deck') ?>
            </a>
        </div>

    <?php } else { ?>

        <div class="row g-3">
            <?php foreach ($decks as $deck) { ?>
            <div class="col-md-6 col-lg-4">
                <div class="card h-100">
                    <div class="card-body d-flex flex-column gap-3">

                        <div>
                            <div class="car-label-uc d-flex align-items-center gap-1 mb-1">
                                <?php if ($deck['deck_public']) { ?>
                                    <i class="bi bi-globe2" aria-hidden="true"></i>
                                    <?= car_t($t, 'dash.home.public') ?>
                                <?php } else { ?>
                                    <i class="bi bi-lock" aria-hidden="true"></i>
                                    <?= car_t($t, 'dash.home.private') ?>
                                <?php } ?>
                            </div>
                            <a href="<?= CAR_PATH_WEB ?>/dash/deck?k=<?= car_htmlspecialchars($deck['deck_key']) ?>"
                               class="text-decoration-none text-body">
                                <div class="fw-semibold"><?= car_htmlspecialchars($deck['deck_name']) ?></div>
                            </a>
                            <?php if (!empty($deck['deck_desc'])) { ?>
                                <div class="small text-secondary text-truncate mt-1"><?= car_htmlspecialchars($deck['deck_desc']) ?></div>
                            <?php } ?>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mt-auto">
                            <div class="d-flex gap-4">
                                <div>
                                    <div class="car-label-uc"><?= car_t($t, 'profile.srs.unit-cards') ?></div>
                                    <div class="car-text-mono small fw-medium"><?= (int) $deck['total_cards'] ?></div>
                                </div>
                                <div>
                                    <div class="car-label-uc"><?= car_t($t, 'dash.home.due') ?></div>
                                    <div class="car-text-mono small fw-medium text-secondary">—</div>
                                </div>
                            </div>
                            <a href="<?= CAR_PATH_WEB ?>/dash/study-new-act?k=<?= car_htmlspecialchars($deck['deck_key']) ?>"
                               class="btn btn-primary btn-sm d-inline-flex align-items-center gap-1 flex-shrink-0">
                                <i class="bi bi-play-fill" aria-hidden="true"></i>
                                <?= car_t($t, 'Study') ?>
                            </a>
                        </div>

                    </div>
                </div>
            </div>
            <?php } ?>
        </div>

    <?php } ?>

</div>

<?php include_once CAR_ROOT_WEB . '/dash/containers/footer.inc'; ?>
