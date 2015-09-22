<?php

	// Comment out error_reporting in prod. env.
	error_reporting(E_ALL);
	function generateSalt($length) {
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	    	$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, $charactersLength - 1)];
		}
		return $randomString;
	}

	function generateHash($pwd, $salt){
		return hash_pbkdf2('sha256', $pwd, $salt, 1000, 0, false);
	}


	// Username must be unique
	// Allowed characters password and username: [a-zA-Z0-9]
	// Username at least 1 characters
	// Password at least 10 characters
		
	$sql_user = ini_get("mysql.default_user");
	$sql_host = ini_get("mysql.default_host");
	$sql_pass = ini_get("mysql.default_password");
	
	$mysqli = new mysqli($sql_host, $sql_user, $sql_pass, "EITF05");
	if ($mysqli->connect_errno) {
		echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
	}
	
	$sql = "INSERT INTO users(email, hash, salt, nbrAttempts) VALUES(?, ?, ?, '0')";
	$stmt = $mysqli->prepare($sql);

	echo $sql;
	$email = $_POST['username'];
	$pwd = $_POST['password'];	
	$salt = generateSalt(10);

	echo 'salt: ' . $salt;
	$hash = generateHash($pwd, $salt);

	echo 'email: ' . $email . ', salt: ' . $salt . ', hash ' . $hash;
	if($stmt->bind_param('sss', $email, $hash, $salt)){
		echo "Bound params success <br/>";
		if($stmt->execute()){
			$stmt->free_result();
		}
	}
	$mysqli->close();
?>
