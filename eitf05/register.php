<?php
	// Comment out error_reporting in prod. env.
	//error_reporting(E_ALL);
	include_once "database.php";
	include_once "crypto.php";
	
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
	
	$email = $_POST['username'];
	$pwd = $_POST['password'];

	if(isValidPassword($pwd) && isValidUsername($email)) {
		// Check if blocked ... (TO BE IMPLEMENTED) 
		$db = new Database();
		$mysqli = $db->openConnection();

		$sql = "INSERT INTO users(email, hash, salt, nbrAttempts) VALUES(?, ?, ?, '0')";
		$stmt = $mysqli->prepare($sql);

		$crypto = new Crypto();
		$salt = $crypto->generateSalt(10);
		$hash = $crypto->generateHash($pwd, $salt);

		echo 'email: ' . $email . ', salt: ' . $salt . ', hash ' . $hash;
		if($stmt->bind_param('sss', $email, $hash, $salt)){
			echo "Bound params success <br/>";
			if($stmt->execute()){
				$stmt->free_result();
			}
		}
	}else {
		// TO BE IMPLEMENTED:
		// Count number failed attempts ... 
		// Block if more than 5 for 30 seconds ... 
		header("Location: http://127.0.0.1/EITF05/eitf05/registerView.php?p_false=1");
		die();
	}
	$mysqli->close();
?>
