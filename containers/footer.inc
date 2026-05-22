<?php /** @var array $t */ ?>
<?php include CAR_ROOT_WEB . '/lang/lang.inc'; ?>

<?php if (!isset($_COOKIE['consent_key'])) { ?>
    <div id="cookie-banner" class="cookie-banner">
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

<footer class="py-4 mt-auto">
    <div class="container">
        <div class="d-flex flex-column flex-sm-row align-items-start align-items-sm-center justify-content-between gap-3">
            <!-- Links institucionais -->
            <div class="d-flex flex-wrap gap-3">
                <a href="<?= CAR_PATH_WEB . '/' . $t['lang'] . '/contact-us' ?>"><?= car_t($t, 'Contact us') ?></a>
                <a href="<?= CAR_PATH_WEB . '/' . $t['lang'] . '/terms-and-conditions' ?>"><?= car_t($t, 'Terms and Conditions') ?></a>
                <a href="<?= CAR_PATH_WEB . '/' . $t['lang'] . '/privacy-policy' ?>"><?= car_t($t, 'Privacy Policy') ?></a>
            </div>
            <!-- Redes sociais -->
            <div class="d-flex gap-2">
                <a href="https://x.com/playflashcards" target="_blank" rel="noopener" aria-label="Play Flashcards no X">
                    <img src="<?= CAR_PATH_WEB ?>/assets/img/x.png" alt="X" width="20" height="20">
                </a>
                <a href="https://www.threads.net/@play_flashcards" target="_blank" rel="noopener" aria-label="Play Flashcards no Threads">
                    <img src="<?= CAR_PATH_WEB ?>/assets/img/threads.png" alt="Threads" width="20" height="20">
                </a>
            </div>
        </div>

        <hr class="my-3" style="border-color: var(--bs-border-color);">

        <div class="d-flex flex-column flex-sm-row align-items-start align-items-sm-center justify-content-between gap-2">
            <!-- Seletor de idioma -->
            <div class="d-flex flex-wrap gap-3">
                <a href="<?= CAR_PATH_WEB ?>/services/change-language-act?lang=en"
                   class="<?= $t['lang'] === 'en' ? 'lang-active' : '' ?>"><?= car_t($t, 'English') ?></a>
                <a href="<?= CAR_PATH_WEB ?>/services/change-language-act?lang=es"
                   class="<?= $t['lang'] === 'es' ? 'lang-active' : '' ?>"><?= car_t($t, 'Spanish') ?></a>
                <a href="<?= CAR_PATH_WEB ?>/services/change-language-act?lang=pt-br"
                   class="<?= $t['lang'] === 'pt-br' ? 'lang-active' : '' ?>"><?= car_t($t, 'Portuguese') ?></a>
                <a href="<?= CAR_PATH_WEB ?>/services/change-language-act?lang=fr"
                   class="<?= $t['lang'] === 'fr' ? 'lang-active' : '' ?>"><?= car_t($t, 'France') ?></a>
            </div>
            <!-- Versão -->
            <span class="label-uc">
                <a href="<?= CAR_PATH_WEB . '/' . $t['lang'] . '/' ?>">Play Flashcards <?= CAR_VERSION ?></a>
            </span>
        </div>
    </div>
</footer>

</body>
</html>
<?php include_once CAR_ROOT_WEB . '/services/set-user-last-access-act.inc'; ?>
