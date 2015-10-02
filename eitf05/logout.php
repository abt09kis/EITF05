<?php

		session_start();
		$logout = $_POST['Logout'];
		// logout() will log the user out, clear all session variables and unset coookies in addition to terminating the session.
			if(!is_null($logout)){
				$_SESSION = array();
				if(ini_get('session.use_cookies')){
					$params = session_get_cookie_params();
					setcookie(session_name(), ' ', time() - 42000, $params['path'], $params['domain'],$params['secure'], $params['httponly']);
					}
			}
		session_destroy();
		header("Location: http://localhost:8000/index.php");

?>
