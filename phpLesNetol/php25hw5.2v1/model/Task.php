<?php

class Task
{
		private $pdo = null;

		public function __construct($pdo) {
				$this->pdo = $pdo;
		}
		public function registration($params) {
				$sql = "INSERT INTO user (login, password) VALUES (?, ?)";
				$statement = $this->pdo->prepare($sql);
				$statement->bindValue(1, $params['login'], PDO::PARAM_INT);
				$statement->bindValue(2, $params['password'], PDO::PARAM_INT);
				return $statement->execute();
		}

		public function authorization($params) {
				$sql = "SELECT * FROM user WHERE login = ? AND password = ?";
				$statement = $this->pdo->prepare($sql);
				$statement->bindValue(1, $params['login'], PDO::PARAM_INT);
				$statement->bindValue(2, $params['password'], PDO::PARAM_INT);
				if ($statement->execute()) {
					 $user = $statement->fetch(PDO::FETCH_ASSOC);
					 return $user;
				}
		}

		public function edit($params) {
				$sql = "UPDATE task SET description = ? WHERE id = ?";
				$statement = $this->pdo->prepare($sql);
				$statement->bindValue(1, $params['description'], PDO::PARAM_STR);
				$statement->bindValue(2, $params['id'], PDO::PARAM_INT);
				return $statement->execute();
		}

		public function done($params) {
				$sql = "UPDATE task SET is_done = 1 WHERE id = ?";
				$statement = $this->pdo->prepare($sql);
				$statement->bindValue(1, $params['id'], PDO::PARAM_INT);
				return $statement->execute();
		}

		public function delete($params) {
				$sql = "DELETE FROM task WHERE id = ?";
				$statement = $this->pdo->prepare($sql);
				$statement->bindValue(1, $params['id'], PDO::PARAM_INT);
				return $statement->execute();
		}

		public function insert($params) {
				$sql = "INSERT INTO  task (description, date_added, assigned_user_id, user_id) VALUES (?, ?, ?, ?)";
				$statement = $this->pdo->prepare($sql);
				$statement->bindValue(1, $params['description'], PDO::PARAM_STR);
				$statement->bindValue(2, $params['date_added'], PDO::PARAM_STR);
				$statement->bindValue(3, $params['assigned_user_id'], PDO::PARAM_INT);
				$statement->bindValue(4, $params['user_id'], PDO::PARAM_INT);
				return $statement->execute();
		}

		public function setAssigned($params) {
				$sql = "UPDATE task SET assigned_user_id = ? WHERE id = ?";
				$statement = $this->pdo->prepare($sql);
				$statement->bindValue(1, $params['assigned_user_id'], PDO::PARAM_INT);
				$statement->bindValue(2, $params['id_description'], PDO::PARAM_INT);
				return $statement->execute();
		}

		public function sort($params) {
				$sql = "SELECT *, task.id AS id_description, user.login AS user_login FROM task 
				INNER JOIN user ON task.user_id=user.id 
				INNER JOIN user AS us ON task.assigned_user_id=us.id 
				ORDER BY {$params['sort_by']} ASC";
				$statement = $this->pdo->prepare($sql);
				if ($statement->execute()) {
						return $statement->fetchAll(PDO::FETCH_ASSOC);
				}
		}

		public function sortDefault() {
				$sql = "SELECT *, task.id AS id_description, user.login AS user_login FROM task 
				INNER JOIN user ON task.user_id=user.id 
				INNER JOIN user AS us ON task.assigned_user_id=us.id";
				$statement = $this->pdo->prepare($sql);
				if ($statement->execute()) {
						return $statement->fetchAll(PDO::FETCH_ASSOC);
				}
		}

		public function selectUsers() {
				$sqlUsers = "SELECT * FROM user";
				$statementUsers = $this->pdo->prepare($sqlUsers);
				if ($statementUsers->execute()) {
						return $statementUsers->fetchAll(PDO::FETCH_ASSOC);
				}
		}

		public function selectMyTasks($params) {
				$sqlMyList = "SELECT *, task.id AS id_description, user.login AS user_login FROM task 
				INNER JOIN user ON task.user_id=user.id 
				INNER JOIN user AS us ON task.assigned_user_id=us.id
				WHERE assigned_user_id = ?";
				$statementMyList = $this->pdo->prepare($sqlMyList);
				$statementMyList->bindValue(1, $params['userID'], PDO::PARAM_INT);
				if ($statementMyList->execute()) {
						return $statementMyList->fetchAll(PDO::FETCH_ASSOC);
				}
		}
}
