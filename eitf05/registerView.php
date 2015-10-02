<?php
	session_start();
?>

<html>
	<head>
		<title> ProWebshop0.1</title>
	</head>
	<body>
		<form id='login' action='register.php' method='post' accept-charset='UTF-8'>
			<fieldset >
				<legend>Register</legend>
				<input type='hidden' name='submitted' id='submitted' value='1'/>
				<label for='username' >UserName*:</label>
				<input type='text' name='username' id='username'  maxlength="50" />
				<label for='password' >Password*:</label>
				<input type='password' name='password' id='password' maxlength="50" />
				<input type='submit' name='Submit' value='Submit' />

<?php
	include_once "regcodes.php";
	//Add token to protect from CSRF
	echo "<input type=\"hidden\" name=\"token\" value=\"" .  $_COOKIE['session_id'] . "\"/>"; 
	
	$illegal_pass = $_SESSION[RegCodes::ILLEGAL_PASSWORD];
	$illegal_user = $_SESSION[RegCodes::ILLEGAL_USERNAME];
	$used_user = $_SESSION[RegCodes::USED_USERNAME];
	
	if($illegal_pass){
		echo "<div style=\"font-size: 25px; color:#F00; margin:10px 5px 15px 20px;\">";
		echo "Illegal Password";
		echo "<div style=\"font-size: 18px; margin:10px 5px 15px 20px;\">";
		echo "At least 10 characters long. 
			<br/> It must consist only of [a-zA-Z0-9] 
			and cotain at least ";
		echo "<br/>one lower case letter <br/>one upper case letter<br/>one digit";
		echo "</div></div>";
	}

	if($illegal_user){
		echo "<div style=\"font-size: 25px; color:#F00; margin:10px 5px 15px 20px;\">";
		echo "<br/>Illegal Username";
		echo "<div style=\"font-size: 18px; margin:10px 5px 15px 20px;\">";
		echo "<br/> It must consist only of [a-zA-Z0-9] be at least one character long";
		echo "</div></div>";
	}

	if($used_user){
		echo "<div style=\"font-size: 25px; color:#F00; margin:10px 5px 15px 20px;\">";
		echo "</br>Username already in use";
		echo "</div>";
	}

?>

			</fieldset>
		</form>
	</body>
</html>
