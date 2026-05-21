<?php
	// o $user_email foi definido no php que chamou esse inc

    // Variáveis
	$user_id = 0;
    $user_lang = CAR_SYSTEM_LANG_DEFAULT;
	$user_max_group = 0;
	$user_max_card = 0;
	$user_max_study = 0;
	
	// Procurando o user_id pela conta de e-mail
	$sql = sprintf("select user_id, user_lang from car_user where user_email = '%s'",
                    $mysqli->real_escape_string(car_never_null($user_email)));
	
	$result = $mysqli->query($sql);
	
	while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
		$user_id = $row['user_id'];
	}
	
	if ($user_id == 0) {
        // Pega o idioma definido na sessão e define para o usuario
        $user_lang = $t['lang'];

		// Inserindo o usuário
		$sql = sprintf("insert into car_user (user_email, user_lang) values ('%s', '%s')",
                        $mysqli->real_escape_string(car_never_null($user_email)),
                        $mysqli->real_escape_string(car_never_null($user_lang)));
		
		$result = $mysqli->query($sql);
		
		$user_id = car_last_insert_id($mysqli);

        $mysqli->commit();
    }

    // Atualizando o cookie do navegador para o usuario
    if (isset($_COOKIE['consent_key'])) {
        $cook_key = $_COOKIE['consent_key'];

        $sql = sprintf("
                        update car_cookie set user_id = %d where cook_key = '%s' and cook_update = now()",
                        $user_id,
                        $mysqli->real_escape_string(car_never_null($cook_key)));

        $mysqli->query($sql);

        $mysqli->commit();
    }
	
	// Procurando informações do usuario
	$sql = sprintf('select user_lang, user_max_deck, user_max_card, user_max_study from car_user where user_id = %d',
                    $user_id);
	
	$result = $mysqli->query($sql);
	
	while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
		$user_max_deck = $row['user_max_deck'];
		$user_max_card = $row['user_max_card'];
		$user_max_study = $row['user_max_study'];
        $user_lang = $row['user_lang'];
	}

    // Carrega o conteúdo do idioma do usuario
    $_SESSION['lang'] = $user_lang;

	car_set_session_attribute('session_login', 'on'); // logado!
	car_set_session_attribute('user_id', $user_id); // armazenando o user_id na sessão
	car_set_session_attribute('user_max_deck', $user_max_deck); // armazenando o número máximo de grupos por usuário
	car_set_session_attribute('user_max_card', $user_max_card); // armazenando o número máximo de cartões por grupo
	car_set_session_attribute('user_max_study', $user_max_study); // armazenando o número máximo de estudos por grupo
