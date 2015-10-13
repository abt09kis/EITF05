<?php
	session_start();
	include_once "testlogin.php";
	redirectIfNotLoggedIn("https://127.0.0.1/");
?>

<html>
	<body>

<div>
<?php
	echo "<h1 style=\"text-align: right; color: red;\">Username = " . htmlspecialchars($_SESSION['username']) . "<h1/>";
?>
		<form action="search.php" method="POST">
			<input id="search" name="searchField" type="text" placeholder="Type here">
			<input id="submit" type="submit" value="Search">
<?php
	echo "<input type=\"hidden\" name=\"token\" value=\"" . session_id()  . "\"/>";
?>

		</form>

<div/>
		<form action="logout.php" method="POST">
			<input type='submit' name='Logout'  value='Logout' />
<?php
	echo "<input type=\"hidden\" name=\"token\" value=\"" . session_id()  . "\"/>";
?>
		</form>
		<form action='checkoutView.php' method='POST'>
			<input id='submit' type='submit' value='Checkout' name= 'Checkout'>

<?php
	echo "<input type=\"hidden\" name=\"token\" value=\"" . session_id() . "\"/>";
?>
		</form>
	</body>
</html>
