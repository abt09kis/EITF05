<?php
	class LoginManager {
		$logout_persist = 0;
		public function login() {
			$_SESSION['isLoggedIn'] = 1;
			$this->startLogoutTimer();
			$this->listenTabClose();
			$this->listenLogout();
			$this->listenWindowClose();
		}

		public function logout() {

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
