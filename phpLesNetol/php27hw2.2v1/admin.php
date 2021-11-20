<?php

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

if (isset($_POST['upload'])) {

    if (!empty(glob('tests/*.json'))) {
        $allFiles = glob('tests/*.json');
    } else {
        $allFiles = [0];
    }

    $uploadTest = 'tests/' . basename($_FILES['testFile']['name']);

    if (pathinfo($_FILES['testFile']['name'], PATHINFO_EXTENSION) !== 'json') {
        $output = "<p class='error'>Необходим файл с расширением json</p>";
    } else if (in_array($uploadTest, $allFiles, true)) {
        $output = "<p class='error'>Имя файла занято</p>";
    } else if (move_uploaded_file($_FILES['testFile']['tmp_name'], $uploadTest)) {
        $output = "<p class='success'>Файл загружен</p>";
    } else {
        $output = "<p class='error'>Ошибка!</p>";
    }
}

?>

<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Test</title>
</head>
<body>

<?php if (isset($_POST['upload'])): ?>
    <a href="<?php $_SERVER['HTTP_REFERER'] ?>"><div>< Назад</div></a>
    <?php echo $output; ?>
    <h1>Техническая информация:</h1>
    <pre>
        <?php print_r($allFiles); ?>
        <hr>
        <?php print_r($_FILES); ?>
    </pre>
<?php endif; ?>

<?php if (!isset($_POST['create']) && !isset($_POST['upload'])): ?>

    <form id="load-json" method="POST" enctype="multipart/form-data">
        <fieldset>
            <legend>Загрузите свой тест в формате json</legend>
            <input type="file" name="testFile" id="uploadTest" required>
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