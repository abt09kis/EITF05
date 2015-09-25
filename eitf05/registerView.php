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
		/**
		 * Add token to protect from CSRF
		 */
		echo "<input type=\"hidden\" name=\"token\" value=\"" .  $_COOKIE['PHPSESSID'] . "\"/>"; 
		
		/**
		 * Only displays if failed attempt ... 
		 * Important that no logic is here ...  
		 */

		$legal_pass = $_SESSION[RegCodes::ILLEGAL_PASSWORD];
		echo "p_false = " . $p_false;
		if($p_false){
			echo "<span style=\"color:#F00\"><br/><br/>Password must be at least 10 characters long. 
				<br/> It must consist only of [a-zA-Z0-9] 
				and contain at least <br/>one lower case 
				letter <br/>one upper case letter<br/>one digit</span>";
		}
?>

			</fieldset>
		</form>
	</body>
</html>
