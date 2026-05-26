<?php /** @var array $t */ ?>
<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/car-server.php'; ?>
<?php include_once CAR_ROOT_WEB . '/config.inc'; ?>
<?php include CAR_ROOT_WEB . '/lang/lang.inc'; ?>
<?php car_check_login($t); ?>
<?php
    car_set_session_attribute('read_database', 'on');

    $user_id  = car_get_session_attribute('user_id', 0);
    $deck_key = car_get_parameter('k', '');

    $current_page     = (int) car_get_parameter('current_page', 0);
    $total_records    = 0;
    $total_pages      = 0;
    $records_per_page = 25;

    $deck_id   = 0;
    $deck_name = '';

    $timezone = car_get_session_attribute('timezone', CAR_TIMEZONE_DEFAULT);
    $sql = sprintf("set time_zone = '%s'", $timezone);
    $mysqli->query($sql);

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

    $sql = sprintf('select count(*) as count
                      from car_study
                     where deck_id = %d
                       and user_id = %d',
                    $deck_id,
                    $user_id);
    $result_count = $mysqli->query($sql);
    while ($row = $result_count->fetch_array(MYSQLI_ASSOC)) {
        $total_records = $row['count'];
    }

    $total_pages = ceil($total_records / $records_per_page);

    $sql = sprintf('select stud_key,
                           stud_total,
                           stud_true,
                           stud_false,
                           stud_begin,
                           stud_end
                      from car_study
                     where deck_id = %d
                       and user_id = %d
                     order by stud_id desc
                     limit %d, %d',
                    $deck_id, $user_id,
                    $current_page * $records_per_page,
                    $records_per_page);

    $result = $mysqli->query($sql);
?>
<?php
    $header_title    = car_t($t, 'Studies') . ' - Play Flashcards';
    $dash_active     = 'decks';
    $dash_deck_key   = $deck_key;
    $dash_breadcrumb = [
        [car_t($t, 'Decks'), CAR_PATH_WEB . '/dash/deck-list'],
        [$deck_name, CAR_PATH_WEB . '/dash/deck?k=' . $deck_key],
        [car_t($t, 'Studies')]
    ];
    include_once CAR_ROOT_WEB . '/dash/header.inc';
?>

<div>

    <?php include_once CAR_ROOT_WEB . '/containers/message.inc'; ?>

    <div class="d-flex justify-content-between align-items-center mb-4 gap-3 flex-wrap">
        <div>
            <h1 class="h3 fw-semibold mb-1"><?= car_t($t, 'Studies') ?></h1>
            <a href="<?= CAR_PATH_WEB ?>/dash/deck?k=<?= car_htmlspecialchars($deck_key) ?>"
               class="text-secondary small text-decoration-none">
                <i class="bi bi-arrow-left" aria-hidden="true"></i>
                <?= car_htmlspecialchars($deck_name) ?>
            </a>
        </div>
    </div>

    <?php if ($result->num_rows > 0) { ?>

    <div class="card mb-4">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th class="small text-secondary fw-normal"><?= car_t($t, 'Start Date') ?></th>
                        <th class="small text-secondary fw-normal" style="width: 90px"><?= car_t($t, 'Flashcards') ?></th>
                        <th class="small text-secondary fw-normal" style="width: 130px"><?= car_t($t, 'Accuracy Rate') ?></th>
                        <th class="small text-secondary fw-normal" style="width: 110px"><?= car_t($t, 'Study Time') ?></th>
                        <th style="width: 32px"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_array(MYSQLI_ASSOC)) { ?>
                    <?php
                        $_sl_open  = empty($row['stud_end']);
                        $_sl_acc   = car_percent((int) $row['stud_true'], (int) $row['stud_total']);
                        $_sl_color = $_sl_acc < 50 ? 'bg-danger' : ($_sl_acc < 75 ? 'bg-warning' : 'bg-success');
                    ?>
                    <tr <?= $_sl_open ? 'style="cursor: pointer" onclick="location.href=\'' . CAR_PATH_WEB . '/dash/study?k=' . car_htmlspecialchars($row['stud_key']) . '\'"' : '' ?>>
                        <td class="small fw-medium car-text-mono">
                            <?= car_htmlspecialchars($row['stud_begin']) ?>
                            <?php if ($_sl_open) { ?>
                            <span class="badge ms-1"><?= car_t($t, 'dash.study-list.open') ?></span>
                            <?php } ?>
                        </td>
                        <td class="small car-text-mono"><?= (int) $row['stud_total'] ?></td>
                        <td>
                            <?php if (!$_sl_open) { ?>
                            <div class="d-flex align-items-center gap-2">
                                <div class="progress flex-shrink-0" style="width: 40px; height: 4px" role="progressbar"
                                     aria-valuenow="<?= $_sl_acc ?>" aria-valuemin="0" aria-valuemax="100">
                                    <div class="progress-bar <?= $_sl_color ?>" style="width: <?= $_sl_acc ?>%"></div>
                                </div>
                                <span class="car-text-mono small"><?= $_sl_acc ?>%</span>
                            </div>
                            <?php } else { ?>
                            <span class="small text-secondary">&mdash;</span>
                            <?php } ?>
                        </td>
                        <td class="small car-text-mono text-secondary">
                            <?= !$_sl_open ? car_diff_dates($row['stud_begin'], $row['stud_end']) : '&mdash;' ?>
                        </td>
                        <td>
                            <?php if ($_sl_open) { ?>
                            <i class="bi bi-chevron-right small text-primary" aria-hidden="true"></i>
                            <?php } ?>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>

    <?php if ($total_pages > 1) { ?>
    <nav class="mb-4" aria-label="Pagination">
        <ul class="pagination">
            <li class="page-item <?= $current_page === 0 ? 'disabled' : '' ?>">
                <a class="page-link"
                   href="<?= CAR_PATH_WEB ?>/dash/study-list?k=<?= $deck_key ?>&current_page=<?= $current_page - 1 ?>">
                    &laquo;
                </a>
            </li>
            <?php for ($page = 0; $page < $total_pages; $page++) { ?>
            <li class="page-item <?= $current_page === $page ? 'active' : '' ?>">
                <a class="page-link"
                   href="<?= CAR_PATH_WEB ?>/dash/study-list?k=<?= $deck_key ?>&current_page=<?= $page ?>">
                    <?= $page + 1 ?>
                </a>
            </li>
            <?php } ?>
            <li class="page-item <?= $current_page + 1 >= $total_pages ? 'disabled' : '' ?>">
                <a class="page-link"
                   href="<?= CAR_PATH_WEB ?>/dash/study-list?k=<?= $deck_key ?>&current_page=<?= $current_page + 1 ?>">
                    &raquo;
                </a>
            </li>
        </ul>
    </nav>
    <?php } ?>

    <?php } else { ?>

    <div class="text-center py-5 text-secondary">
        <i class="bi bi-clock-history fs-1 mb-3 d-block" aria-hidden="true"></i>
        <p class="mb-0"><?= car_t($t, 'dash.study-list.empty') ?></p>
    </div>

    <?php } ?>

</div>

        </div><!-- .car-app-page -->

    </div><!-- coluna principal -->

</div><!-- .car-app-shell -->

<?php include CAR_ROOT_WEB . '/dash/sidebar.inc'; ?>
<?php include_once CAR_ROOT_WEB . '/containers/footer.inc'; ?>
