<?php /** @var array $t */ ?>
<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/car-server.php'; ?>
<?php include_once CAR_ROOT_WEB . '/config.inc'; ?>
<?php include CAR_ROOT_WEB . '/lang/lang.inc'; ?>
<?php
    $user_id = car_get_session_attribute('user_id', CAR_USER_ID_MASTER);

    $stud_key   = '';
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

    if (isset($_GET['page'])) {
        $pages = $_GET['page'];
        if ($pages[strlen($pages) - 1] === '/') $pages = substr($pages, 0, -1);
        $pages    = explode('/', $pages);
        $stud_key = $pages[1] ?? '';

        $timezone = car_get_session_attribute('timezone', CAR_TIMEZONE_DEFAULT);
        $mysqli->query(sprintf("SET time_zone = '%s'", $timezone));

        $sql = sprintf("select b.deck_key, b.deck_name, a.stud_id, a.stud_begin, a.stud_end, a.stud_total, a.stud_true, a.stud_false
                          from car_study a, car_deck b
                         where a.stud_key = '%s'
                           and a.user_id = %d
                           and a.deck_id = b.deck_id",
                        $mysqli->real_escape_string(car_never_null($stud_key)),
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

        if ($has_study && empty($stud_end)) {
            $sql = sprintf("select b.stse_order, c.card_front, c.card_back
                              from car_study a, car_study_session b, car_card c
                             where a.stud_key = '%s'
                               and a.user_id = %d
                               and a.stud_id = b.stud_id
                               and b.card_id = c.card_id
                               and b.stse_answer is null
                             order by b.stse_order
                            limit 1",
                            $mysqli->real_escape_string(car_never_null($stud_key)),
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
            $mysqli->query(sprintf('update car_study set stud_end = now() where stud_id = %d and user_id = %d', $stud_id, $user_id));
            $mysqli->query(sprintf('delete from car_study_session where stud_id = %d and user_id = %d', $stud_id, $user_id));
            $mysqli->commit();

            $result = $mysqli->query(sprintf('select stud_end from car_study where stud_id = %d and user_id = %d', $stud_id, $user_id));
            while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
                $stud_end = $row['stud_end'];
            }
        }
    }

    $asset_v = CAR_PROD ? CAR_VERSION : (string)($_SERVER['REQUEST_TIME'] ?? time());
    $asset_v = rawurlencode($asset_v);

    $_progress_pct = ($has_card && $stud_total > 0) ? round(($stse_order - 1) / $stud_total * 100) : 100;
    $_deck_url     = CAR_PATH_WEB . '/deck/' . rawurlencode($deck_key);
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

<div class="car-play-stage">

    <div class="car-play-header">
        <?php if (!empty($deck_key)) { ?>
        <a href="<?= car_htmlspecialchars($_deck_url) ?>"
           class="btn btn-sm btn-link text-secondary text-decoration-none d-inline-flex align-items-center gap-1 px-0">
            <i class="bi bi-x" aria-hidden="true"></i>
            <?= car_t($t, 'dash.study.exit') ?>
        </a>
        <?php } ?>
        <?php if ($has_study && $has_card) { ?>
        <div class="flex-grow-1 d-flex align-items-center gap-3" style="max-width: 360px">
            <div class="progress flex-grow-1" style="height: 4px" role="progressbar"
                 aria-valuenow="<?= $_progress_pct ?>" aria-valuemin="0" aria-valuemax="100">
                <div class="progress-bar" style="width: <?= $_progress_pct ?>%"></div>
            </div>
            <span class="car-text-mono small text-secondary">
                <?= str_pad($stse_order, 2, '0', STR_PAD_LEFT) ?> / <?= str_pad($stud_total, 2, '0', STR_PAD_LEFT) ?>
            </span>
        </div>
        <?php } ?>
        <?php if (!empty($deck_name)) { ?>
        <div class="ms-auto">
            <div class="car-label-uc"><?= car_htmlspecialchars($deck_name) ?></div>
        </div>
        <?php } ?>
    </div>

    <div class="car-play-canvas">

        <?php if ($has_study && $has_card) { ?>

        <form id="study_form" method="post" action="<?= CAR_PATH_WEB ?>/study/study-act">
            <input type="hidden" name="k" value="<?= car_htmlspecialchars($stud_key) ?>">
            <input type="hidden" name="stse_order" value="<?= $stse_order ?>">
            <input type="hidden" id="stse_answer" name="stse_answer" value="">
        </form>

        <div id="car_flashcard" class="car-flashcard" role="button" tabindex="0">
            <div id="card_side" class="car-flashcard-side"><?= car_t($t, 'Front') ?></div>
            <div id="card_text" class="car-flashcard-text"><?= car_htmlspecialchars($card_front) ?></div>
            <div class="car-flashcard-hint"><?= car_t($t, 'dash.study.flip-hint') ?></div>
        </div>

        <div id="play_actions" class="d-flex gap-3 w-100" style="max-width: 640px">
            <button type="button" id="btn_false" class="car-play-btn dont">
                <span><?= car_t($t, 'False Btn') ?></span>
                <span class="car-play-btn-kbd">←</span>
            </button>
            <button type="button" id="btn_true" class="car-play-btn know">
                <span><?= car_t($t, 'True Btn') ?></span>
                <span class="car-play-btn-kbd">→</span>
            </button>
        </div>

        <div class="d-none d-md-flex gap-4 text-secondary" style="font-size: 0.75rem">
            <div class="d-flex align-items-center gap-2">
                <span class="car-kbd">SPACE</span>
                <?= car_t($t, 'Front') ?> / <?= car_t($t, 'Back') ?>
            </div>
            <div class="d-flex align-items-center gap-2">
                <span class="car-kbd">← →</span>
                <?= car_t($t, 'dash.study.respond') ?>
            </div>
            <div class="d-flex align-items-center gap-2">
                <span class="car-kbd">ESC</span>
                <?= car_t($t, 'dash.study.exit') ?>
            </div>
        </div>

        <?php } elseif ($has_study && !$has_card) { ?>

        <div style="max-width: 480px; width: 100%">

            <div class="text-center mb-4">
                <div class="car-label-uc mb-2"><?= car_t($t, 'Results') ?></div>
                <?php
                    $_acc       = car_percent($stud_true, $stud_total);
                    $_acc_color = $_acc < 50 ? 'text-danger' : ($_acc < 75 ? 'text-warning' : 'text-success');
                ?>
                <div class="display-4 fw-semibold car-text-mono mb-1 <?= $_acc_color ?>"><?= $_acc ?>%</div>
                <div class="text-secondary small"><?= $stud_true ?> / <?= $stud_total ?> <?= car_t($t, 'Correctly Answered') ?></div>
            </div>

            <div class="card mb-3">
                <div class="card-body d-flex flex-column gap-2">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-secondary small"><?= car_t($t, 'Start Date') ?></span>
                        <span class="small car-text-mono"><?= car_htmlspecialchars($stud_begin) ?></span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-secondary small"><?= car_t($t, 'Study Time') ?></span>
                        <span class="small car-text-mono"><?= car_diff_dates($stud_begin, $stud_end) ?></span>
                    </div>
                </div>
            </div>

            <div class="d-flex flex-column gap-2 mb-4">
                <form action="<?= CAR_PATH_WEB ?>/deck/study-new-act" method="post">
                    <input type="hidden" name="k" value="<?= car_htmlspecialchars($deck_key) ?>">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-layers" aria-hidden="true"></i>
                        <?= car_t($t, 'New Study') ?>
                    </button>
                </form>
                <a href="<?= car_htmlspecialchars($_deck_url) ?>"
                   class="btn btn-link text-secondary text-decoration-none">
                    <i class="bi bi-arrow-left" aria-hidden="true"></i>
                    <?= car_t($t, 'dash.study.back-to-deck') ?>
                </a>
            </div>

            <div class="border-top pt-3 text-center">
                <form action="<?= CAR_PATH_WEB ?>/study/study-delete-act" method="post" class="d-inline">
                    <input type="hidden" name="k" value="<?= car_htmlspecialchars($stud_key) ?>">
                    <button type="submit" class="btn btn-link small text-secondary text-decoration-none p-0">
                        <?= car_t($t, 'Delete Study') ?>
                    </button>
                </form>
            </div>

        </div>

        <?php } else { ?>

        <div class="text-center text-secondary py-5">
            <i class="bi bi-exclamation-circle fs-1 mb-3 d-block" aria-hidden="true"></i>
            <p><?= car_t($t, 'Study not found.') ?></p>
        </div>

        <?php } ?>

    </div>

</div>

<?php if ($has_study && $has_card) { ?>
<script>
document.addEventListener('DOMContentLoaded', function () {
    var card       = document.getElementById('car_flashcard');
    var actions    = document.getElementById('play_actions');
    var cardSide   = document.getElementById('card_side');
    var cardText   = document.getElementById('card_text');
    var flipped    = false;
    var frontText  = <?= json_encode($card_front) ?>;
    var backText   = <?= json_encode($card_back) ?>;
    var labelFront = <?= json_encode(car_t($t, 'Front')) ?>;
    var labelBack  = <?= json_encode(car_t($t, 'Back')) ?>;
    var exitUrl    = <?= json_encode($_deck_url) ?>;

    function flip() {
        if (card.classList.contains('flip-out') || card.classList.contains('flip-start')) return;
        card.classList.add('flip-out');
        setTimeout(function () {
            flipped = !flipped;
            card.classList.toggle('flipped', flipped);
            cardSide.textContent = flipped ? labelBack : labelFront;
            cardText.textContent = flipped ? backText : frontText;
            card.classList.add('flip-start');
            card.classList.remove('flip-out');
            void card.offsetWidth; // força reflow para o jump sem transição
            card.classList.remove('flip-start');
        }, 180);
    }

    function answer(value) {
        document.getElementById('stse_answer').value = value;
        document.getElementById('study_form').submit();
    }

    card.addEventListener('click', flip);
    card.addEventListener('keydown', function (e) {
        if (e.key === ' ' || e.key === 'Enter') { e.preventDefault(); flip(); }
    });

    document.getElementById('btn_true').addEventListener('click', function () { answer('true'); });
    document.getElementById('btn_false').addEventListener('click', function () { answer('false'); });

    document.addEventListener('keydown', function (e) {
        if      (e.key === ' ')                    { e.preventDefault(); flip(); }
        else if (e.key === 'ArrowRight' && flipped) { answer('true'); }
        else if (e.key === 'ArrowLeft'  && flipped) { answer('false'); }
        else if (e.key === 'Escape')                { location.href = exitUrl; }
    });
});
</script>
<?php } ?>

</body>
</html>
