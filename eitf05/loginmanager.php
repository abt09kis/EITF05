<?php
	class LoginManager {
		$logout_persist = 0;
		public function login() {
			$_SESSION['isLoggedIn'] = 1;
			$this->startLogoutTimer();
			$this->listenTabClose();
			$this->listenLogout();
			$this->listenWindowClose();
			$logout= strip_tags($_POST['Logout']);
		}

		session_start();
		
		// logout() will log the user out, clear all session variables and unset coookies in addition to terminating the session.
		public function logout() {
			if(!is_null($logout)){
				$_SESSION = array();
				//$_SESSION['isLoggedIn'] = 0;
				if(ini_get("session.use_cookies")){
					$params = session_get_cookie_params();
					setcookie(session_name(), " ", time() - 42000, $params["path"], $params["domain"],$params["secure"], $params["httponly"]);
				}
			}
			session_destroy();
		}

		private function startLogoutTimer($millis) {
			echo "<script>setTimeout(function(){ alert(\"Hello\"); }, " . $millis . ");</script>";
		}

		private function listenLogout(){

		}

		private function listenWindowClose() {

		}

		private function listenTabClose() {

		}

		public function isLoggedIn(){
			return $_SESSION['isLoggedIn'] == 1;
		}
	}
?>
