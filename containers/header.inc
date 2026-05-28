<?php /** @var array $t */ ?>
<?php
    car_set_session_attribute('current_url', car_current_url());

    $_login    = car_get_session_attribute('session_login', 'off');
    $_timezone = car_get_session_attribute('timezone', '');

    $asset_v = car_is_production() ? CAR_VERSION : (string) ($_SERVER['REQUEST_TIME'] ?? time());
    $asset_v = rawurlencode($asset_v);

    if (isset($header_hreflang_slug) && empty($header_canonical)) {
        $_slug_auto = $header_hreflang_slug === '' ? '/' : ('/' . trim($header_hreflang_slug, '/') . '/');
        $header_canonical = 'https://www.playflashcards.com/' . $t['lang'] . $_slug_auto;
    }
?>
<?php include CAR_ROOT_WEB . '/lang/lang.inc'; ?>
<!DOCTYPE html>
<html lang="<?= $t['lang'] ?>" xml:lang="<?= $t['lang'] ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="<?= car_is_production() ? ($header_index_follow ?? 'noindex,nofollow') : 'noindex,nofollow' ?>">
    <meta name="description" content="<?= car_htmlspecialchars($header_description ?? '') ?>">
    <meta name="author" content="Play Flashcards">

    <meta property="og:type" content="website">
    <meta property="og:url" content="<?= car_htmlspecialchars($header_canonical ?? '') ?>">
    <meta property="og:title" content="<?= car_htmlspecialchars($header_title ?? 'Play Flashcards') ?>">
    <meta property="og:description" content="<?= car_htmlspecialchars($header_description ?? '') ?>">
    <meta property="og:image" content="<?= car_htmlspecialchars($header_og_image ?? (car_get_base_url(CAR_PATH_WEB) . '/assets/img/playflashcards-logo.png')) ?>">
    <meta name="twitter:card" content="<?= car_htmlspecialchars($header_twitter_card ?? 'summary') ?>">
    <meta name="twitter:site" content="@playflashcards">

    <?php if (!empty($header_canonical)) { ?>
        <link rel="canonical" href="<?= car_htmlspecialchars($header_canonical) ?>">
    <?php } ?>

    <?php if (isset($header_hreflang_slug)) {
        $_hslug = $header_hreflang_slug === '' ? '/' : ('/' . trim($header_hreflang_slug, '/') . '/');
        $_hbase = 'https://www.playflashcards.com';
        $_hreflangs = [
            'en'    => 'en',
            'pt-BR' => 'pt-br',
            'es'    => 'es',
            'fr'    => 'fr',
            'de'    => 'de',
            'it'    => 'it',
            'nl'    => 'nl',
            'pl'    => 'pl',
            'ru'    => 'ru',
            'ja'    => 'ja',
            'zh'    => 'zh',
            'hi'    => 'hi',
        ];
        ?>
        <?php foreach ($_hreflangs as $_hreflang => $_lang_path) { ?>
        <link rel="alternate" hreflang="<?= $_hreflang ?>" href="<?= $_hbase ?>/<?= $_lang_path ?><?= $_hslug ?>">
        <?php } ?>
        <link rel="alternate" hreflang="x-default" href="<?= $_hbase ?>/en<?= $_hslug ?>">
    <?php } ?>

    <!-- PWA -->
    <meta name="theme-color" content="#4F46E5">
    <?php if (car_is_production()) { ?>
        <link rel="manifest" href="<?= CAR_PATH_WEB ?>/manifest.json">
    <?php } ?>

    <!-- iOS -->
    <link rel="apple-touch-icon" sizes="180x180" href="<?= CAR_PATH_WEB ?>/assets/img/pwa/icon-180.png">
    <meta name="apple-mobile-web-app-title" content="Flashcards">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">

    <link rel="icon" type="image/png" href="<?= CAR_PATH_WEB ?>/assets/img/favicon.png">

    <!-- Fonte Geist -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Geist:wght@400;500;600;700&family=Geist+Mono:wght@400;500&display=swap">

    <link rel="stylesheet" href="<?= CAR_PATH_WEB ?>/assets/css/bootstrap-5.3.8.min.css">
    <link rel="stylesheet" href="<?= CAR_PATH_WEB ?>/assets/css/bootstrap-icons-1.13.1.min.css">
    <link rel="stylesheet" href="<?= CAR_PATH_WEB ?>/assets/css/styles.css?v=<?= $asset_v ?>">

    <script src="<?= CAR_PATH_WEB ?>/assets/js/bootstrap-5.3.8.bundle.min.js" defer></script>
    <script src="<?= CAR_PATH_WEB ?>/assets/js/main.js?v=<?= $asset_v ?>" defer></script>

    <?php if (car_is_production() && isset($_COOKIE['consent_key'])) { ?>
        <?php include_once CAR_ROOT_GENERAL . '/ga.inc'; ?>
    <?php } ?>

    <?php if (car_is_production()) { ?>
        <!-- PWA -->
        <script>
            if ('serviceWorker' in navigator) {
                window.addEventListener('load', () => {
                    navigator.serviceWorker.register('<?= CAR_PATH_WEB ?>/service-worker.js?v=<?= $asset_v ?>', { updateViaCache: 'none' })
                        .catch(err => console.error('Erro ao registrar Service Worker:', err));
                });
            }
        </script>
    <?php } ?>

    <title><?= car_htmlspecialchars($header_title ?? 'Play Flashcards') ?></title>

    <?php if (!empty($header_jsonld)) { echo $header_jsonld; } ?>
