<?php
if (isset($_POST) && isset($_FILES) && isset($_FILES['testFile'])) {
    $fileName = $_FILES['testFile']['name'];
    $tmpFile = $_FILES['testFile']['tmpName'];
    $dbTests = 'db_tests/';
    $pathInfo = pathinfo($dbTests . $fileName);
    if ($pathInfo['extension'] === 'json') {
        move_uploaded_file($tmpFile, $dbTests . $fileName);
        echo 'Тест успешно загружен!';
    } else {
        echo 'Необходим файл с расширением .json!';
    }
}

?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Загрузить тест</title>
</head>
<body>

    <form method="post" enctype="multipart/form-data">
        <input type="file" name="testFile">
        <input type="submit" value="Загрузить">
    </form>

    <ul>
        <li><a href="admin.php">Загрузить тест</a></li>
        <li><a href="list.php">Список тестов</a></li>
    </ul>
</body>
</html>
