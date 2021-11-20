<?php

require_once './vendor/autoload.php';

class TaskController
{
		private $model = null;

		public function __construct($pdo) {
				include 'model/Task.php';
				$this->model = new Task($pdo);
		}

		public function editDescription($post, $get) {
				if (!empty($get['id']) && !empty($get['action']) && $get['action'] == 'edit' && !empty($post['description'])) {
						$isSet = $this->model->edit([
								'description' => $post['description'],
								'id' => $get['id']
						]);
						if ($isSet) {
								header('Location: ./index.php');
						}
				} 
		}

		public function doneDescription($get) {
				if (!empty($get['id']) && !empty($get['action']) && $get['action'] == 'done') {
						$isDone = $this->model->done([
								'id' => $get['id']
						]);
						if ($isDone) {
								header('Location: ./index.php');
						}
				}
		}

		public function deleteDescription($get) {
				if (!empty($get['id']) && !empty($get['action']) && $get['action'] == 'delete') {
						$isDelete = $this->model->delete([
								'id' => $get['id']
						]);
						if ($isDelete) {
								header('Location: ./index.php');
						}
				}
		}

		public function insertDescription($post, $userID) {
				if (!empty($post['description']) && empty($get['action'])) {
						$date = date('Y-m-d H:i:s');
						$isInsert = $this->model->insert([
								'description' => $post['description'],
								'date_added' => $date,
								'assigned_user_id' => $userID,
								'user_id' => $userID		
						]);
				}
		}

		public function setAssignedUser($post) {
				if (!empty($post['assign']) && !empty($post['assigned_user_id'])) {
						$isAssigned = $this->model->setAssigned([
								'assigned_user_id' => $post['assigned_user_id'],
								'id_description' => $post['id_description']
						]);
				}
		}

		public function sortDescription($post, $get, $userID, $userLogin) {
				if (!empty($post['sort']) && !empty($post['sort_by'])) {
						$tasks = $this->model->sort([
								'sort_by' => $post['sort_by']
						]);
						$users = $this->model->selectUsers();
						$myTasks = $this->model->selectMyTasks([
								'userID' => $userID
						]);
						$this->render([
								'tasks' => $tasks,
								'users' => $users,
								'myTasks' => $myTasks,
								'post' => $post,
								'get' => $get,
								'userID' => $userID,
								'user_login' => $userLogin
						]);
				}
		}

		public function sortDescriptionDefault($post, $get, $userID, $userLogin) {
				$tasks = $this->model->sortDefault();
				$users = $this->model->selectUsers();
				$myTasks = $this->model->selectMyTasks([
						'userID' => $userID
				]);
				$this->render([
						'tasks' => $tasks,
						'users' => $users,
						'myTasks' => $myTasks,
						'post' => $post,
						'get' => $get,
						'user_id' => $userID,
						'user_login' => $userLogin
				]);
		}


		private function render($params = []) {
				$loader = new Twig_Loader_Filesystem('./templates');
				$twig = new Twig_Environment($loader, array(
						'cache' => './compilation_cache',
						'auto_reload' => true
				));
				$template= $twig->loadTemplate('./tasks.twig');
				$template->display($params);
		}
}
