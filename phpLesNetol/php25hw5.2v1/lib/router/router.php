<?php

include './controller/TaskController.php';

$controller = new TaskController($pdo);

$post = $_POST;
$get = $_GET;
$userID = $_SESSION['user']['id'];
$userLogin = $_SESSION['user']['login'];

if (!empty($_GET['id']) && !empty($_GET['action'])) {
		if (($_GET['action'] == 'edit') && !empty($_POST['description'])) {
				$controller->editDescription($post, $get);
		}

		if ($_GET['action'] == 'done') {
				$controller->doneDescription($get);
		}

		if ($_GET['action'] == 'delete') {
				$controller->deleteDescription($get);
		} 
}

if (!empty($_POST['description']) && empty($_GET['action'])) {
		$controller->insertDescription($post, $userID);
}

if (!empty($_POST['assign']) && !empty($_POST['assigned_user_id'])) {
		$controller->setAssignedUser($post);
}

if (!empty($_POST['sort']) && !empty($_POST['sort_by'])) {
		$controller->sortDescription($post, $get, $userID, $userLogin);
} else {
		$controller->sortDescriptionDefault($post, $get, $userID, $userLogin);
}

?>
