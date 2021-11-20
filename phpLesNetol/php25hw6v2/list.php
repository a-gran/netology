<?php

$file_list = glob('db_tests/*.json');

?>

<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Список тестов</title>
</head>
<body>

    <?php
        foreach ($file_list as $key => $file) {
            $file_test = file_get_contents($file);
            $decode_file = json_decode($file_test, true);
            foreach ($decode_file as $test) {
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