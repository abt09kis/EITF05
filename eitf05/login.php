<?php
	session_start();
?>
<html>
	<head>
		<title>ProWebshop0.1</title>
	</head>
<body>

<?php
	include_once "database.php";
	include_once "crypto.php";

	function Login(){
		if(empty($_POST['username'])) {
			return false;
		}
		if(empty($_POST['password'])) {
			return false;
		}
		$username = $_POST['username'];
		$password = $_POST['password'];

		echo 'Attempted login: ' . $username . $password;
		if(!DBLogin($username,$password)) {
			return false;
		}
		session_start();
		return true;
	}

	
	function DBLogin($username, $password){
		$db = new Database();
		$mysqli = $db->openConnection();	

	    	$sql = "SELECT salt, hash FROM users WHERE email = ?";
	    	$stmt = $mysqli->prepare($sql);
		
		$hash_db = NULL;
		$salt_db = NULL;
		if($stmt->bind_param('s', $username)){
			if($stmt->execute()){
				$stmt->bind_result($salt_db, $hash_db);
				if(!$stmt->fetch()){
					return false;
				}
				$stmt->free_result();
			}
			$db->closeConnection($mysqli);
		}
		echo $salt_db;
		$crypto = new Crypto();
		$hash = $crypto->generateHash($password,  $salt_db);

		echo '<br/>Generated hash: ' . $hash . '<br/>';
		echo 'Hash From db ' . $hash_db;
		if($res_pwd == $hash){
			header("Location: http://localhost:80/meet2eat/login.php");
		}
	}
	Login();
?>

</body>
</html>
