<?php /** @var array $t */ ?>
<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/car-server.php';?>
<?php include_once CAR_ROOT_WEB . '/config.inc';?>
<?php include CAR_ROOT_WEB . '/lang/lang.inc'; ?>
<?php car_check_language($t['lang']); ?>
<?php

$page_h1              = '';
$page_subtitle        = '';
$sidebar_on_this_page = '';
$sidebar_questions    = '';
$sidebar_questions_desc = '';
$sections             = [];

switch ($t['lang']) {

    default: // en (único idioma para páginas legais)
        $page_h1       = 'Terms and Conditions of Use';
        $page_subtitle = 'By accessing and using Play Flashcards, you agree to abide by these Terms and Conditions of Use.';
        $sidebar_on_this_page   = 'On this page';
        $sidebar_questions      = 'Questions?';
        $sidebar_questions_desc = 'Reach our support team.';
        $sections = [
            ['id' => 'usage',                'title' => 'Site usage',
             'content' => '<p>Play Flashcards offers a flashcard creation and study service with spaced repetition. By creating an account and using the site, you agree to use the service for personal, educational and lawful purposes only. You must provide a valid email address to create an account.</p>'],
            ['id' => 'responsibility',       'title' => 'User responsibility',
             'content' => '<p>You are responsible for ensuring that any content you create on Play Flashcards — including deck names, descriptions and flashcard text — complies with applicable laws and does not infringe on the rights of third parties. Play Flashcards is not responsible for any content created by users.</p>'],
            ['id' => 'privacy',              'title' => 'Privacy',
             'content' => '<p>We respect your privacy. Please see our <a href="' . CAR_PATH_WEB . '/en/privacy-policy">Privacy Policy</a> for a full description of what data we collect, how we use it, and the third-party services involved.</p>'],
            ['id' => 'intellectual-property','title' => 'Intellectual property',
             'content' => '<p>The Play Flashcards platform — including its design, code and features — is protected by copyright and intellectual property law. You may not copy, modify, distribute or commercially exploit any part of the platform without express permission. The flashcard content you create remains yours.</p>'],
            ['id' => 'public-decks',         'title' => 'Public decks',
             'content' => '<p>By making a deck public, you agree that its name, description and flashcards may be viewed and studied by anyone on the internet, without requiring a login. You are solely responsible for ensuring that public content does not violate any laws or third-party rights.</p>'],
            ['id' => 'account-deletion',     'title' => 'Account deletion',
             'content' => '<p>You can delete your account at any time from your profile settings. Deleting your account permanently removes all your decks, flashcards, study data and personal information from our servers. This action cannot be undone.</p>'],
            ['id' => 'termination',          'title' => 'Termination',
             'content' => '<p>We reserve the right to suspend or terminate accounts that violate these Terms, engage in abusive behavior, or attempt to misuse the service.</p>'],
            ['id' => 'changes',              'title' => 'Changes to terms',
             'content' => '<p>We may update these Terms from time to time. Continued use of the service after changes are posted constitutes acceptance of the updated Terms. We recommend checking this page occasionally to stay informed.</p>'],
        ];
}

$header_title        = $page_h1 . ' - Play Flashcards';
$header_description  = car_t($t, 'common.terms.desc');
$header_index_follow = 'index,follow';
$header_canonical    = 'https://www.playflashcards.com/en/terms-and-conditions/';
include_once CAR_ROOT_WEB . '/containers/header.inc';
?>

<main class="container py-5">

    <!-- título -->
    <h1 class="mb-3" style="font-size:clamp(2rem,5vw,3rem);letter-spacing:-0.025em;line-height:1.1">
        <?= car_htmlspecialchars($page_h1) ?>
    </h1>
    <p class="text-secondary mb-5" style="font-size:1rem;max-width:600px;line-height:1.65">
        <?= car_htmlspecialchars($page_subtitle) ?>
    </p>

    <div class="row g-5">

        <!-- sidebar TOC -->
        <div class="col-lg-3">
            <div class="car-doc-sidebar">
                <p class="car-label-uc mb-3"><?= car_htmlspecialchars($sidebar_on_this_page) ?></p>
                <nav class="car-doc-toc mb-4" aria-label="<?= car_htmlspecialchars($sidebar_on_this_page) ?>">
                    <?php foreach ($sections as $i => $section) { ?>
                    <a href="#<?= car_htmlspecialchars($section['id']) ?>">
                        <span class="car-doc-toc-num"><?= str_pad($i + 1, 2, '0', STR_PAD_LEFT) ?></span>
                        <?= car_htmlspecialchars($section['title']) ?>
                    </a>
                    <?php } ?>
                </nav>

                <!-- card de dúvidas: visível apenas no desktop (mobile fica no fim da página) -->
                <div class="card p-3 d-none d-lg-block">
                    <p class="fw-semibold small mb-1"><?= car_htmlspecialchars($sidebar_questions) ?></p>
                    <p class="small text-secondary mb-3"><?= car_htmlspecialchars($sidebar_questions_desc) ?></p>
                    <a class="btn btn-sm btn-outline-secondary" href="<?= CAR_PATH_WEB . '/' . $t['lang'] . '/contact-us' ?>">
                        <i class="bi bi-envelope" aria-hidden="true"></i>
                        <?= car_t($t, 'Contact us') ?>
                    </a>
                </div>
            </div>
        </div>

        <!-- seções -->
        <div class="col-lg-9">

            <?php foreach ($sections as $i => $section) { ?>
            <section id="<?= car_htmlspecialchars($section['id']) ?>" class="car-doc-section">
                <span class="car-label-uc text-primary d-block mb-2"><?= str_pad($i + 1, 2, '0', STR_PAD_LEFT) ?></span>
                <h2 class="mb-3" style="font-size:1.375rem;letter-spacing:-0.015em">
                    <?= car_htmlspecialchars($section['title']) ?>
                </h2>
                <div class="text-secondary" style="line-height:1.75">
                    <?= $section['content'] ?>
                </div>
            </section>
            <?php } ?>

            <!-- card de dúvidas: visível apenas no mobile (desktop fica na sidebar) -->
            <div class="card p-3 mt-4 d-lg-none">
                <p class="fw-semibold small mb-1"><?= car_htmlspecialchars($sidebar_questions) ?></p>
                <p class="small text-secondary mb-3"><?= car_htmlspecialchars($sidebar_questions_desc) ?></p>
                <a class="btn btn-sm btn-outline-secondary" href="<?= CAR_PATH_WEB . '/' . $t['lang'] . '/contact-us' ?>">
                    <i class="bi bi-envelope" aria-hidden="true"></i>
                    <?= car_t($t, 'Contact us') ?>
                </a>
            </div>
        </div>

    </div>
</main>

<?php include_once CAR_ROOT_WEB . '/containers/footer.inc';?>
