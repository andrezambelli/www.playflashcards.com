<?php /** @var array $t */ ?>
<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/car-server.php'; ?>
<?php include_once CAR_ROOT_WEB . '/config.inc'; ?>
<?php include CAR_ROOT_WEB . '/lang/lang.inc'; ?>
<?php include_once CAR_ROOT_WEB . '/lang/lang-list.inc'; ?>
<?php
    $user_id    = car_get_session_attribute('user_id', CAR_USER_ID_MASTER);
    $is_logged  = car_get_session_attribute('session_login', '') === 'on';

    $user_id_deck  = 0;
    $deck_key      = '';
    $deck_id       = 0;
    $deck_name     = '';
    $deck_desc     = '';
    $deck_url      = '';
    $deck_lang     = '';
    $deck_follow   = 0;

    $total_cards   = 0;
    $preview_cards = [];

    $has_deck      = false;
    $page_deck_url = '';

    if (isset($_GET['page'])) {
        $pages = $_GET['page'];

        if ($pages[strlen($pages) - 1] == '/') {
            $pages = substr($pages, 0, -1);
        }

        $pages    = explode('/', $pages);
        $deck_key = $pages[1];

        $sql = sprintf("select user_id,
                               deck_id,
                               deck_name,
                               deck_desc,
                               deck_url,
                               deck_lang,
                               deck_follow
                          from car_deck
                         where deck_key = '%s'
                           and deck_public = 1",
                        $mysqli->real_escape_string(car_never_null($deck_key)));
        $result = $mysqli->query($sql);
        while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
            $user_id_deck = $row['user_id'];
            $deck_id      = $row['deck_id'];
            $deck_name    = $row['deck_name'];
            $deck_desc    = $row['deck_desc'];
            $deck_url     = $row['deck_url'];
            $deck_lang    = $row['deck_lang'];
            $deck_follow  = $row['deck_follow'];
            $has_deck     = true;
        }

        if ($has_deck) {
            $sql = sprintf('select count(1) as count
                              from car_card
                             where deck_id = %d',
                            $deck_id);
            $result = $mysqli->query($sql);
            while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
                $total_cards = (int) $row['count'];
            }

            if ($total_cards > 0) {
                $sql = sprintf('select card_front,
                                       card_back
                                  from car_card
                                 where deck_id = %d
                                 order by card_front asc',
                                $deck_id);
                $result = $mysqli->query($sql);
                while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
                    $preview_cards[] = $row;
                }
            }
        }

        if (isset($pages[2])) {
            $page_deck_url = $pages[2];
        }

        if (!$has_deck) {
            include CAR_ROOT_WEB . '/common/404.php';
            exit;
        }

        if ($deck_url != $page_deck_url) {
            car_redirect(CAR_PATH_WEB . '/deck/' . $deck_key . '/' . $deck_url . '/');
        }
    }

    $_base_url = car_get_base_url(CAR_PATH_WEB);

    $header_title        = (!empty($deck_name) ? $deck_name . ' - ' : '') . 'Play Flashcards';
    $header_description  = !empty($deck_desc) ? $deck_desc : car_t($t, 'main.desc');
    $header_canonical    = $has_deck ? $_base_url . '/deck/' . $deck_key . '/' . $deck_url . '/' : '';
    $header_og_image     = $_base_url . '/assets/img/playflashcards-logo.png';
    $header_index_follow = $deck_follow ? 'index,follow' : 'noindex,nofollow';
    include_once CAR_ROOT_WEB . '/containers/header.inc';
?>

