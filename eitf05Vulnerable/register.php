<?php
	session_start();
	include_once "testlogin.php";
	redirectIfLoggedIn("https://127.0.0.1/searchView.php");
?>

<?php
	// Secure against XSS since only allow [a-zA-Z0-9]
	// Comment out error_reporting in prod. env.
	//error_reporting(E_ALL);
	include_once "database.php";
	include_once "crypto.php";
	include_once "regcodes.php";


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
			$stmt->free_result();
		}
		$_SESSION[RegCodes::USED_USERNAME] = 2;
		return false;
	}

	function addUser($mysqli, $email, $pwd) {
		$crypto = new Crypto();
		$salt = $crypto->generateSalt(10);
		$hash = $crypto->generateHash($pwd, $salt);
		$sql = "INSERT INTO users(email, hash, salt, nbrAttempts) 
			VALUES('" . $email . "', '" . $hash ."', '". $salt ."', '0')";
		$mysqli->multi_query($sql);
		
		$_SESSION['isLoggedIn'] = 1;
		$_SESSION['username'] = $email;
		
		redirect("https://127.0.0.1/searchView.php");
	}

	$token = $_POST['token'];
	if($token == session_id()) {
		$email = $_POST['username'];
		$pwd = $_POST['password'];

		$db = new Database();
		$mysqli = $db->openConnection();

		$usernameAvailable = isUsernameFree($mysqli, $email);

		if($usernameAvailable){
			addUser($mysqli, $email, $pwd);
		}else {
			redirect("https://127.0.0.1/registerView.php");
		}
		$db->closeConnection($mysqli);
	}else {
		redirect("https://127.0.0.1/index.php");
	}
?>
