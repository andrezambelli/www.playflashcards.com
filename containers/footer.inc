<?php /** @var array $t */ ?>
<?php include CAR_ROOT_WEB . '/lang/lang.inc'; ?>

<?php if (!isset($_COOKIE['consent_key'])) { ?>
    <div id="cookie-banner" class="car-cookie-banner">
        <div class="container d-flex flex-column flex-sm-row align-items-sm-center gap-2">
            <span class="flex-grow-1"><?= car_t($t, 'include.footer.cookie-warning') ?></span>
            <button type="button"
                    class="btn btn-primary btn-sm flex-shrink-0"
                    onclick="setCookieGDPR('<?= CAR_PATH_WEB ?>/services/set-cookie-act')">
                <?= car_t($t, 'Accept') ?>
            </button>
        </div>
    </div>
<?php } ?>

<footer class="border-top mt-auto py-4 bg-body-secondary">
    <div class="container d-flex flex-wrap justify-content-between align-items-center gap-3">

        <!-- Brand + versão -->
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

        <!-- Links + idiomas + redes sociais -->
        <div class="d-flex flex-wrap align-items-center gap-3 small text-secondary">
            <a class="text-decoration-none text-secondary" href="<?= CAR_PATH_WEB . '/' . $t['lang'] . '/contact-us' ?>"><?= car_t($t, 'Contact') ?></a>
            <a class="text-decoration-none text-secondary" href="<?= CAR_PATH_WEB . '/' . $t['lang'] . '/terms-and-conditions' ?>"><?= car_t($t, 'Terms') ?></a>
            <a class="text-decoration-none text-secondary" href="<?= CAR_PATH_WEB . '/' . $t['lang'] . '/privacy-policy' ?>"><?= car_t($t, 'Privacy') ?></a>
            <span aria-hidden="true">·</span>
            <a class="text-decoration-none <?= $t['lang'] === 'en'    ? 'text-body fw-medium' : 'text-secondary' ?>" href="<?= CAR_PATH_WEB ?>/services/change-language-act?lang=en">English</a>
            <a class="text-decoration-none <?= $t['lang'] === 'es'    ? 'text-body fw-medium' : 'text-secondary' ?>" href="<?= CAR_PATH_WEB ?>/services/change-language-act?lang=es">Español</a>
            <a class="text-decoration-none <?= $t['lang'] === 'fr'    ? 'text-body fw-medium' : 'text-secondary' ?>" href="<?= CAR_PATH_WEB ?>/services/change-language-act?lang=fr">Français</a>
            <a class="text-decoration-none <?= $t['lang'] === 'pt-br' ? 'text-body fw-medium' : 'text-secondary' ?>" href="<?= CAR_PATH_WEB ?>/services/change-language-act?lang=pt-br">Português</a>
            <span aria-hidden="true">·</span>
            <a href="https://x.com/playflashcards" target="_blank" rel="noopener" aria-label="Play Flashcards no X" class="text-secondary">
                <i class="bi bi-twitter-x" aria-hidden="true"></i>
            </a>
            <a href="https://www.threads.net/@play_flashcards" target="_blank" rel="noopener" aria-label="Play Flashcards no Threads" class="text-secondary">
                <i class="bi bi-threads" aria-hidden="true"></i>
            </a>
        </div>

    </div>
</footer>

</body>
</html>
<?php include_once CAR_ROOT_WEB . '/services/set-user-last-access-act.inc'; ?>
