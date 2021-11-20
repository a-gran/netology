<?php
require_once 'core.php';
if (!isAuthorized())
{
    location('index');
}

$file_list = glob('db_tests/*.json');
foreach ($file_list as $key => $file) {
    if ($key == $_GET['test']) {
        unlink($file);
        location('list');
    }
}