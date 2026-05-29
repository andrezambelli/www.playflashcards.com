<?php /** @var array $t */ ?>
<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/car-server.php';?>
<?php include_once CAR_ROOT_WEB . '/config.inc';?>
<?php include CAR_ROOT_WEB . '/lang/lang.inc'; ?>
<?php
    http_response_code(404);

    $redirects_path = CAR_ROOT_WEB . '/assets/data/301.json';
    $original_path = $_SERVER['REDIRECT_URL'] ?? '';
    $request_path = $original_path !== '' ? $original_path : parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
    $request_path = $request_path ?: '/';

    $normalize_path = static function (string $path): string {
        $path = '/' . ltrim($path, '/');
        if ($path !== '/') {
            $path = rtrim($path, '/');
        }
        return $path;
    };

    $request_normalized = $normalize_path($request_path);

    // Em ambientes com subpasta (ex.: /www.site.com.br/...), remove o prefixo do app.
    $script_name = $_SERVER['SCRIPT_NAME'] ?? '';
    $app_base = rtrim(str_replace('\\', '/', dirname($script_name)), '/');
    if ($app_base !== '' && $app_base !== '/' && stripos($request_normalized, $app_base . '/') === 0) {
        $request_normalized = $normalize_path(substr($request_normalized, strlen($app_base)));
    }
    // Quando o 404 é despachado por um roteador superior, a URL pode vir com
    // "/<site-id>/..." e precisa remover esse prefixo também.
    $site_prefix = '/' . basename(CAR_ROOT_WEB);
    if (stripos($request_normalized, $site_prefix . '/') === 0) {
        $request_normalized = $normalize_path(substr($request_normalized, strlen($site_prefix)));
    }

    if (is_file($redirects_path)) {
        $redirects_data = json_decode(file_get_contents($redirects_path), true);
        $redirects_list = $redirects_data['redirects'] ?? [];
        foreach ($redirects_list as $redirect) {
            $from = $redirect['from'] ?? '';
            $to = $redirect['to'] ?? '';
            if (!$from || !$to) {
                continue;
            }
            $from_normalized = $normalize_path($from);
            // Match por segmento: "/erro" casa com "/erro" e "/erro/...", mas nao com "/erro-andre".
            $from_pattern = preg_quote($from_normalized, '#');
            $matched = (bool) preg_match('#^' . $from_pattern . '(?:/|$)#i', $request_normalized);
            // Ao encontrar, responde com 301 e encerra o 404.
            if ($matched) {
                $target = $to;
                if (!preg_match('#^https?://#i', $target)) {
                    $target = rtrim(car_get_base_url(CAR_PATH_WEB), '/') . '/' . ltrim($target, '/');
                }
                header('Location: ' . $target, true, 301);
                exit;
            }
        }
    }

    $header_title        = car_t($t, 'common.404.title') . ' - Play Flashcards';
    $header_description  = car_t($t, 'common.404.desc');
    $header_index_follow = 'noindex,nofollow';
    include_once CAR_ROOT_WEB . '/containers/header.inc';
?>

<main class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6 text-center py-5">
            <div class="display-1 fw-bold text-secondary mb-3">404</div>
            <h1 class="h3 fw-semibold mb-2"><?= car_t($t, 'common.404.title') ?></h1>
            <p class="text-secondary mb-4"><?= car_t($t, 'common.404.desc') ?></p>
            <a href="<?= CAR_PATH_WEB ?>/" class="btn btn-primary">
                <?= car_t($t, 'Home') ?>
            </a>
        </div>
    </div>
</main>

<?php include_once CAR_ROOT_WEB . '/containers/footer.inc';?>
