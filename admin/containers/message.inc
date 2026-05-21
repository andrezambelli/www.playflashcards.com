<?php if (cal_has_session_error_message()) { ?>
	<div class="message">
		<div class="content">
			<div class="error">
				<?= cal_htmlspecialchars(cal_get_session_error_message()); ?>
			</div>
		</div>
	</div>
	<?= cal_set_session_error_message(''); ?>
<?php } ?>
<?php if (cal_has_session_alert_message()) { ?>
	<div class="message">
		<div class="content">
			<div class="alert">
				<?= cal_htmlspecialchars(cal_get_session_alert_message()); ?>
			</div>
		</div>
	</div>
	<?= cal_set_session_alert_message(''); ?>
<?php } ?>

