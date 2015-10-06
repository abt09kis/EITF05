<?php
	session_start();
	include_once "testlogin.php";
	redirectIfLoggedIn("https://127.0.0.1/searchView.php");
?>

<html>
	<head>
		<title> ProWebshop0.1</title>
	</head>
	<body>
		<form id='login' action='login.php' method='post' accept-charset='UTF-8'>
			<fieldset >
				<legend>Login</legend>
				<input type='hidden' name='submitted' id='submitted' value='1'/>

				<label for='username' >UserName*:</label>
				<input type='text' name='username' id='username'  maxlength="50" />

				<label for='password' >Password*:</label>
				<input type='password' name='password' id='password' maxlength="50" />

				<input type='submit' name='Submit' value='Submit' />
				<input type='submit' name='Register' formaction='registerView.php' value='Not a member?, register here.' />
<?php
		echo "<input type=\"hidden\" name=\"token\" value=\"" . session_id() . "\"/>";
?>
			</fieldset>
		</form>
	</body>
</html>
