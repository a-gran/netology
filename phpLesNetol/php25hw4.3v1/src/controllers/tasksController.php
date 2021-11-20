<?php

session_start();

require_once __DIR__ . '/../autoload.php';

$task = new models\Tasks\Task;

if (!empty($_POST['addTask'])) {
    $task->addTask();
    echo $task->getLastTaskOfUser();
}

if (!empty($_POST['getAllUsers'])) {
    $user = new models\Users\User;
    echo json_encode($user->getAllUsers());
}

if (!empty($_POST['isDoneChange'])) {
    echo $task->changeTaskStatus();
}

if (!empty($_POST['delete'])) {
    $task->deleteTask();
}

if (!empty($_POST['editDescription'])) {
    echo $task->editTask();
}

if (!empty($_POST['sortBy'])) {
    $table = new models\Tasks\TaskTable;
    echo $table->sortTable($_POST['sortBy']);
}

if (!empty($_POST['changeAssignedUser'])) {
    if (empty($_POST['assignedUser'])) die;
    echo $task->changeAssignedUser($_POST['assignedUser']);
}