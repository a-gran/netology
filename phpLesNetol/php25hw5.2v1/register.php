<?php
require 'core.php';
if (isRegistration())  {
		$pdo = createPDO();
		$sql = "INSERT INTO user (login, password) VALUES (?, ?)";
		$statement = $pdo->prepare($sql);
		$userPassword = getHashPassword($_POST['password']);
		$statement->execute(["{$_POST['login']}", "{$userPassword}"]);
}
if (isAuthorization()) {
		$pdo = createPDO();
		$sql = "SELECT * FROM user WHERE login = ? AND password = ?";
		$statement = $pdo->prepare($sql);
		$userPassword = getHashPassword($_POST['password']);
		$statement->execute(["{$_POST['login']}", "{$userPassword}"]);
    $user = $statement->fetch(PDO::FETCH_ASSOC);
		if (!empty($user)) {
			session_start();
			unset($user['password']);
			$_SESSION['user'] = $user;
			header('Location: ./index.php');
		}
} 
?>

<!DOCTYPE html>
<html lang="ru">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="style.css">
    <title>Вход</title>
  </head>
  <body>
    <form method="POST">
		  <p style="display: inline-block;"><b><?php if (isRegistration()) {
			  echo 'Ваши данные отправлены! Войдите, используя свой логин и пароль:'; } else if (isAuthorization() && empty($user)) { echo 'Неправильный логин и пароль!'; } else { echo 'Войдите или зарегистрируйтесь:'; } ?></b></p>
      <input name="login" id="login" placeholder="Логин">
      <input name="password" id="password" placeholder="Пароль">
			<button type="submit" name="registration">Регистрация</button>
			<button type="submit" name="authorization">Вход</button>
    </form><br>
  </body>
</html>
</html>