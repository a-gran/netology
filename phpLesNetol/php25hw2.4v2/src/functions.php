<?php

// Проверка теста, вывод ответа пользователя и правильного ответа
function checkTest($testFile)
{

    // Проверяем, решены ли все задания
    foreach ($testFile as $key => $item) {
        if (!isset($_POST['answer' . $key])) {
            echo 'Должны быть решены все задания!';
            die;
        }
    }

    // Проверяем тест
    foreach ($testFile as $key => $item) {

        // Здесь идет определение названия класса для блока с вопросом и ответом, чтобы выводить красный/зеленый фон для удобства
        // А также прибавляется 1 к переменной $i, если ответ правильный
        if ($item['correct_answer'] === $_POST['answer' . $key]) {
            $infoStyle = 'correct';
        } else {
            $infoStyle = 'incorrect';
        }

        // Вывод блока с вопросом и ответом
        echo '<div class=' . $infoStyle . '>' .
            'Вопрос: ' . $item['question'] . '<br>' .
            'Ваш ответ: ' . $item['answers'][$_POST['answer' . $key]] . '<br>' .
            'Правильный ответ: ' . $item['answers'][$item['correct_answer']] . '<br>' .
            '</div>' .
            '<hr>';
    }
}

// Счетчик правильных ответов в тесте
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


// Проверка файла перед загрузкой
function checkUploadedFile($file)
{

    $uploadfile = 'tests/' . basename($file['name']);
    $allFiles = !empty(glob('tests/*.json')) ? glob('tests/*.json') : $allFiles = [];

    if (pathinfo($file['name'], PATHINFO_EXTENSION) !== 'json') {
        return [
            'classname' => 'error',
            'message' => 'Можно загружать файлы только с расширением json!'
        ];
    } else if ($file["size"] > 1024 * 1024 * 1024) {
        return [
            'classname' => 'error',
            'message' => 'Размер файла превышает три мегабайта!'
        ];
    } else if (in_array($uploadfile, $allFiles, true)) {
        return [
            'classname' => 'error',
            'message' => 'Файл с таким именем уже существует!'
        ];
    } else if (move_uploaded_file($file['tmp_name'], $uploadfile)) {
        return [
            'classname' => 'success',
            'message' => 'Файл корректен и успешно загружен на сервер'
        ];
    } else {
        return [
            'classname' => 'error',
            'message' => 'Произошла ошибка'
        ];
    }
}

// Отображает все загруженные тесты
function dispayAllTests($allTests)
{
    $i = 0;
    while ($i < count($allTests)) {
        if (in_array($allTests[$i], $allTests, true)) {
            echo '<div class="file-block">';
            echo '<h1>' . str_replace('tests/', '', $allTests[$i]) . '</h1><br>';
            echo '<em>Загружен: ' . date("d-m-Y H:i", filemtime($allTests[$i])) . '</em><br>';
            echo '<a href="test.php?number=' . array_search($allTests[$i], $allTests) . '">Перейти на страницу с тестом &blacktriangleright;</a><br>';
            if (isAuthorized()) {
                echo '<form method="POST">';
                echo "<input type=\"hidden\" name=\"path\" value=\"$allTests[$i]\">";
                echo '<input type="submit" name="del" value="Удалить тест" class="del">';
                echo '</form>';
            }
            echo '</div>';
            echo '<hr>';
            $i++;
        }
    }
}

function login($login, $password)
{
    $users = getUsers();
    foreach ($users as $user) {
        if ($user['login'] == $login && $user['password'] == $password) {
            unset($user['password']);
            $_SESSION['user'] = $user;
            return true;
        }
    }
    return false;
}

function getUsers()
{
    $path = __DIR__ . '/users.json';
    $fileData = file_get_contents($path);
    $data = json_decode($fileData, true);
    if (!$data) {
        return [];
    }
    return $data;
}

function getLoggedUserData()
{
    if (!isset($_SESSION['user'])) {
        return null;
    }
    return $_SESSION['user'];
}

function isAuthorized()
{
    return (getLoggedUserData() !== null);
}

function getQuestUserData()
{
    if (!isset($_SESSION['quest'])) {
        return null;
    }
    return $_SESSION['quest'];
}

function isQuest()
{
    return getQuestUserData() !== null;
}

function location($path)
{
    header("Location: $path");
    die;
}

function isPOST()
{
    return $_SERVER['REQUEST_METHOD'] === 'POST';
}

function logout()
{
    session_destroy();
    location('../index.php');
}

function delTest($files)
{
    $path = $_POST['path'];
    if (file_exists($path)) {
        unlink($path);
    }
    unset($files[array_search($path, $files, true)]);
    return glob('tests/*.json');
}

function generateCode()
{
    $chars = 'abdefhknrstyz23456789';
    $length = rand(4, 6);
    $numChars = strlen($chars);
    $str = '';
    for ($i = 0; $i < $length; $i++) {
        $str .= substr($chars, rand(1, $numChars) - 1, 1);
    }
    return $str;
}

function imgCode($code) // $code - код нашей капчи, который мы укажем при вызове функции
{

    header('Content-type: image/png');

    $font = '../fonts/OpenSans.ttf';

    $im = imagecreatetruecolor(200, 50);
    $bg = imagecolorallocate($im, mt_rand(0, 100), mt_rand(0, 100), mt_rand(0, 100));
    imagefill($im, 0, 0, $bg);

    $x = mt_rand(0, 35);
    for($i = 0; $i < strlen($code); $i++) {
        $x+=mt_rand(15, 25);
        $fontSize = mt_rand(20, 30);
        $color = imagecolorallocate($im, mt_rand(100, 200), mt_rand(100, 200), mt_rand(100, 200));
        $letter = substr($code, $i, 1);
        imagettftext($im, $fontSize, mt_rand(2, 10  ), $x, mt_rand(30, 40), $color, $font, $letter);
    }

    imagepng($im);
    imagedestroy($im);
}

function checkCaptcha($userCaptcha, $cookieCaptcha) {

    $userCaptcha = strtolower(trim($userCaptcha));
    $userCaptcha = md5($userCaptcha);

    return $userCaptcha === $cookieCaptcha;
}

function banUser() {
    setcookie('ban', 'banned', time() + 10, '/', $_SERVER['HTTP_HOST']);
    session_destroy();
}

