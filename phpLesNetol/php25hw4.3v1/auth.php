<?php

use models\Auth\Auth as Auth;

require_once __DIR__ . '/src/core.php';

$auth = new Auth;
if ($auth->isAuth()) {
    header('Location: index.php');
}

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="web/style/auth.css">
    <title>Авторизация</title>
</head>
<body>

<form method="POST" class="auth">
    <input type="text" name="login" placeholder="Логин">
    <input type="password" name="password" placeholder="Пароль">
    <input type="submit" name="authButton" value="Войти"><br>
    <a class="switcher" href=".">Нет аккаунта? Зарегистрируйтесь!</a>
</form>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="http://code.jquery.com/color/jquery.color-2.1.2.min.js"></script>
<script src="web/js/auth.js"></script>
</body>
</html>
