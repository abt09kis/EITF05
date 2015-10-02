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
					attemptLogin($username);
					return false;
				} else {
					validUsername($salt_db, $hash_db, $password, $username);
				}
				$stmt->free_result();
			}
			$db->closeConnection($mysqli);
		}
	}

	function clientIP() {
	    $ipaddress = '';
	    if (getenv('HTTP_CLIENT_IP'))
		$ipaddress = getenv('HTTP_CLIENT_IP');
	    else if(getenv('HTTP_X_FORWARDED_FOR'))
		$ipaddress = getenv('HTTP_X_FORWARDED_FOR');
	    else if(getenv('HTTP_X_FORWARDED'))
		$ipaddress = getenv('HTTP_X_FORWARDED');
	    else if(getenv('HTTP_FORWARDED_FOR'))
		$ipaddress = getenv('HTTP_FORWARDED_FOR');
	    else if(getenv('HTTP_FORWARDED'))
	       $ipaddress = getenv('HTTP_FORWARDED');
	    else if(getenv('REMOTE_ADDR'))
		$ipaddress = getenv('REMOTE_ADDR');
	    else
		$ipaddress = 'UNKNOWN';
	    return $ipaddress;
	}

	function validUsername($salt_db, $hash_db, $password, $username){
		echo $salt_db;
		$crypto = new Crypto();
		$hash = $crypto->generateHash($password,  $salt_db);

		echo '<br/>Generated hash: ' . $hash . '<br/>';
		echo 'Hash From db ' . $hash_db;

		if($res_pwd == $hash){
			$_SESSION['username'] = $username;
			header("Location: http://localhost:80/meet2eat/login.php");
		} else {
			attemptLogin($username);
		}
	}

	function attemptLogin($username) {
		$ip = clientIP();
		echo '<br/>IP = ' . $ip . ' attempt for ' . $username;
		$fp = fopen('login_data.txt', 'w+') or die("Unable to open file!");
		fwrite($fp, "This is a test \n\nnewline?");
		$attempt = array("ip" => $ip, "username" => $username);
		fwrite($fp, var_dump($attempt));
		fclose($fp);
	}
	Login();
?>

</body>
</html>
