<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/car-server.php';?>
<?php include_once CAR_ROOT_ADMIN . '/config.inc' ?>
<?php car_set_session_attribute('read_database', 'on'); ?>
<?php
    $total_sessions = 0;
    $last_session = '';

    $sql = 'select count(*) as count from car_session';
    $result = $mysqli->query($sql, MYSQLI_STORE_RESULT);
    while ($row = $result->fetch_array(MYSQLI_ASSOC)) { $total_sessions = $row['count']; }

    $sql = 'select created from car_session order by created desc limit 1';
    $result = $mysqli->query($sql, MYSQLI_STORE_RESULT);
    while ($row = $result->fetch_array(MYSQLI_ASSOC)) { $last_session = $row['created']; }
?>
<?php include_once CAR_ROOT_ADMIN . '/containers/header.inc'; ?>
<div class="container-lg py-4">
    <h5 class="mb-4">Serviços</h5>
    <div class="list-group">
        <a href="sitemap-act.php" class="list-group-item list-group-item-action">
            <div class="fw-semibold">Criar sitemap</div>
            <small class="text-muted">Gera o sitemap.xml principal do site e todas as categorias.</small>
        </a>
        <a href="update-card-rate-act.php" class="list-group-item list-group-item-action">
            <div class="fw-semibold">Atualizar rate dos cartões</div>
            <small class="text-muted">Atualiza o rate de todos os cartões.</small>
        </a>
        <a href="session-act.php" class="list-group-item list-group-item-action">
            <div class="fw-semibold">Apagar sessões</div>
            <small class="text-muted">
                Apaga todos os registros da tabela car_session.
                <?php if ($last_session) { ?>
                    Última sessão: <strong><?= $last_session ?></strong>.
                <?php } ?>
                Total: <strong><?= $total_sessions ?></strong>.
            </small>
        </a>
    </div>
</div>
<?php include_once CAR_ROOT_ADMIN . '/containers/footer.inc'; ?>
