<?php /** @var array $t */ ?>
<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/car-server.php';?>
<?php include_once CAR_ROOT_WEB . '/config.inc';?>
<?php include CAR_ROOT_WEB . '/lang/lang.inc'; ?>
<?php car_check_login($t); ?>
<?php
	car_set_session_attribute('read_database', 'on');

	// Parâmetros
	$user_id = car_get_session_attribute('user_id', 0);

    $stud_key = car_get_parameter('k', '');

    // Variáveis
	$stse_order = 0;
	$card_front = '';
	$card_back = '';

    $deck_key = '';
    $deck_name = '';
    $deck_desc = '';
    $deck_color = '';
    $deck_bgcolor = '';

	$stud_id = '';
	$stud_begin = '';
	$stud_end = '';
	$stud_total = 0;
	$stud_true = 0;
	$stud_false = 0;

    $has_study = false;
    $has_card = false;

    // Ajustando o timezone do banco de dados
    $timezone = car_get_session_attribute('timezone', CAR_TIMEZONE_DEFAULT);
    $sql = sprintf("SET time_zone = '%s'", $timezone);
    $mysqli->query($sql);

	// Procurando o deck_key e informações do estudo
	$sql = sprintf(" 
                    select b.deck_key, b.deck_name, b.deck_desc, b.deck_color, b.deck_bgcolor, a.stud_id, a.stud_begin, a.stud_end, a.stud_total, a.stud_true, a.stud_false
                      from car_study a, car_deck b
                     where a.stud_key = '%s'
                       and a.user_id = %d
                       and a.deck_id = b.deck_id",
                    $mysqli->real_escape_string(car_never_null($stud_key)),
                    $user_id);
	
	$result = $mysqli->query($sql);
	
	while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
        $deck_key = $row['deck_key'];
        $deck_name = $row['deck_name'];
        $deck_desc = $row['deck_desc'];
        $deck_color = $row['deck_color'];
        $deck_bgcolor = $row['deck_bgcolor'];

		$stud_id = $row['stud_id'];
		$stud_begin = $row['stud_begin'];
		$stud_end = $row['stud_end'];
		$stud_total = $row['stud_total'];
		$stud_true = $row['stud_true'];
		$stud_false = $row['stud_false'];

        $has_study = true;
	}
	
	if ($has_study and empty($stud_end)) { // O estudo ainda não está finalizado
		// Procurando o primeiro cartão pendente de resposta desta sessão de estudo
		$sql = sprintf(" 
                        select b.stse_order, c.card_front, c.card_back
                          from car_study a, car_study_session b, car_card c
                         where a.stud_key = '%s'
                           and a.user_id = %d
                           and a.stud_id = b.stud_id
                           and b.card_id = c.card_id
                           and b.stse_answer is null
                         order by b.stse_order
                        limit 1",
                        $mysqli->real_escape_string(car_never_null($stud_key)),
                        $user_id);
		
		$result = $mysqli->query($sql);
		
		while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
			$stse_order = $row['stse_order'];
			$card_front = $row['card_front'];
			$card_back = $row['card_back'];

			$has_card = true;
		}
	}
	
	if ($has_study and !$has_card and empty($stud_end)) {
        // Não tem novo flashcard para responder e o estudo  ainda não tem data de fim
		// Atualiza a data de fim do estudo
        $sql = sprintf(" update car_study 
                            set stud_end = now()
                          where stud_id = %d
                            and user_id = %d",
                        $stud_id,
                        $user_id);
		
		$result = $mysqli->query($sql);
	
		// Apaga a tabela de sessões desse estudo
		$sql = sprintf('delete from car_study_session where stud_id = %d and user_id = %d', $stud_id, $user_id);
		
		$result = $mysqli->query($sql);
		
		$mysqli->commit();
		
		// Procurando a data final do estudo
		$sql = sprintf('select stud_end
                          from car_study
                         where stud_id = %d
                           and user_id = %d',
                        $stud_id,
                        $user_id);
		
		$result = $mysqli->query($sql);
		
		while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
			$stud_end = $row['stud_end'];
		}
	}
?>
<?php
    $header_title = car_t($t, 'Study') . ' - Play Flashcards';
    $header_description = '';
    $header_index_follow = 'noindex,nofollow';
    include_once CAR_ROOT_WEB . '/containers/header.inc';
?>
<script>
    $(document).ready(function() {
        // Tamanho da fonte de acrodo com a quantidade de caracteres
        var flipCardBack = $("#flip_card_back");
        var textBack = flipCardBack.text().trim();
        var fontSizeBack = Math.min(16, 1000 / textBack.length);
        flipCardBack.css("font-size", fontSizeBack + "px");

        var flipCardFront = $("#flip_card_front");
        var textFront = flipCardFront.text().trim();
        var fontSizeFront = Math.min(18, 1000 / textFront.length);
        flipCardFront.css("font-size", fontSizeFront + "px");

        var front = true;

  		$('#flip_btn').click(function(event) {
			event.preventDefault();

            if (front) {
                $('#flip_div').text('<?= car_t($t, 'Back'); ?>');
                front = false;
            } else {
                $('#flip_div').text('<?= car_t($t, 'Front'); ?>');
                front = true;
            }

			$('.flip-card').toggleClass('flipped');
		});

		$('#flip_card').click(function(event) {
			$('#flip_btn').click();
		});

		$('#true_btn').click(function(event) {
			event.preventDefault();

			$('#stse_answer').val('true');
			$('#main_form').attr('action', '<?= CAR_PATH_WEB; ?>/dash/study-act');
			$('#main_form').submit();
		});

		$('#false_btn').click(function(event) {
			event.preventDefault();

			$('#stse_answer').val('false');
			$('#main_form').attr('action', '<?= CAR_PATH_WEB; ?>/dash/study-act');
			$('#main_form').submit();
		});
	});
