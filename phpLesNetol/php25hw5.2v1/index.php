<?php
require 'core.php';
if (empty($_SESSION['user']['id'])) {
		header('Location: ./register.php');
}
$pdo = createPDO();
if (!empty($_GET['id']) && !empty($_GET['action'])) {
		if (($_GET['action'] == 'edit') && !empty($_POST['description'])) {
				$sql = "UPDATE task SET description = ? WHERE id = ?";
				$statement = $pdo->prepare($sql);
				$statement->execute(["{$_POST['description']}", "{$_GET['id']}"]);
				header('Location: ./index.php');	
		} else {
				$sql = "SELECT * FROM tasks";
		}
		if ($_GET['action'] == 'done') {
				$sql = "UPDATE task SET is_done = 1 WHERE id = ?";
				$statement = $pdo->prepare($sql);
				$statement->execute(["{$_GET['id']}"]);
				header( 'Location: ./index.php');		
		}
		if ($_GET['action'] == 'delete') {
				$sql = "DELETE FROM task WHERE id = ?";
				$statement = $pdo->prepare($sql);
				$statement->execute(["{$_GET['id']}"]);
				header( 'Location: ./index.php');
		} 
}
if (!empty($_POST['description']) && empty($_GET['action'])) {
		$date = date('Y-m-d H:i:s');
		$sql = "INSERT INTO  task (description, date_added, assigned_user_id, user_id) VALUES (?, ?, ?, ?)";
		$statement = $pdo->prepare($sql);
		$statement->execute(["{$_POST['description']}", "{$date}", "{$_SESSION['user']['id']}", "{$_SESSION['user']['id']}"]);
}
if (!empty($_POST['assign']) && !empty($_POST['assigned_user_id'])) {
		$sql = "UPDATE task SET assigned_user_id = ? WHERE id = ?";
		$statement = $pdo->prepare($sql);
		$statement->execute(["{$_POST['assigned_user_id']}", "{$_POST['id_description']}"]);
}
if (!empty($_POST['sort']) && !empty($_POST['sort_by'])) {
		$sql = "SELECT *, task.id AS id_description, user.login AS user_login FROM task 
		INNER JOIN user ON task.user_id=user.id 
		INNER JOIN user AS us ON task.assigned_user_id=us.id 
		ORDER BY {$_POST['sort_by']} ASC";
		$statement = $pdo->prepare($sql);
		$statement->execute();
} else {
		$sql = "SELECT *, task.id AS id_description, user.login AS user_login FROM task 
		INNER JOIN user ON task.user_id=user.id 
		INNER JOIN user AS us ON task.assigned_user_id=us.id";
		$statement = $pdo->prepare($sql);
    $statement->execute();
}
$sqlUsers = "SELECT * FROM user";
$statementUsers = $pdo->prepare($sqlUsers);
$statementUsers->execute();
while ($rowUser = $statementUsers->fetch(PDO::FETCH_ASSOC)) {
		$users[] = $rowUser;
}
$sqlMyList = "SELECT *, task.id AS id_description, user.login AS user_login FROM task 
INNER JOIN user ON task.user_id=user.id 
INNER JOIN user AS us ON task.assigned_user_id=us.id
WHERE assigned_user_id = ?";
$statementMyList = $pdo->prepare($sqlMyList);
$statementMyList->execute(["{$_SESSION['user']['id']}"]);
?>

