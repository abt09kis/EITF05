<?php
	session_start();
?>

<?php
	// Comment out error_reporting in prod. env.
	//error_reporting(E_ALL);
	include_once "database.php";
	include_once "crypto.php";
	include_once "regcodes.php";

	$token = $_POST['token'];
	if($token == $_COOKIE['PHPSESSID']) {
		/*
		* 10 to 64 characters in [1-zA-Z0-9]
		* At least one lower case, one upper case and one digit.
		*/
		function isValidPassword($pwd){
			$regex = "/\A(?=[a-zA-Z0-9]{10,64}\z)(?=[^a-z]*[a-z])(?=[^A-Z]*[A-Z])(?=[^0-9]*[0-9])/";
			$combined = preg_match($regex, $pwd);
			return $combined;
		}

		/*
		* 1 to 64 characters in [1-zA-Z0-9]
		*/
		function isValidUsername($uid){
			$regex = "/\A(?=[a-zA-Z0-9]{1,64}\z)/";
			$combined = preg_match($regex, $uid);
			return $combined;
		}

		function isUsernameFree($mysqli, $uid){
			$sql = "SELECT COUNT(*) INTO count FROM users where email = ?";
			$stmt = $mysqli->prepare($sql);
			$stmt->bind_param('s', $uid);
			if($stmt->execute()){
				if($stmt->fetch()) {
					return count == 0;
				}
			}
			return false;
		}
		
		$email = $_POST['username'];
		$pwd = $_POST['password'];

		if(isValidPassword($pwd) && isValidUsername($email)) {
			$_SESSION[RegCodes::ILLEGAL_PASSWORD] = 0;
			// Check if blocked ... (TO BE IMPLEMENTED) 
			$db = new Database();
			$mysqli = $db->openConnection();

			// Check if username already exists ... 
			//if(isUsernameFree($mysqli, $email)) {
				$sql = "INSERT INTO users(email, hash, salt, nbrAttempts) VALUES(?, ?, ?, '0')";
				$stmt = $mysqli->prepare($sql);

				$crypto = new Crypto();
				$salt = $crypto->generateSalt(10);
				$hash = $crypto->generateHash($pwd, $salt);

				if($stmt->bind_param('sss', $email, $hash, $salt)){
					echo "Bound params success <br/>";
					if($stmt->execute()){
						$_SESSION[RegCodes::REGISTER_SUCCESS] = 1;
						$stmt->free_result();
					}
				}

			}else {
				// TO BE IMPLEMENTED:
				// Count number failed attempts ... 
				// Block if more than 5 for 30 seconds ... 
				$_SESSION[RegCodes::ILLEGAL_PASSWORD] = 1;
				//if(!isset($_SESSION[''])) {
				//	$_SESSION[''] = 0;
				//}else {
				//	$_SESSION['']++;
				//}
				header("Location: http://127.0.0.1/EITF05/eitf05/registerView.php");
				die();

			}
			$mysqli->close();
		//}
	}else {
		header("Location: http://127.0.0.1/EITF05/eitf05/index.php");
		die();
		// LOG NO TOKEN SET ... 
	}
?>
