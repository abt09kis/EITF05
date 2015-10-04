<?php
	function redirect($url){
		$h = "Location: " . $url;
		header($h);
		die();
	}

	function redirectIfNotLoggedIn($url){
		if(!empty($_SESSION['isLoggedIn'])) {
			if(!$_SESSION['isLoggedIn']){
				redirect($url);	
			}
		}else{
			redirect($url);	
		}
	}

	function redirectIfLoggedIn($url) {
		if(!empty($_SESSION['isLoggedIn'])) {
			if($_SESSION['isLoggedIn']){
				redirect($url);	
			}
		}
	}
?>
