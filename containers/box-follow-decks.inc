<?php /** @var array $t */ ?>
<?php
    $sql    = 'select deck_key,
                      deck_url,
                      deck_name
                 from car_deck
                where deck_follow = 1
                  and deck_public = 1
                order by deck_name asc';
    $result = $mysqli->query($sql, MYSQLI_STORE_RESULT);
?>
<?php if ($result->num_rows > 0) { ?>
<div class="card">
    <div class="card-header fw-medium"><?= car_t($t, 'public.deck.more-decks') ?></div>
    <div class="list-group list-group-flush">
        <?php while ($row = $result->fetch_array(MYSQLI_ASSOC)) { ?>
        <a href="<?= CAR_PATH_WEB . '/deck/' . $row['deck_key'] . '/' . $row['deck_url'] . '/' ?>"
           class="list-group-item list-group-item-action d-flex align-items-center justify-content-between gap-2 py-2">
            <span class="small"><?= car_htmlspecialchars($row['deck_name']) ?></span>
            <i class="bi bi-chevron-right small text-primary flex-shrink-0" aria-hidden="true"></i>
        </a>
        <?php } ?>
    </div>
</div>
<?php } ?>
