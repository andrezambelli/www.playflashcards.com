<?php if (cal_has_session_error_message()) { ?>
	<div class="div-message-error">
        <?= cal_t($t, cal_get_session_error_message()); ?>
	</div>
	<?php cal_set_session_error_message(''); ?>
<?php } ?>
<?php if (cal_has_session_alert_message()) { ?>
	<div class="div-message-success">
        <?= cal_t($t, cal_get_session_alert_message()); ?>
	</div>
	<?php cal_set_session_alert_message(''); ?>
<?php } ?>

