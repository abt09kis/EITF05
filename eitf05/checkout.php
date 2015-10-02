<?php

session_start();

echo "<tr><th> Id </th><th> Name </th><th> Cost </th></tr>";

for ($x = 0; $x <= $_COOKIE['cookieNbr']; $x++) {

    echo "<tr><th>" .  $_COOKIE[purchases[$x]] . "</th></tr>";

}

echo "<form action='purchase.php' method='POST'>";
echo "<input id='submit' type='submit' value='Buy' name= 'Buy'>";
echo "</form>";

?>
