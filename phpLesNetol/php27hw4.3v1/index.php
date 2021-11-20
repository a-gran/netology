<?php
include_once 'entrance.php';
?>

<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="styles.css">
    <title>Таблица</title>
</head>
<h1>Создание таблиц SQL</h1>
<?php
if (empty($_GET)) :?>
    <p>
    <form action="index.php" method="get">
        Создать таблицу
        <input type="text" name="name" placeholder="наименование таблицы"> на
        <input type="text" name="cols" placeholder="количество ячеек"> ячеек
        <input type="submit" value="Создать">
    </form></p>
<?php elseif (empty($_POST)) :
    $cols = (int)$_GET['cols'];
    $name = (string)strip_tags($_GET['name']); ?>
    <p>Наименование столбцов для таблицы <b><?= $name ?></b> и их парметры <br>
        Первый столбец устанавливается по-умолчанию и называется `id`</p>
    <form action="index.php?cols=<?= $cols ?>&name=<?= $name ?>" class="create-rows" method="post">
        <table>
            <?php
            for ($i = 0; $i < $cols; $i++) {
                echo '<tr><td><input type="text" placeholder="название столбца" name="col' . $i . '"></td> ';
                echo '<td><select name="param' . $i . '">';
                echo '<option value="int (10)">int (10)</option>';
                echo '<option value="varchar (50)">varchar (50)</option>';
                echo '</select></td></tr>';
            }
            ?>
        </table>
        <br>
        <input type="submit" value="Создать таблицу '<?= $name ?>' на <?= $cols ?> столбцов">
    </form>
    <p><a href="index.php">Отменить создание таблицы</a></p>
<?php endif; ?>
<p>Существующие таблицы:<br>
    <a href="index.php">Обновить</a></p>
<?php
if (!array_key_exists('tablename', $_GET)) {
    $sql = "Show TABLES";
    $showTable = $db->prepare($sql);
    $showTable->execute();
    $tables = $showTable->fetchAll(PDO::FETCH_ASSOC);
    foreach ($tables as $table) {
        $tableName = "Tables_in_" . DB_NAME;
        echo "<a href=\"tables.php?tablename={$table[$tableName]}\">" . $table[$tableName] . "</a><br>";
    }
}
?>
</body>
</html>