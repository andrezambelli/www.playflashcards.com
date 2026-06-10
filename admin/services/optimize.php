<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/car-server.php'; ?>
<?php include_once CAR_ROOT_ADMIN . '/config.inc' ?>
<?php
    $tabelas = [];

    $sql = "select table_name as tabela,
                   round(data_length  / 1024, 1) as dados_kb,
                   round(index_length / 1024, 1) as indices_kb,
                   round(data_free    / 1024, 1) as livre_kb,
                   case when (data_length + index_length) > 0
                        then round(data_free / (data_length + index_length) * 100, 1)
                        else 0 end as frag_pct
              from information_schema.tables
             where table_schema = database()
               and table_name like 'car_%'
             order by data_free desc";

    $result = $mysqli->query($sql, MYSQLI_STORE_RESULT);
    while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
        $tabelas[] = $row;
    }

    $total_livre = array_sum(array_column($tabelas, 'livre_kb'));
?>
<?php include_once CAR_ROOT_ADMIN . '/containers/header.inc'; ?>
<div class="container-lg py-4">
    <h5 class="mb-4">Otimizar tabelas</h5>
    <p class="text-muted small mb-3">
        A coluna <strong>Livre KB</strong> mostra o espaço fragmentado de cada tabela.
        Valores acima de 0 indicam fragmentação; acima de 10% vale executar o OPTIMIZE TABLE.
    </p>

    <div class="table-responsive mb-4">
        <table class="table table-sm table-bordered align-middle">
            <thead class="table-light">
                <tr>
                    <th>Tabela</th>
                    <th class="text-end">Dados KB</th>
                    <th class="text-end">Índices KB</th>
                    <th class="text-end">Livre KB</th>
                    <th class="text-end">Fragmentação %</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($tabelas as $t) { ?>
                <tr>
                    <td><?= htmlspecialchars($t['tabela']) ?></td>
                    <td class="text-end"><?= number_format($t['dados_kb'],   1, ',', '.') ?></td>
                    <td class="text-end"><?= number_format($t['indices_kb'], 1, ',', '.') ?></td>
                    <td class="text-end <?= $t['livre_kb'] > 0 ? 'fw-semibold text-warning-emphasis' : 'text-muted' ?>">
                        <?= number_format($t['livre_kb'], 1, ',', '.') ?>
                    </td>
                    <td class="text-end <?= $t['frag_pct'] > 10 ? 'fw-semibold text-danger' : 'text-muted' ?>">
                        <?= $t['frag_pct'] ?>%
                    </td>
                </tr>
                <?php } ?>
            </tbody>
            <tfoot class="table-light">
                <tr>
                    <td colspan="3" class="fw-semibold">Total livre</td>
                    <td class="text-end fw-semibold"><?= number_format($total_livre, 1, ',', '.') ?></td>
                    <td></td>
                </tr>
            </tfoot>
        </table>
    </div>

    <?php if ($total_livre > 0) { ?>
    <div class="alert alert-warning">
        Há <?= number_format($total_livre, 1, ',', '.') ?> KB de espaço fragmentado. A otimização pode ser útil.
    </div>
    <?php } else { ?>
    <div class="alert alert-success">
        Nenhuma fragmentação detectada. A otimização não é necessária no momento.
    </div>
    <?php } ?>

    <a href="optimize-run-act.php" class="btn btn-primary btn-sm">Executar OPTIMIZE TABLE</a>
    <a href="home.php" class="btn btn-outline-secondary btn-sm ms-2">Voltar aos serviços</a>
</div>
<?php include_once CAR_ROOT_ADMIN . '/containers/footer.inc'; ?>
