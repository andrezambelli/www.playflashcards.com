<?php
    $_found = false;

	if (!empty($card_key)) {
		// Procurando a chave do grupo pela chave do cartão
		$sql = sprintf("
                        select b.deck_key
                          from car_card a, car_deck b
                         where a.card_key = '%s'
                           and a.user_id = %d
                           and a.deck_id = b.deck_id",
                        $mysqli->real_escape_string(car_never_null($card_key)),
						$user_id);
		
		$result = $mysqli->query($sql);
		
		while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
			$deck_key = $row['deck_key'];
		}
	} elseif (!empty($stud_key)) {
		// Procurando a chave do grupo pela chave do estudo
		$sql = sprintf(" 
                        select b.deck_key
                          from car_study a, car_deck b
                         where a.stud_key = '%s'
                           and a.user_id = %d
                           and a.deck_id = b.deck_id",
                        $mysqli->real_escape_string(car_never_null($stud_key)),
                        $user_id);
		
		$result = $mysqli->query($sql);
		
		while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
			$deck_key = $row['deck_key'];
		}
	}
	
	// Procurando informação do grupo
	if (!empty($deck_key)) {
		$sql = sprintf(" 
                        select deck_key, deck_name, deck_desc
                          from car_deck a
                         where deck_key = '%s'
                           and user_id = %d",
                        $mysqli->real_escape_string(car_never_null($deck_key)),
                        $user_id);
		
		$result_subsubmenu = $mysqli->query($sql);
		
		$_deck_key = '';
		$_deck_name = '';
		$_deck_desc = '';
		
		$_found = false;
		
		while ($row = $result_subsubmenu->fetch_array(MYSQLI_ASSOC)) {
			$_deck_key = $row['deck_key'];
			$_deck_name = $row['deck_name'];
			$_deck_desc = $row['deck_desc'];
			
			$_found = true;
		}
	}
	
	// Se não achou o grupo, apresenta mensagem de erro
	if (!$_found) {
		car_set_session_error_message('dash.deck-info.not-found');

        car_redirect(CAR_PATH_WEB . '/dash/deck-list');
	}
?>

<?php if ($_found) { ?>
    <a href="<?= CAR_PATH_WEB; ?>/dash/deck?k=<?= $deck_key; ?>" class="button w100p">
        <?= car_htmlspecialchars($_deck_name); ?>
    </a>
<?php } ?>
