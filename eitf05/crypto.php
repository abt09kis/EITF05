<?php
	class Crypto {
		public function generateHash($pwd, $salt){
	  		return hash_pbkdf2('sha256', $pwd, $salt, 100000, 0, false);
		}

		function generateSalt($length) {
			$characters = ' !"#$%&\'()*+,-./0123456789:;<=>?@ABCDEFGHIJKLMNOPQRSTUVWXYZ[\\]^_`abcdefghijklmnopqrstuvwxyz{|}~';
			$charactersLength = strlen($characters);
			$randomString = '';
			for ($i = 0; $i < $length; $i++) {
				$randomString .= $characters[rand(0, $charactersLength - 1)];
			}
			return $randomString;
		}
	}
?>
