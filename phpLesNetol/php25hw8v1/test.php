<?php
require_once 'core.php';
$file_list = glob('db_tests/*.json');

$test = [];
foreach ($file_list as $key => $file) {
    if ($key == $_GET['test']) {
        $file_test = file_get_contents($file_list[$key]);
        $decode_file = json_decode($file_test, true);
        $test = $decode_file;
    }
}

// Проверка массива test
if (empty($test)) {
    header("HTTP/1.0 404 Not Found");
    exit;
}

$question = $test[0]['question'];
$answers[] = $test[0]['answers'];


// Кол-во правильных ответов
$result_true = 0;
foreach ($answers[0] as $item) {
    if ($item['result'] === true) {
        $result_true++;
    }
}

// Проверка правильности введенных ответов
$post_true = 0;
$post_false = 0;
$test_success = 0;
if (!empty($_POST['form_answer'])) {
    foreach ($_POST['form_answer'] as $item) {
        if ($answers[0][$item]['result'] === true) {
            $post_true++;
        }else{
            $post_false++;
        }
    }
    // Вывод результата
    if ($post_true === $result_true && $post_false === 0) {
        $test_success++;
    } else {
        echo 'Есть ошибки!';
    }
}

?>

<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Тест: <?=$question?></title>
</head>
<body>

<form method="post">
    <fieldset>
        <legend><?=$question?></legend>
        <?php foreach ($answers[0] as $key => $item) : ?>
            <label><input type="checkbox" name="form_answer[]" value="<?=$key;?>"> <?=$item['answer'];?></label>
        <?php endforeach; ?>
    </fieldset>
    <input type="submit" value="Отправить">
</form>

<ul>
    <li><a href="index.php">Главная</a></li>
    <li><a href="list.php">Список тестов</a></li>
    <?php if (isAuthorized()) : ?>
        <li><a href="admin.php">Загрузить тест</a></li>
    <?php endif; ?>
</ul>

</body>
</html>


