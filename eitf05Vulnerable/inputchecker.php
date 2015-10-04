<?php
	include_once "regcodes.php";
	class InputChecker {
		/*
		* 10 to 64 characters in [1-zA-Z0-9]
		* At least one lower case, one upper case and one digit.
		*/
		function isValidPassword($pwd){
			if(strlen($pwd) == 0)
				return false;
			$regex = "/\A(?=[a-zA-Z0-9]{10,64}\z)(?=[^a-z]*[a-z])(?=[^A-Z]*[A-Z])(?=[^0-9]*[0-9])/";
			$valid = preg_match($regex, $pwd);

			if($valid) {
				$_SESSION[RegCodes::ILLEGAL_PASSWORD] = 0;
			}else {
				$_SESSION[RegCodes::ILLEGAL_PASSWORD] = 1;
			}

			return $valid;
		}

		/*
		* 1 to 64 characters in [1-zA-Z0-9]
		*/
		function isValidUsername($uid){
			if(strlen($uid) == 0)
				return false;
			$regex = "/\A(?=[a-zA-Z0-9]{1,64}\z)/";
			$valid = preg_match($regex, $uid);
			if($valid) {
				$_SESSION[RegCodes::ILLEGAL_USERNAME] = 0;
			}else {
				$_SESSION[RegCodes::ILLEGAL_USERNAME] = 1;
			}
			return $valid;
		}
	}
?>


