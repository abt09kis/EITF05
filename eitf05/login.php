<?php
session_start();

  ?>
<html>
<head>
<title> ProWebshop0.1</title>
</head>
<body>
<?php
function Login(){
    if(empty($_POST['username']))
    {
        $this->HandleError("UserName is empty!");
        return false;
    }

    if(empty($_POST['password']))
    {
        $this->HandleError("Password is empty!");
        return false;
    }

    $username = $_POST['username'];
    $password = $_POST['password'];

    if(!$this->DBLogin($username,$password))
    {
        return false;
    }

    session_start();

    $_SESSION[$this->GetLoginSessionVar()] = $username;

    return true;
}
function generateHash($pwd, $salt){
  return hash_pbkdf2('sha256', $pwd, $salt, 1000, 0, false);
}
function DBLogin($username, $password){

  $mysqli = new mysqli($sql_host, $sql_user, $pas, "EITF05");

		if ($mysqli->connect_errno) {
			echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
		}
		$sql = "SELECT email, pwd FROM Users WHERE uid = ? AND pwd = ?";
    $sql2 = "SELECT salt FROM users WHERE uid = ?";
		$stmt = $mysqli->prepare($sql);
    $stmt2 = $mysqli->prepare($sql2))
		$uid = $_POST['username'];
		$pwd = $this->generateHash($_POST['password'],  $stmt2);
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

}

?>
</body>
</html>
