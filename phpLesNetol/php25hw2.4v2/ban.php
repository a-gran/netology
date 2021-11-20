<?php

require_once 'src/core.php';

if (!isset($_COOKIE['ban'])) {
    location('index.php');
}

?>

<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Ban</title>
</head>
<body>
    Вы забанены на 10 секунд
</body>
</html>