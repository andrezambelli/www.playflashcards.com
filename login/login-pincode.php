<?php /** @var array $t */ ?>
<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/car-server.php';?>
<?php include_once CAR_ROOT_WEB . '/config.inc';?>
<?php include CAR_ROOT_WEB . '/lang/lang.inc'; ?>
<?php car_check_login($t); ?>
<?php
    // Parâmetros
    $pincode_s = car_get_session_attribute('pincode', ''); // pincode da sessão

    if (empty($pincode_s)) {
        car_redirect(CAR_PATH_WEB . '/'. $t['lang'] . '/login/login');
    }

    $header_title = car_t($t, 'login.login-pincode.title') . ' - Play Flashcards';
    $header_description = '';
    $header_index_follow = 'noindex,nofollow';
    include_once CAR_ROOT_WEB . '/containers/header.inc';
?>
<div class="div-primary">
    <div class="div-start">
        <h1><?= car_t($t, 'login.login-pincode.title'); ?></h1>
        <?php include_once CAR_ROOT_WEB . '/containers/message.inc' ?>
        <div class="space"></div>
        <div class="form">
            <form action="<?= CAR_PATH_WEB . '/login/login-pincode-act'; ?>" method="post">
                <?= car_t($t, 'Enter the Code'); ?>:<br/>
                <input type="text" name="pincode" id="pincode" placeholder="<?= car_t($t, 'Code'); ?>" value="" maxlength="6" class="input w75" /><br/>
                <div class="space"></div>
                <div class="tip"><?= car_t($t, 'login.login-pincode.message1'); ?></div>
                <div class="tip"><?= car_t($t, 'login.login-pincode.message2'); ?></div>
                <div class="space"></div>
                <input type="submit" class="buttonx" value="<?= car_t($t, 'Check the Code'); ?>"/>
            </form>
            <a href="<?= car_get_base_url(CAR_PATH_WEB) . '/'. $t['lang'] . '/login/login'; ?>"><?= car_t($t, 'login.login-pincode.resend'); ?></a>
        </div>
    </div>
</div>
<div class="div-secondary">
    <!-- -->
</div>
<?php include_once CAR_ROOT_WEB . '/containers/footer.inc';?>
