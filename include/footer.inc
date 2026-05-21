<?php include CAL_ROOT_WEB . '/lang/lang.inc'; ?>
<?php if (!isset($_COOKIE['consent_key'])) { // Se não existir cookie, faz a pergunta?>
    <div class="div-cookie-consent">
        <div class="div-cookie-container">
            <div>
                <?= cal_t($t, 'include.footer.cookie-warning'); ?>
            </div>
            <div class="div-cookie-buttons">
                <input type="button" onclick="setCookieGDPR('<?= CAL_PATH_WEB . '/general/set-cookie-act'; ?>')" value="Accept" class="buttonx green" />
            </div>
        </div>
    </div>
<?php } ?>
<footer>
    <div class="full">
		<a href="<?= CAL_PATH_WEB . '/'. $t['lang'] . '/contact-us'; ?>"><?= cal_t($t, 'Contact us'); ?></a>
		<a href="<?= CAL_PATH_WEB . '/'. $t['lang'] . '/terms-and-conditions'; ?>"><?= cal_t($t, 'Terms and Conditions'); ?></a>
		<a href="<?= CAL_PATH_WEB . '/'. $t['lang'] . '/privacy-policy'; ?>"><?= cal_t($t, 'Privacy Policy'); ?></a>
    </div>
    <div class="full">
        <a href="<?= CAL_PATH_WEB .'/general/change-language-act?lang=en'; ?>" <?php if ($t['lang'] == 'en') { ?>style="font-weight: bold;"<?php } ?>><?= cal_t($t, 'English'); ?></a>
        <a href="<?= CAL_PATH_WEB .'/general/change-language-act?lang=es'; ?>" <?php if ($t['lang'] == 'es') { ?>style="font-weight: bold;"<?php } ?>><?= cal_t($t, 'Spanish'); ?></a>
        <a href="<?= CAL_PATH_WEB .'/general/change-language-act?lang=pt-br'; ?>" <?php if ($t['lang'] == 'pt-br') { ?>style="font-weight: bold;"<?php } ?>><?= cal_t($t, 'Portuguese'); ?></a>
        <a href="<?= CAL_PATH_WEB .'/general/change-language-act?lang=fr'; ?>" <?php if ($t['lang'] == 'fr') { ?>style="font-weight: bold;"<?php } ?>><?= cal_t($t, 'France'); ?></a>
	</div>
    <div class="social">
        <a href="https://x.com/playflashcards" target="_blank" title="Play Flashcards X">
            <img src="<?= CAL_PATH_WEB . '/content/img/x.png' ?>" alt="Play Flashcards X" width="25px" height="25px" />
        </a>
        <a href="https://www.threads.net/@play_flashcards" target="_blank" title="Play Flashcards Threads">
            <img src="<?= CAL_PATH_WEB . '/content/img/threads.png' ?>" alt="Play Flashcards Threads" width="25px" height="25px" />
        </a>
    </div>
	<div class="sign">
		<a href="<?= CAL_PATH_WEB .  '/'. $t['lang'] . '/'; ?>/">
			Play Flashcards - <?= CAL_VERSION; ?>
		</a>
	</div>
</footer>
</div> <!-- id="div-content" -->
<script>
    $(document).ready(function() {
        $('form input[type="text"]:first').focus().select();
    });
</script>
</body>
</html>
<?php include_once CAL_ROOT_WEB . '/include/set-user-last-access-act.inc';?>
