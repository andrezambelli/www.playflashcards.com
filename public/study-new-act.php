<?php /** @var array $t */ ?>
<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/car-server.php'; ?>
<?php include_once CAR_ROOT_WEB . '/config.inc'; ?>
<?php include CAR_ROOT_WEB . '/lang/lang.inc'; ?>
<?php
	// Parâmetros
	$user_id = CAR_USER_ID_MASTER; // o estudo iniciado aqui sempre será público

    $deck_key = car_get_parameter('k', '');

    // Variáveis
	$deck_id = 0;
	
	$redirect = CAR_PATH_WEB . '/deck/' . $deck_key;

	if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
		car_redirect($redirect);
	}

	// reutiliza estudo público aberto da mesma sessão do browser
	$_session_study_key = 'car_pub_' . $deck_key;
	if (!empty($_SESSION[$_session_study_key])) {
		$sql = sprintf("select stud_key
                          from car_study
                         where stud_key = '%s'
                           and user_id = %d
                           and stud_end is null
                         limit 1",
						$mysqli->real_escape_string($_SESSION[$_session_study_key]),
						$user_id);
		$result = $mysqli->query($sql);
		if ($result->num_rows > 0) {
			$mysqli->close();
			car_redirect(CAR_PATH_WEB . '/study/' . $_SESSION[$_session_study_key]);
		}
		unset($_SESSION[$_session_study_key]);
	}

	try {
		// Procurando o deck_id
		$sql = sprintf("select deck_id
                          from car_deck
                         where deck_key = '%s'
                           and deck_public = 1",
                        $mysqli->real_escape_string(car_never_null($deck_key)));
		
		$result = $mysqli->query($sql);
		
		while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
			$deck_id = $row['deck_id'];
		}

        if ($deck_id === 0) {
            include_once CAR_ROOT_WEB . '/common/404.php';
            exit;
        }

        // Apaga todos os cards em branco do usuarios
        $_sql = sprintf("delete from car_card
                          where deck_id = %d
                            and (card_front is null or trim(card_front) = '' or card_back is null or trim(card_back) = '')",
                        $deck_id);

        $_result = $mysqli->query($_sql);

        if (!$_result) { error_log($mysqli->sqlstate . ' - ' . $mysqli->error); throw new Exception('error.db'); }

        // Cria a chave do estudo
        $stud_key = null;

        while ($stud_key == null) {
            $stud_key = car_generate_key(12);

            // A chave do estudo precisa ser única no banco de dados
            $sql = sprintf("select count(1) as count
                              from car_study
                             where stud_key = '%s'",
                            $mysqli->real_escape_string(car_never_null($stud_key)));

            $result = $mysqli->query($sql);

            while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
                $_count = $row['count'];

                if ($_count >= 1) $stud_key = null;
            }
        }
			
        // Procurando o total de cartões deste grupo
        $stud_total = 0;
        $sql = sprintf('select count(1) as count
                          from car_card
                         where deck_id = %d',
                        $deck_id);

        $result = $mysqli->query($sql);

        while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
            $stud_total = $row['count'];
        }

        if ($stud_total > 0) {
            // O estudo sempres erá publico nesta ação
            $_public = 1; // true

            // Inserindo o estudo público
            $sql = sprintf("insert into car_study
                                (user_id, deck_id, stud_key, stud_total, stud_public)
                            values (%d, %d, '%s', %d, %d)",
                            $user_id,
                            $deck_id,
                            $mysqli->real_escape_string(car_never_null($stud_key)),
                            $stud_total,
                            $_public);

            $result = $mysqli->query($sql);

            $stud_id = car_last_insert_id($mysqli);

            if (!$result) { error_log($mysqli->sqlstate . ' - ' . $mysqli->error); throw new Exception('error.db'); }

            // Inserindo os cartões na sessão do estudo
            $sql = sprintf('insert into car_study_session
                                (stse_order, user_id, stud_id, card_id)
                            select row_number() over (order by RAND()) as stse_order, %d, %d, card_id
                              from car_card
                             where deck_id = %d',
                            $user_id,
                            $stud_id,
                            $deck_id);

            $result = $mysqli->query($sql);

            if (!$result) { error_log($mysqli->sqlstate . ' - ' . $mysqli->error); throw new Exception('error.db'); }

            $mysqli->commit();

            $_SESSION[$_session_study_key] = $stud_key;
            $redirect = CAR_PATH_WEB . '/study/' . $stud_key;
        } else {
            car_set_session_error_message('dash.study-new-act.no-cards');

            $redirect = CAR_PATH_WEB . '/deck/' . $deck_key;
        }
	} catch(Exception $e) {
		$mysqli->rollback();
		
		car_set_session_error_message($e->getMessage());
		
		$redirect = CAR_PATH_WEB . '/deck/' . $deck_key;
	}

	$mysqli->close();

	car_redirect($redirect);
?>