</head>
<body class="<?= !isset($_COOKIE['consent_key']) ? 'car-has-cookie-banner' : '' ?>">

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
    $lang_labels = ['en' => 'EN', 'pt-br' => 'PT', 'es' => 'ES', 'fr' => 'FR', 'de' => 'DE', 'it' => 'IT', 'ja' => 'JA', 'zh' => 'ZH', 'nl' => 'NL', 'pl' => 'PL', 'ru' => 'RU', 'hi' => 'HI'];
    $lang_current = $lang_labels[$t['lang']] ?? strtoupper($t['lang']);
?>
<?php if (empty($header_no_navbar)) { ?>
<!-- Navbar -->
<nav class="navbar navbar-expand-lg fixed-top">
    <div class="container">

        <!-- Toggler mobile -->
        <button class="btn btn-sm btn-outline-secondary d-lg-none border-0 px-2"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#main-navbar"
                aria-controls="main-navbar"
                aria-expanded="false"
                aria-label="<?= car_t($t, 'Menu') ?>">
            <i class="bi bi-list fs-5" aria-hidden="true"></i>
        </button>

        <!-- Logo -->
        <a class="navbar-brand d-flex align-items-center gap-2 fw-bold text-body" href="<?= CAR_PATH_WEB . '/' . $t['lang'] . '/' ?>">
            <span class="car-brand-mark" aria-hidden="true">
                <svg width="11" height="13" viewBox="0 0 11 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M1 1L10 6.5L1 12V1Z" fill="white" stroke="white" stroke-width="1.2" stroke-linejoin="round"/>
                </svg>
            </span>
            Play Flashcards
        </a>

        <div class="collapse navbar-collapse" id="main-navbar">

            <?php if ($_login === 'off') { ?>

                <!-- links centrais comentados até as páginas públicas ficarem prontas
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
                -->

                <!-- Direita: idioma + CTA -->
                <div class="d-flex align-items-center gap-2 ms-lg-auto car-navbar-actions">

                    <?php
                        $langs = [
                            'en'    => 'English',
                            'es'    => 'Español',
                            'fr'    => 'Français',
                            'pt-br' => 'Português',
                            'de'    => 'Deutsch',
                            'it'    => 'Italiano',
                            'nl'    => 'Nederlands',
                            'pl'    => 'Polski',
                            'ru'    => 'Русский',
                            'ja'    => '日本語',
                            'zh'    => '中文',
                            'hi'    => 'हिंदी',
                        ];
                        $lang_redirect_url = urlencode(car_current_url());
                    ?>

                    <!-- Idioma: dropdown (desktop) -->
                    <div class="dropdown d-none d-lg-block">
                        <button class="btn btn-link text-secondary text-decoration-none dropdown-toggle d-inline-flex align-items-center gap-1"
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
                                   href="<?= CAR_PATH_WEB ?>/services/change-language-act?lang=<?= $code ?>&redirect_url=<?= $lang_redirect_url ?>">
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

                    <!-- Idioma: lista aberta (mobile) -->
                    <div class="d-lg-none w-100 py-2">
                        <p class="d-flex align-items-center gap-1 text-secondary small mb-2">
                            <i class="bi bi-globe" aria-hidden="true"></i>
                            <?= car_t($t, 'Language') ?>
                        </p>
                        <div class="row g-1">
                            <?php foreach ($langs as $code => $name) { $active = $t['lang'] === $code; ?>
                            <div class="col-6">
                                <a href="<?= CAR_PATH_WEB ?>/services/change-language-act?lang=<?= $code ?>&redirect_url=<?= $lang_redirect_url ?>"
                                   class="d-flex align-items-center gap-2 px-2 py-1 rounded text-decoration-none <?= $active ? 'bg-primary-subtle text-primary fw-semibold' : 'text-secondary' ?>">
                                    <span class="car-text-mono small" style="width:20px"><?= $lang_labels[$code] ?></span>
                                    <span class="small"><?= $name ?></span>
                                    <?php if ($active) { ?>
                                        <i class="bi bi-check ms-auto" aria-hidden="true"></i>
                                    <?php } ?>
                                </a>
                            </div>
                            <?php } ?>
                        </div>
                    </div>

                    <a id="car-navbar-cta"
                       class="btn btn-primary"
                       href="<?= CAR_PATH_WEB . '/' . $t['lang'] . '/login/login' ?>"
                       data-dash-href="<?= CAR_PATH_WEB ?>/dash/home"
                       data-dash-label="<?= car_t($t, 'Dashboard') ?>"><?= car_t($t, 'Get Started') ?></a>
                </div>

            <?php } else { ?>

                <!-- Links área logada -->
                <ul class="navbar-nav ms-auto align-items-lg-center gap-1">
                    <li class="nav-item ms-lg-2">
                        <a class="btn btn-primary" href="<?= CAR_PATH_WEB ?>/dash/home"><?= car_t($t, 'Dashboard') ?></a>
                    </li>
                </ul>

            <?php } ?>

        </div>
    </div>
</nav>

<!-- Espaço para a navbar fixa -->
<div style="height: var(--app-header-h);"></div>
<?php } ?>
