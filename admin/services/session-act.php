<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/car-server.php';?>
<?php include_once CAR_ROOT_ADMIN . '/config.inc' ?>
<?php
    $deleted = 0;

    try {
        $sql = 'delete from car_session';
        $result = $mysqli->query($sql);
        if (!$result) throw new Exception($mysqli->sqlstate . ' - ' . $mysqli->error);
        $deleted = $mysqli->affected_rows;
        $mysqli->commit();

        // log
        $log_info = $mysqli->real_escape_string($deleted . ' sessões apagadas');
        $mysqli->query("insert into car_admin_log (log_service, log_info) values ('session', '{$log_info}')");
        $mysqli->commit();

    } catch(Exception $e) {
        $mysqli->rollback();
        car_set_session_error_message($e->getMessage());
    }
?>
<?php include_once CAR_ROOT_ADMIN . '/containers/header.inc'; ?>
<div class="container-lg py-4">
    <?php include_once CAR_ROOT_ADMIN . '/containers/message.inc' ?>
    <h5 class="mb-4">Apagar sessões</h5>
    <div class="alert alert-success">
        <strong><?= $deleted ?></strong> sessão(ões) excluída(s) com sucesso.
    </div>
    <a href="home.php" class="btn btn-outline-secondary btn-sm">Voltar aos serviços</a>
</div>
<?php include_once CAR_ROOT_ADMIN . '/containers/footer.inc'; ?>
