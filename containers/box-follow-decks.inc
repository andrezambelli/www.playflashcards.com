<?php /** @var array $t */ ?>
<?php
    $sql = 'select deck_key,
                   deck_url,
                   deck_name
              from car_deck
             where deck_follow = 1
               and deck_public = 1
             order by deck_name asc';
    $result = $mysqli->query($sql, MYSQLI_STORE_RESULT);

    $_all_decks  = [];
    $_current_pos = -1;

    while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
        if ($row['deck_key'] === $deck_key) {
            $_current_pos = count($_all_decks);
        }
        $_all_decks[] = $row;
    }

    $_total      = count($_all_decks);
    $_show_decks = [];

    if ($_total > 1) {
        if ($_current_pos === -1) {
            $_show_decks = array_slice($_all_decks, 0, 6);
        } else {
            $_start  = max(0, $_current_pos - 3);
            $_end    = min($_total - 1, $_current_pos + 3);
            $_before = $_current_pos - $_start;
            $_after  = $_end - $_current_pos;

            if ($_before < 3) {
                $_end = min($_total - 1, $_end + (3 - $_before));
            }
            if ($_after < 3) {
                $_start = max(0, $_start - (3 - $_after));
            }

            for ($_i = $_start; $_i <= $_end; $_i++) {
                if ($_i !== $_current_pos) {
                    $_show_decks[] = $_all_decks[$_i];
                }
            }
        }
    }
?>
<?php if (!empty($_show_decks)) { ?>
<div class="card">
    <div class="card-header fw-medium"><?= car_t($t, 'public.deck.more-decks') ?></div>
    <div class="list-group list-group-flush">
        <?php foreach ($_show_decks as $_deck) { ?>
        <a href="<?= CAR_PATH_WEB . '/deck/' . $_deck['deck_key'] . '/' . $_deck['deck_url'] . '/' ?>"
           class="list-group-item list-group-item-action d-flex align-items-center justify-content-between gap-2 py-2">
            <span class="small"><?= car_htmlspecialchars($_deck['deck_name']) ?></span>
            <i class="bi bi-chevron-right small text-primary flex-shrink-0" aria-hidden="true"></i>
        </a>
        <?php } ?>
    </div>
    <div class="card-footer text-center">
        <a href="<?= CAR_PATH_WEB . '/' . $t['lang'] ?>/explore/" class="btn btn-link btn-sm text-decoration-none">
            <?= car_t($t, 'public.deck.all-decks') ?>
            <i class="bi bi-arrow-right ms-1" aria-hidden="true"></i>
        </a>
    </div>
</div>
<?php } ?>
