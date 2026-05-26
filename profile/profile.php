<?php /** @var array $t */ ?>
<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/car-server.php'; ?>
<?php include_once CAR_ROOT_WEB . '/config.inc'; ?>
<?php include CAR_ROOT_WEB . '/lang/lang.inc'; ?>
<?php car_check_login($t); ?>
<?php
    car_set_session_attribute('read_database', 'on');

    $user_id = car_get_session_attribute('user_id', 0);

    $user_email  = '';
    $user_lang   = '';
    $user_create = '';

    $timezone = car_get_session_attribute('timezone', CAR_TIMEZONE_DEFAULT);
    $sql = sprintf("set time_zone = '%s'", $timezone);
    $mysqli->query($sql);

    $sql = sprintf('select user_email,
                           user_lang,
                           user_create
                      from car_user
                     where user_id = %d',
                    $user_id);
    $result = $mysqli->query($sql);
    while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
        $user_email  = $row['user_email'];
        $user_lang   = $row['user_lang'];
        $user_create = $row['user_create'];
    }

    // formata data de criação: "Aug 2023"
    $member_since = '';
    if (!empty($user_create)) {
        $member_since = date('M Y', strtotime($user_create));
    }
?>
<?php
    $header_title      = car_t($t, 'Profile') . ' - Play Flashcards';
    $dash_active       = 'profile';
    $dash_breadcrumb   = [[car_t($t, 'Profile')]];
    include_once CAR_ROOT_WEB . '/dash/header.inc';
?>

<div style="max-width: 720px">

    <?php include_once CAR_ROOT_WEB . '/containers/message.inc'; ?>

    <h1 class="h3 fw-semibold mb-1"><?= car_t($t, 'Profile') ?></h1>
    <p class="text-secondary small mb-4"><?= car_t($t, 'Preferences') ?> &amp; <?= car_t($t, 'Stats') ?></p>

    <!-- Preferências -->
    <div class="card mb-3">
        <div class="card-header"><?= car_t($t, 'Preferences') ?></div>
        <div class="card-body">
            <div class="row g-3 align-items-center">

                <div class="col-md-4 form-label mb-0"><?= car_t($t, 'Email') ?></div>
                <div class="col-md-8 small"><?= car_htmlspecialchars($user_email) ?></div>

                <div class="col-md-4 form-label mb-0"><?= car_t($t, 'Language') ?></div>
                <div class="col-md-8">
                    <form id="lang-form" action="<?= CAR_PATH_WEB ?>/services/change-language-act" method="get">
                        <input type="hidden" name="redirect_url" value="<?= CAR_PATH_WEB ?>/profile/profile">
                        <select id="lang-select" name="lang" class="form-select form-select-sm" style="max-width: 280px">
                            <option value="en"    <?= $user_lang === 'en'    ? 'selected' : '' ?>>English</option>
                            <option value="pt-br" <?= $user_lang === 'pt-br' ? 'selected' : '' ?>>Português (Brasil)</option>
                            <option value="es"    <?= $user_lang === 'es'    ? 'selected' : '' ?>>Español</option>
                            <option value="fr"    <?= $user_lang === 'fr'    ? 'selected' : '' ?>>Français</option>
                        </select>
                    </form>
                </div>

                <div class="col-md-4 form-label mb-0"><?= car_t($t, 'Timezone') ?></div>
                <div class="col-md-8 small car-text-mono">GMT<?= car_htmlspecialchars($timezone) ?></div>

            </div>
        </div>
    </div>

    <!-- Stats -->
    <div class="card mb-4">
        <div class="card-header"><?= car_t($t, 'Stats') ?></div>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-3 col-6">
                    <div class="car-label-uc mb-1"><?= car_t($t, 'profile.stats.sessions') ?></div>
                    <div class="car-text-mono fw-500" style="font-size: 1.375rem; font-weight: 500">—</div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="car-label-uc mb-1"><?= car_t($t, 'profile.stats.cards') ?></div>
                    <div class="car-text-mono" style="font-size: 1.375rem; font-weight: 500">—</div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="car-label-uc mb-1"><?= car_t($t, 'profile.stats.accuracy') ?></div>
                    <div class="car-text-mono" style="font-size: 1.375rem; font-weight: 500">—</div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="car-label-uc mb-1"><?= car_t($t, 'profile.stats.member-since') ?></div>
                    <div class="car-text-mono" style="font-size: 1.375rem; font-weight: 500"><?= car_htmlspecialchars($member_since) ?></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Sign out -->
    <div class="d-flex justify-content-between align-items-center gap-3 py-3 border-top">
        <div>
            <div class="fw-semibold small"><?= car_t($t, 'Sign Out') ?></div>
            <div class="form-text mt-1"><?= car_t($t, 'profile.account.signout-desc') ?></div>
        </div>
        <a href="<?= CAR_PATH_WEB ?>/login/logoff-act"
           class="btn btn-outline-secondary flex-shrink-0">
            <i class="bi bi-box-arrow-right" aria-hidden="true"></i>
            <?= car_t($t, 'Sign Out') ?>
        </a>
    </div>

    <!-- Excluir conta -->
    <div class="d-flex justify-content-between align-items-start gap-3 py-3 border-top">
        <div>
            <div class="fw-semibold small text-danger-emphasis"><?= car_t($t, 'Delete your Account') ?></div>
            <div class="form-text mt-1" style="max-width: 480px"><?= car_t($t, 'profile.profile-delete.warning') ?></div>
        </div>
        <a href="<?= CAR_PATH_WEB ?>/profile/profile-delete"
           class="btn btn-outline-danger flex-shrink-0">
            <i class="bi bi-trash" aria-hidden="true"></i>
            <?= car_t($t, 'Delete') ?>
        </a>
    </div>

</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    document.getElementById('lang-select').addEventListener('change', function () {
        document.getElementById('lang-form').submit();
    });
});
</script>

<?php include_once CAR_ROOT_WEB . '/dash/footer.inc'; ?>
