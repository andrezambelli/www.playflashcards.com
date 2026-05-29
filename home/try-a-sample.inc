<?php /** @var array $t */ ?>
<?php
    $sql = 'select d.deck_key,
                   d.deck_url,
                   d.deck_name,
                   d.deck_desc,
                   d.deck_lang,
                   count(c.card_id) as total_cards
              from car_deck d
              left join car_card c on c.deck_id = d.deck_id
             where d.deck_public = 1
               and d.deck_follow = 1
             group by d.deck_id
             order by rand()
             limit 3';
    $result       = $mysqli->query($sql, MYSQLI_STORE_RESULT);
    $sample_decks = [];
    while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
        $sample_decks[] = $row;
    }
    if (empty($sample_decks)) return;
?>
<section id="try-a-sample" class="py-5">
    <div class="container">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="h3 fw-bold mb-0"><?= car_t($t, 'home.sample-decks.title') ?></h2>
            <a href="<?= CAR_PATH_WEB . '/' . $t['lang'] ?>/explore/" class="text-decoration-none small">
                <?= car_t($t, 'home.hero.cta-secondary') ?>
                <i class="bi bi-arrow-right ms-1" aria-hidden="true"></i>
            </a>
        </div>

        <div class="row g-4">

            <?php foreach ($sample_decks as $deck) { ?>
            <div class="col-md-4">
                <a href="<?= CAR_PATH_WEB . '/deck/' . $deck['deck_key'] . '/' . $deck['deck_url'] . '/' ?>"
                   class="card h-100 text-decoration-none text-body car-card-link">
                    <div class="card-body d-flex flex-column gap-3">
                        <div>
                            <div class="car-label-uc d-flex align-items-center gap-1 mb-1">
                                <i class="bi bi-globe2" aria-hidden="true"></i>
                                <?= car_t($t, 'home.sample-decks.public-badge') ?>
                            </div>
                            <div class="fw-semibold"<?= !empty($deck['deck_lang']) ? ' lang="' . car_htmlspecialchars($deck['deck_lang']) . '"' : '' ?>><?= car_htmlspecialchars($deck['deck_name']) ?></div>
                            <?php if (!empty($deck['deck_desc'])) { ?>
                                <div class="small text-secondary text-truncate mt-1"<?= !empty($deck['deck_lang']) ? ' lang="' . car_htmlspecialchars($deck['deck_lang']) . '"' : '' ?>><?= car_htmlspecialchars($deck['deck_desc']) ?></div>
                            <?php } ?>
                        </div>

                        <div class="mt-auto">
                            <div class="d-flex gap-4 mt-3">
                                <div>
                                    <div class="car-label-uc"><?= car_t($t, 'home.sample-decks.cards-label') ?></div>
                                    <div class="car-text-mono small fw-medium"><?= (int) $deck['total_cards'] ?></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <?php } ?>

        </div>
    </div>
</section>
