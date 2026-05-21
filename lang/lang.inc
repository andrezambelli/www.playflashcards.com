<?php
    if ($_SESSION['lang'] == 'pt-br') {
        include CAR_ROOT_WEB . '/lang/lang-pt-br.inc';
    } elseif ($_SESSION['lang'] == 'es') {
        include CAR_ROOT_WEB . '/lang/lang-es.inc';
    } elseif ($_SESSION['lang'] == 'fr') {
        include CAR_ROOT_WEB . '/lang/lang-fr.inc';
    } else {
        include CAR_ROOT_WEB . '/lang/lang-en.inc';
    }
