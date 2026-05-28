<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/car-server.php'; ?>
<?php include_once CAR_ROOT_WEB . '/config.inc'; ?>
<?php
    $today = date('Y-m-d');
    $base  = 'https://www.playflashcards.com';
    $root  = CAR_ROOT_WEB;
    $langs = ['en', 'pt-br', 'es', 'fr', 'de', 'it', 'ja', 'zh', 'nl', 'pl', 'ru', 'hi'];
    $logs  = [];
    $urls  = [];

    function car_sitemap_lastmod(array $files, string $default): string {
        $latest = 0;
        foreach ($files as $file) {
            $full = realpath($file);
            if ($full && file_exists($full)) {
                $latest = max($latest, filemtime($full));
            }
        }
        return $latest > 0 ? date('Y-m-d', $latest) : $default;
    }

    function car_sitemap_url(string $loc, string $lastmod, string $changefreq, string $priority): string {
        $loc = htmlspecialchars($loc, ENT_QUOTES | ENT_XML1, 'UTF-8');
        return "    <url>\n" .
            "        <loc>{$loc}</loc>\n" .
            "        <lastmod>{$lastmod}</lastmod>\n" .
            "        <changefreq>{$changefreq}</changefreq>\n" .
            "        <priority>{$priority}</priority>\n" .
            "    </url>";
    }

    // home
    $home_lastmod = car_sitemap_lastmod([
        $root . '/main.php',
        $root . '/home/hero.inc',
        $root . '/home/card-preview.inc',
        $root . '/home/build-for-focus.inc',
        $root . '/home/try-a-sample.inc',
    ], $today);
    foreach ($langs as $lang) {
        $urls[] = car_sitemap_url($base . '/' . $lang . '/', $home_lastmod, 'weekly', '1.0');
    }
    $logs[] = '[OK] home: ' . count($langs) . ' URLs';

    // contact-us
    $contact_lastmod = car_sitemap_lastmod([$root . '/common/contact-us.php'], $today);
    foreach ($langs as $lang) {
        $urls[] = car_sitemap_url($base . '/' . $lang . '/contact-us/', $contact_lastmod, 'monthly', '0.7');
    }
    $logs[] = '[OK] contact-us: ' . count($langs) . ' URLs';

    // privacy-policy (somente en — canonical único, conteúdo não traduzido)
    $privacy_lastmod = car_sitemap_lastmod([$root . '/common/privacy-policy.php'], $today);
    $urls[] = car_sitemap_url($base . '/en/privacy-policy/', $privacy_lastmod, 'yearly', '0.4');
    $logs[] = '[OK] privacy-policy: 1 URL';

    // terms-and-conditions (somente en — canonical único, conteúdo não traduzido)
    $terms_lastmod = car_sitemap_lastmod([$root . '/common/terms-and-conditions.php'], $today);
    $urls[] = car_sitemap_url($base . '/en/terms-and-conditions/', $terms_lastmod, 'yearly', '0.4');
    $logs[] = '[OK] terms-and-conditions: 1 URL';

    // cookie-settings
    $cookie_lastmod = car_sitemap_lastmod([$root . '/common/cookie-settings.php'], $today);
    foreach ($langs as $lang) {
        $urls[] = car_sitemap_url($base . '/' . $lang . '/cookie-settings/', $cookie_lastmod, 'yearly', '0.3');
    }
    $logs[] = '[OK] cookie-settings: ' . count($langs) . ' URLs';

    // spaced-repetition
    $srs_lastmod = car_sitemap_lastmod([$root . '/common/spaced-repetition.php'], $today);
    foreach ($langs as $lang) {
        $urls[] = car_sitemap_url($base . '/' . $lang . '/spaced-repetition/', $srs_lastmod, 'monthly', '0.7');
    }
    $logs[] = '[OK] spaced-repetition: ' . count($langs) . ' URLs';

    // explore
    $explore_lastmod = car_sitemap_lastmod([$root . '/public/explore.php'], $today);
    foreach ($langs as $lang) {
        $urls[] = car_sitemap_url($base . '/' . $lang . '/explore/', $explore_lastmod, 'weekly', '0.9');
    }
    $logs[] = '[OK] explore: ' . count($langs) . ' URLs';

    // baralhos públicos
    $sql = 'select deck_key, deck_url
              from car_deck
             where deck_public = 1
               and deck_follow = 1
             order by deck_id asc';
    $result = $mysqli->query($sql, MYSQLI_STORE_RESULT);
    $deck_count = 0;
    while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
        $urls[] = car_sitemap_url(
            $base . '/deck/' . $row['deck_key'] . '/' . $row['deck_url'] . '/',
            $today,
            'weekly',
            '0.8'
        );
        $deck_count++;
    }
    $logs[] = '[OK] baralhos públicos: ' . $deck_count . ' URL(s)';

    // gera e salva o XML
    $xml = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n" .
        '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n" .
        implode("\n", $urls) . "\n" .
        '</urlset>' . "\n";

    file_put_contents($root . '/sitemap.xml', $xml);

    $logs[] = 'Total de URLs: ' . count($urls);
    $logs[] = 'Executado em: ' . date('Y-m-d H:i:s');

    echo implode("\n", $logs) . "\n";
