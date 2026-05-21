<?php /** @var array $t */ ?>
<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/car-server.php';?>
<?php include_once CAR_ROOT_WEB . '/config.inc';?>
<?php include CAR_ROOT_WEB . '/lang/lang.inc'; ?>
<?php car_check_login($t); ?>
<?php
	// Parâmetros 
	$user_id = car_get_session_attribute('user_id', 0);

    $deck_key = car_get_parameter('k', '');

    // Variáveis
	$deck_id = 0;

    // Procurando informação do grupo
    $sql = sprintf(" select deck_id from car_deck where deck_key = '%s' and user_id = %d",
                    $mysqli->real_escape_string(car_never_null($deck_key)),
                    $user_id);

    $result = $mysqli->query($sql);

    while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
        $deck_id = $row['deck_id'];
    }

    // Procurando os cartões do grupo
    $sql = sprintf('select card_front, card_back
                            from car_card
                           where deck_id = %d
                             and user_id = %d
                           order by card_front',
                    $deck_id,
                    $user_id);

    $result = $mysqli->query($sql);

    $today = date("YmdHis");
    $filename = $deck_key . '-'. $today . '.csv';

    // Define o cabeçalho para download
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=' . $filename);

    $output = fopen('php://output', 'w');

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
            fputcsv($output, [$row['card_front'], $row['card_back']], ';');
        }
    }

    fclose($output);
    exit();


