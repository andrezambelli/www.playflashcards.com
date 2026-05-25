<?php /** @var array $t */ ?>
<?php
    // variáveis esperadas da página que inclui este arquivo:
    // $header_title      (string)  — título da aba
    // $dash_active       (string)  — item ativo na sidebar: 'decks' | 'srs' | 'profile'
    // $dash_breadcrumb   (array)   — [['label', 'url'], ['label']] — último item sem url

    car_set_session_attribute('current_url', car_current_url());

    $_timezone = car_get_session_attribute('timezone', '');
    $user_id   = car_get_session_attribute('user_id', 0);

    $asset_v = CAR_PROD ? CAR_VERSION : (string)($_SERVER['REQUEST_TIME'] ?? time());
    $asset_v = rawurlencode($asset_v);

    // lista de baralhos para a sidebar
    $sidebar_decks = [];
    $sql_decks = sprintf('select deck_key, deck_name from car_deck where user_id = %d order by deck_name', $user_id);
    $result_decks = $mysqli->query($sql_decks);
    while ($row_deck = $result_decks->fetch_array(MYSQLI_ASSOC)) {
        $sidebar_decks[] = $row_deck;
    }
?>
<?php include CAR_ROOT_WEB . '/lang/lang.inc'; ?>
<!DOCTYPE html>
<html lang="<?= $t['lang'] ?>" xml:lang="<?= $t['lang'] ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex,nofollow">
    <meta name="author" content="Play Flashcards">

    <link rel="icon" type="image/png" href="<?= CAR_PATH_WEB ?>/assets/img/favicon.png">
    <link rel="apple-touch-icon" sizes="180x180" href="<?= CAR_PATH_WEB ?>/assets/img/icon.png">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Geist:wght@400;500;600;700&family=Geist+Mono:wght@400;500&display=swap">

    <link rel="stylesheet" href="<?= CAR_PATH_WEB ?>/assets/css/bootstrap-5.3.8.min.css">
    <link rel="stylesheet" href="<?= CAR_PATH_WEB ?>/assets/css/bootstrap-icons-1.13.1.min.css">
    <link rel="stylesheet" href="<?= CAR_PATH_WEB ?>/assets/css/styles.css?v=<?= $asset_v ?>">

    <script src="<?= CAR_PATH_WEB ?>/assets/js/bootstrap-5.3.8.bundle.min.js" defer></script>
    <script src="<?= CAR_PATH_WEB ?>/assets/js/main.js?v=<?= $asset_v ?>" defer></script>

    <?php if (CAR_PROD && isset($_COOKIE['consent_key'])) { ?>
        <?php include_once CAR_ROOT_GENERAL . '/ga.inc'; ?>
    <?php } ?>

    <title><?= car_htmlspecialchars($header_title ?? 'Play Flashcards') ?></title>
</head>
<body>

<?php if (empty($_timezone)) { ?>
    <script>
        (function() {
            var offset = new Date().getTimezoneOffset();
            var h = Math.floor(Math.abs(offset) / 60);
            var m = Math.abs(offset) % 60;
            var tz = (offset < 0 ? '+' : '-') + (h < 10 ? '0' : '') + h + ':' + (m < 10 ? '0' : '') + m;
            fetch('<?= CAR_PATH_WEB ?>/services/set-timezone-act', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: 'timezone=' + encodeURIComponent(tz)
            });
        })();
    </script>
<?php } ?>

