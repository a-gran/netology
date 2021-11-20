<?php

    $allFiles = glob('tests/*.json');

?>

<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Тестирование</title>
    <link rel="stylesheet" href="styles/list.css">
</head>
<body>
    <a href="index.php" class="back"><div>&lt; Назад</div></a>
    <h2>Все тесты</h2>
    <hr>

    <?php if (!empty($allFiles)): ?>
        <?php foreach ($allFiles as $file): ?>

            <div class="file-block">
                <h1><?php echo str_replace('tests/', '', $file); ?></h1><br>
                <em>Загружен: <?php echo date("d-m-Y H:i", filemtime($file)) ?></em><br>
                <a href="test.php?number=<?php echo array_search($file, $allFiles); ?>">Перейти на страницу с тестом ></a>
            </div>
            <hr>

        <?php endforeach; ?>
    <?php endif; ?>

    <?php if (empty($allFiles)) echo 'Пока ничего не загружено';?>

</body>
</html>