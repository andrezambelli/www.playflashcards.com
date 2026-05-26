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

    // total de cartões
    $sql = sprintf('select count(*) as count
                      from car_card
                     where deck_id = %d
                       and user_id = %d',
                    $deck_id,
                    $user_id);
    $result_count = $mysqli->query($sql);
    while ($row = $result_count->fetch_array(MYSQLI_ASSOC)) {
        $total_records = $row['count'];
    }

    $total_pages = ceil($total_records / $records_per_page);

    // lista de cartões
    $sql = sprintf('select card_key,
                           card_front,
                           card_back,
                           card_true,
                           card_false
                      from car_card
                     where deck_id = %d
                       and user_id = %d
                     order by card_front
                     limit %d, %d',
                    $deck_id, $user_id,
                    $current_page * $records_per_page,
                    $records_per_page);

    $result = $mysqli->query($sql);
?>
<?php
    $header_title    = car_htmlspecialchars($deck_name) . ' - Play Flashcards';
    $dash_active     = 'decks';
    $dash_deck_key   = $deck_key;
    $dash_breadcrumb = [
        [car_t($t, 'Decks'), CAR_PATH_WEB . '/dash/deck-list'],
        [$deck_name, CAR_PATH_WEB . '/dash/deck?k=' . $deck_key],
        [car_t($t, 'Flashcards')]
    ];
    include_once CAR_ROOT_WEB . '/dash/header.inc';
?>

<div>

    <?php include_once CAR_ROOT_WEB . '/containers/message.inc'; ?>

    <div class="d-flex justify-content-between align-items-center mb-4 gap-3 flex-wrap">
        <div>
            <h1 class="h3 fw-semibold mb-1"><?= car_t($t, 'Flashcards') ?></h1>
            <a href="<?= CAR_PATH_WEB ?>/dash/deck?k=<?= car_htmlspecialchars($deck_key) ?>"
           class="text-secondary small text-decoration-none">
            <i class="bi bi-arrow-left" aria-hidden="true"></i>
            <?= car_htmlspecialchars($deck_name) ?>
        </a>
        </div>
        <a href="<?= CAR_PATH_WEB ?>/dash/card-new?k=<?= car_htmlspecialchars($deck_key) ?>"
           class="btn btn-primary flex-shrink-0">
            <i class="bi bi-plus" aria-hidden="true"></i>
            <?= car_t($t, 'New Flashcard') ?>
        </a>
    </div>

    <?php if ($result->num_rows > 0) { ?>

        <div class="card mb-4">
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
                        <?php while ($row = $result->fetch_array(MYSQLI_ASSOC)) { ?>
                        <?php
                            $_cl_attempts = (int) $row['card_true'] + (int) $row['card_false'];
                            $_cl_acc      = car_percent((int) $row['card_true'], $_cl_attempts);
                            $_cl_color    = $_cl_acc < 50 ? 'bg-danger' : ($_cl_acc < 75 ? 'bg-warning' : 'bg-success');
                        ?>
                        <tr style="cursor: pointer" onclick="location.href='<?= CAR_PATH_WEB ?>/dash/card-edit?k=<?= car_htmlspecialchars($row['card_key']) ?>'">
                            <td class="small fw-medium"><?= car_htmlspecialchars($row['card_front']) ?></td>
                            <td class="small text-secondary"><?= car_htmlspecialchars($row['card_back']) ?></td>
                            <td>
                                <?php if ($_cl_attempts > 0) { ?>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="progress flex-shrink-0" style="width: 40px; height: 4px" role="progressbar" aria-valuenow="<?= $_cl_acc ?>" aria-valuemin="0" aria-valuemax="100">
                                        <div class="progress-bar <?= $_cl_color ?>" style="width: <?= $_cl_acc ?>%"></div>
                                    </div>
                                    <span class="car-text-mono small"><?= $_cl_acc ?>%</span>
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
        </div>

        <?php if ($total_pages > 1) { ?>
        <nav class="mb-4" aria-label="Pagination">
            <ul class="pagination">
                <li class="page-item <?= $current_page === 0 ? 'disabled' : '' ?>">
                    <a class="page-link"
                       href="<?= CAR_PATH_WEB ?>/dash/card-list?k=<?= $deck_key ?>&current_page=<?= $current_page - 1 ?>">
                        &laquo;
                    </a>
                </li>
                <?php for ($page = 0; $page < $total_pages; $page++) { ?>
                <li class="page-item <?= $current_page === $page ? 'active' : '' ?>">
                    <a class="page-link"
                       href="<?= CAR_PATH_WEB ?>/dash/card-list?k=<?= $deck_key ?>&current_page=<?= $page ?>">
                        <?= $page + 1 ?>
                    </a>
                </li>
                <?php } ?>
                <li class="page-item <?= $current_page + 1 >= $total_pages ? 'disabled' : '' ?>">
                    <a class="page-link"
                       href="<?= CAR_PATH_WEB ?>/dash/card-list?k=<?= $deck_key ?>&current_page=<?= $current_page + 1 ?>">
                        &raquo;
                    </a>
                </li>
            </ul>
        </nav>
        <?php } ?>

    <?php } else { ?>

        <div class="text-center py-5 text-secondary mb-4">
            <i class="bi bi-collection fs-1 mb-3 d-block" aria-hidden="true"></i>
            <p class="mb-3"><?= car_t($t, 'This deck has no flashcards.') ?></p>
            <a href="<?= CAR_PATH_WEB ?>/dash/card-new?k=<?= car_htmlspecialchars($deck_key) ?>"
               class="btn btn-primary">
                <i class="bi bi-plus" aria-hidden="true"></i>
                <?= car_t($t, 'New Flashcard') ?>
            </a>
        </div>

    <?php } ?>

    <!-- Exportar e importar -->
    <div class="card">
        <div class="card-header">
            <div class="fw-medium"><?= car_t($t, 'Export and Import') ?></div>
        </div>
        <div class="card-body d-flex flex-column gap-3">
            <div class="d-flex justify-content-between align-items-center gap-3 flex-wrap">
                <div class="small text-secondary"><?= car_t($t, 'dash.card-list.export') ?></div>
                <a href="<?= CAR_PATH_WEB ?>/dash/card-download-act?k=<?= car_htmlspecialchars($deck_key) ?>"
                   class="btn btn-outline-secondary btn-sm flex-shrink-0">
                    <?= car_t($t, 'Export') ?>
                </a>
            </div>
            <div class="d-flex justify-content-between align-items-center gap-3 flex-wrap">
                <div class="small text-secondary"><?= car_t($t, 'dash.card-list.import') ?></div>
                <form id="upload_form" action="<?= CAR_PATH_WEB ?>/dash/card-upload-act" method="post" enctype="multipart/form-data">
                    <input type="file" id="input_file" name="input_file" class="d-none">
                    <input type="hidden" name="k" value="<?= car_htmlspecialchars($deck_key) ?>">
                    <label for="input_file" class="btn btn-outline-secondary btn-sm">
                        <?= car_t($t, 'Import') ?>
                    </label>
                </form>
            </div>
        </div>
    </div>

</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    document.getElementById('input_file').addEventListener('change', function () {
        document.getElementById('upload_form').submit();
    });
});
</script>

        </div><!-- .car-app-page -->

    </div><!-- coluna principal -->

</div><!-- .car-app-shell -->

<?php include CAR_ROOT_WEB . '/dash/sidebar.inc'; ?>
<?php include_once CAR_ROOT_WEB . '/containers/footer.inc'; ?>
