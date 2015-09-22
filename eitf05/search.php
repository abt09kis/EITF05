

  <?php

print "1";

  echo "<html>";
  echo "<body>";
  echo "<table style='width:100%' id = 'itemTable'>";

  print "2";

  $sql_user = ini_get("mysql.default_user");
  $sql_host = ini_get("mysql.default_host");
  $sql_pass = ini_get("mysql.default_password");

  print "3";


    $mysqli = new mysqli($sql_host, $sql_user, $sql_pass, "EITF05");
    if ($mysqli->connect_errno) {
      echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
    }

    print "4";

    $sql = "SELECT * FROM items WHERE itemName = ?";

    print "5";

    $stmt = $mysqli->prepare($sql);

    print "6";

    $search = strip_tags($_POST['search']);

    print "7";

    $stmt->bind_param('s', $search);

    print "8";


    if(!$result = $mysqli->query($stmt)){

        die('There was an error running the query [' . $db->error . ']');
    }

    print "9";


    if ($result->num_rows > 0) {

            echo "<tr><th>Id</th><th>Name</th><th>cost</th></tr>";

            print "10";

        while($row = $result->fetch_assoc()) {

            echo "<tr><th>". $row["itemId"]."</th><th>". $row["itemName"]."</th><th>". $row["cost"]."</th></tr>";
            $_SESSION["itemId"] = $row["itemId"];
        }

    } else {

        print "0 results for search: " . htmlspecialchars($search);
    }
    print "11";

    $mysqli->close();
    print "12";

    echo "</table>";
    echo "<form action='buy.php' method='POST'>";
    echo "<input id='submit' type='submit' value='buy' name= 'buy'>";
    echo "</form>";
    echo "</body>";
    echo "</html>";

    print "13";

  ?>