<div class="car-app-shell">

    <!-- Sidebar (desktop) -->
    <aside class="car-app-sidebar d-none d-md-flex flex-column">

        <!-- Logo -->
        <a class="car-app-brand text-decoration-none text-body" href="<?= CAR_PATH_WEB ?>/dash/home">
            <span class="car-brand-mark" aria-hidden="true">
                <svg width="11" height="13" viewBox="0 0 11 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M1 1L10 6.5L1 12V1Z" fill="white" stroke="white" stroke-width="1.2" stroke-linejoin="round"/>
                </svg>
            </span>
            Play Flashcards
        </a>

        <!-- Navegação principal -->
        <nav class="car-nav-section" aria-label="<?= car_t($t, 'Navigation') ?>">
            <a class="car-app-nav-item <?= ($dash_active ?? '') === 'home' ? 'active' : '' ?>"
               href="<?= CAR_PATH_WEB ?>/dash/home">
                <i class="bi bi-house" aria-hidden="true"></i>
                <?= car_t($t, 'Dashboard') ?>
            </a>
            <a class="car-app-nav-item <?= ($dash_active ?? '') === 'decks' ? 'active' : '' ?>"
               href="<?= CAR_PATH_WEB ?>/dash/deck-list">
                <i class="bi bi-layers" aria-hidden="true"></i>
                <?= car_t($t, 'Decks') ?>
            </a>
        </nav>

        <!-- Lista de baralhos -->
        <nav class="car-nav-section car-nav-section--decks" aria-label="<?= car_t($t, 'Decks') ?>">
            <div class="car-nav-section-title"><?= car_t($t, 'Decks') ?></div>
            <?php foreach ($sidebar_decks as $sd) { ?>
            <a class="car-app-nav-item car-app-nav-item--deck"
               href="<?= CAR_PATH_WEB ?>/dash/deck?k=<?= car_htmlspecialchars($sd['deck_key']) ?>">
                <span class="car-nav-deck-dot" aria-hidden="true"></span>
                <span class="car-app-nav-label"><?= car_htmlspecialchars($sd['deck_name']) ?></span>
            </a>
            <?php } ?>
            <a class="car-app-nav-item text-secondary"
               href="<?= CAR_PATH_WEB ?>/dash/deck-new-act">
                <i class="bi bi-plus" aria-hidden="true"></i>
                <?= car_t($t, 'New Deck') ?>
            </a>
        </nav>

        <!-- Configurações -->
        <nav class="car-nav-section mt-auto" aria-label="<?= car_t($t, 'Settings') ?>">
            <div class="car-nav-section-title"><?= car_t($t, 'Settings') ?></div>
            <a class="car-app-nav-item <?= ($dash_active ?? '') === 'srs' ? 'active' : '' ?>"
               href="<?= CAR_PATH_WEB ?>/profile/srs">
                <i class="bi bi-arrow-repeat" aria-hidden="true"></i>
                <?= car_t($t, 'SRS') ?>
            </a>
            <a class="car-app-nav-item <?= ($dash_active ?? '') === 'profile' ? 'active' : '' ?>"
               href="<?= CAR_PATH_WEB ?>/profile/profile">
                <i class="bi bi-person" aria-hidden="true"></i>
                <?= car_t($t, 'Profile') ?>
            </a>
            <a class="car-app-nav-item text-secondary"
               href="<?= CAR_PATH_WEB ?>/login/logoff-act">
                <i class="bi bi-box-arrow-right" aria-hidden="true"></i>
                <?= car_t($t, 'Sign Out') ?>
            </a>
        </nav>

    </aside>

    <!-- Coluna principal -->
    <div class="d-flex flex-column min-vh-100" style="min-width: 0; overflow-x: hidden">

        <!-- Topbar -->
        <div class="car-app-topbar">

            <!-- Hamburger (mobile) -->
            <button class="btn btn-sm btn-outline-secondary d-md-none border-0 px-2"
                    type="button"
                    data-bs-toggle="offcanvas"
                    data-bs-target="#car-mobile-sidebar"
                    aria-controls="car-mobile-sidebar"
                    aria-label="<?= car_t($t, 'Menu') ?>">
                <i class="bi bi-list fs-5" aria-hidden="true"></i>
            </button>

            <!-- Breadcrumb -->
            <?php if (!empty($dash_breadcrumb)) { ?>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <?php foreach ($dash_breadcrumb as $i => $crumb) {
                        $is_last = $i === array_key_last($dash_breadcrumb);
                    ?>
                    <li class="breadcrumb-item <?= $is_last ? 'active' : '' ?>">
                        <?php if (!$is_last && !empty($crumb[1])) { ?>
                            <a href="<?= car_htmlspecialchars($crumb[1]) ?>"><?= car_htmlspecialchars($crumb[0]) ?></a>
                        <?php } else { ?>
                            <?= car_htmlspecialchars($crumb[0]) ?>
                        <?php } ?>
                    </li>
                    <?php } ?>
                </ol>
            </nav>
            <?php } ?>

        </div>

        <!-- Conteúdo da página -->
        <div class="car-app-page">
