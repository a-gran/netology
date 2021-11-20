<?php
$fileList = glob('db_tests/*.json');

$test = [];
foreach ($fileList as $key => $file) {
    if ($key == $_GET['test']) {
        $fileTest = file_get_contents($fileList[$key]);
        $decodeFile = json_decode($fileTest, true);
        $test = $decodeFile;
    }
}
$question = $test[0]['question'];
$answers[] = $test[0]['answers'];

// Кол верных ответов
$resultTrue = 0;
foreach ($answers[0] as $item) {
    if ($item['result'] === true) {
        $resultTrue++;
    }
}

$ansTrue = 0;
$ansFalse = 0;
if (count($_POST) > 0) {
    // Кол правильных введенных ответов
    foreach ($_POST as $key => $item) {
        if ($answers[0][$key]['result'] === true) {
            $ansTrue++;
        } else {
            $ansFalse++;
        }
    }
    // Вывод результата
    if ($ansTrue === $resultTrue && $ansFalse === 0) {
        echo 'Все верно!';
    } else {
        echo 'Есть ошибки!';
    }
}

?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Тест: <?=$question?></title>
</head>
<body>

<form method="POST">
    <fieldset>
        <legend><?=$question?></legend>
        <?php foreach ($answers[0] as $key => $item) : ?>
            <label><input type="radio" name="<?=$key;?>" value="<?=$item['answer'];?>"> <?=$item['answer'];?></label>
        <?php endforeach; ?>
    </fieldset>
    <input type="submit" value="Отправить">
</form>

<ul>
    <li><a href="admin.php">Загрузить тест</a></li>
    <li><a href="list.php">Список тестов</a></li>
</ul>

</body>
</html>


