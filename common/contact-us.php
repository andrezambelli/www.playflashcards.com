<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/car-server.php';?>
<?php include_once CAL_ROOT_WEB . '/config.inc';?>
<?php include CAL_ROOT_WEB . '/lang/lang.inc'; ?>
<?php cal_check_language($t['lang']); ?>
<?php
    $header_title = cal_t($t, 'common.contact-us.title') . ' - Play Flashcards';
    $header_description = cal_t($t, 'common.contact-us.desc');
    $header_index_follow = 'index,follow';
    include_once CAL_ROOT_WEB . '/include/header.inc';
?>
<div class="div-primary">
    <div class="div-start">
        <h1><?= cal_t($t, 'common.contact-us.title'); ?></h1>
        <?php include_once CAL_ROOT_WEB . '/include/message.inc' ?>
        <form id="main_form" action="<?= CAL_PATH_WEB .'/contact-us-act'; ?>" method="post">
            <?= cal_t($t, 'common.contact-us.message1'); ?><br/>
            <?= cal_t($t, 'common.contact-us.message2'); ?><br/>
            <input type="text" id="form_content" name="form_content" value="" maxlength="256" class="input w90p" /><br/>
            <input type="submit" value="<?= cal_t($t, 'Send'); ?>" class="buttonx" />
        </form>
        <br/>
        <?= cal_t($t, 'common.contact-us.message3'); ?>
        <div class="social">
            <a href="https://x.com/playflashcards" target="_blank" title="Play Flashcards X">
                <img src="<?= CAL_PATH_WEB . '/content/img/x.png' ?>" alt="Play Flashcards X" width="25px" height="25px" />
            </a>
            <a href="https://www.threads.net/@play_flashcards" target="_blank" title="Play Flashcards Threads">
                <img src="<?= CAL_PATH_WEB . '/content/img/threads.png' ?>" alt="Play Flashcards Threads" width="25px" height="25px" />
            </a>
        </div>
    </div>
</div>
<div class="div-secondary">
    <!-- -->
</div>˙
<?php include_once CAL_ROOT_WEB . '/include/footer.inc';?>
