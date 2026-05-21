<?php /** @var array $t */ ?>
<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/car-server.php' ;?>
<?php include_once CAR_ROOT_WEB . '/config.inc' ;?>
<?php include CAR_ROOT_WEB . '/lang/lang.inc'; ?>
<?php car_check_login($t); ?>
<?php 
	car_set_session_attribute('read_database', 'on');

    // Parâmetros
    $user_id = car_get_session_attribute('user_id', 0);
    $deck_key = car_get_parameter('k', '');

    // Variáveis de Paginação
    $current_page = car_get_parameter('current_page', 0);
	$total_records = 0; // quantidade de registro da consulta
	$total_pages = 0; // quantidade de páginas
	$records_per_page = 25; // quantidade de registros por página
	
	// Variáveis
    $deck_id = 0;

	// Procurando informação do grupo
	$sql = sprintf(" select deck_id, deck_key, deck_name from car_deck where deck_key = '%s' and user_id = %d",
                    $mysqli->real_escape_string(car_never_null($deck_key)),
                    $user_id);

	$result = $mysqli->query($sql);

	while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
		$deck_id = $row['deck_id'];
	}
	
	// Apagando todos os cartões que estiverem em branco deste grupo
	$_sql = sprintf("delete from car_card where deck_id = %d and user_id = %d and (card_front is null or trim(card_front) = '' or card_back is null or trim(card_back) = '');",
                     $deck_id,
                     $user_id);
	
	$_result = $mysqli->query($_sql);
	
	$mysqli->commit();
	
	// Procurando a quantidade de cartões do grupo (para se utilizado na paginação)
	$sql = sprintf('select count(*) as count from car_card where deck_id = %d and user_id = %d',
                    $deck_id,
                    $user_id);
	
	$result_count = $mysqli->query($sql);
	
	while ($row = $result_count->fetch_array(MYSQLI_ASSOC)) {
		$total_records = $row['count'];
	}
	
	$total_pages = ceil($total_records / $records_per_page);
	
	// Procurando os cartões do grupo
	$sql = sprintf('select card_key, card_front, card_back, card_true, card_false, card_sequence
                            from car_card
                           where deck_id = %d
                             and user_id = %d
                           order by card_front
                    limit %d, %d',
                    $deck_id,
                    $user_id,
                    $current_page * $records_per_page,
                    $records_per_page);
	
	$result = $mysqli->query($sql);
?>
<?php
    $header_title = car_t($t, 'Flashcards') . ' - Play Flashcards';
    $header_description = '';
    $header_index_follow = 'noindex,nofollow';
    include_once CAR_ROOT_WEB . '/containers/header.inc';
?>
<script>
    $(document).ready(function() {
        $("#input_file").change(function() {
            $("#upload_form").submit();
        });
    });
</script>
<div class="div-primary">
    <div class="div-start">
        <?php include_once CAR_ROOT_WEB . '/containers/message.inc' ?>
        <div class="title">
            <?= car_t($t, 'Deck'); ?>
        </div>
        <?php include_once CAR_ROOT_WEB . '/dash/deck-info.inc'; ?>
        <div class="space"></div>
        <div class="title">
            <?= car_t($t, 'Flashcards'); ?>
        </div>
        <a href="<?= CAR_PATH_WEB; ?>/dash/card-new-act?k=<?= $deck_key; ?>" class="buttonx">
            <?= car_t($t, 'New Flashcard'); ?>
        </a>
        <?php if ($_found) { ?>
            <?php if (isset($result)) { ?>
                <?php if ($result->num_rows > 0) { ?>
                    <div class="table">
                        <table>
                            <?php $count = 0; ?>
                            <tr>
                                <th style="width: 40%">
                                    <?= car_t($t, 'Front'); ?>
                                </th>
                                <th style="width: 40%;">
                                    <?= car_t($t, 'Back'); ?>
                                </th>
                                <th style="width: 15%">
                                    <?= car_t($t, 'Accuracy Rate'); ?>
                                </th>
                                <th style="width: 5%">
                                    <!-- -->
                                </th>
                            </tr>
                            <?php while ($row = $result->fetch_array(MYSQLI_ASSOC)) { ?>
                                <?php $count += 1; ?>
                                <tr>
                                    <td>
                                        <?= car_htmlspecialchars($row['card_front']); ?>
                                    </td>
                                    <td>
                                        <?= car_htmlspecialchars($row['card_back']); ?>
                                    </td>
                                    <td>
                                        <?= car_percent($row['card_true'], $row['card_true'] + $row['card_false']); ?>%
                                    </td>
                                    <td>
                                        <a href="<?= CAR_PATH_WEB; ?>/dash/card-edit?k=<?= $row['card_key']; ?>">
                                            <?= car_t($t, 'Edit'); ?>
                                        </a>
                                    </td>
                                </tr>
                            <?php } ?>
                        </table>
                    </div>
                    <?php if ($total_pages > 1) { ?>
                        <div class="pages">
                            <?php if ($current_page > 0) { ?>
                                <a href="<?= CAR_PATH_WEB; ?>/dash/card-list?k=<?= $deck_key?>&current_page=<?= ($current_page - 1); ?>" class="buttonx">&lt;</a>
                            <?php } ?>
                            <?php for ($page = 0; $page < $total_pages; $page++) { ?>
                                <?php if ($current_page != $page) { ?>
                                    <a href="<?= CAR_PATH_WEB; ?>/dash/card-list?k=<?= $deck_key?>&current_page=<?= $page; ?>" class="buttonx"><?= ($page + 1); ?></a>
                                <?php } else { ?>
                                    <span class="disabledx"><?= ($page + 1); ?></span>
                                <?php } ?>
                            <?php } ?>
                            <?php if ($current_page + 1 < $total_pages) { ?>
                                <a href="<?= CAR_PATH_WEB; ?>/dash/card-list?k=<?= $deck_key?>&current_page=<?= ($current_page + 1); ?>" class="buttonx">&gt;</a>
                            <?php } ?>
                        </div>
                    <?php } ?>
                    <div class="space"></div>
                    <?php include_once CAR_ROOT_WEB . '/dash/new-study.inc'; ?>
                <?php } ?>
                <div class="space"></div>
                <?php include_once CAR_ROOT_WEB . '/dash/card-export-import.inc'; ?>
            <?php } ?>
        <?php } ?>
    </div>
</div>
<div class="div-secondary">
    <?php include_once CAR_ROOT_WEB . '/home/secondary.inc'; ?>
</div>
<?php include_once CAR_ROOT_WEB . '/containers/footer.inc'; ?>
