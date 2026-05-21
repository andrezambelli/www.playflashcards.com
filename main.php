<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/car-server.php';?>
<?php include_once CAL_ROOT_WEB . '/config.inc';?>
<?php include CAL_ROOT_WEB . '/lang/lang.inc'; ?>
<?php cal_check_language($t['lang']); ?>
<?php
	$header_title = 'Play Flashcards - Expand your Knowledge';
    $header_canonical = cal_get_base_url(CAL_PATH_WEB) . '/'. $t['lang'] . '/';
    $header_description = cal_t($t, 'main.desc');
    $header_index_follow = 'index,follow';
	include_once CAL_ROOT_WEB . '/include/header.inc';
?>
<div class="div-primary">
	<div class="div-start">
		<div class="desc">
            <?= cal_t($t, 'main.desc'); ?>
		</div>
        <div class="subdesc">
            <?= cal_t($t, 'main.subdesc'); ?>
        </div>
	</div>
</div>
<div class="div-secondary">
    <?php include_once CAL_ROOT_WEB . '/include/box-signin.inc'; ?>
    <?php include_once CAL_ROOT_WEB . '/include/box-follow-decks.inc'; ?>
</div>
<?php include_once CAL_ROOT_WEB . '/include/footer.inc';?>
