<?php

require_once 'src/Task.php';

?>

<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="styles.css">
    <title>TODO</title>
</head>
<body>
<div id="wrap">
    <div class="tasks">

        <?php if ($allTasks->rowCount() === 0): ?>
            <p class="smile">&#65039;</p>
            <p>Не добавлено ни одной задачи</p>
        <?php else: ?>

            <form method="POST" class="sortForm">
                <label>
                    Сортировать по:
                    <select name="sortBy" id="sortBy">
                        <option value="date">Дате добавления</option>
                        <option value="status">Статусу</option>
                        <option value="description">Описанию</option>
                    </select>
                </label>
                <input type="submit" name="sort" id="sort" value="Сортировка">
            </form>

            <table>
                <tr>
                    <td>Задача</td>
                    <td>Статус</td>
                    <td>Дата добавления</td>
                    <td>Действия</td>
                </tr>
                <?php foreach ($allTasks as $task): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($task['description']) ?></td>
                        <?php echo htmlspecialchars($task['is_done']) ? '<td>Выполнено</td>' : '<td>В процессе</td>' ?>
                        <td><?php echo htmlspecialchars($task['date_added']) ?></td>
                        <td>
                            <p class='edit link'>Изменить &#9997;</p>
                            <?php if (!$task['is_done']): ?>
                                <p class='done link'>Выполнить &10004; </p>
                            <?php endif; ?>
                            <p class='delete link'>Удалить &#10008; </p>
                            <input type="hidden" value="<?php echo $task['id'] ?>">
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
<script src="script.js"></script>

</body>
</html>
