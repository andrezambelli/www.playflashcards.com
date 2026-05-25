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

    // total de cartões
    $sql = sprintf('select count(*) as count from car_card where deck_id = %d and user_id = %d', $deck_id, $user_id);
    $result = $mysqli->query($sql);
    if ($row = $result->fetch_array(MYSQLI_ASSOC)) {
        $total_cards = (int) $row['count'];
    }

    // taxa de acerto geral do baralho
    $deck_accuracy     = 0;
    $deck_total_true   = 0;
    $deck_total_attempts = 0;
    $sql = sprintf('select coalesce(sum(card_true), 0) as total_true, coalesce(sum(card_true + card_false), 0) as total_attempts from car_card where deck_id = %d and user_id = %d', $deck_id, $user_id);
    $result = $mysqli->query($sql);
    if ($row = $result->fetch_array(MYSQLI_ASSOC)) {
        $deck_total_true     = (int) $row['total_true'];
        $deck_total_attempts = (int) $row['total_attempts'];
    }
    $deck_accuracy = car_percent($deck_total_true, $deck_total_attempts);

    // total de sessões de estudo do usuário neste baralho
    $sql = sprintf('select count(*) as count from car_study where deck_id = %d and user_id = %d', $deck_id, $user_id);
    $result = $mysqli->query($sql);
    if ($row = $result->fetch_array(MYSQLI_ASSOC)) {
        $total_private_studies = (int) $row['count'];
    }

    // sessão de estudo em aberto (sem data de fim)
    $open_study_key = '';
    $sql = sprintf("select stud_key from car_study where deck_id = %d and user_id = %d and stud_end is null order by stud_begin desc limit 1", $deck_id, $user_id);
    $result = $mysqli->query($sql);
    if ($row = $result->fetch_array(MYSQLI_ASSOC)) {
        $open_study_key = $row['stud_key'];
    }

    // url pública
    $public_url = car_get_base_url(CAR_PATH_WEB) . '/deck/' . $deck_key . '/' . $deck_url;

    // preview: 5 cartões com menor taxa de acerto (cartões sem tentativas ficam por último)
    $preview_cards = [];
    $sql = sprintf("select card_key, card_front, card_back, card_true, card_false, (card_true + card_false) as total_attempts
                      from car_card
                     where deck_id = %d and user_id = %d
                     order by case when (card_true + card_false) = 0 then 1 else 0 end asc,
                              (card_true / (card_true + card_false)) asc
                     limit 5",
                    $deck_id, $user_id);
    $result = $mysqli->query($sql);
    while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
        $preview_cards[] = $row;
    }
