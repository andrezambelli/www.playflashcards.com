<?php /** @var array $t */ ?>
<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/car-server.php';?>
<?php include_once CAR_ROOT_WEB . '/config.inc';?>
<?php include CAR_ROOT_WEB . '/lang/lang.inc'; ?>
<?php car_check_language($t['lang']); ?>
<?php
    $header_title = car_t($t, 'common.contact-us.title') . ' - Play Flashcards';
    $header_description = car_t($t, 'common.contact-us.desc');
    $header_index_follow = 'index,follow';
    include_once CAR_ROOT_WEB . '/containers/header.inc';
?>
<div class="div-primary">
    <div class="div-start">
        <h1><?= car_t($t, 'common.contact-us.title'); ?></h1>
        <?php include_once CAR_ROOT_WEB . '/containers/message.inc' ?>
        <form id="main_form" action="<?= CAR_PATH_WEB .'/contact-us-act'; ?>" method="post">
            <?= car_t($t, 'common.contact-us.message1'); ?><br/>
            <?= car_t($t, 'common.contact-us.message2'); ?><br/>
            <input type="text" id="form_content" name="form_content" value="" maxlength="256" class="input w90p" /><br/>
            <input type="submit" value="<?= car_t($t, 'Send'); ?>" class="buttonx" />
        </form>
        <br/>
        <?= car_t($t, 'common.contact-us.message3'); ?>
        <div class="social">
            <a href="https://x.com/playflashcards" target="_blank" title="Play Flashcards X">
                <img src="<?= CAR_PATH_WEB . '/assets/img/x.png' ?>" alt="Play Flashcards X" width="25px" height="25px" />
            </a>
            <a href="https://www.threads.net/@play_flashcards" target="_blank" title="Play Flashcards Threads">
                <img src="<?= CAR_PATH_WEB . '/assets/img/threads.png' ?>" alt="Play Flashcards Threads" width="25px" height="25px" />
            </a>
        </div>
    </div>
</div>
<div class="div-secondary">
    <!-- -->
</div>˙
<?php include_once CAR_ROOT_WEB . '/containers/footer.inc';?>
