<?php /** @var array $t */ ?>
<section class="py-5">
    <div class="container">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="h3 fw-bold mb-0"><?= car_t($t, 'home.sample-decks.title') ?></h2>
            <a href="#" class="text-body-secondary text-decoration-none small d-flex align-items-center gap-1">
                <?= car_t($t, 'home.sample-decks.all') ?>
                <i class="bi bi-arrow-right" aria-hidden="true"></i>
            </a>
        </div>

        <div class="row g-4">

            <div class="col-md-4">
                <div class="card h-100">
                    <div class="card-body d-flex flex-column">
                        <div class="d-flex align-items-center justify-content-center gap-1 py-1 rounded-pill bg-primary-subtle car-label-uc text-primary mb-3">
                            <i class="bi bi-globe2" aria-hidden="true"></i>
                            <?= car_t($t, 'home.sample-decks.public-badge') ?>
                        </div>
                        <h3 class="h5 fw-bold mb-1">Car Brands and Origins</h3>
                        <p class="text-body-secondary small flex-grow-1">Country of origin for every major automaker.</p>
                        <div class="d-flex gap-4 mt-2">
                            <div>
                                <p class="car-label-uc mb-1"><?= car_t($t, 'home.sample-decks.cards-label') ?></p>
                                <p class="fw-bold mb-0">64</p>
                            </div>
                            <div>
                                <p class="car-label-uc mb-1"><?= car_t($t, 'home.sample-decks.accuracy-label') ?></p>
                                <p class="fw-bold mb-0">94%</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card h-100">
                    <div class="card-body d-flex flex-column">
                        <div class="d-flex align-items-center justify-content-center gap-1 py-1 rounded-pill bg-primary-subtle car-label-uc text-primary mb-3">
                            <i class="bi bi-globe2" aria-hidden="true"></i>
                            <?= car_t($t, 'home.sample-decks.public-badge') ?>
                        </div>
                        <h3 class="h5 fw-bold mb-1">FIFA World Cup Champions</h3>
                        <p class="text-body-secondary small flex-grow-1">Winners, hosts and finals from 1930 to present.</p>
                        <div class="d-flex gap-4 mt-2">
                            <div>
                                <p class="car-label-uc mb-1"><?= car_t($t, 'home.sample-decks.cards-label') ?></p>
                                <p class="fw-bold mb-0">22</p>
                            </div>
                            <div>
                                <p class="car-label-uc mb-1"><?= car_t($t, 'home.sample-decks.accuracy-label') ?></p>
                                <p class="fw-bold mb-0">88%</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card h-100">
                    <div class="card-body d-flex flex-column">
                        <div class="d-flex align-items-center justify-content-center gap-1 py-1 rounded-pill bg-primary-subtle car-label-uc text-primary mb-3">
                            <i class="bi bi-globe2" aria-hidden="true"></i>
                            <?= car_t($t, 'home.sample-decks.public-badge') ?>
                        </div>
                        <h3 class="h5 fw-bold mb-1">Countries and Capitals</h3>
                        <p class="text-body-secondary small flex-grow-1">Capital cities for 200 countries worldwide.</p>
                        <div class="d-flex gap-4 mt-2">
                            <div>
                                <p class="car-label-uc mb-1"><?= car_t($t, 'home.sample-decks.cards-label') ?></p>
                                <p class="fw-bold mb-0">47</p>
                            </div>
                            <div>
                                <p class="car-label-uc mb-1"><?= car_t($t, 'home.sample-decks.accuracy-label') ?></p>
                                <p class="fw-bold mb-0">81%</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>
