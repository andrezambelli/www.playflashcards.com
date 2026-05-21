<?php /** @var array $t */ ?>
<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/car-server.php';?>
<?php include_once CAR_ROOT_WEB . '/config.inc';?>
<?php include CAR_ROOT_WEB . '/lang/lang.inc'; ?>
<?php car_check_language($t['lang']); ?>
<?php
	$header_title = 'Play Flashcards - Expand your Knowledge';
    $header_canonical = car_get_base_url(CAR_PATH_WEB) . '/'. $t['lang'] . '/';
    $header_description = car_t($t, 'main.desc');
    $header_index_follow = 'index,follow';
	include_once CAR_ROOT_WEB . '/containers/header.inc';
?>
<div class="div-primary">
	<div class="div-start">
		<div class="desc">
            <?= car_t($t, 'main.desc'); ?>
		</div>
        <div class="subdesc">
            <?= car_t($t, 'main.subdesc'); ?>
        </div>
	</div>
</div>
<div class="div-secondary">
    <?php include_once CAR_ROOT_WEB . '/containers/box-signin.inc'; ?>
    <?php include_once CAR_ROOT_WEB . '/containers/box-follow-decks.inc'; ?>
</div>
<?php include_once CAR_ROOT_WEB . '/containers/footer.inc';?>
