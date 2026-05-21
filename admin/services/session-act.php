<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/car-server.php';?>
<?php include_once CAL_ROOT_ADMIN . '/config.inc' ?>
<?php 
	try {
		// apagando as respostas
		$sql = "delete from car_session";
		
		$result = $mysqli->query($sql);
		
		if (!$result) throw new Exception($mysqli->sqlstate . ' - ' .$mysqli->error);
		
		$mysqli->commit();
	} catch(Exception $e) {
		$mysqli->rollback();
		
		cal_set_session_error_message($e->getMessage());
	}
?>
<?php include_once CAL_ROOT_ADMIN . "/include/header.inc"; ?>
<div class="master">
	<div class="form">
		<strong>Apagar Sessões</strong><br/>
		<br/>
		Sessões excluídas com sucesso.
	</div>
</div>
<?php include_once CAL_ROOT_ADMIN . "/include/footer.inc"; ?>
		