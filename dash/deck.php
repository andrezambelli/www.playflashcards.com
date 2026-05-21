<?php /** @var array $t */ ?>
<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/car-server.php' ;?>
<?php include_once CAR_ROOT_WEB . '/config.inc' ;?>
<?php include CAR_ROOT_WEB . '/lang/lang.inc'; ?>
<?php car_check_login($t); ?>
<?php
	car_set_session_attribute('read_database', 'on');

	// Parâmetros
	$user_id = car_get_session_attribute('user_id', 0);

    $deck_key = car_get_parameter('k', 0);

    // Variáveis
	$deck_id = 0;
    $deck_desc = '';
    $deck_url = '';
    $deck_public = 0;
    $total_cards = 0;
    $total_private_studies = 0;
    $total_open_studies = 0;
    $total_public_studies = 0;
    $last_study_key = 0;

	// Procurando informação do grupo
	$sql = sprintf("select deck_id, deck_key, deck_name, deck_desc, deck_url, deck_public from car_deck where deck_key = '%s' and user_id = %d",
                    $mysqli->real_escape_string(car_never_null($deck_key)),
                    $user_id);

	$result = $mysqli->query($sql);

	while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
		$deck_id = $row['deck_id'];
        $deck_desc = $row['deck_desc'];
        $deck_url = $row['deck_url'];
        $deck_public = $row['deck_public'];
	}
	
	// TODO: mover para um cron job dedicado (services/cleanup-act.php)
	// Apagando todos os cartões que estiverem em branco deste grupo
	$_sql = sprintf(" delete from car_card where deck_id = %d and user_id = %d and (card_front is null or trim(card_front) = '' or card_back is null or trim(card_back) = '');", $deck_id, $user_id);
	
	$_result = $mysqli->query($_sql);
	
	$mysqli->commit();
	
	// Procurando a quantidade de cartões do grupo
	$sql = sprintf(' select count(*) as count from car_card where deck_id = %d and user_id = %d',
                    $deck_id,
                    $user_id);
	
	$result_count = $mysqli->query($sql);
	
	while ($row = $result_count->fetch_array(MYSQLI_ASSOC)) {
        $total_cards = $row['count'];
	}

    // Procurando a quantidade de estudos privados do grupo que pertencem ao usuário logado
    $sql = sprintf(' select count(*) as count from car_study where deck_id = %d and user_id = %d',
                    $deck_id,
                    $user_id);

    $result_count = $mysqli->query($sql);

    while ($row = $result_count->fetch_array(MYSQLI_ASSOC)) {
        $total_private_studies = $row['count'];
    }

    // Procurando a quantidade de estudos públicos do grupo (estudos de qualquer usuário)
    $sql = sprintf(' select count(*) as count from car_study where deck_id = %d and user_id != %d and stud_public = 1',
                    $deck_id,
                    $user_id);

    $result_count = $mysqli->query($sql);

    while ($row = $result_count->fetch_array(MYSQLI_ASSOC)) {
        $total_public_studies = $row['count'];
    }

    // Procurando a quantidade de estudos abertos que pertencem ao usuário logado
    $sql = sprintf(' select count(*) as count from car_study where user_id = %d and deck_id = %d and stud_end is null',
                    $user_id,
                    $deck_id);

    $result_count = $mysqli->query($sql);

    while ($row = $result_count->fetch_array(MYSQLI_ASSOC)) {
        $total_open_studies = $row['count'];
    }

    if ($total_open_studies > 0) {
        // Procurando informações do último estudo aberto que pertence ao usuário logado
        $sql = sprintf(' 
                            select a.stud_key, a.stud_create
                              from car_study a
                             where a.user_id = %d
                               and a.deck_id = %d
                               and a.stud_end is null
                             order by a.stud_id desc
                             limit 1',
                        $user_id,
                        $deck_id);

        $result = $mysqli->query($sql);
    }
?>
<?php
    $header_title = car_t($t, 'Deck') . ' - Play Flashcards';
    $header_description = '';
    $header_index_follow = 'noindex,nofollow';
    include_once CAR_ROOT_WEB . '/containers/header.inc';
