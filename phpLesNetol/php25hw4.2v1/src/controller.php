<?php

require_once 'Task.php';

if (!empty($_POST['addTask'])) {
    $task->addTask();
    echo $task->getLastTask();
}

if (!empty($_POST['done'])) {
    echo $task->setTaskIsDone() ? 'Выполнено' : 'В процессе';
}

if (!empty($_POST['delete'])) {
    $task->deleteTask();
}

if (!empty($_POST['editDescription'])) {
    echo $task->editTask();
}

if (!empty($_POST['sortBy'])) {
    $table = new TaskTable;
    echo $table->sortTable($_POST['sortBy']);
}