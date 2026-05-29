<?php
    $path  = strtok($_SERVER['REQUEST_URI'] ?? '', '?');
    $first = explode('/', trim($path, '/'))[0] ?? '';
    $valid = ['en', 'pt-br', 'es', 'fr', 'de', 'it', 'ja', 'zh', 'nl', 'pl', 'ru', 'hi'];

    if (in_array($first, $valid)) {
        $_SESSION['lang'] = $first;
    } elseif (empty($_SESSION['lang'])) {
        // novo visitante: detecta idioma preferido pelo navegador, fallback en
        preg_match('/^([a-z]{2})/i', $_SERVER['HTTP_ACCEPT_LANGUAGE'] ?? '', $_m);
        $_browser = strtolower($_m[1] ?? '');
        $_lang_map = ['pt' => 'pt-br', 'es' => 'es', 'fr' => 'fr', 'de' => 'de', 'it' => 'it', 'ja' => 'ja', 'zh' => 'zh', 'nl' => 'nl', 'pl' => 'pl', 'ru' => 'ru', 'hi' => 'hi'];
        $_SESSION['lang'] = $_lang_map[$_browser] ?? 'en';
        unset($_m, $_browser, $_lang_map);
    }

    if ($_SESSION['lang'] == 'pt-br') {
        include CAR_ROOT_WEB . '/lang/lang-pt-br.inc';
    } elseif ($_SESSION['lang'] == 'es') {
        include CAR_ROOT_WEB . '/lang/lang-es.inc';
    } elseif ($_SESSION['lang'] == 'fr') {
        include CAR_ROOT_WEB . '/lang/lang-fr.inc';
    } elseif ($_SESSION['lang'] == 'de') {
        include CAR_ROOT_WEB . '/lang/lang-de.inc';
    } elseif ($_SESSION['lang'] == 'it') {
        include CAR_ROOT_WEB . '/lang/lang-it.inc';
    } elseif ($_SESSION['lang'] == 'ja') {
        include CAR_ROOT_WEB . '/lang/lang-ja.inc';
    } elseif ($_SESSION['lang'] == 'zh') {
        include CAR_ROOT_WEB . '/lang/lang-zh.inc';
    } elseif ($_SESSION['lang'] == 'nl') {
        include CAR_ROOT_WEB . '/lang/lang-nl.inc';
    } elseif ($_SESSION['lang'] == 'pl') {
        include CAR_ROOT_WEB . '/lang/lang-pl.inc';
    } elseif ($_SESSION['lang'] == 'ru') {
        include CAR_ROOT_WEB . '/lang/lang-ru.inc';
    } elseif ($_SESSION['lang'] == 'hi') {
        include CAR_ROOT_WEB . '/lang/lang-hi.inc';
    } else {
        include CAR_ROOT_WEB . '/lang/lang-en.inc';
    }

    include_once CAR_ROOT_WEB . '/lang/lang-list.inc';
