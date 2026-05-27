<?php
    $path  = strtok($_SERVER['REQUEST_URI'] ?? '', '?');
    $first = explode('/', trim($path, '/'))[0] ?? '';
    $valid = ['en', 'pt-br', 'es', 'fr'];

    if (in_array($first, $valid)) {
        $_SESSION['lang'] = $first;
    } elseif (empty($_SESSION['lang'])) {
        // novo visitante: detecta idioma preferido pelo navegador, fallback en
        preg_match('/^([a-z]{2})/i', $_SERVER['HTTP_ACCEPT_LANGUAGE'] ?? '', $_m);
        $_browser = strtolower($_m[1] ?? '');
        $_lang_map = ['pt' => 'pt-br', 'es' => 'es', 'fr' => 'fr'];
        $_SESSION['lang'] = $_lang_map[$_browser] ?? 'en';
        unset($_m, $_browser, $_lang_map);
    }

    if ($_SESSION['lang'] == 'pt-br') {
        include CAR_ROOT_WEB . '/lang/lang-pt-br.inc';
    } elseif ($_SESSION['lang'] == 'es') {
        include CAR_ROOT_WEB . '/lang/lang-es.inc';
    } elseif ($_SESSION['lang'] == 'fr') {
        include CAR_ROOT_WEB . '/lang/lang-fr.inc';
    } else {
        include CAR_ROOT_WEB . '/lang/lang-en.inc';
    }
