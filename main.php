<?php /** @var array $t */ ?>
<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/car-server.php';?>
<?php include_once CAR_ROOT_WEB . '/config.inc';?>
<?php include CAR_ROOT_WEB . '/lang/lang.inc'; ?>
<?php car_check_language($t['lang']); ?>
<?php
    // redireciona raiz sem prefixo de idioma (ex: /) para /{lang}/
    $_uri_first = explode('/', trim(strtok($_SERVER['REQUEST_URI'] ?? '/', '?'), '/'))[0] ?? '';
    if (!in_array($_uri_first, ['en', 'pt-br', 'es', 'fr'])) {
        car_redirect(car_get_base_url(CAR_PATH_WEB) . '/' . $t['lang'] . '/');
    }
    unset($_uri_first);
?>
<?php
    $header_title        = car_t($t, 'main.title');
    $header_canonical    = car_get_base_url(CAR_PATH_WEB) . '/' . $t['lang'] . '/';
    $header_description  = car_t($t, 'main.desc');
    $header_index_follow = 'index,follow';
    $header_hreflang_slug = '';

    $_base_url   = 'https://www.playflashcards.com';
    $_lang_bcp47 = ['en' => 'en', 'pt-br' => 'pt-BR', 'es' => 'es', 'fr' => 'fr'];
    $_json_flags = JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT;

    $_schema_website = [
        '@context' => 'https://schema.org',
        '@type'    => 'WebSite',
        'name'     => 'Play Flashcards',
        'url'      => $_base_url . '/'
    ];

    $_schema_app = [
        '@context'            => 'https://schema.org',
        '@type'               => 'WebApplication',
        'name'                => 'Play Flashcards',
        'url'                 => $_base_url . '/' . $t['lang'] . '/',
        'description'         => car_t($t, 'main.desc'),
        'applicationCategory' => 'EducationApplication',
        'operatingSystem'     => 'All',
        'inLanguage'          => $_lang_bcp47[$t['lang']] ?? $t['lang'],
        'offers'              => [
            '@type'         => 'Offer',
            'price'         => '0',
            'priceCurrency' => 'USD'
        ]
    ];

    $header_jsonld = "<!-- Schema.org: WebSite -->\n"
        . '<script type="application/ld+json">' . "\n"
        . json_encode($_schema_website, $_json_flags)
        . "\n</script>\n"
        . "<!-- Schema.org: WebApplication -->\n"
        . '<script type="application/ld+json">' . "\n"
        . json_encode($_schema_app, $_json_flags)
        . "\n</script>";

    include_once CAR_ROOT_WEB . '/containers/header.inc';
?>

<main>
    <?php include CAR_ROOT_WEB . '/home/hero.inc'; ?>
    <?php include CAR_ROOT_WEB . '/home/card-preview.inc'; ?>
    <?php include CAR_ROOT_WEB . '/home/build-for-focus.inc'; ?>
    <?php include CAR_ROOT_WEB . '/home/try-a-sample.inc'; ?>
</main>

<?php include_once CAR_ROOT_WEB . '/containers/footer.inc';?>
