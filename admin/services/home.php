<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/car-server.php';?>
<?php include_once CAR_ROOT_ADMIN . '/config.inc' ?>
<?php car_set_session_attribute('read_database', 'on'); ?>
<?php 
	$total_sessions = 0;
	$last_session = 0;

	// contando quantas linhas de session
	$sql = "select count(*) as count from car_session";

	$result = $mysqli->query($sql, MYSQLI_STORE_RESULT);

	while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
		$total_sessions = $row['count'];
	}

	// contando quantas linhas de session
	$sql = "select created from car_session order by created desc limit 1";

	$result = $mysqli->query($sql, MYSQLI_STORE_RESULT);
	
	while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
		$last_session = $row['created'];
	}
?>
<?php include_once CAR_ROOT_ADMIN . "/include/header.inc"; ?>
<div class="master">
    <div class="subtitle"><div>Serviços</div></div>
	<div class="form">
		<a href="sitemap-act.php">Criar Sitemap</a><br/>
		Para gerar o sitemap.xml principal do site + todas as categorias.<br/>
		<br/>
		<a href="update-card-rate-act.php">Atualizar Rate dos Cartões</a><br/>
		Atualiza o rate de todos os cartões.<br/>
        <br/>
        <a href="session-act.php">Apagar Sessões</a><br/>
        Apaga todos os registros da tabela car_session. Última sessão: <strong><?= $last_session; ?></strong>. Total = <strong><?= $total_sessions; ?></strong><br/>
    </div>
</div>
<?php include_once CAR_ROOT_ADMIN . "/include/footer.inc"; ?>
