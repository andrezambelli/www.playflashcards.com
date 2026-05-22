<?php /** @var array $t */ ?>
<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/car-server.php';?>
<?php include_once CAR_ROOT_WEB . '/config.inc';?>
<?php include CAR_ROOT_WEB . '/lang/lang.inc'; ?>
<?php car_check_language($t['lang']); ?>
<?php
    $header_title = 'Play Flashcards';
    $header_canonical = car_get_base_url(CAR_PATH_WEB) . '/' . $t['lang'] . '/';
    $header_description = car_t($t, 'main.desc');
    $header_index_follow = 'index,follow';
    include_once CAR_ROOT_WEB . '/containers/header.inc';
?>

<main>

    <!-- Hero -->
    <section class="py-5 text-center">
        <div class="container py-4">
            <div class="row justify-content-center">
                <div class="col-md-10 col-lg-8">

                    <!-- Badge -->
                    <p class="car-label-uc mb-4">
                        <?= car_t($t, 'home.hero.badge') ?> · <?= CAR_VERSION ?>
                    </p>

                    <!-- Headline -->
                    <h1 class="display-3 fw-bold lh-1 mb-4">
                        <?= car_t($t, 'home.hero.h1-before') ?><br>
                        <em class="fst-italic text-primary"><?= car_t($t, 'home.hero.h1-accent') ?></em>
                        <?= car_t($t, 'home.hero.h1-after') ?>
                    </h1>

                    <!-- Subtitle -->
                    <p class="lead text-body-secondary mb-5 mx-auto" style="max-width: 520px;">
                        <?= car_t($t, 'home.hero.subtitle') ?>
                    </p>

                    <!-- CTAs -->
                    <div class="d-flex gap-3 justify-content-center flex-wrap mb-3">
                        <a href="<?= CAR_PATH_WEB . '/' . $t['lang'] . '/login/login' ?>"
                           class="btn btn-primary btn-lg rounded-pill px-4">
                            <?= car_t($t, 'home.hero.cta-primary') ?>
                            <i class="bi bi-arrow-right ms-1" aria-hidden="true"></i>
                        </a>
                        <a href="#"
                           class="btn btn-outline-secondary btn-lg rounded-pill px-4">
                            <?= car_t($t, 'home.hero.cta-secondary') ?>
                        </a>
                    </div>

                    <!-- Footnote -->
                    <p class="small text-body-tertiary mb-0">
                        <?= car_t($t, 'home.hero.footnote') ?>
                    </p>

                </div>
            </div>
        </div>
    </section>


    <!-- Card Preview -->
    <section class="pb-5 overflow-hidden">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-sm-11 col-md-9 col-lg-7">
                    <div class="car-card-stack">
                        <div class="car-card-ghost car-card-ghost--back"></div>
                        <div class="car-card-preview">
                            <div class="car-card-preview-header">
                                <span class="car-label-uc">
                                    <?= car_t($t, 'Front') ?> &middot; 7/20
                                </span>
                            </div>
                            <div class="car-card-preview-body">
                                <p class="car-card-preview-text mb-0">Posh part of the city</p>
                            </div>
                            <div class="car-card-preview-footer">
                                <span class="car-card-preview-hint"><?= car_t($t, 'home.hero.card-hint') ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- Features -->
    <section class="py-5 bg-white border-top border-bottom">
        <div class="container py-4">

            <div class="row justify-content-center mb-5">
                <div class="col-lg-7 text-center">
                    <p class="car-label-uc mb-3"><?= car_t($t, 'home.features.eyebrow') ?></p>
                    <h2 class="display-6 fw-bold"><?= car_t($t, 'home.features.title') ?></h2>
                </div>
            </div>

            <div class="row g-5">

                <div class="col-md-4">
                    <div class="d-inline-flex align-items-center justify-content-center rounded-2 bg-primary-subtle mb-3" style="width:40px;height:40px">
                        <i class="bi bi-sliders text-primary" aria-hidden="true"></i>
                    </div>
                    <h3 class="h5 fw-bold mb-2"><?= car_t($t, 'home.features.1.title') ?></h3>
                    <p class="text-body-secondary small mb-0"><?= car_t($t, 'home.features.1.desc') ?></p>
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

</main>

<?php include_once CAR_ROOT_WEB . '/containers/footer.inc';?>
