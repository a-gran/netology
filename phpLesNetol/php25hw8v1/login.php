<?php
require_once 'core.php';
if (isAuthorized())
{
    location('admin');
}

$errors = [];
if (isPost())
{
    if (login($_POST['login'], $_POST['password']))
    {
        location('admin');
    } else {
        $errors[] = 'Неверный логин и пароль';
    }
}

?>

<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Вход</title>
</head>
<body>
    <ul>
    <?php foreach ($errors as $error) : ?>
        <li><?=$error;?></li>
    <?php endforeach; ?>
    </ul>

    <form method="POST">
        <label for="login">Логин</label>
        <input name="login" id="login">

        <label for="password">Пароль</label>
        <input name="password" id="password">

        <button type="submit">Войти</button>
    </form>
</body>
</html>
