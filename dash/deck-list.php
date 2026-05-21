<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/car-server.php'; ?>
<?php include_once CAL_ROOT_WEB . '/config.inc';?>
<?php include CAL_ROOT_WEB . '/lang/lang.inc'; ?>
<?php cal_check_login($t); ?>
<?php
	cal_set_session_attribute('read_database', 'on');

    // Parâmetros
    $user_id = cal_get_session_attribute('user_id', 0);

    // Variáveis
    $total_records = 0; // quantidade de registro da consulta

    // Procurando a quantidade de grupos do usuário
    $sql = sprintf('select count(*) as count from car_deck where user_id = %d',
                    $user_id);

    $result_count = $mysqli->query($sql);

    while ($row = $result_count->fetch_array(MYSQLI_ASSOC)) {
        $total_records = $row['count'];
    }

    // Apagando todos os grupos que estiveram com o nome padrão
    $_sql = sprintf(" delete from car_deck where user_id = %d and deck_name = '%s'",
                    $user_id,
                    $mysqli->real_escape_string(cal_never_null(CAL_DECK_NAME_DEFAULT)));

    $_result = $mysqli->query($_sql);

    $mysqli->commit();

	// Procurando todos os grupos do usuário
	$sql = sprintf('select deck_id, deck_name, deck_key from car_deck where user_id = %d order by deck_name',
                    $user_id);

	$result = $mysqli->query($sql);
?>
<?php
    $header_title = cal_t($t, 'Decks') . ' - Play Flashcards';
    $header_description = '';
    $header_index_follow = 'noindex,nofollow';
    include_once CAL_ROOT_WEB . '/containers/header.inc';
?>
<div class="div-primary">
    <div class="div-start">
        <?php include_once CAL_ROOT_WEB . '/containers/message.inc' ?>
        <div class="title">
            <?= cal_t($t, 'Decks'); ?>
        </div>
        <?php if ($result->num_rows > 0) { ?>
            <?php while ($row = $result->fetch_array(MYSQLI_ASSOC)) { ?>
                <a href="<?= CAL_PATH_WEB; ?>/dash/deck?k=<?= $row['deck_key']; ?>" class="button w100p">
                    <?= cal_htmlspecialchars($row['deck_name']); ?>
                </a>
            <?php } ?>
        <?php } ?>
        <div class="stats-value">
            <a href="<?= CAL_PATH_WEB; ?>/dash/deck-new-act" class="buttonx">
                <?= cal_t($t, 'New Deck'); ?>
            </a>
        </div>
    </div>
</div>
<div class="div-secondary">
    <?php include_once CAL_ROOT_WEB . '/home/secondary.inc'; ?>
</div>
<?php include_once CAL_ROOT_WEB . '/containers/footer.inc'; ?>
