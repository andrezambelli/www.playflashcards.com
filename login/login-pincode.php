<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/car-server.php';?>
<?php include_once CAL_ROOT_WEB . '/config.inc';?>
<?php include CAL_ROOT_WEB . '/lang/lang.inc'; ?>
<?php cal_check_login($t); ?>
<?php
    // Parâmetros
    $pincode_s = cal_get_session_attribute('pincode', ''); // pincode da sessão

    if (empty($pincode_s)) {
        cal_redirect(CAL_PATH_WEB . '/'. $t['lang'] . '/login/login');
    }

    $header_title = cal_t($t, 'login.login-pincode.title') . ' - Play Flashcards';
    $header_description = '';
    $header_index_follow = 'noindex,nofollow';
    include_once CAL_ROOT_WEB . '/include/header.inc';
?>
<div class="div-primary">
    <div class="div-start">
        <h1><?= cal_t($t, 'login.login-pincode.title'); ?></h1>
        <?php include_once CAL_ROOT_WEB . '/include/message.inc' ?>
        <div class="space"></div>
        <div class="form">
            <form action="<?= CAL_PATH_WEB . '/login/login-pincode-act'; ?>" method="post">
                <?= cal_t($t, 'Enter the Code'); ?>:<br/>
                <input type="text" name="pincode" id="pincode" placeholder="<?= cal_t($t, 'Code'); ?>" value="" maxlength="6" class="input w75" /><br/>
                <div class="space"></div>
                <div class="tip"><?= cal_t($t, 'login.login-pincode.message1'); ?></div>
                <div class="tip"><?= cal_t($t, 'login.login-pincode.message2'); ?></div>
                <div class="space"></div>
                <input type="submit" class="buttonx" value="<?= cal_t($t, 'Check the Code'); ?>"/>
            </form>
            <a href="<?= cal_get_base_url(CAL_PATH_WEB) . '/'. $t['lang'] . '/login/login'; ?>"><?= cal_t($t, 'login.login-pincode.resend'); ?></a>
        </div>
    </div>
</div>
<div class="div-secondary">
    <!-- -->
</div>
<?php include_once CAL_ROOT_WEB . '/include/footer.inc';?>
