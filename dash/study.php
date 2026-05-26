<?php /** @var array $t */ ?>
<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/car-server.php'; ?>
<?php include_once CAR_ROOT_WEB . '/config.inc'; ?>
<?php include CAR_ROOT_WEB . '/lang/lang.inc'; ?>
<?php car_check_login($t); ?>
<?php
    car_set_session_attribute('read_database', 'on');

    $user_id  = car_get_session_attribute('user_id', 0);
    $stud_key = car_get_parameter('k', '');

    $stse_order = 0;
    $card_front = '';
    $card_back  = '';

    $deck_key  = '';
    $deck_name = '';

    $stud_id    = '';
    $stud_begin = '';
    $stud_end   = '';
    $stud_total = 0;
    $stud_true  = 0;
    $stud_false = 0;

    $has_study = false;
    $has_card  = false;

    $timezone = car_get_session_attribute('timezone', CAR_TIMEZONE_DEFAULT);
    $sql = sprintf("set time_zone = '%s'", $timezone);
    $mysqli->query($sql);

    $sql = sprintf("select b.deck_key,
                           b.deck_name,
                           a.stud_id,
                           a.stud_begin,
                           a.stud_end,
                           a.stud_total,
                           a.stud_true,
                           a.stud_false
                      from car_study a,
                           car_deck b
                     where a.stud_key = '%s'
                       and a.user_id = %d
                       and a.deck_id = b.deck_id
                       and b.user_id = %d",
                    $mysqli->real_escape_string(car_never_null($stud_key)),
                    $user_id,
                    $user_id);

    $result = $mysqli->query($sql);

    while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
        $deck_key   = $row['deck_key'];
        $deck_name  = $row['deck_name'];
        $stud_id    = $row['stud_id'];
        $stud_begin = $row['stud_begin'];
        $stud_end   = $row['stud_end'];
        $stud_total = $row['stud_total'];
        $stud_true  = $row['stud_true'];
        $stud_false = $row['stud_false'];
        $has_study  = true;
    }

    if (!$has_study) {
        include_once CAR_ROOT_WEB . '/common/404.php';
        exit;
    }

    if ($has_study && empty($stud_end)) {
        $sql = sprintf("select b.stse_order,
                               c.card_front,
                               c.card_back
                          from car_study a,
                               car_study_session b,
                               car_card c
                         where a.stud_key = '%s'
                           and a.user_id = %d
                           and a.stud_id = b.stud_id
                           and b.user_id = %d
                           and b.card_id = c.card_id
                           and c.user_id = %d
                           and b.stse_answer is null
                         order by b.stse_order
                        limit 1",
                        $mysqli->real_escape_string(car_never_null($stud_key)),
                        $user_id,
                        $user_id,
                        $user_id);

        $result = $mysqli->query($sql);

        while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
            $stse_order = $row['stse_order'];
            $card_front = $row['card_front'];
            $card_back  = $row['card_back'];
            $has_card   = true;
        }
    }

    if ($has_study && !$has_card && empty($stud_end)) {
        $sql = sprintf('update car_study
                           set stud_end = now()
                         where stud_id = %d
                           and user_id = %d',
                        $stud_id,
                        $user_id);
        $mysqli->query($sql);

        $sql = sprintf('delete from car_study_session
                         where stud_id = %d
                           and user_id = %d',
                        $stud_id,
                        $user_id);
        $mysqli->query($sql);
        $mysqli->commit();

        $sql = sprintf('select stud_end
                          from car_study
                         where stud_id = %d
                           and user_id = %d',
                        $stud_id,
                        $user_id);
        $result = $mysqli->query($sql);
        while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
            $stud_end = $row['stud_end'];
        }
    }

    $asset_v = CAR_PROD ? CAR_VERSION : (string)($_SERVER['REQUEST_TIME'] ?? time());
    $asset_v = rawurlencode($asset_v);

    $_progress_pct = ($has_card && $stud_total > 0) ? round(($stse_order - 1) / $stud_total * 100) : 100;
    $_deck_url     = CAR_PATH_WEB . '/dash/deck?k=' . rawurlencode($deck_key);

    // variáveis específicas da área logada passadas para o canvas
    $_form_action  = CAR_PATH_WEB . '/dash/study-act';
    $_is_public    = false;
?>
<!DOCTYPE html>
<html lang="<?= $t['lang'] ?>" xml:lang="<?= $t['lang'] ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex,nofollow">
    <link rel="icon" type="image/png" href="<?= CAR_PATH_WEB ?>/assets/img/favicon.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Geist:wght@400;500;600;700&family=Geist+Mono:wght@400;500&display=swap">
    <link rel="stylesheet" href="<?= CAR_PATH_WEB ?>/assets/css/bootstrap-5.3.8.min.css">
    <link rel="stylesheet" href="<?= CAR_PATH_WEB ?>/assets/css/bootstrap-icons-1.13.1.min.css">
    <link rel="stylesheet" href="<?= CAR_PATH_WEB ?>/assets/css/styles.css?v=<?= $asset_v ?>">
    <script src="<?= CAR_PATH_WEB ?>/assets/js/bootstrap-5.3.8.bundle.min.js" defer></script>
    <title><?= car_t($t, 'Study') ?> - Play Flashcards</title>
</head>
<body>

<?php include_once CAR_ROOT_WEB . '/containers/message.inc'; ?>

<?php include_once CAR_ROOT_WEB . '/containers/study-canvas.inc'; ?>

</body>
</html>
