<?php
    include_once 'general/config.inc';
    include_once 'general/functions.inc';

    const CAR_VERSION = '0.0.24';

    // Controla a versão para recarregar o arquivo de idioma na sessão
    if (!isset($_SESSION['version'])) {
        $_SESSION['version'] = CAR_VERSION;
    }

    if ($_SESSION['version'] != CAR_VERSION) {
        $_SESSION['version'] = CAR_VERSION;

        unset($_SESSION['lang']);
    }

    if (!isset($_SESSION['session_login']) or $_SESSION['session_login'] == '') {
        $_SESSION['session_login'] = 'off';
    }

    const CAR_USER_ID_MASTER = 1; // Id do usuário master. Utilizado para Grupos e Estudos Públicos
    const CAR_USER_EMAIL_MASTER = 'flashcardsplay@gmail.com'; // Email do usuário master

    const CAR_USER_MAX_DECK = 5; // precisa ser a mesma definição do banco de dados
    const CAR_USER_MAX_STUDY = 500; // precisa ser a mesma definição do banco de dados
    const CAR_USER_MAX_CARD = 100;  // precisa ser a mesma definição do banco de dados

    const CAR_DECK_NAME_DEFAULT = 'NEW_DELETE_GROUP';
    const CAR_DECK_BGCOLOR_DEFAULT = 'fef161';

    const CAR_SYSTEM_LANG_DEFAULT = 'en';

    const CAR_TIMEZONE_DEFAULT = '+00:00';

    const CAR_USER_SRS_LIMIT = 20;
    const CAR_USER_SRS_SEQUENCE = 5;
    const CAR_USER_SRS_RATE = 75;
    const CAR_USER_SRS_DAYS = 7;

    const CAR_GOOGLE_CLIENT_ID  = '353483523181-otmn1tnj09sbbj1gfvjpeba8tvga5dn2.apps.googleusercontent.com';
    const CAR_SERVICE_URL       = 'https://services.onepropage.com.br/auth/send-pin-user-1.0.0.php';

    // Se o idioma estiver vazio na sessão
    // Carrega o conteúdo do idioma do navegador na sessão
    if (!isset($_SESSION['lang'])) {
        // $_SESSION['lang'] = car_get_browser_language();
        $_SESSION['lang'] = CAR_SYSTEM_LANG_DEFAULT;
    }

    include_once 'routes.inc';