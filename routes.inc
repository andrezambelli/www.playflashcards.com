<?php
	$routes = [];

    // general
    $routes['en'] = 'main.php';
    $routes['pt-br'] = 'main.php';
    $routes['fr'] = 'main.php';
    $routes['es'] = 'main.php';

    // login - public
    $routes['en/login/login'] = 'login/login.php';
    $routes['pt-br/login/login'] = 'login/login.php';
    $routes['fr/login/login'] = 'login/login.php';
    $routes['es/login/login'] = 'login/login.php';

    $routes['login/login-act'] = 'login/login-act.php';
    $routes['login/logoff-act'] = 'login/logoff-act.php';
    $routes['login/login-pincode'] = 'login/login-pincode.php';
    $routes['login/login-pincode-act'] = 'login/login-pincode-act.php';
    $routes['login/login-google-act'] = 'login/login-google-act.php';

    $routes['deck/study-new-act'] = 'public/study-new-act.php';
    $routes['study/study-act'] = 'public/study-act.php';
    $routes['study/study-delete-act'] = 'public/study-delete-act.php';

    // system
    $routes['404'] = 'common/404.php';
    $routes['home/home'] = 'home/home.php';
    $routes['services/set-timezone-act'] = 'services/set-timezone-act.php';
    $routes['services/set-cookie-act'] = 'services/set-cookie-act.php';
    $routes['services/change-language-act'] = 'services/change-language-act.php';

    // profile - private
    $routes['profile/home'] = 'profile/home.php';
    $routes['profile/profile-delete'] = 'profile/profile-delete.php';
    $routes['profile/profile-delete-act'] = 'profile/profile-delete-act.php';
    $routes['profile/srs'] = 'profile/srs.php';
    $routes['profile/srs-act'] = 'profile/srs-act.php';

    // deck - private
    $routes['dash/home'] = 'dash/home.php';
    $routes['dash/deck-list'] = 'dash/deck-list.php';
    $routes['dash/deck'] = 'dash/deck.php';
    $routes['dash/deck-new'] = 'dash/deck-new.php';
    $routes['dash/deck-new-act'] = 'dash/deck-new-act.php';
    $routes['dash/deck-edit'] = 'dash/deck-edit.php';
    $routes['dash/deck-edit-act'] = 'dash/deck-edit-act.php';
    $routes['dash/deck-delete'] = 'dash/deck-delete.php';
    $routes['dash/deck-delete-act'] = 'dash/deck-delete-act.php';
    $routes['dash/card-list'] = 'dash/card-list.php';
    $routes['dash/card-new'] = 'dash/card-new.php';
    $routes['dash/card-new-act'] = 'dash/card-new-act.php';
    $routes['dash/card-edit'] = 'dash/card-edit.php';
    $routes['dash/card-edit-act'] = 'dash/card-edit-act.php';
    $routes['dash/card-delete-act'] = 'dash/card-delete-act.php';
    $routes['dash/study-list'] = 'dash/study-list.php';
    $routes['dash/study-new-act'] = 'dash/study-new-act.php';
    $routes['dash/study-srs-new-act'] = 'dash/study-srs-new-act.php';
    $routes['dash/study'] = 'dash/study.php';
    $routes['dash/study-act'] = 'dash/study-act.php';
    $routes['dash/study-delete-act'] = 'dash/study-delete-act.php';
    $routes['dash/card-download-act'] = 'dash/card-download-act.php';
    $routes['dash/card-upload-act'] = 'dash/card-upload-act.php';

    // common - public
    $routes['en/contact-us'] = 'common/contact-us.php';
    $routes['pt-br/contact-us'] = 'common/contact-us.php';
    $routes['es/contact-us'] = 'common/contact-us.php';
    $routes['fr/contact-us'] = 'common/contact-us.php';

    $routes['en/cookie-settings'] = 'common/cookie-settings.php';
    $routes['pt-br/cookie-settings'] = 'common/cookie-settings.php';
    $routes['es/cookie-settings'] = 'common/cookie-settings.php';
    $routes['fr/cookie-settings'] = 'common/cookie-settings.php';

    $routes['en/terms-and-conditions'] = 'common/terms-and-conditions.php';
    $routes['pt-br/terms-and-conditions'] = 'common/terms-and-conditions.php';
    $routes['es/terms-and-conditions'] = 'common/terms-and-conditions.php';
    $routes['fr/terms-and-conditions'] = 'common/terms-and-conditions.php';

    $routes['en/privacy-policy'] = 'common/privacy-policy.php';
    $routes['pt-br/privacy-policy'] = 'common/privacy-policy.php';
    $routes['es/privacy-policy'] = 'common/privacy-policy.php';
    $routes['fr/privacy-policy'] = 'common/privacy-policy.php';

