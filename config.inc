<?php
    include_once 'general/functions.inc';
    include_once 'general/db.inc';

    const CAR_VERSION = '0.1.0';

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

    const CAR_DECK_BGCOLOR_DEFAULT = 'fef161';

    const CAR_SYSTEM_LANG_DEFAULT = 'en';

    const CAR_TIMEZONE_DEFAULT = '+00:00';

    const CAR_USER_SRS_LIMIT = 20;
    const CAR_USER_SRS_SEQUENCE = 5;
    const CAR_USER_SRS_RATE = 75;
    const CAR_USER_SRS_DAYS = 7;

    // em produção envia e-mail real; em desenvolvimento usa código fixo 111111 sem envio
    define('CAR_SEND_EMAIL', car_is_production());

    // Se o idioma estiver vazio na sessão
    // Carrega o conteúdo do idioma do navegador na sessão
    if (!isset($_SESSION['lang'])) {
        // $_SESSION['lang'] = car_get_browser_language();
        $_SESSION['lang'] = CAR_SYSTEM_LANG_DEFAULT;
    }

    include_once 'routes.inc';
