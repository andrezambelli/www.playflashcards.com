<?php /** @var array $t */ ?>
<?php
    car_set_session_attribute('current_url', car_current_url());

    $_login    = car_get_session_attribute('session_login', 'off');
    $_timezone = car_get_session_attribute('timezone', '');

    $asset_v = CAR_PROD ? CAR_VERSION : (string) ($_SERVER['REQUEST_TIME'] ?? time());
    $asset_v = rawurlencode($asset_v);
?>
<?php include CAR_ROOT_WEB . '/lang/lang.inc'; ?>
<!DOCTYPE html>
<html lang="<?= $t['lang'] ?>" xml:lang="<?= $t['lang'] ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="<?= $header_index_follow ?? 'noindex,nofollow' ?>">
    <meta name="description" content="<?= car_htmlspecialchars($header_description ?? '') ?>">
    <meta name="author" content="Play Flashcards">

    <meta property="og:type" content="website">
    <meta property="og:url" content="<?= car_htmlspecialchars($header_canonical ?? '') ?>">
    <meta property="og:title" content="<?= car_htmlspecialchars($header_title ?? 'Play Flashcards') ?>">
    <meta property="og:description" content="<?= car_htmlspecialchars($header_description ?? '') ?>">

    <?php if (!empty($header_canonical)) { ?>
        <link rel="canonical" href="<?= car_htmlspecialchars($header_canonical) ?>">
    <?php } ?>

    <?php if ($_SERVER['REQUEST_URI'] === '' || $_SERVER['REQUEST_URI'] === '/') { ?>
        <link rel="alternate" hreflang="en"    href="https://www.playflashcards.com/en/">
        <link rel="alternate" hreflang="pt-br" href="https://www.playflashcards.com/pt-br/">
        <link rel="alternate" hreflang="es"    href="https://www.playflashcards.com/es/">
        <link rel="alternate" hreflang="fr"    href="https://www.playflashcards.com/fr/">
    <?php } ?>

    <link rel="icon" type="image/png" href="<?= CAR_PATH_WEB ?>/assets/img/favicon.png">
    <link rel="apple-touch-icon" sizes="180x180" href="<?= CAR_PATH_WEB ?>/assets/img/icon.png">

    <!-- Fonte Geist -->
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

<?php
    $lang_labels = ['en' => 'EN', 'pt-br' => 'PT', 'es' => 'ES', 'fr' => 'FR'];
    $lang_current = $lang_labels[$t['lang']] ?? strtoupper($t['lang']);
?>
<!-- Navbar -->
<nav class="navbar navbar-expand-lg fixed-top">
    <div class="container">

        <!-- Logo -->
        <a class="navbar-brand d-flex align-items-center gap-2 fw-bold text-body" href="<?= CAR_PATH_WEB . '/' . $t['lang'] . '/' ?>">
            <span class="car-brand-mark" aria-hidden="true">
                <svg width="11" height="13" viewBox="0 0 11 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M1 1L10 6.5L1 12V1Z" fill="white" stroke="white" stroke-width="1.2" stroke-linejoin="round"/>
                </svg>
            </span>
            Play Flashcards
        </a>

        <!-- Toggler mobile -->
        <button class="navbar-toggler border-0"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#main-navbar"
                aria-controls="main-navbar"
                aria-expanded="false"
                aria-label="<?= car_t($t, 'Menu') ?>">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="main-navbar">

            <?php if ($_login === 'off') { ?>

                <!-- Links centrais (público) -->
                <ul class="navbar-nav mx-auto gap-1">
                    <li class="nav-item">
                        <a class="nav-link text-secondary" href="#"><?= car_t($t, 'Features') ?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-secondary" href="#"><?= car_t($t, 'Public Decks') ?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-secondary" href="#"><?= car_t($t, 'Pricing') ?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-secondary" href="<?= CAR_PATH_WEB . '/' . $t['lang'] . '/contact-us' ?>"><?= car_t($t, 'Help') ?></a>
                    </li>
                </ul>

                <!-- Direita: idioma + CTA -->
                <div class="d-flex align-items-center gap-2 ms-lg-3 car-navbar-actions">

                    <?php
                        $langs = [
                            'en'    => 'English',
                            'es'    => 'Español',
                            'fr'    => 'Français',
                            'pt-br' => 'Português',
                        ];
                    ?>

                    <!-- Idioma: dropdown (desktop) -->
                    <div class="dropdown d-none d-lg-block">
                        <button class="btn btn-sm btn-link text-secondary text-decoration-none dropdown-toggle d-inline-flex align-items-center gap-1"
                                type="button"
                                data-bs-toggle="dropdown"
                                aria-expanded="false">
                            <i class="bi bi-globe" aria-hidden="true"></i>
                            <?= $lang_current ?>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <?php foreach ($langs as $code => $name) { $active = $t['lang'] === $code; ?>
                            <li>
                                <a class="dropdown-item d-flex align-items-center gap-2 <?= $active ? 'active' : '' ?>"
                                   href="<?= CAR_PATH_WEB ?>/services/change-language-act?lang=<?= $code ?>">
                                    <span class="car-text-mono text-secondary" style="width:22px"><?= $lang_labels[$code] ?></span>
                                    <?= $name ?>
                                    <?php if ($active) { ?>
                                        <i class="bi bi-check ms-auto text-primary" aria-hidden="true"></i>
                                    <?php } ?>
                                </a>
                            </li>
                            <?php } ?>
                        </ul>
                    </div>

                    <!-- Idioma: inline (mobile) -->
                    <div class="d-flex d-lg-none align-items-center gap-1">
                        <i class="bi bi-globe text-secondary me-1" style="font-size:0.8125rem" aria-hidden="true"></i>
                        <?php foreach ($langs as $code => $name) { $active = $t['lang'] === $code; ?>
                            <a href="<?= CAR_PATH_WEB ?>/services/change-language-act?lang=<?= $code ?>"
                               class="car-lang-pill <?= $active ? 'active' : '' ?>"
                               title="<?= $name ?>">
                                <?= $lang_labels[$code] ?>
                            </a>
                        <?php } ?>
                    </div>

                    <a class="btn btn-primary"
                       href="<?= CAR_PATH_WEB . '/' . $t['lang'] . '/login/login' ?>"><?= car_t($t, 'Get Started') ?></a>
                </div>

            <?php } else { ?>

                <!-- Links área logada -->
                <ul class="navbar-nav ms-auto align-items-lg-center gap-1">
                    <li class="nav-item">
                        <a class="nav-link text-secondary" href="<?= CAR_PATH_WEB ?>/dash/deck-list"><?= car_t($t, 'Decks') ?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-secondary" href="<?= CAR_PATH_WEB ?>/profile/profile"><?= car_t($t, 'Profile') ?></a>
                    </li>
                    <li class="nav-item ms-lg-2">
                        <a class="btn btn-sm btn-outline-secondary" href="<?= CAR_PATH_WEB ?>/login/logoff-act"><?= car_t($t, 'Sign Out') ?></a>
                    </li>
                </ul>

            <?php } ?>

        </div>
    </div>
</nav>

<!-- Espaço para a navbar fixa -->
<div style="height: var(--app-header-h);"></div>
