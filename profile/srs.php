<?php /** @var array $t */ ?>
<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/car-server.php'; ?>
<?php include_once CAR_ROOT_WEB . '/config.inc'; ?>
<?php include CAR_ROOT_WEB . '/lang/lang.inc'; ?>
<?php car_check_login($t); ?>
<?php
    $user_id       = car_get_session_attribute('user_id', 0);
    $read_database = car_get_session_attribute('read_database', 'on');

    $srs_limit    = CAR_USER_SRS_LIMIT;
    $srs_sequence = CAR_USER_SRS_SEQUENCE;
    $srs_rate     = CAR_USER_SRS_RATE;
    $srs_days     = CAR_USER_SRS_DAYS;

    car_set_session_attribute('read_database', 'on');

    if ($read_database == 'on') {
        $sql = sprintf('select user_srs_limit,
                               user_srs_rate,
                               user_srs_sequence,
                               user_srs_days
                          from car_user
                         where user_id = %d',
                        $user_id);
        $result = $mysqli->query($sql);
        while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
            $srs_limit    = $row['user_srs_limit'];
            $srs_sequence = $row['user_srs_sequence'];
            $srs_rate     = $row['user_srs_rate'];
            $srs_days     = $row['user_srs_days'];
        }
    } else {
        $srs_limit    = car_get_session_attribute('srs_limit',    CAR_USER_SRS_LIMIT);
        $srs_sequence = car_get_session_attribute('srs_sequence', CAR_USER_SRS_SEQUENCE);
        $srs_rate     = car_get_session_attribute('srs_rate',     CAR_USER_SRS_RATE);
        $srs_days     = car_get_session_attribute('srs_days',     CAR_USER_SRS_DAYS);
    }
?>
<?php
    $header_title    = car_t($t, 'Spaced Repetition System (SRS)') . ' - Play Flashcards';
    $dash_active     = 'srs';
    $dash_breadcrumb = [[car_t($t, 'SRS')]];
    include_once CAR_ROOT_WEB . '/dash/header.inc';
?>