</script>
<div class="div-primary">
    <div class="div-start">
        <?php include_once CAR_ROOT_WEB . '/containers/message.inc' ?>
        <?php if ($has_study) { ?>
            <?php if ($has_card) { ?>
                <div>
                    <form id="main_form" method="post">
                        <input type="hidden" name="k" value="<?= $stud_key; ?>" />
                        <input type="hidden" name="stse_order" value="<?= $stse_order; ?>" />
                        <input type="hidden" id="stse_answer" name="stse_answer" value="" />
                        <input type="hidden" id="flip_btn" value="<?= car_t($t, 'Flip'); ?>" />
                        <div id="flip_div">
                            <?= car_t($t, 'Front'); ?>
                        </div>
                        <div class="flip_leg">
                            <?= car_t($t, 'click on the card'); ?>
                        </div>
                        <div id="flip_card" class="flip-card">
                            <div class="flip-card-inner">
                                <div id="flip_card_front" class="flip-card-front" style="color: #<?= $deck_color; ?>; background-color: #<?= $deck_bgcolor; ?>;">
                                    <h1><?= car_htmlspecialchars($card_front); ?></h1>
                                </div>
                                <div id="flip_card_back" class="flip-card-back" style="color: #<?= $deck_color; ?>; background-color: #<?= $deck_bgcolor; ?>;">
                                    <h1><?= car_htmlspecialchars($card_back); ?>	</h1>
                                </div>
                            </div>
                        </div>
                        <div class="flip-button">
                            <div class="buttons">
                                <input type="button" id="true_btn" value="<?= car_t($t, 'True Btn'); ?>" class="buttonx green" />
                                <input type="button" id="false_btn" value="<?= car_t($t, 'False Btn'); ?>" class="buttonx" />
                            </div>
                        </div>
                    </form>
                </div>
                <div class="stats-title">
                    <?= car_t($t, 'Flashcard'); ?>
                </div>
                <div class="stats-value">
                    <?= car_htmlspecialchars($stse_order . '/' . $stud_total); ?>
                </div>
            <?php } ?>
            <div class="space"></div>
            <div class="title">
                <?= car_t($t, 'Deck'); ?>
            </div>
            <?php if ($has_card) { ?>
                <div class="stats-value">
                    <a href="<?= CAR_PATH_WEB; ?>/dash/deck?k=<?= $deck_key; ?>">
                        <?= car_htmlspecialchars($deck_name); ?>
                    </a>
                </div>
                <div class="stats-value">
                    <?= car_htmlspecialchars($deck_desc); ?>
                </div>
            <?php } else { ?>
                <?php include_once CAR_ROOT_WEB . '/dash/deck-info.inc'; ?>
            <?php } ?>
            <?php if (!$has_card) { ?>
                <div class="title"><?= car_t($t, 'Results'); ?></div>
                <div class="stats-title"><?= car_t($t, 'Accuracy Rate'); ?></div>
                <div class="stats-value"><?= car_percent($stud_true, $stud_total); ?>%</div>
                <div class="stats-title"><?= car_t($t, 'Correctly Answered'); ?>:</div>
                <div class="stats-value"><?= car_htmlspecialchars($stud_true . '/' . $stud_total); ?></div>
                <div class="stats-title"><?= car_t($t, 'Start Date'); ?>:</div>
                <div class="stats-value"><?= car_htmlspecialchars($stud_begin); ?></div>
                <div class="stats-title"><?= car_t($t, 'Study Time'); ?>:</div>
                <div class="stats-value"><?= car_diff_dates($stud_begin, $stud_end); ?></div>
                <div class="space"></div>
                <?php include_once CAR_ROOT_WEB . '/dash/new-study.inc'; ?>
            <?php } ?>
            <div class="space"></div>
            <div class="stats-title"><?= car_t($t, 'Delete Study'); ?>:</div>
            <div class="stats-value">
                <a href="<?= CAR_PATH_WEB; ?>/dash/study-delete-act?k=<?= $stud_key; ?>" class="buttonx w75">
                    <?= car_t($t, 'Delete'); ?>
                </a>
            </div>
        <?php } ?>
    </div>
</div>
<div class="div-secondary">
    <?php include_once CAR_ROOT_WEB . '/home/secondary.inc'; ?>
</div>
<?php include_once CAR_ROOT_WEB . '/containers/footer.inc'; ?>
