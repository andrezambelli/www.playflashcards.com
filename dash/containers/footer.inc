<?php /** @var array $t */ ?>
<?php include CAR_ROOT_WEB . '/lang/lang.inc'; ?>

        </div><!-- .car-app-page -->

    </div><!-- coluna principal -->

</div><!-- .car-app-shell -->

<!-- Sidebar mobile (offcanvas) -->
<div class="offcanvas offcanvas-start d-md-none" tabindex="-1" id="car-mobile-sidebar" style="width: 260px">
    <div class="offcanvas-header border-bottom py-2">
        <a class="car-app-brand text-decoration-none text-body py-0" href="<?= CAR_PATH_WEB . '/' . $t['lang'] . '/' ?>">
            <span class="car-brand-mark" aria-hidden="true">
                <svg width="11" height="13" viewBox="0 0 11 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M1 1L10 6.5L1 12V1Z" fill="white" stroke="white" stroke-width="1.2" stroke-linejoin="round"/>
                </svg>
            </span>
            Play Flashcards
        </a>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="<?= car_t($t, 'Close') ?>"></button>
    </div>
    <div class="offcanvas-body p-3 d-flex flex-column gap-1">

        <nav class="car-nav-section" aria-label="<?= car_t($t, 'Navigation') ?>">
            <a class="car-app-nav-item <?= ($dash_active ?? '') === 'decks' ? 'active' : '' ?>"
               href="<?= CAR_PATH_WEB ?>/dash/deck-list">
                <i class="bi bi-layers" aria-hidden="true"></i>
                <?= car_t($t, 'Decks') ?>
            </a>
        </nav>

        <?php if (!empty($sidebar_decks)) { ?>
        <nav class="car-nav-section car-nav-section--decks" aria-label="<?= car_t($t, 'Decks') ?>">
            <div class="car-nav-section-title"><?= car_t($t, 'Decks') ?></div>
            <?php foreach ($sidebar_decks as $sd) { ?>
            <a class="car-app-nav-item car-app-nav-item--deck"
               href="<?= CAR_PATH_WEB ?>/dash/deck?k=<?= car_htmlspecialchars($sd['deck_key']) ?>">
                <span class="car-nav-deck-dot" aria-hidden="true"></span>
                <span class="car-app-nav-label"><?= car_htmlspecialchars($sd['deck_name']) ?></span>
            </a>
            <?php } ?>
            <a class="car-app-nav-item text-secondary"
               href="<?= CAR_PATH_WEB ?>/dash/deck-new-act">
                <i class="bi bi-plus" aria-hidden="true"></i>
                <?= car_t($t, 'New Deck') ?>
            </a>
        </nav>
        <?php } ?>

        <nav class="car-nav-section mt-auto" aria-label="<?= car_t($t, 'Settings') ?>">
            <div class="car-nav-section-title"><?= car_t($t, 'Settings') ?></div>
            <a class="car-app-nav-item <?= ($dash_active ?? '') === 'srs' ? 'active' : '' ?>"
               href="<?= CAR_PATH_WEB ?>/profile/srs">
                <i class="bi bi-arrow-repeat" aria-hidden="true"></i>
                <?= car_t($t, 'SRS') ?>
            </a>
            <a class="car-app-nav-item <?= ($dash_active ?? '') === 'profile' ? 'active' : '' ?>"
               href="<?= CAR_PATH_WEB ?>/profile/profile">
                <i class="bi bi-person" aria-hidden="true"></i>
                <?= car_t($t, 'Profile') ?>
            </a>
            <a class="car-app-nav-item text-secondary"
               href="<?= CAR_PATH_WEB ?>/login/logoff-act">
                <i class="bi bi-box-arrow-right" aria-hidden="true"></i>
                <?= car_t($t, 'Sign Out') ?>
            </a>
        </nav>

    </div>
</div>

<!-- Footer -->
<footer class="border-top py-4 bg-body-secondary">
    <div class="container-fluid px-4">
        <div class="d-flex flex-column flex-md-row justify-content-md-between align-items-md-center gap-2 gap-md-0">

            <div class="d-flex align-items-center gap-2">
                <a class="d-flex align-items-center gap-2 text-decoration-none text-body fw-bold"
                   href="<?= CAR_PATH_WEB . '/' . $t['lang'] . '/' ?>">
                    <span class="car-brand-mark" aria-hidden="true">
                        <svg width="11" height="13" viewBox="0 0 11 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M1 1L10 6.5L1 12V1Z" fill="white" stroke="white" stroke-width="1.2" stroke-linejoin="round"/>
                        </svg>
                    </span>
                    Play Flashcards
                </a>
                <span class="badge car-text-mono ms-1"><?= CAR_VERSION ?></span>
            </div>

            <div class="d-flex flex-column flex-md-row align-items-start align-items-md-center gap-2 gap-md-0 small text-secondary">
                <div class="d-flex align-items-center gap-3">
                    <a class="text-decoration-none text-secondary" href="<?= CAR_PATH_WEB . '/' . $t['lang'] . '/contact-us' ?>"><?= car_t($t, 'Contact') ?></a>
                    <a class="text-decoration-none text-secondary" href="<?= CAR_PATH_WEB . '/' . $t['lang'] . '/terms-and-conditions' ?>"><?= car_t($t, 'Terms') ?></a>
                    <a class="text-decoration-none text-secondary" href="<?= CAR_PATH_WEB . '/' . $t['lang'] . '/privacy-policy' ?>"><?= car_t($t, 'Privacy') ?></a>
                </div>
            </div>

        </div>
    </div>
</footer>

</body>
</html>
<?php include_once CAR_ROOT_WEB . '/services/set-user-last-access-act.inc'; ?>
