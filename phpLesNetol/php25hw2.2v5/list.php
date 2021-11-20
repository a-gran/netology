<?php
$fileList = glob('db_tests/*.json');

?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Список тестов</title>
</head>
<body>

    <?php
        foreach ($fileList as $key => $file) {
            $fileTest = file_get_contents($file);
            $decodeFile = json_decode($fileTest, true);
            foreach ($decodeFile as $test) {
                $question = $test['question'];
                echo "<a href=\"test.php?test=$key\">$question</a><br>";
            }
        }
    ?>

    <ul>
        <li><a href="admin.php">Загрузить тест</a></li>
        <li><a href="list.php">Список тестов</a></li>
    </ul>

</body>
</html>