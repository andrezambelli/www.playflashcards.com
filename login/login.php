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

    // csrf state para oauth do google
    $google_state = bin2hex(random_bytes(16));
    car_set_session_attribute('google_oauth_state', $google_state);
    car_set_session_attribute('google_redirect_url', $redirect_url);
    // cookie para sobreviver à mudança de domínio no redirect do Google (localhost <-> playflashcards.localhost)
    setcookie('car_google_state', $google_state, [
        'expires'  => time() + 300,
        'path'     => '/',
        'domain'   => car_is_localhost() ? '.localhost' : '',
        'httponly' => true,
        'samesite' => 'Lax',
    ]);
    $google_base_url = car_get_base_url(CAR_PATH_WEB);
    $google_auth_url = '';
    if (defined('CAR_GOOGLE_CLIENT_ID') && defined('CAR_GOOGLE_CLIENT_SECRET')) {
        $google_auth_url = 'https://accounts.google.com/o/oauth2/v2/auth?' . http_build_query([
            'client_id'     => CAR_GOOGLE_CLIENT_ID,
            'redirect_uri'  => $google_base_url . '/login/login-google-act',
            'response_type' => 'code',
            'scope'         => 'openid email',
            'state'         => $google_state,
        ]);
    }
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
                           autocomplete="email"
                           style="font-size:0.875rem" />
                </div>
                <button type="submit" class="btn btn-primary btn-lg w-100">
                    <i class="bi bi-envelope" aria-hidden="true"></i>
                    <?= car_t($t, 'Send Code') ?>
                </button>
            </form>

            <?php if (!empty($google_auth_url)) { ?>
                <!-- divisor -->
                <div class="d-flex align-items-center gap-3 my-4">
                    <div class="flex-grow-1 border-top"></div>
                    <span class="small text-secondary"><?= car_t($t, 'or') ?></span>
                    <div class="flex-grow-1 border-top"></div>
                </div>

                <!-- google sign-in -->
                <a href="<?= car_htmlspecialchars($google_auth_url) ?>"
                   class="btn btn-outline-secondary btn-lg w-100 d-flex align-items-center justify-content-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 48 48" aria-hidden="true">
                        <path fill="#EA4335" d="M24 9.5c3.54 0 6.71 1.22 9.21 3.6l6.85-6.85C35.9 2.38 30.47 0 24 0 14.62 0 6.51 5.38 2.56 13.22l7.98 6.19C12.43 13.72 17.74 9.5 24 9.5z"/>
                        <path fill="#4285F4" d="M46.98 24.55c0-1.57-.15-3.09-.38-4.55H24v9.02h12.94c-.58 2.96-2.26 5.48-4.78 7.18l7.73 6c4.51-4.18 7.09-10.36 7.09-17.65z"/>
                        <path fill="#FBBC05" d="M10.53 28.59c-.48-1.45-.76-2.99-.76-4.59s.27-3.14.76-4.59l-7.98-6.19C.92 16.46 0 20.12 0 24c0 3.88.92 7.54 2.56 10.78l7.97-6.19z"/>
                        <path fill="#34A853" d="M24 48c6.48 0 11.93-2.13 15.89-5.81l-7.73-6c-2.18 1.48-4.97 2.36-8.16 2.36-6.26 0-11.57-4.22-13.47-9.91l-7.98 6.19C6.51 42.62 14.62 48 24 48z"/>
                    </svg>
                    <?= car_t($t, 'login.login.google-btn') ?>
                </a>
            <?php } ?>

            <!-- nota de privacidade (usa $t diretamente para preservar as tags <a> da tradução) -->
            <p class="form-text mt-4">
                <?= sprintf($t['login.login.privacy'] ?? '', CAR_PATH_WEB . '/'. $t['lang'] . '/terms-and-conditions', CAR_PATH_WEB . '/'. $t['lang'] . '/privacy-policy'); ?>
            </p>
        </div>

    </div>
</div>

<?php include_once CAR_ROOT_WEB . '/containers/footer.inc'; ?>
