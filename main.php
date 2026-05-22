<?php /** @var array $t */ ?>
<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/car-server.php';?>
<?php include_once CAR_ROOT_WEB . '/config.inc';?>
<?php include CAR_ROOT_WEB . '/lang/lang.inc'; ?>
<?php car_check_language($t['lang']); ?>
<?php
    $header_title = 'Play Flashcards';
    $header_canonical = car_get_base_url(CAR_PATH_WEB) . '/' . $t['lang'] . '/';
    $header_description = car_t($t, 'main.desc');
    $header_index_follow = 'index,follow';
    include_once CAR_ROOT_WEB . '/containers/header.inc';
?>

<main>
    <?php include CAR_ROOT_WEB . '/home/hero.inc'; ?>
    <?php include CAR_ROOT_WEB . '/home/card-preview.inc'; ?>
    <?php include CAR_ROOT_WEB . '/home/build-for-focus.inc'; ?>
    <?php include CAR_ROOT_WEB . '/home/try-a-sample.inc'; ?>
</main>

<?php include_once CAR_ROOT_WEB . '/containers/footer.inc';?>
