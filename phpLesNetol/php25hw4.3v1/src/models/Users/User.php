<?php

namespace models\Users;

use models\ConnectDB;

class User extends ConnectDB
{
    public function getAllUsers()
    {
        $pdo = $this->connectToDb();

        $query = "SELECT id, login FROM `user`";

        return $this->sendQueryToDb($pdo, $query)->fetchAll();
    }
}