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

</main>

<?php include_once CAR_ROOT_WEB . '/containers/footer.inc';?>
