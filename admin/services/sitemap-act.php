<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/car-server.php'; ?>
<?php include_once CAR_ROOT_ADMIN . '/config.inc' ?>
<?php
    ob_start();
    include CAR_ROOT_WEB . '/services/create-sitemap.php';
    $output = ob_get_clean();

    // extrai o total de URLs do output para o log
    preg_match('/Total de URLs: (\d+)/', $output, $matches);
    $total_urls = isset($matches[1]) ? (int) $matches[1] : 0;

    // log
    $log_info = $mysqli->real_escape_string($total_urls . ' URLs geradas');
    $mysqli->query("insert into car_admin_log (log_service, log_info) values ('sitemap', '{$log_info}')");
    $mysqli->commit();
?>
<?php include_once CAR_ROOT_ADMIN . '/containers/header.inc'; ?>
<div class="container-lg py-4">
    <h5 class="mb-4">Criar sitemap</h5>
    <div class="alert alert-success">
        Sitemap criado com sucesso.
        Arquivo: <a href="<?= CAR_PATH_WEB ?>/sitemap.xml" target="_blank"><?= CAR_PATH_WEB ?>/sitemap.xml</a>
    </div>
    <pre><?= htmlspecialchars($output, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?></pre>
    <a href="home.php" class="btn btn-outline-secondary btn-sm">Voltar aos serviços</a>
</div>
<?php include_once CAR_ROOT_ADMIN . '/containers/footer.inc'; ?>
