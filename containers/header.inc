<?php
    cal_set_session_attribute('current_url', cal_current_url());

    $_login = cal_get_session_attribute('session_login', 'off');
    $_timezone = cal_get_session_attribute('timezone', '');
?>
<?php include CAL_ROOT_WEB . '/lang/lang.inc'; ?>
<!DOCTYPE html><html lang="<?= $t['lang']; ?>" xml:lang="<?= $t['lang']; ?>">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta http-equiv="Content-Language" content="pt-br" />
    <meta name="Googlebot" content="<?= $header_index_follow; ?>" />
    <meta name="Robots" content="<?= $header_index_follow; ?>">
	<meta name="Distribution" content="global" />
	<meta name="Author" content="Play Flashcards 2023" />
	<meta name="Copyright" content="Play Flashcards 2023" />
	<meta name="Keywords" content="playflashcards, flashcards" />
	<meta name="Description" content="<?php if (isset($header_description)) { echo cal_htmlspecialchars($header_description); } ?>" />
	<meta name="viewport" content="width=device-width" />

    <meta property="og:type" content="website" />
	<meta property="og:url" content="<?php if (isset($header_canonical)) { echo cal_htmlspecialchars($header_canonical); } ?>" />
	<meta property="og:title" content="<?php if (isset($header_title)) { echo cal_htmlspecialchars($header_title); } ?>" />
	<meta property="og:description" content="<?php if (isset($header_description)) { echo cal_htmlspecialchars($header_description); } ?>" />
	<?php if (isset($header_canonical) & !empty($header_canonical)) { ?>
		<link rel="canonical" href="<?= $header_canonical; ?>" />
	<?php } ?>
	<link rel="apple-touch-icon" sizes="180x180" href="<?= cal_get_base_url(CAL_PATH_WEB) . '/assets/img/icon.png'; ?>" />
 	<link type="text/css" rel="stylesheet" href="<?= cal_get_base_url(CAL_PATH_WEB) . '/assets/css/styles.css'; ?>"  media="all" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="<?= cal_get_base_url(CAL_PATH_WEB) . '/assets/js/main.js' ?>"></script>
	<title>
		<?= cal_htmlspecialchars($header_title); ?>
	</title>
	<link rel=”shortcut icon” href=”<?= cal_get_base_url(CAL_PATH_WEB) . '/favicon.ico'; ?>”>
	<link rel="icon" type="image/png" href="<?= cal_get_base_url(CAL_PATH_WEB) . '/assets/img/favicon.png' ?>">
	<link rel="shortcut icon" type="image/png"  href="<?= cal_get_base_url(CAL_PATH_WEB) . '/assets/img/favicon.png' ?>" />
    <?php if ($_SERVER['REQUEST_URI'] == '' || $_SERVER['REQUEST_URI'] == '/') { ?>
        <?php // estamos na raiz e no site de produção ?>
        <link rel="alternate" hreflang="en" href="https://www.playflashcards.com/en/">
        <link rel="alternate" hreflang="pt-br" href="https://www.playflashcards.com/pt-br/">
        <link rel="alternate" hreflang="es" href="https://www.playflashcards.com/es/">
        <link rel="alternate" hreflang="fr" href="https://www.playflashcards.com/fr/">
    <?php } ?>
    <?php if (CAL_PROD and isset($_COOKIE['consent_key'])) { ?>
		<?php include_once CAL_ROOT_GENERAL . '/ga.inc'; ?>
	<?php } ?>
</head>
<body>
    <?php if (empty($_timezone)) { ?>
        <script>
            $(document).ready(function() {
                // Atualiza o timezone do navegador na sessão do usuário
                $.ajax({
                    url: "<?= CAL_PATH_WEB . '/services/set-timezone-act'; ?>",
                    type: "POST",
                    data: {timezone: getTimezoneFormated()},
                    success: function (response) {
                    },
                    error: function (xhr, status, error) {
                    }
                });
            });
        </script>
    <?php } ?>
	<div id="div-content">
        <div class="div-header">
            <div class="container">
                <div class="logo">
                    <?php if ($_login == 'off') { ?>
                        <a href="<?= CAL_PATH_WEB . '/' . $t['lang'] . '/'; ?>">
                            <img src="<?= CAL_PATH_WEB . '/assets/img/playflashcards-logo.png'; ?>" width="40px" height="40px" alt="Play Flashcards" />
                        </a>
                    <?php } else { ?>
                        <a href="<?= CAL_PATH_WEB . '/dash/deck-list'; ?>">
                            <img src="<?= CAL_PATH_WEB . '/assets/img/playflashcards-logo.png'; ?>" width="40px" height="40px" alt="Play Flashcards" />
                        </a>
                    <?php } ?>
                    <span>
                        Play Flashcards
                    </span>
                </div>
                <div class="menu" id="btn_menu_div">
                    <img id="menu_img" src="<?= CAL_PATH_WEB . '/assets/img/menu.png'; ?>" width="40px" height="40px" alt="<?= cal_t($t, 'Menu'); ?>" />
                    <img id="close_img" src="<?= CAL_PATH_WEB . '/assets/img/close.png'; ?>" width="40px" height="40px" alt="<?= cal_t($t, 'Menu'); ?>" />
                </div>
            </div>
            <div id="menu_div">
                <div class="menu">
                    <?php if ($_login == 'off') { ?>
                        <div><a href="<?= CAL_PATH_WEB . '/'. $t['lang'] . '/'; ?>"><?= cal_t($t, 'Home'); ?></a></div>
                        <div><a href="<?= CAL_PATH_WEB . '/'. $t['lang'] . '/login/login'; ?>"><?= cal_t($t, 'Get Started'); ?></a></div>
                    <?php } else { ?>
                        <div class="title"><?= cal_t($t, 'Welcome'); ?></div>
                        <div><a href="<?= CAL_PATH_WEB . '/dash/deck-list'; ?>"><?= cal_t($t, 'Decks'); ?></a></div>
                        <div><a href="<?= CAL_PATH_WEB . '/dash/deck-new-act'; ?>"><?= cal_t($t, 'New Deck'); ?></a></div>
                        <div><a href="<?= CAL_PATH_WEB . '/profile/profile'; ?>"><?= cal_t($t, 'Profile'); ?></a></div>
                    <?php } ?>
                    <div class="title">Play Flashcards</div>
                    <div><a href="<?= CAL_PATH_WEB . '/'. $t['lang'] . '/contact-us'; ?>"><?= cal_t($t, 'Contact us'); ?></a></div>
                    <div><a href="<?= CAL_PATH_WEB . '/'. $t['lang'] . '/terms-and-conditions'; ?>"><?= cal_t($t, 'Terms and Conditions'); ?></a></div>
                    <div><a href="<?= CAL_PATH_WEB . '/'. $t['lang'] . '/privacy-policy'; ?>"><?= cal_t($t, 'Privacy Policy'); ?></a></div>
                </div>
            </div>
        </div>
        <header>
            <!-- -->
        </header>
