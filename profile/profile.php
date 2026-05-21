<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/car-server.php' ;?>
<?php include_once CAL_ROOT_WEB . '/config.inc' ;?>
<?php include CAL_ROOT_WEB . '/lang/lang.inc'; ?>
<?php cal_check_login($t); ?>
<?php
    cal_set_session_attribute('read_database', 'on');

    // Parâmetros
    $user_id = cal_get_session_attribute('user_id', 0);
    $timezone = cal_get_session_attribute('timezone', CAL_TIMEZONE_DEFAULT);

    // Variáveis
    $user_email = '';
    $user_lang = '';
    $user_create = '';

    // Ajustando o timezone do banco de dados
    $timezone = cal_get_session_attribute('timezone', CAL_TIMEZONE_DEFAULT);
    $sql = sprintf("SET time_zone = '%s'", $timezone);
    $mysqli->query($sql);

    // Procurando informações do usuário
    $sql = sprintf("select user_email, user_lang, user_create from car_user where user_id = %d",
                    $user_id);

    $result = $mysqli->query($sql);

    while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
        $user_email = $row['user_email'];
        $user_lang = $row['user_lang'];
        $user_create = $row['user_create'];
    }
?>
<?php
    $header_title = cal_t($t, 'Profile') . ' - Play Flashcards';
    $header_description = '';
    $header_index_follow = 'noindex,nofollow';
    include_once CAL_ROOT_WEB . '/containers/header.inc';
?>
<script>
    $(document).ready(function() {
        // Quando o valor do select mudar
        $('#user_lang_select').change(function() {
            // Submete o formulário quando a seleção muda
            $('#main_form').submit();
        });
    });
</script>
<div class="div-primary">
    <div class="div-start">
        <?php include_once CAL_ROOT_WEB . '/containers/message.inc' ?>
        <div class="title">
            <?= cal_t($t, 'Profile'); ?>
        </div>
        <div class="stats-title"><?= cal_t($t, 'Email'); ?>:</div>
        <div class="stats-value"><?= cal_htmlspecialchars($user_email); ?></div>
        <div class="stats-title"><?= cal_t($t, 'Lang'); ?>:</div>
        <div class="stats-value">
            <form id="main_form" action="<?= CAL_PATH_WEB . '/services/change-language-act'; ?>" method="post">
                <select id="user_lang_select" name="lang" class="selectx w300">
                    <option value="en" <?php if ($user_lang == 'en') { ?>selected<?php } ?>><?= cal_t($t, 'English'); ?></option>
                    <option value="pt-br" <?php if ($user_lang == 'pt-br') { ?>selected<?php } ?>><?= cal_t($t, 'Portuguese'); ?></option>
                    <option value="es" <?php if ($user_lang == 'es') { ?>selected<?php } ?>><?= cal_t($t, 'Spanish'); ?></option>
                </select>
                <input type="submit" style="display:none" />
            </form>
        </div>
        <div class="stats-title"><?= cal_t($t, 'Timezone'); ?>:</div>
        <div class="stats-value">GMT<?= cal_htmlspecialchars($timezone); ?></div>
        <div class="stats-title"><?= cal_t($t, 'Create'); ?>:</div>
        <div class="stats-value"><?= cal_htmlspecialchars($user_create); ?></div>
        <div class="space"></div>
        <div class="stats-title"><?= cal_t($t, 'Sign Out'); ?>:</div>
        <div class="stats-value">
            <a href="<?= CAL_PATH_WEB . '/login/logoff-act'; ?>" class="buttonx">
                <?= cal_t($t, 'Sign Out'); ?>
            </a>
        </div>
        <div class="space"></div>
        <div class="stats-title"><?= cal_t($t, 'Delete your Account'); ?>:</div>
        <div class="stats-value">
            <a href="../profile/profile-delete">
                <?= cal_t($t, 'Delete'); ?>
            </a>
        </div>
    </div>
</div>
<div class="div-secondary">
    <?php include_once CAL_ROOT_WEB . '/home/secondary.inc'; ?>
</div>
<?php include_once CAL_ROOT_WEB . '/containers/footer.inc'; ?>
