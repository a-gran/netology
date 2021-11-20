<?php

function checkTest($testFile)
{
    foreach ($testFile as $key => $item) {
        if (!isset($_POST['answer' . $key])) {
            echo 'Задания не выполнены!';
            exit;
        }
    }

    foreach ($testFile as $key => $item) {
        if ($item['correct_answer'] === $_POST['answer' . $key]) {
            $description = 'correct';
        } else {
            $description = 'incorrect';
        }
        echo '<div class=' . $description . '>' .
            'Вопрос: ' . $item['question'] . '<br>' .
            'Ответ: ' . $item['answers'][$_POST['answer' . $key]] . '<br>' .
            'Верный ответ: ' . $item['answers'][$item['correct_answer']] . '<br>' .
            '</div>' .
            '<hr>';
    }
}

$allTests = glob('tests/*.json');
$number = $_GET['number'];
$test = file_get_contents($allTests[$number]);
$test = json_decode($test, true);

if (!isset(glob('tests/*.json')[$_GET['number']])) {
    header($_SERVER['SERVER_PROTOCOL'] . ' 404 Not Found');
    exit;
}

if (!isset($_GET['number'])) {
    header('Location: list.php');
    exit;
}

function answersCounter($testFile)
{
    $i = 0;
    $questions = 0;

    foreach ($testFile as $key => $item) {
        $questions++;
        if ($item['correct_answer'] === $_POST['answer' . $key]) {
            $i++;
        }
    }
    return ['correct' => $i, 'total' => $questions];
}

if (isset($_POST['check-test'])) {
    $testname = basename($allTests[$number]);
    $username = str_replace(' ', '', $_POST['username']);
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

if (isset($_POST['generate-picture'])) {
    include_once 'create-picture.php';
}

?>

<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Тестирование</title>
    <link rel="stylesheet" href="styles/test.css">
</head>
<body>

<a href="<?php echo isset($_POST['check-test']) ? $_SERVER['HTTP_REFERER'] : 'list.php' ?>"><div>&lt; Назад</div></a><br>

<?php if (!isset($_POST['check-test'])): ?>
    <form method="POST">
        <h1><?php echo basename($allTests[$number]); ?></h1>
        <label>Введите ваше имя: <input type="text" name="username" required></label>
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

<?php if (isset($_POST['check-test'])): ?>
    <div class="check-test">
        <?php checkTest($test) ?>
        <p style="font-weight: bold;">Итого правильных ответов: <?php echo "$correctAnswers из $totalAnswers" ?></p>
        <h2>Вы можете сгенерировать сертификат, <?php echo $username ?>: </h2>
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
