<?php /** @var array $t */ ?>
<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/car-server.php'; ?>
<?php include_once CAR_ROOT_WEB . '/config.inc'; ?>
<?php include CAR_ROOT_WEB . '/lang/lang.inc'; ?>
<?php car_check_login($t); ?>
<?php
    $user_id       = car_get_session_attribute('user_id', 0);
    $read_database = car_get_session_attribute('read_database', 'on');
?>
<?php
    $header_title    = car_t($t, 'Delete your Account') . ' - Play Flashcards';
    $dash_active     = 'profile';
    $dash_breadcrumb = [[car_t($t, 'Profile'), CAR_PATH_WEB . '/profile/profile'], [car_t($t, 'Delete your Account')]];
    include_once CAR_ROOT_WEB . '/dash/containers/header.inc';
?>

<div style="max-width: 560px">

    <?php include_once CAR_ROOT_WEB . '/containers/message.inc'; ?>

    <h1 class="h3 fw-semibold mb-1"><?= car_t($t, 'Delete your Account') ?></h1>
    <p class="text-secondary small mb-4"><?= car_t($t, 'profile.profile-delete.question') ?></p>

    <div class="card border-danger-subtle">
        <div class="card-body">
            <p class="small text-secondary mb-4">
                <span class="fw-semibold text-danger-emphasis"><?= car_t($t, 'Warning') ?>:</span>
                <?= car_t($t, 'profile.profile-delete.warning') ?>
            </p>
            <div class="d-flex gap-2">
                <a href="<?= CAR_PATH_WEB ?>/profile/profile" class="btn btn-outline-secondary">
                    <?= car_t($t, 'Cancel') ?>
                </a>
                <form method="post" action="<?= CAR_PATH_WEB ?>/profile/profile-delete-act">
                    <button type="submit" class="btn btn-danger">
                        <i class="bi bi-trash" aria-hidden="true"></i>
                        <?= car_t($t, 'Yes') ?>, <?= car_t($t, 'Delete') ?>
                    </button>
                </form>
            </div>
        </div>
    </div>

</div>

<?php include_once CAR_ROOT_WEB . '/dash/containers/footer.inc'; ?>
