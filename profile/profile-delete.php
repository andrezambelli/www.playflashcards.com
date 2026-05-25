<?php /** @var array $t */ ?>
<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/car-server.php'; ?>
<?php include_once CAR_ROOT_WEB . '/config.inc'; ?>
<?php include CAR_ROOT_WEB . '/lang/lang.inc'; ?>
<?php car_check_login($t); ?>
<?php
	// Parâmetros 
	$user_id = car_get_session_attribute('user_id', 0);
	$read_database = car_get_session_attribute('read_database', 'on');
?>
<?php
    $header_title = car_t($t, 'Delete your Account') . ' - Play Flashcards';
    $dash_active = 'profile';
    $dash_breadcrumb = [[car_t($t, 'Profile'), CAR_PATH_WEB . '/profile/profile'], [car_t($t, 'Delete your Account')]];
    include_once CAR_ROOT_WEB . '/dash/containers/header.inc';
?>
<script>
	$(document).ready(function() {
		$('#yes_btn').click(function(event) {
			event.preventDefault();
			$('#main_form').attr('action', '<?= CAR_PATH_WEB; ?>/profile/profile-delete-act');
			$('#main_form').submit();
		});
	
		$('#no_btn').click(function(event) {
			event.preventDefault();
				$('#stse_answer').val('false');
				$('#main_form').attr('action', '<?= CAR_PATH_WEB; ?>/profile/profile');
				$('#main_form').submit();
		});
	});
</script>
<div class="div-primary">
    <div class="div-start">
        <?php include_once CAR_ROOT_WEB . '/containers/message.inc' ?>
        <div class="title">
            <?= car_t($t, 'Delete your Account'); ?>
        </div>
        <div class="form">
            <form id="main_form" method="post">
                <?= car_t($t, 'profile.profile-delete.question'); ?><br/>
                <span class="note-text"><?= car_t($t, 'Warning'); ?>:</span> <?= car_t($t, 'profile.profile-delete.warning'); ?><br/>
                <input type="button" id="yes_btn" value="<?= car_t($t, 'Yes'); ?>" class="buttonx" />
                <input type="button" id="no_btn" value="<?= car_t($t, 'No'); ?>" class="buttonx" />
            </form>
        </div>
    </div>
</div>
<div class="div-secondary">
    <?php include_once CAR_ROOT_WEB . '/home/secondary.inc'; ?>
</div>
<?php include_once CAR_ROOT_WEB . '/dash/containers/footer.inc'; ?>
