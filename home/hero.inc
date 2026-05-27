<?php /** @var array $t */ ?>
<section class="py-5 text-center">
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-8">
                <p class="car-label-uc mb-4">
                    <?= car_t($t, 'home.hero.badge') ?> · <?= CAR_VERSION ?>
                </p>

                <h1 class="display-3 fw-bold lh-1 mb-4">
                    <?= car_t($t, 'home.hero.h1-before') ?><br>
                    <em class="fst-italic text-primary"><?= car_t($t, 'home.hero.h1-accent') ?></em>
                    <?= car_t($t, 'home.hero.h1-after') ?>
                </h1>

                <p class="lead text-body-secondary mb-5 mx-auto" style="max-width: 520px;">
                    <?= car_t($t, 'home.hero.subtitle') ?>
                </p>

                <div class="d-flex gap-3 justify-content-center flex-wrap mb-3">
                    <?php $hero_logged_in = car_get_session_attribute('session_login', '') === 'on'; ?>
                    <a href="<?= $hero_logged_in ? CAR_PATH_WEB . '/dash/home' : CAR_PATH_WEB . '/' . $t['lang'] . '/login/login' ?>"
                       class="btn btn-primary btn-lg rounded-pill px-4">
                        <?= car_t($t, 'home.hero.cta-primary') ?>
                        <i class="bi bi-arrow-right ms-1" aria-hidden="true"></i>
                    </a>
                    <a href="#try-a-sample"
                       class="btn btn-outline-secondary btn-lg rounded-pill px-4">
                        <?= car_t($t, 'home.hero.cta-secondary') ?>
                    </a>
                </div>

                <p class="small text-body-tertiary mb-0">
                    <?= car_t($t, 'home.hero.footnote') ?>
                </p>
            </div>
        </div>
    </div>
</section>
