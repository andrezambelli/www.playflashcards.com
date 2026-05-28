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
        $page_h1       = 'Privacy Policy';
        $page_subtitle = 'Play Flashcards is committed to protecting your privacy. This policy describes exactly what we collect, how we use it, and the controls you have.';
        $sidebar_on_this_page   = 'On this page';
        $sidebar_questions      = 'Questions?';
        $sidebar_questions_desc = 'Reach our team.';
        $sections = [
            ['id' => 'information', 'title' => 'Information collected',
             'content' => '<p>When you create an account, Play Flashcards collects and stores:</p><ul><li>Your <strong>email address</strong>, used to identify your account and send login codes.</li><li>Your <strong>language and timezone preferences</strong>.</li><li>The <strong>decks, flashcards and study data</strong> you create, including progress and performance statistics used by the spaced repetition system.</li><li>A <strong>cookie consent record</strong>, linked anonymously before login and associated with your account after login.</li></ul><p>We do not collect your name, profile picture or any information beyond what is listed above.</p>'],
            ['id' => 'use',         'title' => 'Use of information',
             'content' => '<p>We use your information to provide the flashcard and spaced repetition service, to send one-time login codes to your email address, and to analyze anonymized usage patterns to improve the product.</p><p>We do not send marketing, promotional or newsletter emails. The only emails we send are transactional: one-time login codes requested by you.</p>'],
            ['id' => 'sharing',     'title' => 'Third-party services',
             'content' => '<p>We do not sell your data. We work with the following third-party services, each governed by its own privacy policy:</p><ul><li><strong>MailerSend</strong> — processes your email address solely to deliver login codes.</li><li><strong>Google Analytics</strong> — receives anonymized usage data (pages visited, session duration) to help us understand how the site is used. No personally identifiable information is sent.</li><li><strong>Google Sign-In</strong> — if you choose to sign in with Google, your authentication is processed by Google, which shares only your email address with us.</li></ul><div class="d-flex align-items-start gap-3 p-3 mt-3 rounded" style="background:var(--bs-primary-bg-subtle);border:1px solid var(--bs-primary-border-subtle)"><i class="bi bi-lock-fill text-primary flex-shrink-0" style="margin-top:2px" aria-hidden="true"></i><div><p class="fw-semibold text-primary small mb-1">We don\'t sell your data. Ever.</p><p class="small mb-0" style="color:var(--bs-secondary-color)">No advertising networks, no behavioral profiling, no data brokers.</p></div></div>'],
            ['id' => 'security',    'title' => 'Security and account deletion',
             'content' => '<p>We implement security measures to protect your information, including encryption in transit (TLS 1.3) and encryption at rest. We do not store passwords. Authentication uses one-time codes sent to your email, or Google Sign-In.</p><p>You can permanently delete your account at any time from your profile settings. Deleting your account removes all your decks, flashcards, study data and personal information from our servers.</p>'],
            ['id' => 'cookies',     'title' => 'Cookies',
             'content' => '<p>We use cookies to keep your session active and to understand how the site is used. No cookies are used for advertising or tracking across other websites.</p><div class="table-responsive mt-3"><table class="table table-bordered mb-0"><thead><tr><th>Cookie</th><th>Purpose</th><th>Duration</th></tr></thead><tbody><tr><td class="font-monospace small">PHPSESSID</td><td>Keeps your session active while you browse the site.</td><td>Session</td></tr><tr><td class="font-monospace small">consent_key</td><td>Records your consent to the use of cookies.</td><td>30 days</td></tr><tr><td class="font-monospace small">_ga</td><td>Google Analytics: distinguishes unique users.</td><td>2 years</td></tr><tr><td class="font-monospace small">_ga_LDCEXXD2NL</td><td>Google Analytics: maintains the analytics session state.</td><td>2 years</td></tr></tbody></table></div>'],
            ['id' => 'changes',     'title' => 'Policy changes',
             'content' => '<p>We may update this Privacy Policy as the service evolves. Any changes will be posted on this page. We recommend checking this page occasionally to stay informed.</p>'],
        ];
}

$header_title        = $page_h1 . ' - Play Flashcards';
$header_description  = car_t($t, 'common.privacy.desc');
$header_index_follow = 'index,follow';
$header_canonical    = 'https://www.playflashcards.com/en/privacy-policy/';
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
