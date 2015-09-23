<?php
	// Comment out error_reporting in prod. env.
	error_reporting(E_ALL);
	include_once "database.php";
	include_once "crypto.php";

	// Username must be unique
	// Allowed characters password and username: [a-zA-Z0-9]
	// Username at least 1 characters
	// Password at least 10 characters
	$db = new Database();
	$mysqli = $db->openConnection();

	$sql = "INSERT INTO users(email, hash, salt, nbrAttempts) VALUES(?, ?, ?, '0')";
	$stmt = $mysqli->prepare($sql);

	echo $sql;
	$email = $_POST['username'];
	$pwd = $_POST['password'];	

	$crypto = new Crypto();
	$salt = $crypto->generateSalt(10);

	echo 'salt: ' . $salt;
	$hash = $crypto->generateHash($pwd, $salt);

	echo 'email: ' . $email . ', salt: ' . $salt . ', hash ' . $hash;
	if($stmt->bind_param('sss', $email, $hash, $salt)){
		echo "Bound params success <br/>";
		if($stmt->execute()){
			$stmt->free_result();
		}
	}
	$mysqli->close();
?>
