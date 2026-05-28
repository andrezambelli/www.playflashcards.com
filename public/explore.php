<?php /** @var array $t */ ?>
<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/car-server.php'; ?>
<?php include_once CAR_ROOT_WEB . '/config.inc'; ?>
<?php include CAR_ROOT_WEB . '/lang/lang.inc'; ?>
<?php
    $sql = 'select d.deck_key,
                   d.deck_url,
                   d.deck_name,
                   d.deck_desc,
                   d.deck_category,
                   count(c.card_id) as total_cards
              from car_deck d
              left join car_card c on c.deck_id = d.deck_id
             where d.deck_public = 1
               and d.deck_follow = 1
             group by d.deck_id
             order by d.deck_category asc, d.deck_name asc';
    $result = $mysqli->query($sql, MYSQLI_STORE_RESULT);

    $by_category = [];
    $all_decks   = [];
    while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
        $by_category[$row['deck_category']][] = $row;
        $all_decks[] = $row;
    }

    $category_order = ['geography', 'language', 'science', 'technology', 'history', 'arts', 'business', 'nature', 'sports'];

    $category_icons = [
        'geography'  => 'bi-geo-alt',
        'language'   => 'bi-chat-text',
        'science'    => 'bi-eyedropper',
        'technology' => 'bi-cpu',
        'history'    => 'bi-clock-history',
        'arts'       => 'bi-music-note-beamed',
        'business'   => 'bi-briefcase',
        'nature'     => 'bi-tree',
        'sports'     => 'bi-trophy',
    ];

    $_base_url = car_get_base_url(CAR_PATH_WEB);

    $header_title        = car_t($t, 'public.explore.title');
    $header_description  = car_t($t, 'public.explore.desc');
    $header_canonical    = $_base_url . '/explore/';
    $header_og_image     = $_base_url . '/assets/img/playflashcards-logo.png';
    $header_index_follow = 'index,follow';
    include_once CAR_ROOT_WEB . '/containers/header.inc';
?>

<main class="container py-4 py-lg-5">

    <?php include_once CAR_ROOT_WEB . '/containers/message.inc'; ?>

    <div class="row g-4">

        <div class="col-lg-8">

            <div class="mb-5">
                <h1 class="h2 fw-semibold mb-2"><?= car_t($t, 'public.explore.heading') ?></h1>
                <p class="text-secondary mb-0"><?= car_t($t, 'public.explore.subtitle') ?></p>
            </div>

            <?php foreach ($category_order as $cat) { ?>
            <?php if (empty($by_category[$cat])) { continue; } ?>

            <section class="mb-5">
                <h2 class="h6 car-label-uc d-flex align-items-center gap-2 mb-3">
                    <i class="bi <?= $category_icons[$cat] ?? 'bi-collection' ?>" aria-hidden="true"></i>
                    <?= car_htmlspecialchars(car_t($t, 'public.explore.cat.' . $cat)) ?>
                </h2>
                <div class="row g-3">
                    <?php foreach ($by_category[$cat] as $deck) { ?>
                    <div class="col-sm-4">
                        <a href="<?= CAR_PATH_WEB . '/deck/' . $deck['deck_key'] . '/' . $deck['deck_url'] . '/' ?>"
                           class="card h-100 text-decoration-none text-body car-card-link">
                            <div class="card-body">
                                <div class="car-label-uc mb-2">
                                    <?= (int) $deck['total_cards'] ?> <?= car_t($t, 'profile.srs.unit-cards') ?>
                                </div>
                                <div class="fw-medium mb-1"><?= car_htmlspecialchars($deck['deck_name']) ?></div>
                                <?php if (!empty($deck['deck_desc'])) { ?>
                                <div class="small text-secondary"><?= car_htmlspecialchars($deck['deck_desc']) ?></div>
                                <?php } ?>
                            </div>
                        </a>
                    </div>
                    <?php } ?>
                </div>
            </section>

            <?php } ?>

            <?php
            // exibe decks sem categoria ou com categoria fora da ordem definida
            $extra = [];
            foreach ($by_category as $cat => $decks) {
                if (!in_array($cat, $category_order)) {
                    foreach ($decks as $deck) {
                        $extra[] = $deck;
                    }
                }
            }
            if (!empty($extra)) {
            ?>
            <section class="mb-5">
                <h2 class="h6 car-label-uc d-flex align-items-center gap-2 mb-3">
                    <i class="bi bi-collection" aria-hidden="true"></i>
                    <?= car_t($t, 'public.explore.cat.other') ?>
                </h2>
                <div class="row g-3">
                    <?php foreach ($extra as $deck) { ?>
                    <div class="col-sm-4">
                        <a href="<?= CAR_PATH_WEB . '/deck/' . $deck['deck_key'] . '/' . $deck['deck_url'] . '/' ?>"
                           class="card h-100 text-decoration-none text-body car-card-link">
                            <div class="card-body">
                                <div class="car-label-uc mb-2">
                                    <?= (int) $deck['total_cards'] ?> <?= car_t($t, 'profile.srs.unit-cards') ?>
                                </div>
                                <div class="fw-medium mb-1"><?= car_htmlspecialchars($deck['deck_name']) ?></div>
                                <?php if (!empty($deck['deck_desc'])) { ?>
                                <div class="small text-secondary"><?= car_htmlspecialchars($deck['deck_desc']) ?></div>
                                <?php } ?>
                            </div>
                        </a>
                    </div>
                    <?php } ?>
                </div>
            </section>
            <?php } ?>

        </div>

        <div class="col-lg-4">
            <div class="d-flex flex-column gap-3">
                <?php include_once CAR_ROOT_WEB . '/containers/box-signin.inc'; ?>
            </div>
        </div>

    </div>
</main>

<?php if (!empty($all_decks)) { ?>
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "ItemList",
    "name": <?= json_encode(car_t($t, 'public.explore.heading')) ?>,
    "description": <?= json_encode(car_t($t, 'public.explore.desc')) ?>,
    "url": <?= json_encode($_base_url . '/explore/') ?>,
    "numberOfItems": <?= count($all_decks) ?>,
    "itemListElement": [
        <?php
        $position = 1;
        $items = [];
        foreach ($category_order as $cat) {
            if (empty($by_category[$cat])) { continue; }
            foreach ($by_category[$cat] as $deck) {
                $items[] = json_encode([
                    '@type'    => 'ListItem',
                    'position' => $position++,
                    'name'     => $deck['deck_name'],
                    'url'      => $_base_url . '/deck/' . $deck['deck_key'] . '/' . $deck['deck_url'] . '/',
                ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
            }
        }
        echo implode(",\n        ", $items);
        ?>
    ]
}
</script>
<?php } ?>

<?php include_once CAR_ROOT_WEB . '/containers/footer.inc'; ?>
