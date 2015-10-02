<?php
	session_start();
?>

<?php
	// Secure against XSS since only allow [a-zA-Z0-9]
	// Comment out error_reporting in prod. env.
	//error_reporting(E_ALL);
	include_once "database.php";
	include_once "crypto.php";
	include_once "regcodes.php";

	/*
	* 10 to 64 characters in [1-zA-Z0-9]
	* At least one lower case, one upper case and one digit.
	*/
	function isValidPassword($pwd){
		$regex = "/\A(?=[a-zA-Z0-9]{10,64}\z)(?=[^a-z]*[a-z])(?=[^A-Z]*[A-Z])(?=[^0-9]*[0-9])/";
		$valid = preg_match($regex, $pwd);

		if($valid) {
			$_SESSION[RegCodes::ILLEGAL_PASSWORD] = 0;
		}else {
			$_SESSION[RegCodes::ILLEGAL_PASSWORD] = 1;
		}

		return $valid;
	}

	/*
	* 1 to 64 characters in [1-zA-Z0-9]
	*/
	function isValidUsername($uid){
		$regex = "/\A(?=[a-zA-Z0-9]{1,64}\z)/";
		$valid = preg_match($regex, $uid);
		if($valid) {
			$_SESSION[RegCodes::ILLEGAL_USERNAME] = 0;
		}else {
			$_SESSION[RegCodes::ILLEGAL_USERNAME] = 1;
		}
		return $valid;
	}

	function isUsernameFree($mysqli, $uid){
		$sql = "SELECT COUNT(*) FROM users where email = ?";
		$stmt = $mysqli->prepare($sql);
		$stmt->bind_param('s', $uid);
		if($stmt->execute()){
			$count = NULL;
			$stmt->bind_result($count);
			if($stmt->fetch()) {
				if($count == 0){
					$_SESSION[RegCodes::USED_USERNAME] = 0;
				}else {
					$_SESSION[RegCodes::USED_USERNAME] = 1;
				}
				return $count == 0;
			}
		}
		$_SESSION[RegCodes::USED_USERNAME] = 2;
		return false;
	}

	function redirect($url){
		$h = "Location: " . $url;
		header($h);
		die();
	}

	function addUser($mysqli, $email, $pwd) {
		$sql = "INSERT INTO users(email, hash, salt, nbrAttempts) VALUES(?, ?, ?, '0')";
		$stmt = $mysqli->prepare($sql);
		$crypto = new Crypto();
		$salt = $crypto->generateSalt(10);
		$hash = $crypto->generateHash($pwd, $salt);

		if($stmt->bind_param('sss', $email, $hash, $salt)){
			if($stmt->execute()){
				echo "executed";
				redirect("https://127.0.0.1/search.html");
				$stmt->free_result();
			}
		}
	}

	$token = $_POST['token'];
	if($token == $_COOKIE['session_id']) {
		$email = $_POST['username'];
		$pwd = $_POST['password'];

		$db = new Database();
		$mysqli = $db->openConnection();

		$validPass = isValidPassword($pwd);
		$validUserName = isValidUsername($email);
		$usernameAvailable = isUsernameFree($mysqli, $email);

		if($validPass && $validUserName && $usernameAvailable){
			addUser($mysqli, $email, $pwd);
		}else {
			redirect("https://127.0.0.1/registerView.php");
		}
		$db->closeConnection($mysqli);
	}else {
		redirect("https://127.0.0.1/index.php");
	}
?>
