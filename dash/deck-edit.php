<?php /** @var array $t */ ?>
<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/car-server.php'; ?>
<?php include_once CAR_ROOT_WEB . '/config.inc'; ?>
<?php include CAR_ROOT_WEB . '/lang/lang.inc'; ?>
<?php car_check_login($t); ?>
<?php
	// Parâmetros 
	$user_id = car_get_session_attribute('user_id', 0);
    $read_database = car_get_session_attribute('read_database', 'on');

    $deck_key = car_get_parameter('k', '');

    // Variáveis
	$deck_name = '';
	$deck_desc = '';
    $deck_bgcolor = '';
    $deck_public = '0';
	$deck_update = '';
	$deck_create = '';
	
	if ($read_database == 'on') {
        // Procurando informações do grupo
		$sql = sprintf(" 
                        select deck_id, deck_key, deck_name, deck_desc, deck_bgcolor, deck_public
                          from car_deck
                         where deck_key = '%s'
                           and user_id = %d",
                        $mysqli->real_escape_string(car_never_null($deck_key)),
                        $user_id);

		$result = $mysqli->query($sql);

		while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
			$deck_name = $row['deck_name'];
			$deck_desc = $row['deck_desc'];
            $deck_bgcolor = $row['deck_bgcolor'];
            $deck_public = $row['deck_public'];
		}
	} else {
        $deck_name = car_get_session_attribute('deck_name', '');
        $deck_desc = car_get_session_attribute('deck_desc', '');
        $deck_bgcolor = car_get_session_attribute('deck_bgcolor', '');
        $deck_public = car_get_session_attribute('deck_public', '0');
	}

    if ($deck_name == CAR_DECK_NAME_DEFAULT) $deck_name = '';
?>
<?php
    $header_title = car_t($t, 'Edit Deck') . ' - Play Flashcards';
    $dash_active = 'decks';
    $dash_breadcrumb = [[car_t($t, 'Decks'), CAR_PATH_WEB . '/dash/deck-list'], [car_t($t, 'Edit Deck')]];
    include_once CAR_ROOT_WEB . '/dash/containers/header.inc';
?>
<div class="div-primary">
    <div class="div-start">
        <?php include_once CAR_ROOT_WEB . '/containers/message.inc' ?>
        <div class="title">
            <?= car_t($t, 'Edit Deck'); ?>
        </div>
        <?php include_once CAR_ROOT_WEB . '/dash/deck-info.inc'; ?>
        <?php if ($_found) { ?>
            <div>
                <form id="main_form" action="<?= CAR_PATH_WEB; ?>/dash/deck-edit-act" method="post">
                    <input type="hidden" name="k" value="<?= $deck_key; ?>" />
                    <input type="hidden" name="deck_bgcolor" value="<?= car_htmlspecialchars($deck_bgcolor); ?>" />
                    <?= car_t($t, 'Name'); ?>:<br/>
                    <input type="text" name="deck_name" value="<?= car_htmlspecialchars($deck_name); ?>" maxlength="255" placeholder="<?= car_t($t, 'Deck Name'); ?>" class="input w100p" />
                    <div class="space"></div>
                    <?= car_t($t, 'Description'); ?>:<br/>
                    <input type="text" name="deck_desc" value="<?= car_htmlspecialchars($deck_desc); ?>" maxlength="1024" placeholder="<?= car_t($t, 'Deck Description'); ?>" class="input w100p" />
                    <div class="space"></div>
                    <div class="stats-title"><?= car_t($t, 'Public Access Settings'); ?>:</div>
                    <div class="stats-value">
                        <input type="checkbox" name="deck_public" value="1" <?php if ($deck_public) { ?>checked<?php } ?>><?= car_t($t, 'dash.deck-edit.public'); ?><br/>
                    </div>
                    <div class="space"></div>
                    <div class="tip">
                        <?= car_t($t, 'dash.deck-edit.message1'); ?>
                    </div>
                    <div class="space"></div>
                    <div class="tip">
                        <span class="note-text"><?= car_t($t, 'Note'); ?>:</span>
                        <?= car_t($t, 'dash.deck-edit.message2'); ?>
                    </div>
                    <div class="space"></div>
                    <input type="submit" value="<?= car_t($t, 'Save Deck'); ?>" class="buttonx" />
                    <a href="<?= CAR_PATH_WEB . '/dash/deck?k=' . $deck_key; ?>" class="buttonx silver"><?= car_t($t, 'To Back'); ?></a>
                </form>
            </div>
        <?php } ?>
    </div>
</div>
<div class="div-secondary">
    <?php include_once CAR_ROOT_WEB . '/home/secondary.inc'; ?>
</div>
<?php include_once CAR_ROOT_WEB . '/dash/containers/footer.inc'; ?>
