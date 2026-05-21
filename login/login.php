<?php /** @var array $t */ ?>
<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/car-server.php';?>
<?php include_once CAR_ROOT_WEB . '/config.inc';?>
<?php include CAR_ROOT_WEB . '/lang/lang.inc'; ?>
<?php car_check_language($t['lang']); ?>
<?php
    car_check_login($t);

    // Parâmetros
    $email = car_get_session_attribute('email', '');

    // Variáveis
    $redirect_url = '';

    if (isset($_GET['redirect_url'])) $redirect_url = trim($_GET['redirect_url']);
?>
<?php
    $header_title = car_t($t, 'login.login.title') .' - Play Flashcards';
    $header_description = car_t($t, 'login.login.desc');
    $header_index_follow = 'index,follow';
    include_once CAR_ROOT_WEB . '/containers/header.inc';
?>
<div class="div-primary">
    <div class="div-start">
        <?php include_once CAR_ROOT_WEB . '/containers/message.inc' ?>
        <div class="form">
            <form action="<?= CAR_PATH_WEB . '/login/login-act'; ?>" method="post">
                <input type="hidden" name="redirect_url" value="<?= car_htmlspecialchars($redirect_url); ?>" />
                <?= car_t($t, 'Enter your email'); ?>:<br/>
                <input type="text" name="email" id="email" value="<?= car_htmlspecialchars($email); ?>" maxlength="255" class="input w300" placeholder="<?= car_t($t, 'Email address'); ?>" />
                <div class="space"></div>
                <div class="tip"><?= car_t($t, 'login.login.message1'); ?></div>
                <div class="tip"><?= car_t($t, 'login.login.message2'); ?></div>
                <div class="space"></div>
                <input type="submit" value="<?= car_t($t, 'Send Code'); ?>" class="buttonx"/>
            </form>
            <div class="space"></div>
            <?= car_t($t, 'login.login.message3'); ?><br/>
            <div style="width:204px;">
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
                     data-logo_alignment="left">
                </div>
            </div>
            <div class="space">&nbsp;</div>
            <div class="tip">
                <span class="note-text"><?= car_t($t, 'login.login.privacy-label'); ?></span>
                <?= sprintf(car_t($t, 'login.login.privacy'), CAR_PATH_WEB . '/'. $t['lang'] . '/privacy-policy', CAR_PATH_WEB . '/'. $t['lang'] . '/terms-and-conditions'); ?>
            </div>
        </div>
    </div>
</div>
<div class="div-secondary">
    <?php include_once CAR_ROOT_WEB . '/containers/box-follow-decks.inc'; ?>
</div>
<?php include_once CAR_ROOT_WEB . '/containers/footer.inc';?>
