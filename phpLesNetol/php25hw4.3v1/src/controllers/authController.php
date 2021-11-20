<?php

session_start();

require_once __DIR__ . '/../autoload.php';

$auth = new models\Auth\Auth;

function isInputCorrect($login, $password)
{
    if (empty($login) || empty($password)) {
        $answer['error'] = 'Логин или пароль не введены';
        echo json_encode($answer);
        die;
    }
}

if (!empty($_POST['getNickname'])) {
    echo $_SESSION['user'];
}

if (!empty($_POST['authButton'])) {

    isInputCorrect($_POST['login'], $_POST['password']);

    $login = $_POST['login'];
    $password = $_POST['password'];

    if ($auth->login($login, $password)) {
        echo json_encode(['location' => 'index.php']);
    } else {
        $answer['error'] = 'Неправильный логин или пароль';
        echo json_encode($answer);
        die;
    };
}

if (!empty($_POST['logout'])) {
    echo json_encode($auth->logout());
}

if (!empty($_POST['regButton'])) {

    isInputCorrect($_POST['login'], $_POST['password']);

    $login = $_POST['login'];
    $password = $_POST['password'];

    if ($auth->isUserAlreadyExist($login)) {
        $answer['error'] = 'Такой пользователь уже существует';
        echo json_encode($answer);
        die;
    }

    if ($auth->register($login, $password)) {
        $answer['notice'] = 'Теперь войдите, используя указанные данные';
        echo json_encode($answer);
    }
}