?>
<div class="div-primary">
    <div class="div-start">
        <?php include_once CAR_ROOT_WEB . '/containers/message.inc' ?>
        <div class="title">
            <?= car_t($t, 'Deck'); ?>
        </div>
        <?php include_once CAR_ROOT_WEB . '/dash/deck-info.inc'; ?>
        <?php if (!empty($deck_desc)) { ?>
            <div class="stats-value">
                <div>
                    <?= car_htmlspecialchars($deck_desc); ?>
                </div>
            </div>
        <?php } ?>
        <div class="stats-value">
            <a href="<?= CAR_PATH_WEB; ?>/dash/deck-edit?k=<?= $deck_key; ?>" class="buttonx">
                <?= car_t($t, 'Edit Deck'); ?>
            </a>
        </div>
        <div class="space"></div>
        <?php if ($_found) { ?>
            <a href="<?= CAR_PATH_WEB; ?>/dash/card-list?k=<?= $deck_key; ?>" class="button w100p">
                <?= car_t($t, 'Flashcards'); ?>
            </a>
            <div class="stats-value">
                <a href="<?= CAR_PATH_WEB; ?>/dash/card-new-act?k=<?= $deck_key; ?>" class="buttonx">
                    <?= car_t($t, 'New Flashcard'); ?>
                </a>
            </div>
            <div class="space"></div>
            <?php if ($deck_public) { ?>
                <div class="stats-title"><?= car_t($t, 'Total Flashcards'); ?>:</div>
                <div class="stats-value">
                    <?= $total_cards; ?>
                </div>
            <?php } ?>
            <div class="space"></div>
            <a href="<?= CAR_PATH_WEB; ?>/dash/study-list?k=<?= $deck_key; ?>" class="button w100p">
                <?= car_t($t, 'Studies'); ?>
            </a>
            <?php if ($total_open_studies > 0) { ?>
                <div class="stats-value"><?= car_t($t, 'Open Studies'); ?>: <?= $total_open_studies; ?></div>
                <?php if ($total_open_studies > 0) { ?>
                    <?php while ($row = $result->fetch_array(MYSQLI_ASSOC)) { ?>
                        <div class="stats-value">
                            <?= car_t($t, 'Last Open Study'); ?>:
                            <a href="<?= CAR_PATH_WEB; ?>/dash/study?k=<?= $row['stud_key']; ?>">
                                <?= car_htmlspecialchars($row['stud_create']); ?>
                            </a>
                        </div>
                    <?php } ?>
                <?php } ?>
                <div class="space"></div>
            <?php } ?>
            <?php include_once CAR_ROOT_WEB . '/dash/new-study.inc'; ?>
            <div class="space"></div>
            <div class="stats-title"><?= car_t($t, 'Total Private Studies'); ?>:</div>
            <div class="stats-value">
                <?= $total_private_studies; ?>
            </div>
            <div class="space"></div>
            <div class="stats-title"><?= car_t($t, 'Total Public Studies'); ?>:</div>
            <div class="stats-value">
                <?= $total_public_studies; ?>
            </div>
            <div class="space"></div>
            <div class="stats-title"><?= car_t($t, 'Public Study URL'); ?>:</div>
            <?php if ($deck_public) { ?>
                <div class="stats-value-url">
                    <a href="<?= car_get_base_url(CAR_PATH_WEB). '/deck/'. $deck_key . '/'. $deck_url; ?>">
                        <?= car_get_base_url(CAR_PATH_WEB). '/deck/'. $deck_key . '/'. $deck_url; ?>
                    </a>
                </div>
            <?php } else { ?>
                <div class="stats-value">
                    <?= car_t($t, 'This deck is private.'); ?>
                </div>
            <?php } ?>
            <div class="space"></div>
            <div class="stats-title"><?= car_t($t, 'Delete Deck'); ?>:</div>
            <div class="stats-value">
                <table class="tip-table">
                    <tr>
                        <td class="td1">
                            <a href="<?= CAR_PATH_WEB; ?>/dash/deck-delete?k=<?= $deck_key; ?>" class="buttonx w75">
                                <?= car_t($t, 'Delete'); ?>
                            </a>
                        </td>
                        <td class="td2">
                            <div class="tip">
                                <?= car_t($t, 'dash.deck.delete'); ?><br/>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
        <?php } ?>
    </div>
</div>
<div class="div-secondary">
    <?php include_once CAR_ROOT_WEB . '/home/secondary.inc'; ?>
</div>
<?php include_once CAR_ROOT_WEB . '/containers/footer.inc'; ?>
