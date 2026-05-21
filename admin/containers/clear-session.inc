<?php
	$_login = car_get_session_attribute('session_admin_login', 'off');
	
	if (empty($_login)) {
		$_SESSION = array();
		
		// Finally, destroy the session.
		session_destroy();
	}
?>