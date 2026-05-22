<?php /** @var array $t */ ?>
<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/car-server.php';?>
<?php include_once CAR_ROOT_WEB . '/config.inc';?>
<?php include CAR_ROOT_WEB . '/lang/lang.inc'; ?>
<?php
    $redirect = CAR_PATH_WEB . '/'. $t['lang'] . '/login/login';

    function car_google_exchange_code(string $code): array {
        $ch = curl_init('https://oauth2.googleapis.com/token');
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST           => true,
            CURLOPT_POSTFIELDS     => http_build_query([
                'code'          => $code,
                'client_id'     => CAR_GOOGLE_CLIENT_ID,
                'client_secret' => CAR_GOOGLE_CLIENT_SECRET,
                'redirect_uri'  => CAR_BASE_URL . '/login/login-google-act',
                'grant_type'    => 'authorization_code',
            ]),
            CURLOPT_HTTPHEADER => ['Content-Type: application/x-www-form-urlencoded'],
        ]);
        $body = curl_exec($ch);
        curl_close($ch);
        return json_decode($body ?: '{}', true) ?? [];
    }

    function car_google_userinfo(string $access_token): array {
        $ch = curl_init('https://www.googleapis.com/oauth2/v3/userinfo');
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER     => ['Authorization: Bearer ' . $access_token],
        ]);
        $body = curl_exec($ch);
        curl_close($ch);
        return json_decode($body ?: '{}', true) ?? [];
    }

    try {
        $code         = car_get_parameter('code', '');
        $state_get    = car_get_parameter('state', '');
        // cookie tem prioridade: sobrevive à mudança de domínio localhost <-> playflashcards.localhost
        $state_stored = $_COOKIE['car_google_state'] ?? car_get_session_attribute('google_oauth_state', '');
        $redirect_url = car_get_session_attribute('google_redirect_url', '');

        // limpa state da sessão e do cookie imediatamente para evitar replay
        car_set_session_attribute('google_oauth_state', '');
        car_set_session_attribute('google_redirect_url', '');
        setcookie('car_google_state', '', ['expires' => time() - 3600, 'path' => '/', 'domain' => CAR_PROD ? '' : '.localhost']);

        if (empty($code) || empty($state_get) || empty($state_stored) || $state_get !== $state_stored) {
            car_set_session_error_message('login.login-google-act.error');
            car_redirect($redirect);
        }

        $token = car_google_exchange_code($code);

        if (empty($token['access_token'])) {
            car_set_session_error_message('login.login-google-act.error');
            car_redirect($redirect);
        }

        $userinfo = car_google_userinfo($token['access_token']);

        if (empty($userinfo['email'])) {
            car_set_session_error_message('login.login-google-act.error');
            car_redirect($redirect);
        }

        $user_email = $userinfo['email'];
        include_once CAR_ROOT_WEB . '/login/user-insert-act.inc';

        if (empty($redirect_url)) {
            $redirect = CAR_PATH_WEB . '/dash/deck-list';
        } else {
            $redirect = car_safe_redirect_url($redirect_url, CAR_PATH_WEB . '/dash/deck-list');
        }

    } catch (Exception $e) {
        $mysqli->rollback();
        car_set_session_error_message($e->getMessage());
        $redirect = CAR_PATH_WEB . '/'. $t['lang'] . '/login/login';
    }

    $mysqli->close();
    car_redirect($redirect);
?>
