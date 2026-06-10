<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/car-server.php'; ?>
<?php include_once CAR_ROOT_ADMIN . '/config.inc' ?>
<?php
    $deleted_studies  = 0;
    $deleted_sessions = 0;

    try {
        // contar estudos que serão apagados
        $sql = 'select count(*) as count
                  from car_study
                 where user_id = 1
                   and stud_end is null
                   and stud_begin < now() - interval 24 hour';
        $result = $mysqli->query($sql, MYSQLI_STORE_RESULT);
        if (!$result) throw new Exception($mysqli->sqlstate . ' - ' . $mysqli->error);
        $row = $result->fetch_array(MYSQLI_ASSOC);
        $to_delete = (int) $row['count'];

        if ($to_delete > 0) {
            // apagar car_study_session via join (respeita FK)
            $sql = 'delete ss
                      from car_study_session ss
                      inner join car_study s on ss.stud_id = s.stud_id
                     where s.user_id = 1
                       and s.stud_end is null
                       and s.stud_begin < now() - interval 24 hour';
            $result = $mysqli->query($sql);
            if (!$result) throw new Exception($mysqli->sqlstate . ' - ' . $mysqli->error);
            $deleted_sessions = $mysqli->affected_rows;

            // apagar car_study
            $sql = 'delete from car_study
                     where user_id = 1
                       and stud_end is null
                       and stud_begin < now() - interval 24 hour';
            $result = $mysqli->query($sql);
            if (!$result) throw new Exception($mysqli->sqlstate . ' - ' . $mysqli->error);
            $deleted_studies = $mysqli->affected_rows;
        }

        $mysqli->commit();

        // log
        $log_info = $mysqli->real_escape_string($deleted_studies . ' estudos apagados');
        $mysqli->query("insert into car_admin_log (log_service, log_info) values ('clean_study', '{$log_info}')");
        $mysqli->commit();

    } catch(Exception $e) {
        $mysqli->rollback();
        car_set_session_error_message($e->getMessage());
    }
?>
<?php include_once CAR_ROOT_ADMIN . '/containers/header.inc'; ?>
<div class="container-lg py-4">
    <?php include_once CAR_ROOT_ADMIN . '/containers/message.inc' ?>
    <h5 class="mb-4">Apagar estudos públicos não finalizados</h5>
    <?php if ($deleted_studies === 0) { ?>
    <div class="alert alert-success">
        Nenhum estudo encontrado com mais de 24 horas sem finalizar.
    </div>
    <?php } else { ?>
    <div class="alert alert-success">
        <strong><?= $deleted_studies ?></strong> estudo(s) apagado(s).<br>
        <strong><?= $deleted_sessions ?></strong> registro(s) de car_study_session removido(s).
    </div>
    <?php } ?>
    <a href="home.php" class="btn btn-outline-secondary btn-sm">Voltar aos serviços</a>
</div>
<?php include_once CAR_ROOT_ADMIN . '/containers/footer.inc'; ?>
