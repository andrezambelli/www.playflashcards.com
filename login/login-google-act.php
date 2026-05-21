<?php /** @var array $t */ ?>
<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/car-server.php';?>
<?php include_once CAL_ROOT_WEB . '/config.inc';?>
<?php include_once CAL_ROOT_EXTERNAL_LIB . '/google-api-client-2.12.1/vendor/autoload.php';?>
<?php include CAL_ROOT_WEB . '/lang/lang.inc'; ?>
<?php
    // Parâmetros
	$redirect_url = cal_get_parameter('redirect_url', '');

    // Variáveis
	$redirect = CAL_PATH_WEB . '/'. $t['lang'] . '/login/login';
	
	use Google\Client as GoogleClient;

	try {
		if (isset($_POST['credential']) and isset($_POST['g_csrf_token'])) {
			if (isset($_COOKIE['g_csrf_token'])) {
				$cookie = $_COOKIE['g_csrf_token'];
				
				if ($_POST['g_csrf_token'] == $cookie) {
					$client = new GoogleClient(['client_id' => CAL_GOOGLE_CLIENT_ID]);
					
					$payload = $client->verifyIdToken($_POST['credential']);
					
					if ($payload) { // o payload precisa ter conteúdo, precisa ser um objeto/ string json
						if (isset($payload['email'])) { // o payload precisa ter um e-mail
							$user_email = $payload['email'];

                            if (!empty($user_email)) {
                                include_once CAL_ROOT_WEB . '/login/user-insert-act.inc';

                                if (empty($redirect_url)) {
                                    $redirect = CAL_PATH_WEB . '/dash/deck-list';
                                } else {
                                    $redirect = $redirect_url;
                                }
                            } else {
                                cal_set_session_error_message('login.login-google-act.error');

                                $redirect = CAL_PATH_WEB . '/'. $t['lang'] . '/login/login';
                            }
						} else {
							cal_set_session_error_message('login.login-google-act.error');
							
							$redirect = CAL_PATH_WEB . '/'. $t['lang'] . '/login/login';
						}
					} else {
						cal_set_session_error_message('login.login-google-act.error');
						
						$redirect = CAL_PATH_WEB . '/'. $t['lang'] . '/login/login';
					}
				} else {
					cal_set_session_error_message('login.login-google-act.error');
					
					$redirect = CAL_PATH_WEB . '/'. $t['lang'] . '/login/login';
				}
			} else {
				cal_set_session_error_message('login.login-google-act.error');
				
				$redirect = CAL_PATH_WEB . '/'. $t['lang'] . '/login/login';
			}
		} else {
			cal_set_session_error_message('login.login-google-act.error');
			
			$redirect = CAL_PATH_WEB . '/'. $t['lang'] . '/login/login';
		}
	} catch(Exception $e) {
		$mysqli->rollback();
		
		cal_set_session_error_message($e->getMessage());
		
		$redirect = CAL_PATH_WEB . '/'. $t['lang'] . '/login/login';
	}

    $mysqli->close();
	
	cal_redirect($redirect);
?>