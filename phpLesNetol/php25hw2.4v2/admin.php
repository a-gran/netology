<?php

require_once 'src/core.php';

if (!isAuthorized() && !isQuest()) {
    location('index.php');
}

if (isset($_POST['upload'])) {

    // Редирект на страницу с тестами через три секунды
    header('refresh:3; url=list.php');

    $file = $_FILES['testfile'];
    $uploadResult = checkUploadedFile($file);
}

?>
<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="styles/admin.css">
</head>
<body>

<!-- Если файл был отправлен, то выводить информацию о файле и уведомление об успешной загрузке/ошибке -->

<?php if (isset($_POST['upload'])): ?>
    <a href="<?php $_SERVER['HTTP_REFERER'] ?>"><div>&lt; Назад</div></a>
    <p class="<?php echo $uploadResult['classname'] ?>"><?php echo $uploadResult['message']; ?></p><br>
    <h1>Перенаправление на страницу с тестами...</h1>
<?php endif; ?>

<!-- Пока файл или форма теста не была отправлена, выводить форму загрузки и форму создания теста -->

<?php if (!isset($_POST['upload'])): ?>
    <a href="src/logout.php" class="back"><div>&lt; Разлогиниться</div></a>
    <!-- Если пользователь зашел как гость, то запретить загружать тесты -->

    <?php if (isAuthorized()): ?>
        <h1>Здравствуй, <span style="font-style: italic;"><?php echo $_SESSION['user']['name'] ?> (admin)</span></h1>
        <form id="load-json" method="POST" enctype="multipart/form-data">
            <fieldset>
                <legend>Загрузка теста в формате json</legend>
                <input type="file" name="testfile" id="uploadfile" required>
                <input type="submit" value="Добавить в базу" id="submit-upload" name="upload">
            </fieldset>
        </form>
    <?php endif; ?>

    <?php if (isQuest()): ?>
        <h1>Здравствуй, <span style="font-style: italic;"><?php echo $_SESSION['quest']['username'] ?> (quest)</span></h1>
    <?php endif; ?>
        <div class="all-tests">
            <fieldset>
                <a href="list.php">Посмотреть все тесты</a>
            </fieldset>
        </div>

<?php endif; ?>

</body>
</html>