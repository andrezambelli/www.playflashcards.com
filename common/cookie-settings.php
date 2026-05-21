<?php /** @var array $t */ ?>
<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/car-server.php';?>
<?php include_once CAR_ROOT_WEB . '/config.inc';?>
<?php include CAR_ROOT_WEB . '/lang/lang.inc'; ?>
<?php car_check_language($t['lang']); ?>
<?php
    $header_title = 'Play Flashcards - Cookie Settings';
    $header_description = 'Loren';
    $header_index_follow = 'index,follow';
    include_once CAR_ROOT_WEB . '/containers/header.inc';
?>
<div class="div-primary">
    Cookie Settings
</div>
<div class="div-secondary">
    Cookie Settings
</div>˙
<?php include_once CAR_ROOT_WEB . '/containers/footer.inc';?>
