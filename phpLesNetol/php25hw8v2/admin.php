<?php
require_once 'core.php';
if (!isAuthorized())
{
    location('index');
}

if (isset($_POST) && isset($_FILES) && isset($_FILES['testfile'])) {
    $file_name = $_FILES['testfile']['name'];
    $tmp_file = $_FILES['testfile']['tmp_name'];
    $uploads_dir = 'db_tests/';
    $path_info = pathinfo($uploads_dir . $file_name);
    if ($path_info['extension'] === 'json') {
        move_uploaded_file($tmp_file, $uploads_dir . $file_name);
        header('Location: ' . 'list.php');
    } else {
        echo 'Необходим файл с расширением .json';
    }
}

?>
<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Тест</title>
</head>
<body>
<h2>Добро пожаловать, <?= getLoggedUserData()['name']; ?></h2>

    <h3>Загрузка теста</h3>
    <form method = "post" enctype = "multipart/form-data">
        <input type= "file" name = "testfile">
        <input type= "submit" value = "Загрузить">
    </form>

    <ul>
        <li><a href="index.php">Главная</a></li>
        <li><a href="admin.php">Загрузить тест</a></li>
        <li><a href="list.php">Список тестов</a></li>
        <li><a href="log.php">Выход</a></li>
    </ul>
</body>
</html>
