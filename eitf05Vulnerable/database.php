<?php
	class Database {
		public function openConnection(){
			$sql_user = ini_get("mysql.default_user");
			$sql_host = ini_get("mysql.default_host");
			$sql_pass = ini_get("mysql.default_password");

			$mysqli = new mysqli($sql_host, $sql_user, $sql_pass, "EITF05");
			if ($mysqli->connect_errno) {
				echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
			}
			return $mysqli;
		}

		public function closeConnection($mysqli){
			$mysqli->close();
		}
	}
?>
