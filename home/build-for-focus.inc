<?php /** @var array $t */ ?>
<section class="py-5 bg-white border-top border-bottom">
    <div class="container py-4">

        <div class="row justify-content-center mb-5">
            <div class="col-lg-7 text-center">
                <p class="car-label-uc mb-3"><?= car_t($t, 'home.features.eyebrow') ?></p>
                <h2 class="display-6 fw-bold"><?= car_t($t, 'home.features.title') ?></h2>
            </div>
        </div>

        <div class="row gy-5 gx-4">

            <div class="col-md-4">
                <div class="d-inline-flex align-items-center justify-content-center rounded-2 bg-primary-subtle mb-3" style="width:40px;height:40px">
                    <i class="bi bi-sliders text-primary" aria-hidden="true"></i>
                </div>
                <h3 class="h5 fw-bold mb-2"><?= car_t($t, 'home.features.1.title') ?></h3>
                <p class="text-body-secondary small mb-2"><?= car_t($t, 'home.features.1.desc') ?></p>
                <a href="<?= CAR_PATH_WEB . '/' . $t['lang'] . '/spaced-repetition' ?>" class="small">
                    <?= car_t($t, 'home.features.srs.learn-more') ?>
                    <i class="bi bi-arrow-right" aria-hidden="true"></i>
                </a>
            </div>

            <div class="col-md-4">
                <div class="d-inline-flex align-items-center justify-content-center rounded-2 bg-primary-subtle mb-3" style="width:40px;height:40px">
                    <i class="bi bi-share text-primary" aria-hidden="true"></i>
                </div>
                <h3 class="h5 fw-bold mb-2"><?= car_t($t, 'home.features.2.title') ?></h3>
                <p class="text-body-secondary small mb-0"><?= car_t($t, 'home.features.2.desc') ?></p>
            </div>

            <div class="col-md-4">
                <div class="d-inline-flex align-items-center justify-content-center rounded-2 bg-primary-subtle mb-3" style="width:40px;height:40px">
                    <i class="bi bi-lightning-charge text-primary" aria-hidden="true"></i>
                </div>
                <h3 class="h5 fw-bold mb-2"><?= car_t($t, 'home.features.3.title') ?></h3>
                <p class="text-body-secondary small mb-0"><?= car_t($t, 'home.features.3.desc') ?></p>
            </div>

        </div>
    </div>
</section>
