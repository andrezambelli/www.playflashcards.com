<?php /** @var array $t */ ?>
<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/car-server.php';?>
<?php include_once CAR_ROOT_WEB . '/config.inc';?>
<?php include CAR_ROOT_WEB . '/lang/lang.inc'; ?>
<?php car_check_language($t['lang']); ?>
<?php
    http_response_code(403);
    $header_title = car_t($t, 'common.403.title') . ' - Play Flashcards' ;
    $header_description = car_t($t, 'common.404.desc');
    $header_index_follow = 'noindex,nofollow';
    include_once CAR_ROOT_WEB . '/containers/header.inc';
?>
<div class="div-primary">
    <div class="div-start">
        <div style="font-weight: bold; font-size: 28px;">
            Oops!
        </div>
        <div>
            <?= car_t($t, 'common.403.title'); ?>
        </div>
    </div>
</div>
<div class="div-secondary">
    <!-- -->
</div>˙
<?php include_once CAR_ROOT_WEB . '/containers/footer.inc';?>