?>
<?php
    $header_title    = car_htmlspecialchars($deck_name) . ' - Play Flashcards';
    $dash_active     = 'decks';
    $dash_deck_key   = $deck_key;
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
           class="btn btn-outline-secondary btn-sm flex-shrink-0">
            <i class="bi bi-pencil" aria-hidden="true"></i>
            <?= car_t($t, 'Edit Deck') ?>
        </a>
    </div>

    <!-- Stats -->
    <div class="row g-3 mb-4">

        <div class="col-6 col-md-3">
            <a href="<?= CAR_PATH_WEB ?>/dash/card-list?k=<?= car_htmlspecialchars($deck_key) ?>"
               class="card h-100 text-decoration-none text-body car-card-link">
                <div class="card-body">
                    <div class="car-label-uc mb-2"><?= car_t($t, 'Flashcards') ?></div>
                    <div class="h4 fw-semibold mb-0 car-text-mono"><?= $total_cards ?></div>
                </div>
            </a>
        </div>

        <div class="col-6 col-md-3">
            <div class="card h-100">
                <div class="card-body">
                    <div class="car-label-uc mb-2"><?= car_t($t, 'Accuracy Rate') ?></div>
                    <?php if ($deck_total_attempts > 0) { ?>
                        <?php $acc_color = $deck_accuracy < 50 ? 'bg-danger' : ($deck_accuracy < 75 ? 'bg-warning' : 'bg-success'); ?>
                        <div class="h4 fw-semibold mb-2 car-text-mono"><?= $deck_accuracy ?>%</div>
                        <div class="progress" style="height: 4px" role="progressbar" aria-valuenow="<?= $deck_accuracy ?>" aria-valuemin="0" aria-valuemax="100">
                            <div class="progress-bar <?= $acc_color ?>" style="width: <?= $deck_accuracy ?>%"></div>
                        </div>
                    <?php } else { ?>
                        <div class="h4 fw-semibold mb-0 car-text-mono text-secondary">&mdash;</div>
                    <?php } ?>
                </div>
            </div>
        </div>

        <div class="col-6 col-md-3">
            <div class="card h-100">
                <div class="card-body">
                    <div class="car-label-uc mb-2"><?= car_t($t, 'dash.home.due') ?></div>
                    <div class="h4 fw-semibold mb-1 car-text-mono text-secondary">&mdash;</div>
                    <div class="small text-secondary"><?= car_t($t, 'SRS') ?></div>
                </div>
            </div>
        </div>

        <div class="col-6 col-md-3">
            <a href="<?= CAR_PATH_WEB ?>/dash/study-list?k=<?= car_htmlspecialchars($deck_key) ?>"
               class="card h-100 text-decoration-none text-body car-card-link">
                <div class="card-body">
                    <div class="car-label-uc mb-2"><?= car_t($t, 'profile.srs.unit-sessions') ?></div>
                    <div class="h4 fw-semibold mb-1 car-text-mono"><?= $total_private_studies ?></div>
                    <div class="small text-secondary"><?= car_t($t, 'dash.deck.history') ?></div>
                </div>
            </a>
        </div>

    </div>

    <!-- Sessão de estudo -->
    <div class="card mb-4">
        <div class="card-header">
            <div class="fw-medium"><?= car_t($t, 'dash.deck.study-title') ?></div>
        </div>
        <div class="card-body">

            <?php if (!empty($open_study_key)) { ?>
            <div class="d-flex align-items-start gap-3 p-3 mb-3 rounded-3"
                 style="background: var(--bs-warning-bg-subtle); border: 1px solid var(--bs-warning)">
                <i class="bi bi-exclamation-triangle text-warning-emphasis flex-shrink-0" style="margin-top: 1px" aria-hidden="true"></i>
                <div class="flex-grow-1">
                    <div class="small fw-medium mb-2"><?= car_t($t, 'dash.deck.open-session') ?></div>
                    <div class="d-flex gap-2">
                        <a href="<?= CAR_PATH_WEB ?>/dash/study?k=<?= car_htmlspecialchars($open_study_key) ?>"
                           class="btn btn-sm btn-warning">
                            <?= car_t($t, 'Continue') ?>
                        </a>
                        <a href="<?= CAR_PATH_WEB ?>/dash/study-delete-act?k=<?= car_htmlspecialchars($open_study_key) ?>"
                           class="btn btn-sm btn-outline-secondary">
                            <?= car_t($t, 'Delete') ?>
                        </a>
                    </div>
                </div>
            </div>
            <div class="small text-secondary mb-2"><?= car_t($t, 'dash.deck.open-session-or') ?></div>
            <?php } ?>

            <div class="row g-2">

                <div class="col-md-6">
                    <a href="<?= CAR_PATH_WEB ?>/dash/study-srs-new-act?k=<?= car_htmlspecialchars($deck_key) ?>"
                       class="card h-100 text-decoration-none text-body border-primary car-card-link"
                       style="background: var(--bs-primary-bg-subtle)">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <div class="d-flex align-items-center gap-2">
                                    <i class="bi bi-stars text-primary" aria-hidden="true"></i>
                                    <strong class="small"><?= car_t($t, 'dash.deck.study-smart') ?></strong>
                                </div>
                                <span class="badge text-bg-primary"><?= car_t($t, 'Recommended') ?></span>
                            </div>
                            <div class="small text-secondary"><?= car_t($t, 'dash.deck.study-smart-desc') ?></div>
                        </div>
                    </a>
                </div>

                <div class="col-md-6">
                    <a href="<?= CAR_PATH_WEB ?>/dash/study-new-act?k=<?= car_htmlspecialchars($deck_key) ?>"
                       class="card h-100 text-decoration-none text-body car-card-link">
                        <div class="card-body">
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <i class="bi bi-layers" aria-hidden="true"></i>
                                <strong class="small"><?= car_t($t, 'dash.deck.study-full') ?></strong>
                            </div>
                            <div class="small text-secondary"><?= car_t($t, 'dash.deck.study-full-desc') ?></div>
                        </div>
                    </a>
                </div>

            </div>
        </div>
    </div>

    <!-- Preview de cartões -->
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center gap-3">
            <div>
                <div class="fw-medium"><?= car_t($t, 'Flashcards') ?></div>
                <div class="form-text mt-1"><?= $total_cards ?> <?= car_t($t, 'profile.srs.unit-cards') ?></div>
            </div>
            <a href="<?= CAR_PATH_WEB ?>/dash/card-new?k=<?= car_htmlspecialchars($deck_key) ?>"
               class="btn btn-primary btn-sm d-inline-flex align-items-center gap-1 flex-shrink-0">
                <i class="bi bi-plus" aria-hidden="true"></i>
                <?= car_t($t, 'New Flashcard') ?>
            </a>
        </div>

        <?php if (!empty($preview_cards)) { ?>
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th class="small text-secondary fw-normal"><?= car_t($t, 'Front') ?></th>
                        <th class="small text-secondary fw-normal"><?= car_t($t, 'Back') ?></th>
                        <th class="small text-secondary fw-normal" style="width: 120px"><?= car_t($t, 'Accuracy Rate') ?></th>
                        <th style="width: 32px"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($preview_cards as $_pc) { ?>
                    <?php
                        $_pc_attempts = (int) $_pc['total_attempts'];
                        $_pc_acc      = car_percent((int) $_pc['card_true'], $_pc_attempts);
                        $_pc_color    = $_pc_acc < 50 ? 'bg-danger' : ($_pc_acc < 75 ? 'bg-warning' : 'bg-success');
                    ?>
                    <tr style="cursor: pointer" onclick="location.href='<?= CAR_PATH_WEB ?>/dash/card-edit?k=<?= car_htmlspecialchars($_pc['card_key']) ?>'">
                        <td class="small fw-medium"><?= car_htmlspecialchars($_pc['card_front']) ?></td>
                        <td class="small text-secondary"><?= car_htmlspecialchars($_pc['card_back']) ?></td>
                        <td>
                            <?php if ($_pc_attempts > 0) { ?>
                            <div class="d-flex align-items-center gap-2">
                                <div class="progress flex-shrink-0" style="width: 40px; height: 4px" role="progressbar" aria-valuenow="<?= $_pc_acc ?>" aria-valuemin="0" aria-valuemax="100">
                                    <div class="progress-bar <?= $_pc_color ?>" style="width: <?= $_pc_acc ?>%"></div>
                                </div>
                                <span class="car-text-mono small"><?= $_pc_acc ?>%</span>
                            </div>
                            <?php } else { ?>
                            <span class="small text-secondary">&mdash;</span>
                            <?php } ?>
                        </td>
                        <td><i class="bi bi-chevron-right small text-primary" aria-hidden="true"></i></td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <?php } ?>

        <div class="card-footer text-center py-2">
            <a href="<?= CAR_PATH_WEB ?>/dash/card-list?k=<?= car_htmlspecialchars($deck_key) ?>"
               class="btn btn-sm btn-link text-secondary text-decoration-none">
                <?= car_t($t, 'dash.deck.view-all') ?>
                <i class="bi bi-arrow-right small" aria-hidden="true"></i>
            </a>
        </div>
    </div>

    <?php if ($deck_public) { ?>
    <!-- URL pública -->
    <div class="card mb-4">
        <div class="card-body">
            <div class="car-label-uc mb-2"><?= car_t($t, 'Public Study URL') ?></div>
            <div class="text-truncate small">
                <a href="<?= car_htmlspecialchars($public_url) ?>"
                   class="text-decoration-none d-inline-flex align-items-center gap-1"
                   target="_blank" rel="noopener noreferrer">
                    <?= car_htmlspecialchars($public_url) ?>
                    <i class="bi bi-box-arrow-up-right flex-shrink-0" style="font-size: .75rem" aria-hidden="true"></i>
                </a>
            </div>
        </div>
    </div>
    <?php } ?>

    <!-- Zona de perigo -->
    <div class="d-flex justify-content-between align-items-center gap-3 flex-wrap pt-4 mt-2 border-top">
        <div>
            <div class="fw-medium text-danger small"><?= car_t($t, 'Delete Deck') ?></div>
            <div class="small text-secondary"><?= car_t($t, 'dash.deck.delete') ?></div>
        </div>
        <a href="<?= CAR_PATH_WEB ?>/dash/deck-delete?k=<?= car_htmlspecialchars($deck_key) ?>"
           class="btn btn-outline-danger btn-sm flex-shrink-0">
            <?= car_t($t, 'Delete') ?>
        </a>
    </div>

</div>

<?php include_once CAR_ROOT_WEB . '/dash/containers/footer.inc'; ?>
