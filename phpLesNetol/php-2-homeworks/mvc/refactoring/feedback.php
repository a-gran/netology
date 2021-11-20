<?php

$success = false;
$email = null;
$name = null;
$message = null;
if (count($_POST)) {
    $email = strlen($_POST['email']) ? htmlspecialchars($_POST['email'], ENT_QUOTES, 'UTF-8') : null;
    $name = strlen($_POST['name']) ? htmlspecialchars($_POST['name'], ENT_QUOTES, 'UTF-8') : null;
    $message = strlen($_POST['message']) ? htmlspecialchars($_POST['message'], ENT_QUOTES, 'UTF-8') : null;
    $success =
        $email !== null
        && $message !== null
        && $name !== null
        && mb_strlen($message) > 10
        && mb_strlen($name) > 3
        && countMessages($email) <= 3;
}

function countMessages($email) {
    $count = 0;
    if (file_exists('./messages.csv')) {
        $handler = fopen('./messages.csv', 'r');

        while (($row = fgetcsv($handler, 1000)) !== false) {
            if ($row[1] === $email) {
                $count++;
            }
        }
        fclose($handler);
    }

    return $count;
}

?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <title>Форма обратной связи</title>
    <link href="/style.css" rel="stylesheet">
</head>
<body>

<div class="form-container">
    <?php if ($success === true) {

        $handler = fopen('./messages.csv', 'a');
        if ($handler === false) {
            echo '<span class="error">Ничего не получилось!</span>';
        }

        $result = fputcsv($handler, [date('Y-m-d H:i'), $email, $name, $message]);
        fclose($handler);
        if ($result === false) {
            echo '<span class="error">Ничего не получилось!</span>';
        }

        echo '<span class="success">Спасибо за обращение!</span>';
    } else { ?>
        <form class="feedback" method="POST">
            <h1>Оставьте ваше сообщение</h1>
            <h2>Все что вы напишите очень важно для нас!</h2>
            <fieldset>
                <textarea name="message" placeholder="Поделитесь здесь всем, что думаете..." autofocus><?=$message?></textarea>
                <?php if ($message !== null && mb_strlen($message) <= 10) {?>
                    <span class="notice">Количество символов должно быть больше 10!</span>
                <?php } ?>
            </fieldset>
            <fieldset>
                <input name="name" placeholder="Ваше имя" type="text" value="<?=$name?>" autofocus>
                <?php if ($name === null) {?>
                    <span class="notice">Введите имя!</span>
                <?php } if ($name !== null && mb_strlen($name) <= 3) {?>
                    <span class="notice">Количество символов должно быть больше 3!</span>
                <?php } ?>
                <input name="email" placeholder="Адрес электронной почты (обязательно)" type="email" value="<?=$email?>" required>
                <?php if ($email !== null && $message !== null && $name !== null && mb_strlen($message) > 10 && mb_strlen($name) > 3) {

                    if (countMessages($email) > 3) {
                        echo '<span class="notice">Лимит сообщений привышен!!!</span>';
                    }
                } ?>
            </fieldset>
            <fieldset>
                <input type="submit" value="Отправить">
            </fieldset>
        </form>
    <?php } ?>
</div>

</body>
</html>
