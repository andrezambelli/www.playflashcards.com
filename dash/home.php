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

    // total de cartões do usuário
    $total_cards = 0;
    $sql = sprintf('select count(*) as count from car_card where user_id = %d', $user_id);
    $result = $mysqli->query($sql);
    if ($row = $result->fetch_array(MYSQLI_ASSOC)) {
        $total_cards = (int) $row['count'];
    }

    // taxa de precisão global (de todos os cartões)
    $home_accuracy = 0;
    $sql = sprintf('select coalesce(sum(card_true), 0) as total_true,
                           coalesce(sum(card_true + card_false), 0) as total_attempts
                      from car_card
                     where user_id = %d',
                    $user_id);
    $result = $mysqli->query($sql);
    if ($row = $result->fetch_array(MYSQLI_ASSOC)) {
        $home_accuracy = car_percent((int) $row['total_true'], (int) $row['total_attempts']);
    }

    // configuração SRS do usuário
    $srs_rate     = CAR_USER_SRS_RATE;
    $srs_sequence = CAR_USER_SRS_SEQUENCE;
    $srs_days     = CAR_USER_SRS_DAYS;
    $sql = sprintf('select user_srs_rate, user_srs_sequence, user_srs_days
                      from car_user where user_id = %d',
                    $user_id);
    $result = $mysqli->query($sql);
    if ($row = $result->fetch_array(MYSQLI_ASSOC)) {
        $srs_rate     = (int) $row['user_srs_rate'];
        $srs_sequence = (int) $row['user_srs_sequence'];
        $srs_days     = (int) $row['user_srs_days'];
    }

    // cartões pendentes SRS (todos os baralhos do usuário)
    $pending_cards = 0;
    $sql = sprintf('select count(*) as count
                      from car_card
                     where user_id = %d
                       and (card_rate < %d or card_sequence < %d or card_last_study < DATE_SUB(NOW(), INTERVAL %d DAY))',
                    $user_id, $srs_rate, $srs_sequence, $srs_days);
    $result = $mysqli->query($sql);
    if ($row = $result->fetch_array(MYSQLI_ASSOC)) {
        $pending_cards = (int) $row['count'];
    }

    // total de estudos do usuário
    $total_studies = 0;
    $sql = sprintf('select count(*) as count from car_study where user_id = %d', $user_id);
    $result = $mysqli->query($sql);
    if ($row = $result->fetch_array(MYSQLI_ASSOC)) {
        $total_studies = (int) $row['count'];
    }

    // total de grupos do usuário
    $total_decks = 0;
    $sql = sprintf('select count(*) as count from car_deck where user_id = %d', $user_id);
    $result = $mysqli->query($sql);
    if ($row = $result->fetch_array(MYSQLI_ASSOC)) {
        $total_decks = (int) $row['count'];
    }

    // deck recomendado para o próximo estudo (score ponderado SRS: precisão=3, sequência=2, intervalo=1)
    $next_deck_key     = '';
    $next_deck_name    = '';
    $next_deck_cards   = 0;
    $next_deck_pending = 0;
    if ($total_decks > 0) {
        $sql = sprintf('select d.deck_key,
                               d.deck_name,
                               count(c.card_id) as total_cards,
                               coalesce(sum(
                                 case when c.card_rate < %d or c.card_sequence < %d
                                           or c.card_last_study < DATE_SUB(NOW(), INTERVAL %d DAY)
                                      then 1 else 0 end
                               ), 0) as deck_pending,
                               coalesce(sum(
                                 (case when c.card_rate < %d then 3 else 0 end) +
                                 (case when c.card_sequence < %d then 2 else 0 end) +
                                 (case when c.card_last_study < DATE_SUB(NOW(), INTERVAL %d DAY) then 1 else 0 end)
                               ), 0) as priority_score,
                               coalesce(sum(c.card_true), 0) /
                                 nullif(coalesce(sum(c.card_true), 0) + coalesce(sum(c.card_false), 0), 0) as accuracy_ratio
                          from car_deck d
                          left join car_card c on c.deck_id = d.deck_id
                                               and c.user_id = d.user_id
                         where d.user_id = %d
                         group by d.deck_id, d.deck_key, d.deck_name
                         order by priority_score desc, accuracy_ratio asc
                         limit 1',
                        $srs_rate, $srs_sequence, $srs_days,
                        $srs_rate, $srs_sequence, $srs_days,
                        $user_id);
        $result = $mysqli->query($sql);
        if ($row = $result->fetch_array(MYSQLI_ASSOC)) {
            $next_deck_key     = $row['deck_key'];
            $next_deck_name    = $row['deck_name'];
            $next_deck_cards   = (int) $row['total_cards'];
            $next_deck_pending = (int) $row['deck_pending'];
        }
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
    <div class="d-flex justify-content-end mb-4">
        <a href="<?= CAR_PATH_WEB ?>/dash/deck-new" class="btn btn-outline-secondary">
            <i class="bi bi-plus" aria-hidden="true"></i>
            <?= car_t($t, 'New Deck') ?>
        </a>
    </div>

    <!-- Stats -->
    <div class="row row-cols-2 row-cols-md-5 g-3 mb-4">
        <div class="col">
            <a href="<?= CAR_PATH_WEB ?>/dash/deck-list"
               class="card h-100 text-decoration-none text-body car-card-link">
                <div class="card-body">
                    <div class="car-label-uc mb-2"><?= car_t($t, 'Decks') ?></div>
                    <div class="h4 fw-semibold mb-1 car-text-mono"><?= $total_decks ?></div>
                    <div class="small text-secondary"><?= car_t($t, 'dash.home.view-decks') ?></div>
                </div>
            </a>
        </div>
        <div class="col">
            <div class="card h-100">
                <div class="card-body">
                    <div class="car-label-uc mb-2"><?= car_t($t, 'Flashcards') ?></div>
                    <div class="h4 fw-semibold mb-0 car-text-mono"><?= $total_cards ?></div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card h-100">
                <div class="card-body">
                    <div class="car-label-uc mb-2"><?= car_t($t, 'dash.home.due') ?></div>
                    <div class="h4 fw-semibold mb-1 car-text-mono"><?= $pending_cards ?></div>
                    <div class="small text-secondary">SRS</div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card h-100">
                <div class="card-body">
                    <div class="car-label-uc mb-2"><?= car_t($t, 'Accuracy') ?></div>
                    <?php if ($home_accuracy > 0) { ?>
                    <?php $home_acc_color = $home_accuracy < 50 ? 'bg-danger' : ($home_accuracy < 75 ? 'bg-warning' : 'bg-success'); ?>
                    <div class="h4 fw-semibold mb-1 car-text-mono"><?= $home_accuracy ?>%</div>
                    <div class="progress" style="height: 4px" role="progressbar"
                         aria-valuenow="<?= $home_accuracy ?>" aria-valuemin="0" aria-valuemax="100">
                        <div class="progress-bar <?= $home_acc_color ?>" style="width: <?= $home_accuracy ?>%"></div>
                    </div>
                    <?php } else { ?>
                    <div class="h4 fw-semibold mb-0 car-text-mono text-secondary">&mdash;</div>
                    <?php } ?>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card h-100">
                <div class="card-body">
                    <div class="car-label-uc mb-2"><?= car_t($t, 'Studies') ?></div>
                    <div class="h4 fw-semibold mb-0 car-text-mono"><?= $total_studies ?></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Próximo estudo -->
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center gap-3">
            <div>
                <div class="fw-medium"><?= car_t($t, 'dash.home.next-session') ?></div>
                <div class="form-text mt-1"><?= car_t($t, 'dash.home.session-subtitle') ?></div>
            </div>
            <span class="badge text-bg-primary flex-shrink-0">SRS</span>
        </div>
        <?php if (empty($next_deck_key)) { ?>
        <div class="card-body text-center py-4 text-secondary">
            <p class="mb-3 small"><?= car_t($t, 'dash.home.no-decks') ?></p>
            <a href="<?= CAR_PATH_WEB ?>/dash/deck-new" class="btn btn-primary btn-sm">
                <i class="bi bi-plus" aria-hidden="true"></i>
                <?= car_t($t, 'New Deck') ?>
            </a>
        </div>
        <?php } elseif ($next_deck_cards === 0) { ?>
        <div class="card-body text-center py-4 text-secondary">
            <p class="mb-0 small"><?= car_t($t, 'dash.home.caught-up') ?></p>
        </div>
        <?php } else { ?>
        <div class="card-body d-flex justify-content-between align-items-center gap-3 flex-wrap">
            <div>
                <div class="car-label-uc mb-1"><?= car_t($t, 'Deck') ?></div>
                <div class="fw-semibold mb-3"><?= car_htmlspecialchars($next_deck_name) ?></div>
                <div class="d-flex gap-4">
                    <div>
                        <div class="car-label-uc"><?= car_t($t, 'Flashcards') ?></div>
                        <div class="car-text-mono small fw-medium"><?= $next_deck_cards ?></div>
                    </div>
                    <div>
                        <div class="car-label-uc"><?= car_t($t, 'dash.home.due') ?></div>
                        <div class="car-text-mono small fw-medium"><?= $next_deck_pending ?></div>
                    </div>
                </div>
            </div>
            <?php if ($next_deck_pending > 0) { ?>
            <a href="<?= CAR_PATH_WEB ?>/dash/study-srs-new-act?k=<?= car_htmlspecialchars($next_deck_key) ?>"
               class="btn btn-primary d-inline-flex align-items-center gap-2 flex-shrink-0">
                <i class="bi bi-play-fill" aria-hidden="true"></i>
                <?= car_t($t, 'dash.home.begin-session') ?>
            </a>
            <?php } else { ?>
            <span class="small text-secondary flex-shrink-0"><?= car_t($t, 'dash.home.caught-up') ?></span>
            <?php } ?>
        </div>
        <?php } ?>
    </div>

    <!-- Baralhos -->
    <h2 class="h6 fw-semibold mb-3"><?= car_t($t, 'Decks') ?></h2>

    <?php
        $_dg_srs_rate     = $srs_rate;
        $_dg_srs_sequence = $srs_sequence;
        $_dg_srs_days     = $srs_days;
        include CAR_ROOT_WEB . '/dash/deck-grid.inc';
    ?>

</div>

        </div><!-- .car-app-page -->

    </div><!-- coluna principal -->

</div><!-- .car-app-shell -->

<?php include CAR_ROOT_WEB . '/dash/sidebar.inc'; ?>
<?php include_once CAR_ROOT_WEB . '/containers/footer.inc'; ?>
