<?php if (car_has_session_error_message()) { ?>
<div class="alert alert-danger" role="alert">
    <?= car_htmlspecialchars(car_get_session_error_message()); ?>
</div>
<?= car_set_session_error_message(''); ?>
<?php } ?>
<?php if (car_has_session_alert_message()) { ?>
<div class="alert alert-warning" role="alert">
    <?= car_htmlspecialchars(car_get_session_alert_message()); ?>
</div>
<?= car_set_session_alert_message(''); ?>
<?php } ?>
