<?php if (car_has_session_error_message()) { ?>
	<div class="message">
		<div class="content">
			<div class="error">
				<?= car_htmlspecialchars(car_get_session_error_message()); ?>
			</div>
		</div>
	</div>
	<?= car_set_session_error_message(''); ?>
<?php } ?>
<?php if (car_has_session_alert_message()) { ?>
	<div class="message">
		<div class="content">
			<div class="alert">
				<?= car_htmlspecialchars(car_get_session_alert_message()); ?>
			</div>
		</div>
	</div>
	<?= car_set_session_alert_message(''); ?>
<?php } ?>

