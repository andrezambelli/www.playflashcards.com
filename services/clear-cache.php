<?php
    include_once $_SERVER['DOCUMENT_ROOT'] . '/car-server.php';
    include_once CAR_ROOT_WEB . '/config.inc';

    header('Content-Type: text/html; charset=UTF-8');
    header('Cache-Control: no-store, no-cache');

    $cache_dir = CAR_ROOT_WEB . '/cache';
    $logs = [];

    $files = glob($cache_dir . '/home-*.html') ?: [];
    foreach ($files as $file) {
        if (unlink($file)) {
            $logs[] = '[OK] ' . basename($file) . ' excluído';
        } else {
            $logs[] = '[ERRO] falha ao excluir ' . basename($file);
        }
    }

    if (empty($files)) {
        $logs[] = '[INFO] nenhum arquivo de cache encontrado';
    }

    $logs[] = 'Executado em: ' . date('Y-m-d H:i:s');

    echo '<pre>' . htmlspecialchars(implode("\n", $logs), ENT_QUOTES, 'UTF-8') . '</pre>';
