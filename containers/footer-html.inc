<?php /** @var array $t */ ?>

<?php if (!isset($_COOKIE['consent_key'])) { ?>
    <div id="cookie-banner" class="car-cookie-banner">
        <div class="d-flex flex-column flex-sm-row align-items-sm-center gap-3">
            <span class="flex-grow-1"><?= car_t($t, 'include.footer.cookie-warning') ?></span>
            <button type="button"
                    class="btn btn-primary flex-shrink-0"
                    onclick="setCookieGDPR('<?= CAR_PATH_WEB ?>/services/set-cookie-act')">
                <?= car_t($t, 'Accept') ?>
            </button>
        </div>
    </div>
<?php } ?>

<footer class="border-top py-4 bg-body-secondary">
    <div class="container-fluid px-4">
        <div class="d-flex flex-column flex-md-row justify-content-md-between align-items-md-center gap-2 gap-md-0">

            <div class="d-flex align-items-center gap-2">
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
                <div class="d-flex d-md-none align-items-center gap-3 ms-auto">
                    <a href="https://x.com/playflashcards" target="_blank" rel="noopener" aria-label="Play Flashcards no X" class="text-secondary">
                        <i class="bi bi-twitter-x" aria-hidden="true"></i>
                    </a>
                    <a href="https://www.threads.net/@play_flashcards" target="_blank" rel="noopener" aria-label="Play Flashcards no Threads" class="text-secondary">
                        <i class="bi bi-threads" aria-hidden="true"></i>
                    </a>
                </div>
            </div>

            <div class="d-flex flex-column flex-md-row align-items-start align-items-md-center gap-2 gap-md-0 small text-secondary">

                <div class="d-flex align-items-center gap-3">
                    <a class="text-decoration-none text-secondary" href="<?= CAR_PATH_WEB . '/' . $t['lang'] . '/contact-us' ?>"><?= car_t($t, 'Contact') ?></a>
                    <a class="text-decoration-none text-secondary" href="<?= CAR_PATH_WEB . '/' . $t['lang'] . '/terms-and-conditions' ?>"><?= car_t($t, 'Terms') ?></a>
                    <a class="text-decoration-none text-secondary" href="<?= CAR_PATH_WEB . '/' . $t['lang'] . '/privacy-policy' ?>"><?= car_t($t, 'Privacy') ?></a>
                    <span class="d-none d-md-inline" aria-hidden="true">·</span>
                    <a href="https://x.com/playflashcards" target="_blank" rel="noopener" aria-label="Play Flashcards no X" class="d-none d-md-inline text-secondary">
                        <i class="bi bi-twitter-x" aria-hidden="true"></i>
                    </a>
                    <a href="https://www.threads.net/@play_flashcards" target="_blank" rel="noopener" aria-label="Play Flashcards no Threads" class="d-none d-md-inline text-secondary">
                        <i class="bi bi-threads" aria-hidden="true"></i>
                    </a>
                </div>

            </div>
        </div>
    </div>
</footer>
