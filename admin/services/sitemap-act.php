<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/car-server.php'; ?>
<?php include_once CAR_ROOT_ADMIN . '/config.inc' ?>
<?php
    ob_start();
    include CAR_ROOT_WEB . '/services/create-sitemap.php';
    $output = ob_get_clean();
?>
<?php include_once CAR_ROOT_ADMIN . '/containers/header.inc'; ?>
<div class="container-lg py-4">
    <h5 class="mb-4">Criar sitemap</h5>
    <div class="alert alert-success">
        Sitemap criado com sucesso.
        Arquivo: <a href="<?= CAR_PATH_WEB ?>/sitemap.xml" target="_blank"><?= CAR_PATH_WEB ?>/sitemap.xml</a>
    </div>
    <pre><?= htmlspecialchars($output, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?></pre>
</div>
<?php include_once CAR_ROOT_ADMIN . '/containers/footer.inc'; ?>
