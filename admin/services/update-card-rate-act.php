<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/car-server.php';?>
<?php include_once CAR_ROOT_ADMIN . '/config.inc' ?>
<?php
    $count_updated = 0;

    try {
        $sql = 'select card_id, card_true, card_false from car_card order by card_id asc';
        $result = $mysqli->query($sql, MYSQLI_STORE_RESULT);
        if (!$result) throw new Exception($mysqli->sqlstate . ' - ' . $mysqli->error);

        while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
            $id    = $row['card_id'];
            $true  = $row['card_true'];
            $false = $row['card_false'];
            $rate  = car_percent($true, $true + $false);

            $sql = sprintf('update car_card set card_rate = %d where card_id = %d', $rate, $id);
            $_result = $mysqli->query($sql);
            if (!$_result) throw new Exception($mysqli->sqlstate . ' - ' . $mysqli->error);
            $count_updated++;
        }

        $mysqli->commit();

        // log
        $log_info = $mysqli->real_escape_string($count_updated . ' cartões atualizados');
        $mysqli->query("insert into car_admin_log (log_service, log_info) values ('update_rate', '{$log_info}')");
        $mysqli->commit();

    } catch(Exception $e) {
        $mysqli->rollback();
        car_set_session_error_message($e->getMessage());
    }
?>
<?php include_once CAR_ROOT_ADMIN . '/containers/header.inc'; ?>
<div class="container-lg py-4">
    <?php include_once CAR_ROOT_ADMIN . '/containers/message.inc' ?>
    <h5 class="mb-4">Atualizar rate dos cartões</h5>
    <div class="alert alert-success">
        Rate de <strong><?= $count_updated ?></strong> cartão(ões) atualizado(s) com sucesso.
    </div>
    <a href="home.php" class="btn btn-outline-secondary btn-sm">Voltar aos serviços</a>
</div>
<?php include_once CAR_ROOT_ADMIN . '/containers/footer.inc'; ?>
