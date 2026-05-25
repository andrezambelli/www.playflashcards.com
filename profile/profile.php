<?php /** @var array $t */ ?>
<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/car-server.php' ;?>
<?php include_once CAR_ROOT_WEB . '/config.inc' ;?>
<?php include CAR_ROOT_WEB . '/lang/lang.inc'; ?>
<?php car_check_login($t); ?>
<?php
    car_set_session_attribute('read_database', 'on');

    // Parâmetros
    $user_id = car_get_session_attribute('user_id', 0);

    // Variáveis
    $user_email = '';
    $user_lang = '';
    $user_create = '';

    // Ajustando o timezone do banco de dados
    $timezone = car_get_session_attribute('timezone', CAR_TIMEZONE_DEFAULT);
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
    $header_title = car_t($t, 'Profile') . ' - Play Flashcards';
    $dash_active = 'profile';
    $dash_breadcrumb = [[car_t($t, 'Profile')]];
    include_once CAR_ROOT_WEB . '/dash/containers/header.inc';
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
        <?php include_once CAR_ROOT_WEB . '/containers/message.inc' ?>
        <div class="title">
            <?= car_t($t, 'Profile'); ?>
        </div>
        <div class="stats-title"><?= car_t($t, 'Email'); ?>:</div>
        <div class="stats-value"><?= car_htmlspecialchars($user_email); ?></div>
        <div class="stats-title"><?= car_t($t, 'Lang'); ?>:</div>
        <div class="stats-value">
            <form id="main_form" action="<?= CAR_PATH_WEB . '/services/change-language-act'; ?>" method="post">
                <select id="user_lang_select" name="lang" class="selectx w300">
                    <option value="en" <?php if ($user_lang == 'en') { ?>selected<?php } ?>><?= car_t($t, 'English'); ?></option>
                    <option value="pt-br" <?php if ($user_lang == 'pt-br') { ?>selected<?php } ?>><?= car_t($t, 'Portuguese'); ?></option>
                    <option value="es" <?php if ($user_lang == 'es') { ?>selected<?php } ?>><?= car_t($t, 'Spanish'); ?></option>
                    <option value="fr" <?php if ($user_lang == 'fr') { ?>selected<?php } ?>><?= car_t($t, 'French'); ?></option>
                </select>
                <input type="submit" style="display:none" />
            </form>
        </div>
        <div class="stats-title"><?= car_t($t, 'Timezone'); ?>:</div>
        <div class="stats-value">GMT<?= car_htmlspecialchars($timezone); ?></div>
        <div class="stats-title"><?= car_t($t, 'Create'); ?>:</div>
        <div class="stats-value"><?= car_htmlspecialchars($user_create); ?></div>
        <div class="space"></div>
        <div class="stats-title"><?= car_t($t, 'Sign Out'); ?>:</div>
        <div class="stats-value">
            <a href="<?= CAR_PATH_WEB . '/login/logoff-act'; ?>" class="buttonx">
                <?= car_t($t, 'Sign Out'); ?>
            </a>
        </div>
        <div class="space"></div>
        <div class="stats-title"><?= car_t($t, 'Delete your Account'); ?>:</div>
        <div class="stats-value">
            <a href="<?= CAR_PATH_WEB; ?>/profile/profile-delete">
                <?= car_t($t, 'Delete'); ?>
            </a>
        </div>
    </div>
</div>
<div class="div-secondary">
    <?php include_once CAR_ROOT_WEB . '/home/secondary.inc'; ?>
</div>
<?php include_once CAR_ROOT_WEB . '/dash/containers/footer.inc'; ?>
