<?php /** @var array $t */ ?>
<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/car-server.php' ;?>
<?php include_once CAR_ROOT_WEB . '/config.inc' ;?>
<?php include CAR_ROOT_WEB . '/lang/lang.inc'; ?>
<?php car_check_login($t); ?>
<?php
    // Parâmetros
    $user_id = car_get_session_attribute('user_id', 0);
    $read_database = car_get_session_attribute('read_database', 'on');

    // Variáveis
    $srs_limit = CAR_USER_SRS_LIMIT;
    $srs_sequence = CAR_USER_SRS_SEQUENCE;
    $srs_rate = CAR_USER_SRS_RATE;
    $srs_days = CAR_USER_SRS_DAYS;

    car_set_session_attribute('read_database', 'on');

    if ($read_database == 'on') {
        // Procurando informações do usuário
        $sql = sprintf("select user_srs_limit, user_srs_rate, user_srs_sequence, user_srs_days from car_user where user_id = %d", $user_id);

        $result = $mysqli->query($sql);

        while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
            $srs_limit = $row['user_srs_limit'];
            $srs_sequence = $row['user_srs_sequence'];
            $srs_rate = $row['user_srs_rate'];
            $srs_days = $row['user_srs_days'];
        }
    } else {
        $srs_limit = car_get_session_attribute('srs_limit', '');
        $srs_sequence = car_get_session_attribute('srs_sequence', '');
        $srs_rate = car_get_session_attribute('srs_rate', '');
        $srs_days = car_get_session_attribute('srs_days', '');
    }
?>
<?php
    $header_title = car_t($t, 'Spaced Repetition System (SRS)') . ' - Play Flashcards';
    $header_description = '';
    $header_index_follow = 'noindex,nofollow';
    include_once CAR_ROOT_WEB . '/containers/header.inc';
?>
<script>
    $(document).ready(function() {
        $('#default_btn').click(function(event) {
            event.preventDefault();

            $('#srs_limit').val(<?= CAR_USER_SRS_LIMIT; ?>);
            $('#srs_rate').val(<?= CAR_USER_SRS_RATE; ?>);
            $('#srs_sequence').val(<?= CAR_USER_SRS_SEQUENCE; ?>);
            $('#srs_days').val(<?= CAR_USER_SRS_DAYS; ?>);

            $('#main_form').submit();
        });
    });
</script>
<div class="div-primary">
    <div class="div-start">
        <?php include_once CAR_ROOT_WEB . '/containers/message.inc' ?>
        <div class="title">
            <?= car_t($t, 'Spaced Repetition System (SRS)'); ?>
        </div>
        <div class="stats-value">
            <?= car_t($t, 'profile.srs.definition'); ?>
        </div>
        <div class="space"></div>
        <form id="main_form" action="<?= CAR_PATH_WEB; ?>/profile/srs-act" method="post">
            <div class="stats-title">
                <?= car_t($t, 'Number of Cards per Study Session'); ?>:
            </div>
            <div class="stats-value">
                <table class="tip-table">
                    <tr>
                        <td class="td1">
                            <input type="text" id="srs_limit" name="srs_limit" value="<?= $srs_limit; ?>" class="input w75" maxlength="3" />
                        </td>
                        <td class="td2">
                            <div class="tip">
                                <?= car_t($t, 'profile.srs.limit-definition'); ?>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="space"></div>
            <div class="stats-title">
                <?= car_t($t, 'Accuracy Rate'); ?> (%):
            </div>
            <div class="stats-value">
                <table class="tip-table">
                    <tr>
                        <td class="td1">
                            <input type="text" id="srs_rate" name="srs_rate" value="<?= $srs_rate; ?>" class="input w75" maxlength="3" />
                        </td>
                        <td class="td2">
                            <div class="tip">
                                <?= car_t($t, 'profile.srs.rate-definition'); ?>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="space"></div>
            <div class="stats-title">
                <?= car_t($t, 'Correct Answers in Sequence'); ?>:
            </div>
            <div class="stats-value">
                <table class="tip-table">
                    <tr>
                        <td class="td1">
                            <input type="text" id="srs_sequence" name="srs_sequence" value="<?= $srs_sequence; ?>" class="input w75" maxlength="3" " />
                        </td>
                        <td class="td2">
                            <div class="tip">
                                <?= car_t($t, 'profile.srs.sequence-definition'); ?>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="space"></div>
            <div class="stats-title">
                <?= car_t($t, 'Periodic Flashcard Revitalization'); ?> (<?= car_t($t, 'days'); ?>):
            </div>
            <div class="stats-value">
                <table class="tip-table">
                    <tr>
                        <td class="td1">
                            <input type="text" id="srs_days" name="srs_days" value="<?= $srs_days; ?>" class="input w75" maxlength="3" />
                        </td>
                        <td class="td2">
                            <div class="tip">
                                <?= car_t($t, 'profile.srs.days-definition'); ?>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="space"></div>
            <input type="submit" value="<?= car_t($t, 'Save'); ?>" class="buttonx w75" />
        </form>
        <div class="space"></div>
        <div class="stats-title">
            <?= car_t($t, 'Restore Default Values'); ?>
        </div>
        <input type="button" id="default_btn" value="<?= car_t($t, 'Restore'); ?>" class="buttonx w75" />
    </div>
</div>
<div class="div-secondary">
    <?php include_once CAR_ROOT_WEB . '/home/secondary.inc'; ?>
</div>
<?php include_once CAR_ROOT_WEB . '/containers/footer.inc'; ?>
