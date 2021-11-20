<?php 
function isRegistration() {
		return (isset($_POST['registration']) && !empty($_POST['login']) && !empty($_POST['password']));
}
function isAuthorization() {
		return (isset($_POST['authorization']) && !empty($_POST['login']) && !empty($_POST['password']));
}
function createPDO() {
		$pdo = new PDO("mysql:host=localhost;dbname=dump1;charset=utf8", "root", "", [
	  PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
		return $pdo;
}
function getSalt() {
	return 'Hk532falc0e84GjdF';
}
function getHashPassword($password) {
	return md5($password . getSalt());
}