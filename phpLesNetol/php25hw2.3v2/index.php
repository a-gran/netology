<?php

// Если был получен POST-запрос с файлом, то проверяем, подходит ли он
if (isset($_POST['upload'])) {

    // Редирект на страницу с тестами через три секунды
    header('refresh:3; url=list.php');

    // Определяем массив со всеми файлами из папки с тестами
    if (!empty(glob('tests/*.json'))) {
        $allFiles = glob('tests/*.json');
    } else {
        $allFiles = [0];
    }

    // Определяем загружаемый файл
    $uploadfile = 'tests/' . basename($_FILES['testfile']['name']);

    // Прогоняем файл по if'ам, если не подходит - выкидываем ошибку
    if (pathinfo($_FILES['testfile']['name'], PATHINFO_EXTENSION) !== 'json') {
        $result = "<p class='error'>Необходим файл с расширением .json</p>";
    } else if ($_FILES["testfile"]["size"] > 1024 * 1024 * 1024) {
        $result = "<p class='error'>Размер файла превышает три мегабайта</p>";
    } else if (in_array($uploadfile, $allFiles, true)) {
        $result = "<p class='error'>Файл с таким именем уже существует.</p>";
    } else if (move_uploaded_file($_FILES['testfile']['tmp_name'], $uploadfile)) {
        $result = "<p class='success'>Файл корректен и успешно загружен на сервер</p>";
    } else {
        $result = "<p class='error'>Ошибка!</p>";
    }
}

?>

<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Тестирование</title>
    <link rel="stylesheet" href="styles/admin.css">
</head>
<body>

<!-- Если файл был отправлен, то выводить информацию о файле и уведомление об успешной загрузке/ошибке -->

<?php if (isset($_POST['upload'])): ?>
    <a href="<?php $_SERVER['HTTP_REFERER'] ?>"><div>&lt; Назад</div></a>
    <?php echo $result; ?><br>
    <h1>Вы будете перенаправлены на страницу с тестами...</h1>
<?php endif; ?>

<!-- Пока файл или форма теста не была отправлена, выводить форму загрузки и форму создания теста -->

<?php if (!isset($_POST['create']) && !isset($_POST['upload'])): ?>

    <form id="load-json" method="POST" enctype="multipart/form-data">
        <fieldset>
            <legend>Загрузите свой тест в формате .json</legend>
            <input type="file" name="testfile" id="uploadfile" required>
            <input type="submit" value="Добавить в базу" id="submit-upload" name="upload">
        </fieldset>
    </form>

    <div class="all-tests">
        <fieldset>
            <a href="list.php">Посмотреть все тесты >></a>
        </fieldset>
    </div>

<?php endif; ?>

</body>
</html>