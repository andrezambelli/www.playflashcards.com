<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/car-server.php';?>
<?php include_once CAR_ROOT_ADMIN . '/config.inc' ?>
<?php
    try {
        $sql = 'delete from car_session';
        $result = $mysqli->query($sql);
        if (!$result) throw new Exception($mysqli->sqlstate . ' - ' . $mysqli->error);
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
        Sessões excluídas com sucesso.
    </div>
</div>
<?php include_once CAR_ROOT_ADMIN . '/containers/footer.inc'; ?>
