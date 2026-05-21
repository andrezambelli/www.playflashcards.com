<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/car-server.php';?>
<?php include_once CAL_ROOT_WEB . '/config.inc';?>
<?php include CAL_ROOT_WEB . '/lang/lang.inc'; ?>
<?php
	$header_title = cal_t($t, 'common.contact-us.title') . ' - ' . cal_t($t, 'Thanks') .  ' - Play Flashcards';
	$header_description = '';
    $header_index_follow = 'noindex,nofollow';
	include_once CAL_ROOT_WEB . "/include/header.inc"; 
?>
<div class="div-primary">
    <div class="div-start">
        <h1><?= cal_t($t, 'common.contact-us.title') . ' - ' . cal_t($t, 'Thanks'); ?></h1>
        <?= cal_t($t, 'common.contact-us-thanks.message1'); ?><br/>
        <br/>
        <?= cal_t($t, 'common.contact-us-thanks.message2'); ?><br/>
        <div class="social">
            <a href="https://x.com/playflashcards" target="_blank" title="Play Flashcards X">
                <img src="<?= CAL_PATH_WEB . '/assets/img/x.png' ?>" alt="Play Flashcards X" width="25px" height="25px" />
            </a>
            <a href="https://www.threads.net/@play_flashcards" target="_blank" title="Play Flashcards Threads">
                <img src="<?= CAL_PATH_WEB . '/assets/img/threads.png' ?>" alt="Play Flashcards Threads" width="25px" height="25px" />
            </a>
        </div>
    </div>
</div>
<div class="div-secondary">
    <!-- -->
</div>
<?php include_once CAL_ROOT_WEB . '/containers/footer.inc';?>

