<?php /** @var array $t */ ?>
<?php if (car_get_session_attribute('session_login', 'off') === 'off') { ?>
<div class="card">
    <div class="card-body">
        <p class="fw-semibold mb-1"><?= car_t($t, 'main.start') ?></p>
        <p class="small text-secondary mb-3"><?= car_t($t, 'public.deck.signup-desc') ?></p>
        <a href="<?= CAR_PATH_WEB . '/' . $t['lang'] . '/login/login' ?>" class="btn btn-primary w-100">
            <?= car_t($t, 'Get Started') ?>
        </a>
    </div>
</div>
<?php } ?>
