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
				<legend>Some Cool Website ...</legend>
				<input type='submit' name='Register' formaction='https://127.0.0.1/logout.php' value='Check out my cool pic!' />

			</fieldset>
		</form>
	</body>
</html>
