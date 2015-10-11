<?php
	session_start();
?>

<html>
	<head>
		<title> Safe site</title>
	</head>
	<body>
		<form id='login' action='https://127.0.0.1/logout.php' method='post' accept-charset='UTF-8'>
			<fieldset >
				<legend>Login</legend>
				<input type='hidden' name='submitted' id='submitted' value='1'/>

				<label for='username' >UserName*:</label>
				<input type='text' name='username' id='username'  maxlength="50" />

				<label for='password' >Password*:</label>
				<input type='password' name='password' id='password' maxlength="50" />

				<input type='submit' name='Submit' value='Submit' />
				<input type='submit' name='Register' formaction='https://127.0.0.1/logout.php' value='Not a member?, register here.' />

			</fieldset>
		</form>
	</body>
</html>
