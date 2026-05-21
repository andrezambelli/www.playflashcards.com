<?php /** @var array $t */ ?>
<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/car-server.php';?>
<?php include_once CAR_ROOT_WEB . '/config.inc';?>
<?php include CAR_ROOT_WEB . '/lang/lang.inc'; ?>
<?php car_check_login($t); ?>
<?php
	// Parâmetros 
	$user_id = car_get_session_attribute('user_id', 0);
    $read_database = car_get_session_attribute('read_database', 'on');

    $card_key = car_get_parameter('k', '');

    // Variáveis
    $card_front = '';
	$card_back = '';

    $card_true = 0;;
	$card_false = 0;
	$card_sequence = 0;
    $card_last_study = '';

    $deck_key = '';

    // Ajustando o timezone do banco de dados
    $timezone = car_get_session_attribute('timezone', CAR_TIMEZONE_DEFAULT);
    $sql = sprintf("SET time_zone = '%s'", $timezone);
    $mysqli->query($sql);

	if ($read_database == 'on') {
		// Procurando informações do cartão
		$sql = sprintf(" 
                        select card_id, card_key, card_front, card_back
                          from car_card
                         where card_key = '%s'
                           and user_id = %d",
                        $mysqli->real_escape_string(car_never_null($card_key)),
                        $user_id);

		$result = $mysqli->query($sql);

		while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
			$card_front = $row['card_front'];
			$card_back = $row['card_back'];
		}
	} else {
		$card_front = car_get_session_attribute('card_front', '');
		$card_back = car_get_session_attribute('card_back', '');
	}

    // Procurando outras informações do cartão
    $sql = sprintf(" 
                    select a.card_true, a.card_false, a.card_sequence, b.deck_key, a.card_last_study
                      from car_card a, car_deck b
                     where a.card_key = '%s'
                       and a.user_id = %d
                       and a.deck_id = b.deck_id",
                    $mysqli->real_escape_string(car_never_null($card_key)),
                    $user_id);

    $result = $mysqli->query($sql);

    while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
        $deck_key = $row['deck_key'];
        $card_true = $row['card_true'];
        $card_false = $row['card_false'];
        $card_sequence = $row['card_sequence'];
        $card_last_study = $row['card_last_study'];
    }
?>
<?php
    $header_title = car_t($t, 'Edit Flashcard') . ' - Play Flashcards';
    $header_description = '';
    $header_index_follow = 'noindex,nofollow';
    include_once CAR_ROOT_WEB . '/containers/header.inc';
?>
<script>
    $(document).ready(function() {
        $('#save_insert_btn').click(function(event) {
            event.preventDefault();
            $('#fwd').val('insert-card-action');
            $('#main_form').attr('action', '<?= CAR_PATH_WEB; ?>/dash/card-edit-act');
            $('#main_form').submit();
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
        <div class="title">
            <?= car_t($t, 'Edit Flashcard'); ?>
        </div>
        <?php if ($_found) { ?>
            <div>
                <form id="main_form" method="post" action="<?= CAR_PATH_WEB; ?>/dash/card-edit-act">
                    <input type="hidden" name="k" value="<?= $card_key; ?>" />
                    <input type="hidden" id="fwd" name="fwd" value="view" />
                    <input type="hidden" name="card_true" value="<?= $card_true; ?>" />
                    <input type="hidden" name="card_false" value="<?= $card_false; ?>" />
                    <input type="hidden" name="card_sequence" value="<?= $card_sequence; ?>" />
                    <?= car_t($t, 'Front'); ?>:<br/>
                    <input type="text" name="card_front" value="<?= car_htmlspecialchars($card_front); ?>" maxlength="1024" placeholder="Front" class="input w100p" /><br/>
                    <?= car_t($t, 'Back'); ?>:<br/>
                    <input type="text" name="card_back" value="<?= car_htmlspecialchars($card_back); ?>" maxlength="1024" placeholder="Back" class="input w100p" /><br/>
                    <div class="space"></div>
                    <div class="tip">
                        <input type="checkbox" name="delete_stats" value="true"><?= car_t($t, 'dash.card-edit.reset'); ?>
                    </div>
                    <div class="space"></div>
                    <input type="submit" id="save_finish_btn" value="<?= car_t($t, 'Save Flashcard'); ?>" class="buttonx" />
                    <input type="button" id="save_insert_btn" value="<?= car_t($t, 'Save and Add New Flashcard'); ?>" class="buttonx" />
                    <a href="<?= CAR_PATH_WEB . '/dash/card-list?k=' . $deck_key; ?>" class="buttonx silver"><?= car_t($t, 'To Back'); ?></a>
                    <div class="title">
                        <?= car_t($t, 'Stats'); ?>
                    </div>
                    <div class="stats-title"><?= car_t($t, 'Accuracy Rate'); ?>:</div>
                    <div class="stats-value"><?= car_percent($card_true, $card_true + $card_false) ; ?>%</div>
                    <div class="stats-title"><?= car_t($t, 'Correctly Answered'); ?>:</div>
                    <div class="stats-value"><?= car_htmlspecialchars($card_true); ?></div>
                    <div class="stats-title"><?= car_t($t, 'Correct Answers in Sequence'); ?>:</div>
                    <div class="stats-value"><?= car_htmlspecialchars($card_sequence); ?></div>
                    <div class="stats-title"><?= car_t($t, 'Incorrectly Answered'); ?>:</div>
                    <div class="stats-value"><?= car_htmlspecialchars($card_false); ?></div>
                    <div class="stats-title"><?= car_t($t, 'Last Study'); ?>:</div>
                    <div class="stats-value"><?= car_htmlspecialchars($card_last_study); ?></div>
                    <div class="space"></div>
                    <div class="stats-title"><?= car_t($t, 'Delete Flashcard'); ?>:</div>
                    <div class="stats-value">
                        <table class="tip-table">
                            <tr>
                                <td class="td1">
                                    <a href="<?= CAR_PATH_WEB; ?>/dash/card-delete-act?k=<?= $card_key; ?>" class="buttonx w75">
                                        <?= car_t($t, 'Delete'); ?>
                                    </a>
                                </td>
                                <td class="td2">
                                    <div class="tip">
                                        <?= car_t($t, 'dash.card-edit.delete'); ?><br/>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </div>
                </form>
            </div>
        <?php } ?>
    </div>
</div>
<div class="div-secondary">
    <?php include_once CAR_ROOT_WEB . '/home/secondary.inc'; ?>
</div>
<?php include_once CAR_ROOT_WEB . '/containers/footer.inc'; ?>
