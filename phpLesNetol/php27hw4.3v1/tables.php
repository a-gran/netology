<?php
require_once 'entrance.php';
if (array_key_exists('tablename', $_GET)) {
    $tableName = (string)strip_tags($_GET['tablename']);
    $location = "Location: tables.php?tablename={$tableName}";
    $sql = "DESCRIBE {$tableName};";
    $showTable = $db->prepare($sql);
    $showTable->execute();
    $result = $showTable->fetchAll(PDO::FETCH_ASSOC);
}
if (array_key_exists('addName', $_POST) && array_key_exists('addParam', $_POST)) {
    $newFieldName = (string)strip_tags($_POST['addName']);
    $newFieldParam = $_POST['addParam'];
    $sql = "ALTER TABLE {$tableName} ADD {$newFieldName} {$newFieldParam}";
    $add = $db->prepare($sql);
    $add->execute();
    header($location);
}
if (array_key_exists('action', $_GET)) {
    $field = (string)strip_tags($_GET['field']);
    if ($_GET['action'] == 'changename' && array_key_exists('newName', $_POST)) {
        $oldName = (string)strip_tags($_GET['field']);
        $newName = (string)strip_tags($_POST['newName']);
        $fieldParam = $_POST['param'];
        $sql = "ALTER TABLE {$tableName} CHANGE {$oldName} {$newName} {$fieldParam}";
        $updateName = $db->prepare($sql);
        $updateName->execute();
        header($location);
    }
    elseif ($_GET['action'] == 'changetype' && array_key_exists('name', $_POST)) {
        $fieldName = (string)strip_tags($_POST['name']);
        $newFieldType = (string)strip_tags($_POST['param']);
        $sql = "ALTER TABLE {$tableName} MODIFY {$fieldName} {$newFieldType}";
        $updateType = $db->prepare($sql);
        $updateType->execute();
        header($location);
    }
    elseif ($_GET['action'] == 'delete') {
        $sql = "ALTER TABLE {$tableName} DROP COLUMN {$field}";
        $delete = $db->prepare($sql);
        $delete->execute();
        header($location);
    }
}
?>

<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="styles.css">
    <title>Редактирование</title>
</head>
<body>
<h1>Редактирование "<?= (string)strip_tags($_GET['tablename']) ?>"</h1>
<?php
if (array_key_exists('action',$_GET) && $_GET['action'] == 'changename') :?>
<p>Введите новые параметры поля</p>
    <form action="tables.php?tablename=<?= $tableName ?>&field=<?= (string)strip_tags($_GET['field']) ?>&action=changename" method="post">
        <input type="text" name="oldName" value="<?= (string)strip_tags($_GET['field']) ?> ">
        <input type="text" name="newName" placeholder="новое имя столбца" ">
        <select name="param">
            <option value="int (10)">int (10)</option>';
            <option value="varchar (50)">varchar (50)</option>
        </select>
        <input type="submit"value="Изменить имя поля">
    </form><br>
<?php endif;?>
<?php
if (array_key_exists('action',$_GET) && $_GET['action'] == 'changetype') :?>
<p>Введите имя изменяемого поля и его новые параметры</p>
<form action="tables.php?tablename=<?= $tableName ?>&field=<?= (string)strip_tags($_GET['field']) ?>&action=changetype" method="post">
    <input type="text" name="name" value="<?= (string)strip_tags($_GET['field']) ?> ">
    <select name="param">
        <option value="int (10)">int (10)</option>';
        <option value="tinyint (5)">tinyint (5)</option>';
        <option value="varchar (50)">varchar (50)</option>
        <option value="float">float</option>
    </select>
    <input type="submit"value="Изменить имя поля">
</form><br>
<?php endif;?>
<table>
    <thead>
    <tr>
        <td>Field</td>
        <td>Type</td>
        <td>Null</td>
        <td>Key</td>
        <td>Default</td>
        <td>Extra</td>
    </tr>
    </thead>
    <tbody>
        <?php foreach ($result as $data) : ?>
            <tr>
                <td><?= $data['Field'] ?><br>
                    <a class="small" href="tables.php?tablename=<?= $tableName ?>&field=<?= $data['Field'] ?>&action=changename">изменить название</a><br>
                    <a class="small" href="tables.php?tablename=<?= $tableName ?>&field=<?= $data['Field'] ?>&action=changetype">изменить тип</a><br>
                    <a class="small" href="tables.php?tablename=<?= $tableName ?>&field=<?= $data['Field'] ?>&action=delete">удалить поле</a><br>
                </td>
                <td><?= $data['Type'] ?></td>
                <td><?= $data['Null'] ?></td>
                <td><?= $data['Key'] ?></td>
                <td><?= ($data['Default'] == null) ? 'NULL' : $data['Default'] ?></td>
                <td><?= $data['Extra'] ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table><br>
<form action="tables.php?tablename=<?= $tableName ?>" method="post">
    <input type="text" placeholder="имя поля" name="addName">
    <select name="addParam">
        <option value="int (10)">int (10)</option>';
        <option value="varchar (50)">varchar (50)</option>
    </select>
    <input type="submit" value="Добавить поле">
</form>
<p><a href="index.php">Создать новую таблицу или просмотреть существующие</a></p>
</body>
</html>