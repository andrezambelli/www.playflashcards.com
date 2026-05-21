<?php
    if ($_SESSION['lang'] == 'pt-br') {
        include CAL_ROOT_WEB . '/lang/lang-pt-br.inc';
    } elseif ($_SESSION['lang'] == 'es') {
        include CAL_ROOT_WEB . '/lang/lang-es.inc';
    } elseif ($_SESSION['lang'] == 'fr') {
        include CAL_ROOT_WEB . '/lang/lang-fr.inc';
    } else {
        include CAL_ROOT_WEB . '/lang/lang-en.inc';
    }
