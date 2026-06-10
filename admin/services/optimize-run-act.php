<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/car-server.php'; ?>
<?php include_once CAR_ROOT_ADMIN . '/config.inc' ?>
<?php
    $resultados = [];
    $erro       = null;

    try {
        // busca dinamicamente todas as tabelas car_
        $sql = "select table_name as tbl
                  from information_schema.tables
                 where table_schema = database()
                   and table_name like 'car_%'
                 order by table_name";
        $result = $mysqli->query($sql, MYSQLI_STORE_RESULT);
        if (!$result) throw new Exception($mysqli->sqlstate . ' - ' . $mysqli->error);

        $tabelas = [];
        while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
            $tabelas[] = $row['tbl'];
        }

        if (!empty($tabelas)) {
            $optimize_sql = 'optimize table ' . implode(', ', $tabelas);
            $result = $mysqli->query($optimize_sql, MYSQLI_STORE_RESULT);
            if (!$result) throw new Exception($mysqli->sqlstate . ' - ' . $mysqli->error);

            while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
                $resultados[] = $row;
            }
        }

        // log
        $mysqli->query("insert into car_admin_log (log_service, log_info) values ('optimize', 'ok')");
        $mysqli->commit();

    } catch(Exception $e) {
        $erro = $e->getMessage();
    }
?>
<?php include_once CAR_ROOT_ADMIN . '/containers/header.inc'; ?>
<div class="container-lg py-4">
    <h5 class="mb-4">Otimizar tabelas</h5>

    <?php if ($erro) { ?>
    <div class="alert alert-danger"><?= htmlspecialchars($erro) ?></div>
    <?php } else { ?>
    <div class="alert alert-success mb-4">OPTIMIZE TABLE executado com sucesso.</div>

    <div class="table-responsive">
        <table class="table table-sm table-bordered align-middle">
            <thead class="table-light">
                <tr>
                    <th>Tabela</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($resultados as $r) { ?>
                <?php if ($r['Msg_type'] === 'error') { ?>
                <tr class="table-danger">
                    <td><?= htmlspecialchars($r['Table']) ?></td>
                    <td><?= htmlspecialchars($r['Msg_text']) ?></td>
                </tr>
                <?php } elseif ($r['Msg_type'] === 'status') { ?>
                <tr>
                    <td><?= htmlspecialchars($r['Table']) ?></td>
                    <td class="text-success fw-semibold"><?= htmlspecialchars($r['Msg_text']) ?></td>
                </tr>
                <?php } ?>
                <?php } ?>
            </tbody>
        </table>
    </div>
    <?php } ?>

    <a href="optimize.php" class="btn btn-outline-secondary btn-sm mt-3">Voltar para análise</a>
</div>
<?php include_once CAR_ROOT_ADMIN . '/containers/footer.inc'; ?>
