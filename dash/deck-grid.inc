<?php /** @var array $t */ ?>
<?php
    $_dg_user_id = car_get_session_attribute('user_id', 0);
    $_dg_decks   = [];

    $_dg_sql = sprintf('select d.deck_key,
                               d.deck_name,
                               d.deck_desc,
                               d.deck_public,
                               count(c.card_id) as total_cards,
                               coalesce(sum(c.card_true), 0) as total_true,
                               coalesce(sum(c.card_false), 0) as total_false
                          from car_deck d
                          left join car_card c on c.deck_id = d.deck_id
                                                and c.user_id = d.user_id
                         where d.user_id = %d
                         group by d.deck_id,
                                  d.deck_key,
                                  d.deck_name,
                                  d.deck_desc,
                                  d.deck_public
                         order by d.deck_name',
                        $_dg_user_id);

    $_dg_result = $mysqli->query($_dg_sql);
    while ($_dg_row = $_dg_result->fetch_array(MYSQLI_ASSOC)) {
        $_dg_decks[] = $_dg_row;
    }
?>

<?php if (empty($_dg_decks)) { ?>

    <div class="text-center py-5 text-secondary">
        <i class="bi bi-layers fs-1 mb-3 d-block" aria-hidden="true"></i>
        <p class="mb-3"><?= car_t($t, 'dash.home.no-decks') ?></p>
        <a href="<?= CAR_PATH_WEB ?>/dash/deck-new" class="btn btn-primary">
            <i class="bi bi-plus" aria-hidden="true"></i>
            <?= car_t($t, 'New Deck') ?>
        </a>
    </div>

<?php } else { ?>

    <div class="row g-3">
        <?php foreach ($_dg_decks as $_dg_deck) { ?>
        <div class="col-md-6">
            <a href="<?= CAR_PATH_WEB ?>/dash/deck?k=<?= car_htmlspecialchars($_dg_deck['deck_key']) ?>"
               class="card h-100 text-decoration-none text-body car-card-link">
                <div class="card-body d-flex flex-column gap-3">

                    <div>
                        <div class="car-label-uc d-flex align-items-center gap-1 mb-1">
                            <?php if ($_dg_deck['deck_public']) { ?>
                                <i class="bi bi-globe2" aria-hidden="true"></i>
                                <?= car_t($t, 'dash.home.public') ?>
                            <?php } else { ?>
                                <i class="bi bi-lock" aria-hidden="true"></i>
                                <?= car_t($t, 'dash.home.private') ?>
                            <?php } ?>
                        </div>
                        <div class="fw-semibold"><?= car_htmlspecialchars($_dg_deck['deck_name']) ?></div>
                        <?php if (!empty($_dg_deck['deck_desc'])) { ?>
                            <div class="small text-secondary text-truncate mt-1"><?= car_htmlspecialchars($_dg_deck['deck_desc']) ?></div>
                        <?php } ?>
                    </div>

                    <div class="mt-auto">
                        <?php
                            $_dg_accuracy = car_percent($_dg_deck['total_true'], $_dg_deck['total_true'] + $_dg_deck['total_false']);
                        ?>
                        <div class="d-flex justify-content-between align-items-baseline mb-1">
                            <div class="car-label-uc"><?= car_t($t, 'Accuracy Rate') ?></div>
                            <div class="small fw-medium <?= $_dg_accuracy > 0 ? 'text-warning-emphasis' : 'text-secondary' ?>">
                                <?= $_dg_accuracy > 0 ? $_dg_accuracy . '%' : '—' ?>
                            </div>
                        </div>
                        <div class="progress" style="height: 5px" role="progressbar" aria-valuenow="<?= $_dg_accuracy ?>" aria-valuemin="0" aria-valuemax="100">
                            <div class="progress-bar bg-warning" style="width: <?= $_dg_accuracy ?>%"></div>
                        </div>
                        <div class="d-flex gap-4 mt-3">
                            <div>
                                <div class="car-label-uc"><?= car_t($t, 'profile.srs.unit-cards') ?></div>
                                <div class="car-text-mono small fw-medium"><?= (int) $_dg_deck['total_cards'] ?></div>
                            </div>
                            <div>
                                <div class="car-label-uc"><?= car_t($t, 'dash.home.due') ?></div>
                                <div class="car-text-mono small fw-medium text-secondary">—</div>
                            </div>
                        </div>
                    </div>

                </div>
            </a>
        </div>
        <?php } ?>
    </div>

<?php } ?>