<!DOCTYPE html>
<html lang="ru">
  <head>
	  <meta charset="utf-8">
    <title>Список дел на сегодня</title>
		<style>
		  body {
				max-width: 1160px;
				margin: 0 auto;
			}
		  form {
				display: block;
				margin-bottom: 1rem;
				margin-right: 1rem;
				float: left;
			}
		  table {
				clear: both;
				border-collapse: collapse;
			}
		  th {
				background: #eee;
			}
			th, td {
				padding: 5px;
				border: 1px solid #ccc;
			}
			.logout {
				float: right;
				margin: 10px;
				padding: 6px 15px;
				background-color: #808080;
				text-decoration: none;
				color: white;
				font-size: 18px;
				border: none;
				border-radius: 6px;
				box-shadow: 1px 1px 6px rgba(0, 0, 0, 0.5);
			}
		</style>
  </head>
	<body>
	  <a class="logout" href="logout.php">Выход</a>

	  <h1>Добрый день, <?php echo $_SESSION['user']['login']; ?>! Ваш список дел:</h1>

  	<form method="POST">
			<input type="text" name="description" placeholder="Описание задачи" value="<?php if (!empty($_POST['description'])) echo $_POST['description']; ?>">
      <input type="submit" name="save" value="Сохранить">
		</form>

    <form method="POST">
		  <label for="sort">Сортировать по:</label>
			<select name="sort_by">
			  <option value="date_added">Дате добавления</option>
				<option value="is_done">Статусу</option>
				<option value="description">Описанию</option>
			</select>
			<input type="submit" name="sort" value="Отсортировать">
    </form>

		<table>
		  <tr>
			  <th>Описание задачи</th>
				<th>Дата добавления</th>
				<th>Статус</th>
				<th></th>
				<th>Ответственный</th>
				<th>Автор</th>
				<th>Закрепить задачу за пользователем</th>
			</tr>
			<?php foreach ($statement as $row) { ?>
			<tr>
				<td><?php echo htmlspecialchars($row['description']); ?></td>

				<td><?php echo htmlspecialchars($row['date_added']); ?></td>

				<td <?php if ($row['is_done'] == 1) echo 'style="color: green;"'; ?>>
				  <?php if ($row['is_done'] == 0) {
				    echo 'В процессе';
				  } else {
				    echo 'Выполнено';
				  } ?>
				</td>

				<td>
				  <a href="?id=<?php echo $row['id_description']; ?>&action=edit&description=<?php echo $row['description']; ?>">Изменить</a>
				  <a href="?id=<?php echo $row['id_description']; ?>&action=done">Выполнить</a>
				  <a href="?id=<?php echo $row['id_description']; ?>&action=delete">Удалить</a>
				</td>

				<td><?php if ($row['login'] == $_SESSION['user']['login']) { echo 'Вы'; } else { echo htmlspecialchars($row['login']); } ?></td>

				<td><?php echo htmlspecialchars($row['user_login']); ?></td>

				<td>
					<form method="POST" style="margin: 0;">
						<select name="assigned_user_id">
							<?php foreach ($users as $user) { ?>
								<option value="<?php echo $user['id']; ?>"><?php echo $user['login']; ?></option>
							<?php } ?>					
						</select>
						<input type="hidden" name="id_description" value="<?php echo $row['id_description']; ?>">
						<input type="submit" name="assign" value="Переложить ответственность">
					</form>
				</td>
			</tr>
			<?php } ?>
		</table>

		<h3>Также посмотрите, что от вас требуют другие люди:</h3>

		<table>
		  <tr>
			  <th>Описание задачи</th>
				<th>Дата добавления</th>
				<th>Статус</th>
				<th></th>
				<th>Ответственный</th>
				<th>Автор</th>
			</tr>
			<?php foreach ($statementMyList as $rowMyList) { ?>
			<tr>
				<td><?php echo htmlspecialchars($rowMyList['description']); ?></td>

				<td><?php echo htmlspecialchars($rowMyList['date_added']); ?></td>

				<td <?php if ($rowMyList['is_done'] == 1) echo 'style="color: green;"'; ?>>
				  <?php if ($rowMyList['is_done'] == 0) {
				    echo 'В процессе';
				  } else {
				    echo 'Выполнено';
				  } ?>
				</td>

				<td>
				  <a href="?id=<?php echo $rowMyList['id_description']; ?>&action=edit&description=<?php echo $rowMyList['description']; ?>">Изменить</a>
				  <a href="?id=<?php echo $rowMyList['id_description']; ?>&action=done">Выполнить</a>
				  <a href="?id=<?php echo $rowMyList['id_description']; ?>&action=delete">Удалить</a>
				</td>

				<td><?php if ($rowMyList['login'] == $_SESSION['user']['login']) { echo 'Вы'; } else { echo htmlspecialchars($row['login']); } ?></td>

				<td><?php echo htmlspecialchars($rowMyList['user_login']); ?></td>
			</tr>
			<?php } ?>
		</table>
  </body>
</html>

   
    

