<?php

require_once 'src/core.php';

if (!isAuthorized() && !isQuest()) {
    location('admin.php');
}

$allTests = glob('tests/*.json');
$testNumber = $_GET['number'];
$requiredTest = $allTests[$testNumber];

// Если не существует теста с номером из get-запроса, то выдавать 404 ошибку
if (!isset($requiredTest) || !isset($testNumber)) {
    header($_SERVER['SERVER_PROTOCOL'] . '404 Not Found');
    exit;
}

// Получаем файл с номером из GET-запроса
$test = json_decode(file_get_contents($requiredTest), true);

// Если была нажата кнопка проверки теста, то проверить и вывести результат
if (isset($_POST['check-test'])) {

    $testname = basename($requiredTest);
    if (isAuthorized()) {
        $username = $_SESSION['user']['name'];
    }

    if (isQuest()) {
        $username = $_SESSION['quest']['username'];
    }

    $date = date("d-m-Y H:i");
    $correctAnswers = answersCounter($test)['correct'];
    $totalAnswers = answersCounter($test)['total'];
    $variables = [
        'testname' => $testname,
        'username' => $username,
        'date' => $date,
        'correctAnswers' => $correctAnswers,
        'totalAnswers' => $totalAnswers
    ];
}

// Если была нажата клавиша скачивания, то скачать файл
if (isset($_POST['generate-picture'])) {
    include_once 'src/create-picture.php';
}

?>

<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Test</title>
    <link rel="stylesheet" href="styles/test.css">
</head>
<body>

<!-- Если пользователь находиться на тесте, ссылка введет на страницу с тестами, если пользователь отправил тест на проверку и видит результаты, то возвращает на страницу с тестом -->

<a href="<?php echo isset($_POST['check-test']) ? $_SERVER['HTTP_REFERER'] : 'list.php' ?>"><div>&lt; Назад</div></a><br>

<!-- Если передан номер теста в GET-запросе и пользователь еще не нажал на кнопку проверки теста, то выводить тест -->

<?php if (isset($_GET['number']) && !isset($_POST['check-test'])): ?>
    <form method="POST">
        <h1><?php echo basename($requiredTest); ?></h1>
        <?php foreach ($test as $key => $item): ?>
            <fieldset>
                <div class="on-hidden-radio"></div>
                <input type="radio" name="answer<?php echo $key ?>" id="hidden-radio" required>
                <legend><?php echo $item['question'] ?></legend>
                <label><input type="radio" name="answer<?php echo $key ?>" value="0"><?php echo $item['answers'][0] ?>
                </label><br>
                <label><input type="radio" name="answer<?php echo $key ?>" value="1"><?php echo $item['answers'][1] ?>
                </label><br>
                <label><input type="radio" name="answer<?php echo $key ?>" value="2"><?php echo $item['answers'][2] ?>
                </label><br>
                <label><input type="radio" name="answer<?php echo $key ?>" value="3"><?php echo $item['answers'][3] ?>
                </label>
            </fieldset>
        <?php endforeach; ?>
        <input type="submit" name="check-test" value="Проверить">
    </form>
<?php endif; ?>

<!-- Если пользователь нажал на кнопку проверки теста, то выводить ему результаты -->

<?php if (isset($_POST['check-test'])): ?>
    <div class="check-test">
        <?php checkTest($test) ?>
        <p style="font-weight: bold;">Итого правильных ответов: <?php echo "$correctAnswers из $totalAnswers" ?></p>
        <h2>Ваш сертификат, <span style="font-style: italic;"><?php echo $username ?></span>: </h2>
        <form method="POST">
            <input type="submit" name="generate-picture" value="Сгенерировать">
            <?php foreach ($variables as $key => $variable): ?>
                <input type="hidden" value="<?php echo $variable ?>" name="<?php echo $key ?>">
            <?php endforeach; ?>
        </form>
    </div>
<?php endif; ?>

</body>
</html>
