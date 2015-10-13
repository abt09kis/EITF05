<?php
	session_start();
	include_once "../nonPublic/csrftoken.php";

	if(!function_exists("redirect")){
		function redirect($url){
			$h = "Location: " . $url;
			header($h);
			die();
		}
	}
	if(checkCSRF()){
		$logout = $_POST['Logout'];
		//will log the user out, clear all session variables and unset coookies in addition to terminating the session.
		if(!is_null($logout)){
			$_SESSION = array();
			if(ini_get('session.use_cookies')){
				$params = session_get_cookie_params();
				setcookie(session_name(), ' ', time() - 42000, $params['path'], $params['domain'],$params['secure'], $params['httponly']);
			}
		}
		session_destroy();
		redirect("https://127.0.0.1/");
	}
?>
