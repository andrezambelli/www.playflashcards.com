<?php /** @var array $t */ ?>
<?php
    $sample_decks_data = json_decode(file_get_contents(CAR_ROOT_WEB . '/assets/data/try-a-sample.json'), true) ?? [];
    $sample_decks      = array_values(array_filter(
        $sample_decks_data['decks'] ?? [],
        fn($deck) => ($deck['active'] ?? true) === true
                  && ($deck['home'] ?? true) === true
                  && ($deck['lang'] ?? 'en') === $t['lang']
    ));
    if (empty($sample_decks)) {
        $sample_decks = array_values(array_filter(
            $sample_decks_data['decks'] ?? [],
            fn($deck) => ($deck['active'] ?? true) === true
                      && ($deck['home'] ?? true) === true
                      && ($deck['lang'] ?? 'en') === 'en'
        ));
    }
?>
<section id="try-a-sample" class="py-5">
    <div class="container">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="h3 fw-bold mb-0"><?= car_t($t, 'home.sample-decks.title') ?></h2>
            <a href="<?= CAR_PATH_WEB ?>/explore/" class="text-decoration-none small">
                <?= car_t($t, 'home.hero.cta-secondary') ?>
                <i class="bi bi-arrow-right ms-1" aria-hidden="true"></i>
            </a>
        </div>

        <div class="row g-4">

            <?php foreach ($sample_decks as $sample_deck) { ?>
            <?php
                $sample_name = $sample_deck['title'] ?? '';
                $sample_desc = $sample_deck['desc'] ?? '';
                $sample_link = $sample_deck['link'] ?? '#';
                if (strpos($sample_link, '/') === 0) {
                    $sample_link = CAR_PATH_WEB . $sample_link;
                }
            ?>
            <div class="col-md-4">
                <a href="<?= car_htmlspecialchars($sample_link) ?>" class="card h-100 text-decoration-none text-body car-card-link">
                    <div class="card-body d-flex flex-column gap-3">
                        <div>
                            <div class="car-label-uc d-flex align-items-center gap-1 mb-1">
                                <i class="bi bi-globe2" aria-hidden="true"></i>
                                <?= car_t($t, 'home.sample-decks.public-badge') ?>
                            </div>
                            <div class="fw-semibold"><?= car_htmlspecialchars($sample_name) ?></div>
                            <?php if (!empty($sample_desc)) { ?>
                                <div class="small text-secondary text-truncate mt-1"><?= car_htmlspecialchars($sample_desc) ?></div>
                            <?php } ?>
                        </div>

                        <div class="mt-auto">
                            <div class="d-flex gap-4 mt-3">
                                <div>
                                    <div class="car-label-uc"><?= car_t($t, 'home.sample-decks.cards-label') ?></div>
                                    <div class="car-text-mono small fw-medium"><?= (int) ($sample_deck['cards'] ?? 0) ?></div>
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
