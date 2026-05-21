<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/car-server.php'; ?>
<?php include_once CAL_ROOT_WEB . '/config.inc'; ?>
<?php include CAL_ROOT_WEB . '/lang/lang.inc'; ?>
<?php cal_check_login($t); ?>
<?php
	// Parâmetros 
	$user_id = cal_get_session_attribute('user_id', 0);
    $read_database = cal_get_session_attribute('read_database', 'on');

    $deck_key = cal_get_parameter('k', 0);

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
                        $mysqli->real_escape_string(cal_never_null($deck_key)),
                        $user_id);

		$result = $mysqli->query($sql);

		while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
			$deck_name = $row['deck_name'];
			$deck_desc = $row['deck_desc'];
            $deck_bgcolor = $row['deck_bgcolor'];
            $deck_public = $row['deck_public'];
		}
	} else {
        $deck_name = cal_get_session_attribute('deck_name', '');
        $deck_desc = cal_get_session_attribute('deck_desc', '');
        $deck_bgcolor = cal_get_session_attribute('deck_bgcolor', '');
        $deck_public = cal_get_session_attribute('deck_public', '0');
	}

    if ($deck_name == CAL_DECK_NAME_DEFAULT) $deck_name = '';
?>
<?php
    $header_title = cal_t($t, 'Edit Deck') . ' - Play Flashcards';
    $header_description = '';
    $header_index_follow = 'noindex,nofollow';
    include_once CAL_ROOT_WEB . '/include/header.inc';
?>
<div class="div-primary">
    <div class="div-start">
        <?php include_once CAL_ROOT_WEB . '/include/message.inc' ?>
        <div class="title">
            <?= cal_t($t, 'Edit Deck'); ?>
        </div>
        <?php include_once CAL_ROOT_WEB . '/dash/deck-info.inc'; ?>
        <?php if ($_found) { ?>
            <div>
                <form id="main_form" action="<?= CAL_PATH_WEB; ?>/dash/deck-edit-act" method="post">
                    <input type="hidden" name="k" value="<?= $deck_key; ?>" />
                    <input type="hidden" name="deck_bgcolor" value="<?= cal_htmlspecialchars($deck_bgcolor); ?>" />
                    <?= cal_t($t, 'Name'); ?>:<br/>
                    <input type="text" name="deck_name" value="<?= cal_htmlspecialchars($deck_name); ?>" maxlength="255" placeholder="<?= cal_t($t, 'Deck Name'); ?>" class="input w100p" />
                    <div class="space"></div>
                    <?= cal_t($t, 'Description'); ?>:<br/>
                    <input type="text" name="deck_desc" value="<?= cal_htmlspecialchars($deck_desc); ?>" maxlength="1024" placeholder="<?= cal_t($t, 'Deck Description'); ?>" class="input w100p" />
                    <div class="space"></div>
                    <div class="stats-title"><?= cal_t($t, 'Public Access Settings'); ?>:</div>
                    <div class="stats-value">
                        <input type="checkbox" name="deck_public" value="1" <?php if ($deck_public) { ?>checked<?php } ?>><?= cal_t($t, 'dash.deck-edit.public'); ?><br/>
                    </div>
                    <div class="space"></div>
                    <div class="tip">
                        <?= cal_t($t, 'dash.deck-edit.message1'); ?>
                    </div>
                    <div class="space"></div>
                    <div class="tip">
                        <span class="note-text"><?= cal_t($t, 'Note'); ?>:</span>
                        <?= cal_t($t, 'dash.deck-edit.message2'); ?>
                    </div>
                    <div class="space"></div>
                    <input type="submit" value="<?= cal_t($t, 'Save Deck'); ?>" class="buttonx" />
                    <a href="<?= CAL_PATH_WEB . '/dash/deck?k=' . $deck_key; ?>" class="buttonx silver"><?= cal_t($t, 'To Back'); ?></a>
                </form>
            </div>
        <?php } ?>
    </div>
</div>
<div class="div-secondary">
    <?php include_once CAL_ROOT_WEB . '/home/secondary.inc'; ?>
</div>
<?php include_once CAL_ROOT_WEB . '/include/footer.inc'; ?>
