<?php
	function generateSalt() {
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	    	$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, $charactersLength - 1)];
		}
		return $randomString;
	}

	$sql_user = ini_get("mysql.default_user");
	$sql_host = ini_get("mysql.default_host");
	$sql_pass = ini_get("mysql.default_password");

	$mysqli = new mysqli($sql_host, $sql_user, $sql_pass, "EITF05");
	if ($mysqli->connect_errno) {
		echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
	}
	
	$sql = "INSERT INTO users(email, hash, salt, nbrAttempts) VALUES(?, ?, ?, '0')";
	$stmt = $mysqli->prepare($sql);

	$uid = $_POST['username'];
	$pwd = $_POST['password'];	
	$salt = generateSalt();
	$hash = generateHash($pwd, $salt);

	if($stmt->bind_param('ss', $uid, $pwd)){
		if($stmt->execute()){
			$res_uid = NULL;
			$res_pwd = NULL;
			$stmt->bind_result($res_uid, $res_pwd);
			while ($stmt->fetch()) {
			    echo 'uid = ' . $res_uid . ', pwd = ' . $res_pwd;
			}
			$stmt->free_result();
		}
	}
	$mysqli->close();
?>
