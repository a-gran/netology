<?php
define('DB_DRIVER', 'mysql');
define('DB_HOST', 'localhost');
define('DB_NAME', 'shramko');
define('DB_USER', 'shramko');
define('DB_PASS', 'neto1716');

$connect_str = DB_DRIVER . ':host=' . DB_HOST . '; dbname=' . DB_NAME;
$db = new PDO($connect_str, DB_USER, DB_PASS);
if (!empty($_POST)) {
    $cols = (int)strip_tags($_GET['cols']);
    $name = (string)strip_tags($_GET['name']);
    $sql1 = "CREATE TABLE IF NOT EXISTS `{$name}` (
    `id` int NOT NULL AUTO_INCREMENT,";
    for ($i = 0; $i < $cols; $i++) {
        $col = 'col' . $i;
        $param = 'param' . $i;
        $sql2[$i] = ' ' . strip_tags($_POST[$col]) . ' ' . strip_tags($_POST[$param]) . ' NULL, ';
        
    }
    if (is_array($sql2)) {
        $sql2 = implode($sql2);
    }    
    $sql3 = "PRIMARY KEY (`id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
    $sql = $sql1 . $sql2 . $sql3;    
    $pleaseWork = $db->prepare($sql);
    $pleaseWork->execute();    
    $error_array = $db->errorInfo();
    if ($db->errorCode() != 0000) {
        echo "Ошибка базы данных: " . $error_array[2] . '<br>';
    }
}