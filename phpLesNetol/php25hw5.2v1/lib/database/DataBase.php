<?php

class DataBase 
{
		public static function connect($host, $dbname, $user, $pass) {
				$pdo = new PDO("mysql:host=" . $host . ";dbname=" . $dbname . ";charset=utf8", $user, $pass, [
	  		PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    		]);
				return $pdo;
		}
}
