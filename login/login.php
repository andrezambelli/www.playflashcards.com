<?php /** @var array $t */ ?>
<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/car-server.php';?>
<?php include_once CAR_ROOT_WEB . '/config.inc';?>
<?php include CAR_ROOT_WEB . '/lang/lang.inc'; ?>
<?php car_check_language($t['lang']); ?>
<?php
    car_check_login($t);

    // se já existe código pendente com cooldown ativo, redireciona para pincode
    $sent_at = (int) car_get_session_attribute('code_sent_at', 0);
    if (!empty(car_get_session_attribute('pincode', '')) && $sent_at > 0 && (time() - $sent_at) < 60) {
        car_redirect(CAR_PATH_WEB . '/login/login-pincode');
    }

    $email = car_get_session_attribute('email', '');

    $redirect_url = '';
    if (isset($_GET['redirect_url'])) $redirect_url = trim($_GET['redirect_url']);
?>
<?php
    $header_title       = car_t($t, 'login.login.title') . ' - Play Flashcards';
    $header_description = car_t($t, 'login.login.desc');
    $header_index_follow = 'index,follow';
    include_once CAR_ROOT_WEB . '/containers/header.inc';
?>

<div class="car-auth-wrap">
    <div class="car-auth-panel">

        <!-- formulário -->
        <div class="car-auth-form">
            <?php include_once CAR_ROOT_WEB . '/containers/message.inc' ?>

            <div class="car-label-uc mb-2"><?= car_t($t, 'login.login.label') ?></div>
            <h1 class="mb-0" style="font-size:2rem"><?= car_t($t, 'login.login.heading') ?></h1>
            <p class="text-secondary mt-2 mb-4"><?= car_t($t, 'login.login.subtitle') ?></p>

            <form action="<?= CAR_PATH_WEB . '/login/login-act'; ?>" method="post">
                <input type="hidden" name="redirect_url" value="<?= car_htmlspecialchars($redirect_url); ?>" />
                <div class="mb-3">
                    <label class="form-label" for="email"><?= car_t($t, 'Email') ?></label>
                    <input type="email"
                           name="email"
                           id="email"
                           value="<?= car_htmlspecialchars($email); ?>"
                           maxlength="255"
                           class="form-control form-control-lg"
                           placeholder="<?= car_t($t, 'Email address') ?>"
                           style="font-size:0.875rem" />
                </div>
                <button type="submit" class="btn btn-primary btn-lg w-100">
                    <i class="bi bi-envelope" aria-hidden="true"></i>
                    <?= car_t($t, 'Send Code') ?>
                </button>
            </form>

            <!-- divisor -->
            <div class="d-flex align-items-center gap-3 my-4">
                <div class="flex-grow-1 border-top"></div>
                <span class="small text-secondary"><?= car_t($t, 'or') ?></span>
                <div class="flex-grow-1 border-top"></div>
            </div>

            <!-- Google Sign-In -->
            <script src="https://accounts.google.com/gsi/client" async defer></script>
            <div id="g_id_onload"
                 data-client_id="<?= CAR_GOOGLE_CLIENT_ID; ?>"
                 data-login_uri="<?= CAR_PATH_WEB . '/login/login-google-act?redirect_url=' . car_htmlspecialchars($redirect_url); ?>"
                 data-auto_prompt="false">
            </div>
            <div class="g_id_signin"
                 data-type="standard"
                 data-size="large"
                 data-theme="outline"
                 data-text="sign_in_with"
                 data-shape="rectangular"
                 data-logo_alignment="left"
                 data-width="420">
            </div>

            <!-- nota de privacidade (usa $t diretamente para preservar as tags <a> da tradução) -->
            <p class="form-text mt-4">
                <?= sprintf($t['login.login.privacy'] ?? '', CAR_PATH_WEB . '/'. $t['lang'] . '/privacy-policy', CAR_PATH_WEB . '/'. $t['lang'] . '/terms-and-conditions'); ?>
            </p>
        </div>

    </div>
</div>

<?php include_once CAR_ROOT_WEB . '/containers/footer.inc'; ?>
