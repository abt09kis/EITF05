<?php
	$token = $_POST['token'];
	if($token != $_COOKIE['session_id']){
		if(!function_exists("redirect")){
			function redirect($url){
				$h = "Location: " . $url;
				header($h);
				die();
			}
		}

		$_SESSION = array();
		if(ini_get('session.use_cookies')){
			$params = session_get_cookie_params();
			setcookie(session_name(), ' ', time() - 42000, $params['path'], $params['domain'],$params['secure'], $params['httponly']);
		}
		session_destroy();
		redirect("https://127.0.0.1/");
	}
?>
