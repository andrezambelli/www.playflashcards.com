<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/car-server.php'; ?>
<?php include_once CAL_ROOT_WEB . '/config.inc'; ?>
<?php include CAL_ROOT_WEB . '/lang/lang.inc'; ?>
<?php cal_check_login($t); ?>
<?php
	// Parâmetros 
	$user_id = cal_get_session_attribute('user_id', 0);
	$read_database = cal_get_session_attribute('read_database', 'on');
?>
<?php
    $header_title = cal_t($t, 'Delete your Account') . ' - Play Flashcards';
    $header_description = '';
    $header_index_follow = 'noindex,nofollow';
    include_once CAL_ROOT_WEB . '/include/header.inc';
?>
<script>
	$(document).ready(function() {
		$('#yes_btn').click(function(event) {
			event.preventDefault();
			$('#main_form').attr('action', '<?= CAL_PATH_WEB; ?>/profile/profile-delete-act');
			$('#main_form').submit();
		});
	
		$('#no_btn').click(function(event) {
			event.preventDefault();
				$('#stse_answer').val('false');
				$('#main_form').attr('action', '<?= CAL_PATH_WEB; ?>/profile/profile');
				$('#main_form').submit();
		});
	});
</script>
<div class="div-primary">
    <div class="div-start">
        <?php include_once CAL_ROOT_WEB . '/include/message.inc' ?>
        <div class="title">
            <?= cal_t($t, 'Delete your Account'); ?>
        </div>
        <div class="form">
            <form id="main_form" method="post">
                <?= cal_t($t, 'profile.profile-delete.question'); ?><br/>
                <span class="note-text"><?= cal_t($t, 'Warning'); ?>:</span> <?= cal_t($t, 'profile.profile-delete.warning'); ?><br/>
                <input type="button" id="yes_btn" value="<?= cal_t($t, 'Yes'); ?>" class="buttonx" />
                <input type="button" id="no_btn" value="<?= cal_t($t, 'No'); ?>" class="buttonx" />
            </form>
        </div>
    </div>
</div>
<div class="div-secondary">
    <?php include_once CAL_ROOT_WEB . '/home/secondary.inc'; ?>
</div>
<?php include_once CAL_ROOT_WEB . '/include/footer.inc'; ?>
