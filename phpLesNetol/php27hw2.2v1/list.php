<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

$allFiles = glob('tests/*.json');
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
    <a href="admin.php" class="back"><div><<< Назад</div></a>
    <hr>

    <?php if (!empty($allFiles)): ?>
        <?php foreach ($allFiles as $test): ?>

            <div class="file-block">
                <h1><?php echo str_replace('tests/', '', $test); ?></h1><br>
                <em>Загружен: <?php echo date("d-m-Y H:i", filemtime($test)) ?></em><br>
                <a href="test.php?number=<?php echo array_search($test, $allFiles); ?>">Перейти к тесту ></a>
            </div>
            <hr>

        <?php endforeach; ?>
    <?php endif; ?>
    <?php if (empty($allFiles)) echo 'Тест не загружен';?>

</body>
</html>