<?php

require_once 'src/core.php';

if (isset($_COOKIE['ban'])) {
    location('ban.php');
}

if (isAuthorized() || isQuest()) {
    location('admin.php');
}

if (!isset($_SESSION['incorrect'])) $_SESSION['incorrect'] = 0;
$errors = [];

if ($_SESSION['incorrect'] < 5) {
    if (!empty($_POST['enterAsUser'])) {
        if (login($_POST['login'], $_POST['password'])) {
            location('admin.php');
        } else {
            $errors[] = 'Неверный логин или пароль';
            $_SESSION['incorrect']++;
        }
    }
} else if ($_SESSION['incorrect'] < 10) {
    if (!empty($_POST['enterAsUserWithCaptcha'])) {
        if (login($_POST['login'], $_POST['password']) && checkCaptcha($_POST['captcha'], $_SESSION['captcha'])) {
            location('admin.php');
        }
        if (!login($_POST['login'], $_POST['password']) || !checkCaptcha($_POST['captcha'], $_SESSION['captcha'])) {
            $_SESSION['incorrect']++;
            if (!login($_POST['login'], $_POST['password'])) {
                $errors[] = 'Неверный логин или пароль!';
            }
            if (!checkCaptcha($_POST['captcha'], $_SESSION['captcha'])) {
                $errors[] = 'Неверно распознана каптча!';
            }
        }
    }
}

if ($_SESSION['incorrect'] === 10) {
    banUser();
    location('ban.php');
}

if (isset($_POST['enterAsQuest'])) {
    $_SESSION['quest']['username'] = str_replace(' ', '', $_POST['username']);
    location('admin.php');
}

echo $_SESSION['incorrect'];
echo '</br>';

?>
<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Войти</title>
    <link rel="stylesheet" href="styles/index.css">
</head>
<body>

<ul>
    <?php foreach ($errors as $error): ?>
        <li><?php echo $error ?></li>
    <?php endforeach; ?>
</ul>

<fieldset>
    <legend>Авторизуйтесь (admin:admin)</legend>
    <form method="POST">
        <label>Логин:&nbsp;&nbsp;&nbsp;<input type="text" name="login" id="login"></label><br>
        <label>Пароль:&nbsp;<input type="text" name="password" id="password"></label><br>
        <?php if ($_SESSION['incorrect'] < 5): ?>
            <input type="submit" value="Войти" name="enterAsUser">
        <?php endif; ?>
        <?php if ($_SESSION['incorrect'] >= 5): ?>
            Введите каптчу с картинки:<br>
            <img src="src/captcha.php" alt="Каптча"><br>
            <input type="text" name="captcha" <!--required-->>
            <input type="submit" value="Войти" name="enterAsUserWithCaptcha">
        <?php endif; ?>
    </form>
</fieldset>

<fieldset style="margin-top: 25px;">
    <legend>Или войдите как гость</legend>
    <form method="POST">
        <label>Введите ваше имя: <input type="text" name="username" id="username" required></label>
        <input type="submit" name="enterAsQuest" value="Войти">
    </form>
</fieldset>

</body>
</html>