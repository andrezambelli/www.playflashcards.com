<?php
    cal_check_admin_login();
	$_login = cal_get_session_attribute('session_admin_login', 'off');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pt-br" dir="ltr">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta http-equiv="Content-Language" content="pt-br" />
	<meta name="Robots" content="noindex, nofollow" />
	<meta name="Googlebot" content="noindex, nofollow, noarchive " />
	<meta name="google-site-verification" content="" />
	<meta name="Distribution" content="global" />
	<meta name="Author" content="Aluzax" />
	<meta name="Copyright" content="(c) 2023 Play Flashcards" />
	<meta name="Keywords" content="" />
	<meta name="Description" content="" />
	
	<link rel="shortcut icon" href="../assets/img/favicon.png" type="image/x-icon" />
	<link type="text/css" rel="stylesheet" href="<?= CAL_PATH_ADMIN . "/assets/css/styles.css" ?>"  media="all" />
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
	<title>
		Play Flashcards Admin - <?= CAL_ADMIN_VERSION; ?>
	</title>
</head>
<body>
	<div class="header">
		<div class="title">
			<div style="padding:10px;">
				Administrador do Play Flashcards<br/>
				Versão <?= CAL_ADMIN_VERSION; ?>
				[<?= $_login; ?>]
			</div>
		</div>
	</div>
	<?php if (!empty($_login) and $_login != 'off') { ?>
		<?php include_once "menu-on.inc" ?>
	<?php } else { ?>
		<?php include_once "menu-off.inc" ?>
	<?php } ?>

<?php if (1 == 2) { ?></body></html><?php } ?>