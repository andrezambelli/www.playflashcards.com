<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/car-server.php';?>
<?php include_once CAL_ROOT_WEB . '/config.inc';?>
<?php include CAL_ROOT_WEB . '/lang/lang.inc'; ?>
<?php
    http_response_code(404);
    $header_title = cal_t($t, 'common.404.title') . ' - Play Flashcards';
    $header_description = cal_t($t, 'common.404.desc');
    $header_index_follow = 'noindex,nofollow';
    include_once CAL_ROOT_WEB . '/include/header.inc';
?>
<div class="div-primary">
    <div class="div-start">
        <div style="font-weight: bold; font-size: 28px;">
            Oops!
        </div>
        <div>
            <?= cal_t($t, 'common.404.title'); ?>
        </div>
    </div>
</div>
<div class="div-secondary">
    <!-- -->
</div>˙
<?php include_once CAL_ROOT_WEB . '/include/footer.inc';?>