<main class="container py-4 py-lg-5">

    <?php include_once CAR_ROOT_WEB . '/containers/message.inc'; ?>

    <div class="row g-4">

        <!-- Conteúdo principal -->
        <div class="col-lg-8">

            <?php if ($has_deck) { ?>

            <div class="mb-4">
                <div class="car-label-uc d-flex align-items-center gap-1 mb-2">
                    <i class="bi bi-globe2" aria-hidden="true"></i>
                    <?= car_t($t, 'dash.home.public') ?>
                    <?php if ($total_cards > 0) { ?>
                        <span class="mx-1" aria-hidden="true">·</span>
                        <?= $total_cards ?> <?= car_t($t, 'profile.srs.unit-cards') ?>
                    <?php } ?>
                    <?php if (!empty($deck_lang) && isset($car_langs[$deck_lang])) { ?>
                        <span class="mx-1" aria-hidden="true">·</span>
                        <?= car_htmlspecialchars($car_langs[$deck_lang]) ?>
                    <?php } ?>
                </div>
                <h1 class="h2 fw-semibold mb-2"<?= !empty($deck_lang) ? ' lang="' . car_htmlspecialchars($deck_lang) . '"' : '' ?>><?= car_htmlspecialchars($deck_name) ?></h1>
                <?php if (!empty($deck_desc)) { ?>
                    <p class="text-secondary mb-0"<?= !empty($deck_lang) ? ' lang="' . car_htmlspecialchars($deck_lang) . '"' : '' ?>><?= car_htmlspecialchars($deck_desc) ?></p>
                <?php } ?>
            </div>

            <?php if ($total_cards > 0) { ?>

            <div class="card mb-4">
                <div class="card-body">
                    <?php if ($is_logged && $user_id == $user_id_deck) { ?>
                    <div class="row g-2">
                        <div class="col-md-6">
                            <a href="<?= CAR_PATH_WEB ?>/dash/study-srs-new-act?k=<?= $deck_key ?>"
                               class="card h-100 text-decoration-none text-body border-primary car-card-link"
                               style="background: var(--bs-primary-bg-subtle)">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <div class="d-flex align-items-center gap-2">
                                            <i class="bi bi-stars text-primary" aria-hidden="true"></i>
                                            <strong class="small"><?= car_t($t, 'dash.deck.study-smart') ?></strong>
                                        </div>
                                        <span class="badge text-bg-primary"><?= car_t($t, 'Recommended') ?></span>
                                    </div>
                                    <div class="small text-secondary"><?= car_t($t, 'dash.deck.study-smart-desc') ?></div>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-6">
                            <a href="<?= CAR_PATH_WEB ?>/dash/study-new-act?k=<?= $deck_key ?>"
                               class="card h-100 text-decoration-none text-body car-card-link">
                                <div class="card-body">
                                    <div class="d-flex align-items-center gap-2 mb-2">
                                        <i class="bi bi-layers" aria-hidden="true"></i>
                                        <strong class="small"><?= car_t($t, 'dash.deck.study-full') ?></strong>
                                    </div>
                                    <div class="small text-secondary"><?= car_t($t, 'dash.deck.study-full-desc') ?></div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <?php } else { ?>
                    <div class="d-flex align-items-center justify-content-between gap-3 flex-wrap">
                        <div>
                            <div class="fw-medium mb-1"><?= car_t($t, 'dash.deck.study-full') ?></div>
                            <div class="small text-secondary"><?= car_t($t, 'dash.deck.study-full-desc') ?></div>
                        </div>
                        <form action="<?= CAR_PATH_WEB ?>/deck/study-new-act" method="post" class="flex-shrink-0">
                            <input type="hidden" name="k" value="<?= car_htmlspecialchars($deck_key) ?>">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-play-fill" aria-hidden="true"></i>
                                <?= car_t($t, 'Play') ?>
                            </button>
                        </form>
                    </div>
                    <?php } ?>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <span class="fw-medium"><?= $total_cards ?> <?= car_t($t, 'profile.srs.unit-cards') ?></span>
                </div>
                <?php if (!empty($preview_cards)) { ?>
                <?php $_preview_limit = 5; ?>
                <div class="table-responsive">
                    <table class="table table-hover mb-0"<?= !empty($deck_lang) ? ' lang="' . car_htmlspecialchars($deck_lang) . '"' : '' ?>>
                        <thead>
                            <tr>
                                <th class="small text-secondary fw-normal"><?= car_t($t, 'Front') ?></th>
                                <th class="small text-secondary fw-normal"><?= car_t($t, 'Back') ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($preview_cards as $_i => $_pc) { ?>
                            <?php if ($_i === $_preview_limit) { ?></tbody><tbody id="car-deck-extra" class="d-none"><?php } ?>
                            <tr>
                                <td class="small fw-medium"><?= car_htmlspecialchars($_pc['card_front']) ?></td>
                                <td class="small text-secondary"><?= car_htmlspecialchars($_pc['card_back']) ?></td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
                <?php if ($total_cards > $_preview_limit) { ?>
                <div class="card-footer text-center" id="car-deck-show-more">
                    <button type="button"
                            class="btn btn-link btn-sm text-decoration-none"
                            onclick="document.getElementById('car-deck-extra').classList.remove('d-none');document.getElementById('car-deck-show-more').classList.add('d-none');">
                        <?= car_t($t, 'public.deck.show-all') ?> · <?= $total_cards ?> <?= car_t($t, 'profile.srs.unit-cards') ?>
                    </button>
                </div>
                <?php } ?>
                <?php } ?>
            </div>

            <?php } else { ?>

            <div class="text-center text-secondary py-5">
                <i class="bi bi-layers fs-1 mb-3 d-block" aria-hidden="true"></i>
                <p><?= car_t($t, 'This deck has no flashcards.') ?></p>
            </div>

            <?php } ?>

            <?php } ?>

        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <div class="d-flex flex-column gap-3">
                <?php include_once CAR_ROOT_WEB . '/containers/box-signin.inc'; ?>
                <?php include_once CAR_ROOT_WEB . '/containers/box-follow-decks.inc'; ?>
            </div>
        </div>

    </div>
</main>

<?php if ($has_deck && $deck_follow) { ?>
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "LearningResource",
    "name": <?= json_encode($deck_name) ?>,
    "description": <?= json_encode($deck_desc ?: $deck_name) ?>,
    "url": <?= json_encode($_base_url . '/deck/' . $deck_key . '/' . $deck_url . '/') ?>,
    "learningResourceType": "flashcard",
    "inLanguage": <?= json_encode($deck_lang ?: $t['lang']) ?>,
    "educationalUse": "self-study",
    "provider": {
        "@type": "Organization",
        "name": "Play Flashcards",
        "url": <?= json_encode($_base_url) ?>
    }
}
</script>
<?php } ?>

<?php include_once CAR_ROOT_WEB . '/containers/footer.inc'; ?>
