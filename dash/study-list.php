<?php /** @var array $t */ ?>
<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/car-server.php'; ?>
<?php include_once CAR_ROOT_WEB . '/config.inc'; ?>
<?php include CAR_ROOT_WEB . '/lang/lang.inc'; ?>
<?php car_check_login($t); ?>
<?php
	car_set_session_attribute('read_database', 'on');

	// Parâmetros
    $user_id = car_get_session_attribute('user_id', 0);
	$deck_key = car_get_parameter('k', 0);

    // Variáveis de Paginação
    $current_page = car_get_parameter('current_page', 0);
    $total_records = 0; // quantidade de registro da consulta
    $total_pages = 0; // quantidade de páginas
    $records_per_page = 25; // quantidade de registros por página

    // Variáveis
    $deck_id = 0;

    // Ajustando o timezone do banco de dados
    $timezone = car_get_session_attribute('timezone', CAR_TIMEZONE_DEFAULT);
    $sql = sprintf("SET time_zone = '%s'", $timezone);
    $mysqli->query($sql);

	// Procurando informação do grupo
	$sql = sprintf(" 
                    select deck_id, deck_key, deck_name
                      from car_deck
                     where deck_key = '%s'
                       and user_id = %d",
                    $mysqli->real_escape_string(car_never_null($deck_key)),
                    $user_id);
	
	$result = $mysqli->query($sql);
	
	while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
		$deck_id = $row['deck_id'];
	}
	
	// Procurando a quantidade de estudos do grupo (para se utilizado na paginação)
	$sql = sprintf('select count(*) as count from car_study where deck_id = %d and user_id = %d', $deck_id, $user_id);
	
	$result_count = $mysqli->query($sql);
	
	while ($row = $result_count->fetch_array(MYSQLI_ASSOC)) {
		$total_records = $row['count'];
	}
	
	$total_pages = ceil($total_records / $records_per_page);
	
	// Procurando os estudos privados do grupo
	$sql = sprintf(' 
                    select stud_key, stud_total, stud_true, stud_false, stud_begin, stud_end
                      from car_study
                     where deck_id = %d
                       and user_id = %d
                     order by stud_id desc
                    limit %d, %d',
                    $deck_id,
                    $user_id,
                    $current_page * $records_per_page,
                    $records_per_page);
	
	$result = $mysqli->query($sql);
?>
<?php
    $header_title = car_t($t, 'Studies') . ' - Play Flashcards';
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
        <div class="title">
            <?= car_t($t, 'Studies'); ?> (<?= $total_records; ?>)
        </div>
        <?php if ($_found) { ?>
            <?php if (isset($result)) { ?>
                <?php if ($result->num_rows > 0) { ?>
                    <div class="table">
                        <table>
                            <?php $count = 0; ?>
                            <tr>
                                <th style="width:50%">
                                    <?= car_t($t, 'Start'); ?>
                                </th>
                                <th style="width:25%">
                                    <?= car_t($t, 'Flashcards'); ?>
                                </th>
                                <th style="width:25%">
                                    <?= car_t($t, 'Accuracy Rate'); ?>
                                </th>
                            </tr>
                            <?php while ($row = $result->fetch_array(MYSQLI_ASSOC)) { ?>
                                <?php $count += 1; ?>
                                <tr>
                                    <td>
                                        <a href="../dash/study?k=<?= $row['stud_key']; ?>">
                                            <?= car_htmlspecialchars($row['stud_begin']); ?>
                                        </a>
                                    </td>
                                    <td>
                                        <?= $row['stud_total']; ?>
                                    </td>
                                    <td>
                                        <?php if (empty($row['stud_end'])) { ?>
                                            <a href="../dash/study?k=<?= $row['stud_key']; ?>" class="buttonx">
                                                <?= car_t($t, 'Play'); ?>
                                            </a>
                                        <?php } else { ?>
                                            <?= car_percent($row['stud_true'], $row['stud_total']); ?>%
                                        <?php } ?>
                                    </td>
                                </tr>
                            <?php } ?>
                        </table>
                    </div>
                    <?php if ($total_pages > 1) { ?>
                        <div class="pages">
                            <?php if ($current_page > 0) { ?>
                                <a href="../dash/study-list?k=<?= $deck_key?>&current_page=<?= ($current_page - 1); ?>" class="buttonx">&lt;</a>
                            <?php } ?>
                            <?php for ($page = 0; $page < $total_pages; $page++) { ?>
                                <?php if ($current_page != $page) { ?>
                                    <a href="../dash/study-list?k=<?= $deck_key?>&current_page=<?= $page; ?>" class="buttonx"><?= ($page + 1); ?></a>
                                <?php } else { ?>
                                    <span class="disabledx"><?= ($page + 1); ?></span>
                                <?php } ?>
                            <?php } ?>
                            <?php if ($current_page + 1 < $total_pages) { ?>
                                <a href="../dash/study-list?k=<?= $deck_key?>&current_page=<?= ($current_page + 1); ?>" class="buttonx">&gt;</a>
                            <?php } ?>
                        </div>
                    <?php } ?>
                <?php } ?>
            <?php } ?>
        <?php } ?>
        <?php include_once CAR_ROOT_WEB . '/dash/new-study.inc'; ?>
    </div>
</div>
<div class="div-secondary">
    <?php include_once CAR_ROOT_WEB . '/home/secondary.inc'; ?>
</div>
<?php include_once CAR_ROOT_WEB . '/containers/footer.inc'; ?>