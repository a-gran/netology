<?php

class Task
{

    protected $host = 'localhost';
    protected $dbname = 'shramko';
    protected $dbuser = 'shramko';
    protected $dbpassword = 'neto1716';

    // Подключение к базе данных
    protected function connectToDb()
    {
        try {
            $pdo = new PDO("mysql:host=$this->host;dbname=$this->dbname;charset=utf8", $this->dbuser, $this->dbpassword, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ]);
        } catch (PDOException $e) {
            die('Ошибка, соединение с базой не установлено!');
        }
        return $pdo;
    }

    // Запрос
    protected function sendQueryToDb($pdo, $query, $queryParams = [])
    {
        $statement = $pdo->prepare($query);
        try {
            $statement->execute($queryParams);
        } catch (PDOException $e) {
            die('Ошибка, запрос не выполнен!');
        }
        return $statement;
    }

    public function getAllTasks()
    {
        $pdo = $this->connectToDb();
        $query = "SELECT * FROM tasks";
        return $this->sendQueryToDb($pdo, $query);
    }

    public function addTask()
    {
        $pdo = $this->connectToDb();
        $query = "INSERT INTO tasks (description, date_added) VALUE (?, NOW())";
        $description = (string)(isset($_POST['task']) ? $_POST['task'] : "");
        $description = trim($description);
        if (!strlen($description)) {
            die('Задача не добавлена!');
        }

        return $this->sendQueryToDb($pdo, $query, [$description]);
    }

    public function getLastTask()
    {
        $pdo = $this->connectToDb();
        $query = "SELECT description, date_added, id FROM tasks ORDER BY id DESC LIMIT 1";
        $result = $this->sendQueryToDb($pdo, $query)->fetch(PDO::FETCH_ASSOC);
        $result = json_encode($result);
        return $result;
    }

    public function setTaskIsDone()
    {
        $pdo = $this->connectToDb();
        $query = "UPDATE tasks SET is_done = 1 WHERE id = ?";
        $id = (int)!empty($_POST['id']) ? $_POST['id'] : 0;
        $this->sendQueryToDb($pdo, $query, [$id]);
        return true;
    }

    public function deleteTask()
    {
        $pdo = $this->connectToDb();
        $query = "DELETE FROM tasks WHERE id = ?";
        $id = (int)!empty($_POST['id']) ? $_POST['id'] : 0;
        $this->sendQueryToDb($pdo, $query, [$id]);
    }

    public function editTask()
    {
        $pdo = $this->connectToDb();
        $query = "UPDATE tasks SET description = ? WHERE id = ?";
        $description = (string)!empty($_POST['editDescription']) ? $_POST['editDescription'] : 0;
        if (!trim($description) || strlen(trim($description)) === 0) {
            die('Задача не добавлена!');
        }
        $id = (int)!empty($_POST['id']) ? $_POST['id'] : 0;
        $this->sendQueryToDb($pdo, $query, [$description, $id]);
        return $description;
    }
}

class TaskTable extends Task
{
    public function sortTable($sortingType)
    {
        $pdo = $this->connectToDb();

        switch ($sortingType) {
            case 'date':
                $query = "SELECT * FROM tasks ORDER BY date_added ASC";
                break;
            case 'status':
                $query = "SELECT * FROM tasks ORDER BY is_done ASC";
                break;
            case 'description':
                $query = "SELECT * FROM tasks ORDER BY description ASC";
                break;
            default:
                die('Ошибка сортировки, попробуйте еще раз...');
        }

        $result = $this->sendQueryToDb($pdo, $query)->fetchAll();
        return json_encode($result);
    }
}

$task = new Task;
$allTasks = $task->getAllTasks();