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
		echo "<br/>This (IP, UID) combo has attempted " . nbrAttempts($username) . " times before ...";

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

		if($res_pwd == $hash && !isUserBlocked($username)){
			$_SESSION['username'] = $username;
			header("Location: https://localhost/search.html");
		} else {
			attemptLogin($username);
		}
	}

	function isUserBlocked($username){
		// Check nbrAttempts
		// If too many attempts: Block, delete attempts for (IP, UID)-pair
		// Check Blocked
		$ip = clientIP();
		$filename = "login_data.txt";
		$f = fopen($filename, "r");
		$contents = fread($f, filesize($filename));
		$attempts = json_decode($contents, true);

		if(is_null($attempts[$ip])){
			return false;
		}
		else if(is_null($attempts[$ip][$username])){
			return false;
		}
		return $attempts[$ip][$username]["blockedUntil"] > time();
	}

	function nbrAttempts($username){
		$ip = clientIP();
		$filename = "login_data.txt";
		$f = fopen($filename, "r");
		$contents = fread($f, filesize($filename));
		$attempts = json_decode($contents, true);
		return $attempts[$ip][$username]["nbrAttempts"];
	}

	/**
	 * Block attempts
	 * Need to validate uid !
	 */
	function attemptLogin($username) {
		$ip = clientIP();
		$filename = "login_data.txt";
		$f = fopen($filename, "r");
		$contents = fread($f, filesize($filename));

		$attempts = json_decode($contents, true);
		$attempts = createJson($attempts, $ip, $username);

		$f = fopen($filename, "w");
		fwrite($f, $attempts . "\n");
		fclose($f);
	}

	function defaultArray() {
		return array("nbrAttempts" => 0, "blockedUntil" => 0);
	}

	function createJson($attempts, $ip, $username){
		if(is_null($attempts)){
			$nbrAttempsBlocked = defaultArray();
			$user_attempted = array($username => $nbrAttempsBlocked);
			$attempts = array($ip => $user_attempted);
		}else {
			if(is_null($attempts[$ip])) {
				$nbrAttempsBlocked = defaultArray();
				$attempts[$ip] = array($username => $nbrAttempsBlocked);
			}else if(is_null($attempts[$ip][$username])) {
				$attempts[$ip][$username] = defaultArray();
			}else if(!isUserBlocked($username)){
				$attempts[$ip][$username]["nbrAttempts"] += 1;
				if ($attempts[$ip][$username]["nbrAttempts"] >= 5){
					$attempts[$ip][$username]["nbrAttempts"] = 0;
					$attempts[$ip][$username]["blockedUntil"] = time() + 30*60; //Block for 30 minutes ...
				}
			}
		}
		return json_encode($attempts);
	}
	Login();
?>

</body>
</html>
