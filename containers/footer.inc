<?php /** @var array $t */ ?>
<?php include CAR_ROOT_WEB . '/lang/lang.inc'; ?>
<?php if (!isset($_COOKIE['consent_key'])) { // Se não existir cookie, faz a pergunta?>
    <div class="div-cookie-consent">
        <div class="div-cookie-container">
            <div>
                <?= car_t($t, 'include.footer.cookie-warning'); ?>
            </div>
            <div class="div-cookie-buttons">
                <input type="button" onclick="setCookieGDPR('<?= CAR_PATH_WEB . '/services/set-cookie-act'; ?>')" value="Accept" class="buttonx green" />
            </div>
        </div>
    </div>
<?php } ?>
<footer>
    <div class="full">
		<a href="<?= CAR_PATH_WEB . '/'. $t['lang'] . '/contact-us'; ?>"><?= car_t($t, 'Contact us'); ?></a>
		<a href="<?= CAR_PATH_WEB . '/'. $t['lang'] . '/terms-and-conditions'; ?>"><?= car_t($t, 'Terms and Conditions'); ?></a>
		<a href="<?= CAR_PATH_WEB . '/'. $t['lang'] . '/privacy-policy'; ?>"><?= car_t($t, 'Privacy Policy'); ?></a>
    </div>
    <div class="full">
        <a href="<?= CAR_PATH_WEB .'/services/change-language-act?lang=en'; ?>" <?php if ($t['lang'] == 'en') { ?>style="font-weight: bold;"<?php } ?>><?= car_t($t, 'English'); ?></a>
        <a href="<?= CAR_PATH_WEB .'/services/change-language-act?lang=es'; ?>" <?php if ($t['lang'] == 'es') { ?>style="font-weight: bold;"<?php } ?>><?= car_t($t, 'Spanish'); ?></a>
        <a href="<?= CAR_PATH_WEB .'/services/change-language-act?lang=pt-br'; ?>" <?php if ($t['lang'] == 'pt-br') { ?>style="font-weight: bold;"<?php } ?>><?= car_t($t, 'Portuguese'); ?></a>
        <a href="<?= CAR_PATH_WEB .'/services/change-language-act?lang=fr'; ?>" <?php if ($t['lang'] == 'fr') { ?>style="font-weight: bold;"<?php } ?>><?= car_t($t, 'France'); ?></a>
	</div>
    <div class="social">
        <a href="https://x.com/playflashcards" target="_blank" title="Play Flashcards X">
            <img src="<?= CAR_PATH_WEB . '/assets/img/x.png' ?>" alt="Play Flashcards X" width="25px" height="25px" />
        </a>
        <a href="https://www.threads.net/@play_flashcards" target="_blank" title="Play Flashcards Threads">
            <img src="<?= CAR_PATH_WEB . '/assets/img/threads.png' ?>" alt="Play Flashcards Threads" width="25px" height="25px" />
        </a>
    </div>
	<div class="sign">
		<a href="<?= CAR_PATH_WEB .  '/'. $t['lang'] . '/'; ?>/">
			Play Flashcards - <?= CAR_VERSION; ?>
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
<?php include_once CAR_ROOT_WEB . '/services/set-user-last-access-act.inc';?>
