<?php
	class LoginManager {
		public function login() {
			$_SESSION['isLoggedIn'] = 1;
			$this->startLogoutTimer();
			$this->listenTabClose();
			$this->listenLogout();
			$this->listenWindowClose();
		}

		public function logout() {

		}

		private function startLogoutTimer() {
			echo "<script>setTimeout(function(){ alert(\"Hello\"); }, 3000);</script>";
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
