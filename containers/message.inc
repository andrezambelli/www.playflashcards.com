<?php if (car_has_session_error_message()) { ?>
	<div class="car-message-error">
        <?= car_t($t, car_get_session_error_message()); ?>
	</div>
	<?php car_set_session_error_message(''); ?>
<?php } ?>
<?php if (car_has_session_alert_message()) { ?>
	<div class="car-message-success">
        <?= car_t($t, car_get_session_alert_message()); ?>
	</div>
	<?php car_set_session_alert_message(''); ?>
<?php } ?>

