<?php

namespace models\Tasks;

class TaskTable extends Task
{
    public function sortTable($sortingType)
    {
        $pdo = $this->connectToDb();

        $query = "
SELECT t.id,
user_id, 
assigned_user_id, 
description, 
u1.login AS user_login, 
u2.login AS assigned_user_login, 
is_done, 
date_added
FROM task t
JOIN user u1 ON t.user_id = u1.id
JOIN user u2 ON t.assigned_user_id = u2.id
";

        switch ($sortingType) {
            case 'date':
                $query = $query . "ORDER BY date_added ASC";
                break;
            case 'status':
                $query = $query . "ORDER BY is_done ASC";
                break;
            case 'description':
                $query = $query . "ORDER BY description ASC";
                break;
            default:
                die('Произошла ошибка сортировки, попробуйте еще раз');
        }

        $result = $this->sendQueryToDb($pdo, $query)->fetchAll();
        return json_encode($result);
    }
}