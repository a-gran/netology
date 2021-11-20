<?php

use models\Auth\Auth;

require_once __DIR__ . '/src/core.php';

$auth = new Auth;
if (!$auth->isAuth()) {
    header('Location: auth.php');
}

$task = new models\Tasks\Task;
$tasksOfUser = $task->getTasksOfUser();
$tasksForUser = $task->getTasksForUser();

$user = new models\Users\User;
$users = $user->getAllUsers();

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="web/style/style.css">
    <title>TODO</title>
</head>
<body>
<div id="wrap">
    <a class="logout" href=".">&larr; Выйти</a>
    <div class="tasks">
        <?php if ($tasksOfUser->rowCount() === 0): ?>
            <p class="smile">&#9785;</p>
            <p class="tasksNotExist"><?php echo $_SESSION['user']; ?>, вы пока не добавили ни одной задачи</p>
        <?php else: ?>
            <form method="POST" class="sortForm">
                <div>
                    <label>
                        Сортировать по:
                        <select name="sortBy" id="sortBy">
                            <option value="date">Дате добавления</option>
                            <option value="status">Статусу</option>
                            <option value="description">Описанию</option>
                        </select>
                    </label>
                    <input type="submit" name="sort" id="sort" value="Сортировка">
                </div>
                <h2 class="nickname"><?php echo $_SESSION['user']; ?>, это задачи, созданные вами</h2>
            </form>

            <table class="tasksOfUser">
                <tr>
                    <td>Задача</td>
                    <td>Автор</td>
                    <td>Исполнитель</td>
                    <td>Статус</td>
                    <td>Дата добавления</td>
                    <td>Действия</td>
                </tr>
                <?php foreach ($tasksOfUser as $theTask): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($theTask['description']) ?></td>
                        <td>Вы</td>
                        <td><?php echo $theTask['assigned_user_login'] == $_SESSION['user'] ? 'Вы' : htmlspecialchars($theTask['assigned_user_login']) ?></td>
                        <?php echo htmlspecialchars($theTask['is_done']) ? '<td style="color: green">Выполнено</td>' : '<td style="color: orange">В процессе</td>' ?>
                        <td><?php echo htmlspecialchars($theTask['date_added']) ?></td>
                        <td>
                            <p class='edit link'>Изменить &#9998;</p>
                            <?php if (!$theTask['is_done']): ?>
                                <p class='is_done_changer link'>Выполнить &#10004;</p>
                            <?php else: ?>
                                <p class='is_done_changer link'>Не выполнить X</p>
                            <?php endif; ?>
                            <p class='delete link'>Удалить &cross;</p>
                            <form method="POST" class="changeAssignedUser">
                                <label>
                                    <input type="submit" value="Сменить исполнителя" name="changeAssignedUser">
                                    <select name="assignedUser">
                                        <?php foreach ($users as $theUser): ?>
                                            <option value="<?php echo htmlspecialchars($theUser['id']) ?>"><?php echo htmlspecialchars($theUser['login']) ?>
                                        <?php endforeach; ?>
                                    </select>
                                </label>
                            </form>
                            <input type="hidden" value="<?php echo $theTask['id'] ?>">
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php endif; ?>
    </div>

    <div class="tasksForYou">
        <?php if ($tasksForUser->rowCount() === 0): ?>
            <p class="smile">&#9785;</p>
            <p class="tasksNotExist"><?php echo $_SESSION['user']; ?>, для вас пока не добавили ни одной задачи</p>
        <?php else: ?>
            <h2>А это задачи, созданные другими пользователями для вас:</h2>
            <table class="tasksForUser">
                <tr>
                    <td>Задача</td>
                    <td>Автор</td>
                    <td>Исполнитель</td>
                    <td>Статус</td>
                    <td>Дата добавления</td>
                    <td>Действия</td>
                </tr>
                <?php foreach ($tasksForUser as $theTask): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($theTask['description']) ?></td>
                        <td><?php echo htmlspecialchars($theTask['user_login']) ?></td>
                        <td>Вы</td>
                        <?php echo htmlspecialchars($theTask['is_done']) ? '<td style="color: green">Выполнено</td>' : '<td style="color: orange">В процессе</td>' ?>
                        <td><?php echo htmlspecialchars($theTask['date_added']) ?></td>
                        <td>
                            <p class='edit link'>Изменить &#9998;</p>
                            <?php if (!$theTask['is_done']):?>
                                <p class='is_done_changer link'>Выполнить &#10004;</p>
                            <?php else: ?>
                                <p class='is_done_changer link'>Не выполнить X</p>
                            <?php endif; ?>
                            <p class='delete link'>Удалить &cross;</p>
                            <input type="hidden" value="<?php echo $theTask['id'] ?>">
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php endif; ?>
    </div>

    <div class="forms">
        <form method="POST" class="addTaskForm">
            <textarea name="task" placeholder="Задача" id="task" cols="50" rows="3" required></textarea>
            <input type="submit" name="addTask" value="Добавить задачу" class="button">
        </form>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="http://code.jquery.com/color/jquery.color-2.1.2.min.js"></script>
<script src="web/js/index.js"></script>

</body>
</html>
