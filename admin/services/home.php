<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/car-server.php';?>
<?php include_once CAR_ROOT_ADMIN . '/config.inc' ?>
<?php car_set_session_attribute('read_database', 'on'); ?>
<?php
    // dados do serviço de sessões
    $total_sessions = 0;
    $last_session   = '';

    $sql = 'select count(*) as count from car_session';
    $result = $mysqli->query($sql, MYSQLI_STORE_RESULT);
    while ($row = $result->fetch_array(MYSQLI_ASSOC)) { $total_sessions = $row['count']; }

    $sql = 'select created from car_session order by created desc limit 1';
    $result = $mysqli->query($sql, MYSQLI_STORE_RESULT);
    while ($row = $result->fetch_array(MYSQLI_ASSOC)) { $last_session = $row['created']; }

    // dados do serviço de limpeza de estudos públicos
    $pending_studies = 0;
    $sql = 'select count(*) as count
              from car_study
             where user_id = 1
               and stud_end is null
               and stud_begin < now() - interval 24 hour';
    $result = $mysqli->query($sql, MYSQLI_STORE_RESULT);
    while ($row = $result->fetch_array(MYSQLI_ASSOC)) { $pending_studies = $row['count']; }

    // última execução de cada serviço
    $last_run = [];
    $sql = 'select log_service, max(log_create) as last_run
              from car_admin_log
             group by log_service';
    $result = $mysqli->query($sql, MYSQLI_STORE_RESULT);
    while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
        $last_run[$row['log_service']] = date('d/m/Y H:i', strtotime($row['last_run']));
    }

    function car_admin_last_run(array $last, string $key): string {
        return $last[$key] ?? 'nunca';
    }
?>
<?php include_once CAR_ROOT_ADMIN . '/containers/header.inc'; ?>
<div class="container-lg py-4">
    <h5 class="mb-4">Serviços</h5>
    <div class="list-group">

        <div class="list-group-item">
            <div class="d-flex justify-content-between align-items-center gap-3">
                <div>
                    <div class="fw-semibold">Criar sitemap</div>
                    <small class="text-muted">Gera o sitemap.xml principal do site e todas as categorias.</small>
                </div>
                <a href="sitemap-act.php" class="btn btn-sm btn-outline-primary flex-shrink-0">Executar</a>
            </div>
            <div class="d-flex justify-content-end mt-1">
                <small class="text-secondary"><?= car_admin_last_run($last_run, 'sitemap') ?></small>
            </div>
        </div>

        <div class="list-group-item">
            <div class="d-flex justify-content-between align-items-center gap-3">
                <div>
                    <div class="fw-semibold">Atualizar rate dos cartões</div>
                    <small class="text-muted">Recalcula o rate de todos os cartões com base em acertos e erros.</small>
                </div>
                <a href="update-card-rate-act.php" class="btn btn-sm btn-outline-primary flex-shrink-0">Executar</a>
            </div>
            <div class="d-flex justify-content-end mt-1">
                <small class="text-secondary"><?= car_admin_last_run($last_run, 'update_rate') ?></small>
            </div>
        </div>

        <div class="list-group-item">
            <div class="d-flex justify-content-between align-items-center gap-3">
                <div>
                    <div class="fw-semibold">Apagar sessões</div>
                    <small class="text-muted">Apaga todos os registros da tabela car_session.</small>
                </div>
                <a href="session-act.php" class="btn btn-sm btn-outline-primary flex-shrink-0">Executar</a>
            </div>
            <div class="d-flex justify-content-between mt-1">
                <small class="text-secondary">Total: <strong><?= $total_sessions ?></strong><?php if ($last_session) { ?> &middot; Última sessão: <?= $last_session ?><?php } ?>.</small>
                <small class="text-secondary"><?= car_admin_last_run($last_run, 'session') ?></small>
            </div>
        </div>

        <div class="list-group-item">
            <div class="d-flex justify-content-between align-items-center gap-3">
                <div>
                    <div class="fw-semibold">Apagar estudos públicos não finalizados</div>
                    <small class="text-muted">Apaga estudos de visitantes (user_id = 1) com mais de 24 horas sem finalizar, incluindo os registros de car_study_session.</small>
                </div>
                <a href="clean-study-act.php" class="btn btn-sm btn-outline-primary flex-shrink-0">Executar</a>
            </div>
            <div class="d-flex justify-content-between mt-1">
                <?php if ($pending_studies > 0) { ?>
                <small class="text-warning fw-semibold"><?= $pending_studies ?> aguardando limpeza.</small>
                <?php } else { ?>
                <span></span>
                <?php } ?>
                <small class="text-secondary"><?= car_admin_last_run($last_run, 'clean_study') ?></small>
            </div>
        </div>

        <div class="list-group-item">
            <div class="d-flex justify-content-between align-items-center gap-3">
                <div>
                    <div class="fw-semibold">Otimizar tabelas</div>
                    <small class="text-muted">Analisa a fragmentação das tabelas e permite executar OPTIMIZE TABLE.</small>
                </div>
                <a href="optimize.php" class="btn btn-sm btn-outline-primary flex-shrink-0">Analisar</a>
            </div>
            <div class="d-flex justify-content-end mt-1">
                <small class="text-secondary"><?= car_admin_last_run($last_run, 'optimize') ?></small>
            </div>
        </div>

    </div>
</div>
<?php include_once CAR_ROOT_ADMIN . '/containers/footer.inc'; ?>
