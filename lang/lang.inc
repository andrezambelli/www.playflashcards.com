<?php
    $path  = strtok($_SERVER['REQUEST_URI'] ?? '', '?');
    $first = explode('/', trim($path, '/'))[0] ?? '';
    $valid = ['en', 'pt-br', 'es', 'fr'];

    if (in_array($first, $valid)) {
        $_SESSION['lang'] = $first;
    } elseif (empty($_SESSION['lang'])) {
        $_SESSION['lang'] = 'en';
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
