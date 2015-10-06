<?php
	session_start();
	include_once "testlogin.php";

	$logout = $_POST['Logout'];
	// logout() will log the user out, clear all session variables and unset coookies in addition to terminating the session.

		$_SESSION = array();
		if(ini_get('session.use_cookies')){
			$params = session_get_cookie_params();
			setcookie(session_name(), ' ', time() - 42000, $params['path'], $params['domain'],$params['secure'], $params['httponly']);
		}

	session_destroy();
	redirect("https://127.0.0.1/");
?>
