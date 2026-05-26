<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/car-server.php';?>
<?php include_once CAR_ROOT_ADMIN . '/config.inc' ?>
<?php 
	try {
		// apagando as respostas
        $sql = 'select card_id,
                       card_true,
                       card_false
                  from car_card
                 order by card_id asc';

        $result = $mysqli->query($sql, MYSQLI_STORE_RESULT);
		
		if (!$result) throw new Exception($mysqli->sqlstate . ' - ' .$mysqli->error);

    	while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
            $id = $row['card_id'];
            $true = $row['card_true'];
            $false = $row['card_false'];
            $rate = car_percent($true, $true + $false);

            $sql = sprintf('update car_card
                               set card_rate = %d
                             where card_id = %d',
                            $rate,
                            $id);

            $_result = $mysqli->query($sql);

            if (!$_result) throw new Exception($mysqli->sqlstate . ' - ' .$mysqli->error);
        }

		$mysqli->commit();
	} catch(Exception $e) {
		$mysqli->rollback();
		
		car_set_session_error_message($e->getMessage());
	}
?>
<?php include_once CAR_ROOT_ADMIN . '/containers/header.inc'; ?>
<div class="master">
	<div class="form">
        <?php include_once CAR_ROOT_ADMIN . '/containers/message.inc' ?>
		<strong>Atualizar Rate dos Cartões</strong><br/>
		<br/>
		Rate dos cartões atualizado com sucesso.
	</div>
</div>
<?php include_once CAR_ROOT_ADMIN . '/containers/footer.inc'; ?>
