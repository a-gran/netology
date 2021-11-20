<?php

namespace models\Auth;

use models\ConnectDB;

class Auth extends ConnectDB
{

    private $salt = 'Twcv%4423ewfCWe';

    public function isAuth()
    {
        return ($this->getLoggedUserData() !== null);
    }

    public function getUsers()
    {
        $pdo = $this->connectToDb();
        $query = "SELECT `login`, `password` FROM `user`";
        $statement = $this->sendQueryToDb($pdo, $query);
        if ($statement->rowCount() === 0) return [];
        return $statement->fetchAll();
    }

    public function register($login, $password)
    {
        $pdo = $this->connectToDb();
        $password = md5($password . $this->salt);
        $query = "INSERT INTO `user` (`login`, `password`) VALUES (?, ?)";
        $this->sendQueryToDb($pdo, $query, [$login, $password]);
        return true;
    }

    public function isUserAlreadyExist($login)
    {
        $pdo = $this->connectToDb();

        $query = "SELECT login FROM `user` WHERE login = ?";

        $statement = $this->sendQueryToDb($pdo, $query, [$login]);
        if ($statement->rowCount() > 0) return true;
        return false;
    }

    public function login($login, $password)
    {
        $users = $this->getUsers();
        foreach ($users as $user) {
            if ($user['login'] === $login && $user['password'] === md5($password . $this->salt)) {
                unset($user['password']);
                $_SESSION['user'] = $user['login'];
                return true;
            }
        }
        return false;
    }

    public function getLoggedUserData()
    {
        if (!isset($_SESSION['user'])) {
            return null;
        }
        return $_SESSION['user'];
    }

    public function logout()
    {
        session_destroy();
        return ["location" => "auth.php"];
    }
}