<div style="max-width: 680px">

    <?php include_once CAR_ROOT_WEB . '/containers/message.inc'; ?>

    <h1 class="h3 fw-semibold mb-1"><?= car_t($t, 'Spaced Repetition System (SRS)') ?></h1>
    <p class="text-secondary small mb-4"><?= car_t($t, 'profile.srs.definition') ?></p>

    <div class="card mb-4">
        <div class="card-body">
            <div class="fw-semibold small mb-1"><?= car_t($t, 'profile.srs.pending-title') ?></div>
            <p class="form-text mb-0"><?= car_t($t, 'profile.srs.pending-rule') ?></p>
        </div>
    </div>

    <form id="srs-form" action="<?= CAR_PATH_WEB ?>/profile/srs-act" method="post">
        <div class="d-flex flex-column gap-2 mb-3">

            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-baseline gap-2 mb-1">
                        <div class="fw-semibold small"><?= car_t($t, 'Number of Cards per Study Session') ?></div>
                        <div class="d-flex align-items-baseline gap-1 flex-shrink-0">
                            <span id="srs_limit_val" class="car-text-mono" style="font-size: 1.375rem; font-weight: 500"><?= (int) $srs_limit ?></span>
                            <span class="small text-secondary"><?= car_t($t, 'profile.srs.unit-cards') ?></span>
                        </div>
                    </div>
                    <div class="form-text mb-3"><?= car_t($t, 'profile.srs.limit-definition') ?></div>
                    <input type="range" id="srs_limit" name="srs_limit"
                           min="1" max="50" value="<?= (int) $srs_limit ?>"
                           class="form-range">
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-baseline gap-2 mb-1">
                        <div class="fw-semibold small"><?= car_t($t, 'Accuracy Rate') ?></div>
                        <div class="d-flex align-items-baseline gap-1 flex-shrink-0">
                            <span id="srs_rate_val" class="car-text-mono" style="font-size: 1.375rem; font-weight: 500"><?= (int) $srs_rate ?></span>
                            <span class="small text-secondary">%</span>
                        </div>
                    </div>
                    <div class="form-text mb-3"><?= car_t($t, 'profile.srs.rate-definition') ?></div>
                    <input type="range" id="srs_rate" name="srs_rate"
                           min="1" max="100" value="<?= (int) $srs_rate ?>"
                           class="form-range">
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-baseline gap-2 mb-1">
                        <div class="fw-semibold small"><?= car_t($t, 'Correct Answers in Sequence') ?></div>
                        <div class="d-flex align-items-baseline gap-1 flex-shrink-0">
                            <span id="srs_sequence_val" class="car-text-mono" style="font-size: 1.375rem; font-weight: 500"><?= (int) $srs_sequence ?></span>
                            <span class="small text-secondary"><?= car_t($t, 'profile.srs.unit-sessions') ?></span>
                        </div>
                    </div>
                    <div class="form-text mb-3"><?= car_t($t, 'profile.srs.sequence-definition') ?></div>
                    <input type="range" id="srs_sequence" name="srs_sequence"
                           min="0" max="20" value="<?= (int) $srs_sequence ?>"
                           class="form-range">
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-baseline gap-2 mb-1">
                        <div class="fw-semibold small"><?= car_t($t, 'Periodic Flashcard Revitalization') ?></div>
                        <div class="d-flex align-items-baseline gap-1 flex-shrink-0">
                            <span id="srs_days_val" class="car-text-mono" style="font-size: 1.375rem; font-weight: 500"><?= (int) $srs_days ?></span>
                            <span class="small text-secondary"><?= car_t($t, 'days') ?></span>
                        </div>
                    </div>
                    <div class="form-text mb-3"><?= car_t($t, 'profile.srs.days-definition') ?></div>
                    <input type="range" id="srs_days" name="srs_days"
                           min="0" max="60" value="<?= (int) $srs_days ?>"
                           class="form-range">
                </div>
            </div>

        </div>

        <div class="d-flex gap-2 justify-content-end">
            <button type="button" id="srs-reset" class="btn btn-link text-secondary text-decoration-none">
                <i class="bi bi-arrow-counterclockwise" aria-hidden="true"></i>
                <?= car_t($t, 'Restore Default Values') ?>
            </button>
            <button type="submit" class="btn btn-primary">
                <?= car_t($t, 'Save') ?>
            </button>
        </div>
    </form>

</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    var fields = ['srs_limit', 'srs_rate', 'srs_sequence', 'srs_days'];

    fields.forEach(function (id) {
        var slider  = document.getElementById(id);
        var display = document.getElementById(id + '_val');
        slider.addEventListener('input', function () {
            display.textContent = slider.value;
        });
    });

    document.getElementById('srs-reset').addEventListener('click', function () {
        document.getElementById('srs_limit').value    = <?= CAR_USER_SRS_LIMIT ?>;
        document.getElementById('srs_rate').value     = <?= CAR_USER_SRS_RATE ?>;
        document.getElementById('srs_sequence').value = <?= CAR_USER_SRS_SEQUENCE ?>;
        document.getElementById('srs_days').value     = <?= CAR_USER_SRS_DAYS ?>;

        document.getElementById('srs_limit_val').textContent    = <?= CAR_USER_SRS_LIMIT ?>;
        document.getElementById('srs_rate_val').textContent     = <?= CAR_USER_SRS_RATE ?>;
        document.getElementById('srs_sequence_val').textContent = <?= CAR_USER_SRS_SEQUENCE ?>;
        document.getElementById('srs_days_val').textContent     = <?= CAR_USER_SRS_DAYS ?>;

        document.getElementById('srs-form').submit();
    });
});
</script>

        </div><!-- .car-app-page -->

    </div><!-- coluna principal -->

</div><!-- .car-app-shell -->

<?php include CAR_ROOT_WEB . '/dash/sidebar.inc'; ?>
<?php include_once CAR_ROOT_WEB . '/containers/footer.inc'; ?>
