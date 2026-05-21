<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/car-server.php';?>
<?php include_once CAL_ROOT_ADMIN . '/config.inc' ?>
<?php include_once CAL_ROOT_ADMIN . '/include/header.inc' ?>
<?php 
	$redirect_url = '';
	
	if (isset($_GET['redirect_url'])) $redirect_url = trim($_GET['redirect_url']);
?>
<div class="master">
	<?php include_once "../include/message.inc" ?> 
	<div class="form">
		<form action="login-act.php" method="post">
			<input type="hidden" name="redirect_url" value="<?= cal_htmlspecialchars($redirect_url); ?>" />
			<table>
				<tr>
					<td class="label" style="width:20%">
						Password
					</td>
					<td style="width:80%">
						<input type="password" name="password" id="password" value="" maxlength="100" />
					</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td><input type="submit" class="button" value="Login"/></td>
				</tr>
			</table>
		</form>
	</div> 
</div>
<script>
	$(document).ready(function () {
		$('#password').focus(); 
	});
</script>
<?php include_once CAL_ROOT_ADMIN . "/include/footer.inc" ?>
