<?php

$connection_resource = mysqli_connect("localhost", "root", "root", "doingsdone");
mysqli_set_charset($connection_resource, "utf8");

if ($connection_resource == false) {
   print("Ошибка подключения: " . mysqli_connect_error());
}

if (isset($_SESSION['user_id'])) {

	$user_id = $_SESSION['user_id'];  // если этот параметр поменять на двойку, то подгрузится вся инфа для второго пользователя из БД

	// Получаю имя Юзера
	$sql_request_user = "SELECT name FROM users WHERE id = ".$user_id;
	$result_request_user = mysqli_query($connection_resource, $sql_request_user);
	$user_name = mysqli_fetch_assoc($result_request_user);
	$user_name = $user_name['name'];

	// получаю список проектов
	$sql_request_projects = "SELECT name, id FROM projects WHERE user_id = ".$user_id;
	$result_request_projects = mysqli_query($connection_resource, $sql_request_projects);
	$projects = mysqli_fetch_all($result_request_projects, MYSQLI_ASSOC);

	// Пометка проектов как выполненных
	if (isset($_GET['check'])) {
		$sql_request_task_status = "SELECT status FROM tasks WHERE id = ".$_GET['task_id'];

		$sql_request_task_check = "UPDATE tasks 
		SET status = ".'"'.$_GET['check'].'"'."
		WHERE id = ".'"'.$_GET['task_id'].'"';
		$sql_result = mysqli_query($connection_resource, $sql_request_task_check);
	}

	// Получаю список задач
	if (isset($_GET['task_search'])) {
			$task_search = $_GET['task_search'];
			$sql_request_tasks = "SELECT task_name, dt_deadline, status, projec_id, t.id, p.name 
			FROM tasks t
			JOIN projects p
			ON t.projec_id = p.id
			WHERE MATCH(task_name) AGAINST(".'"'.$task_search.'"'.")
			AND t.user_id = ".$user_id;
			$result_request_tasks = mysqli_query($connection_resource, $sql_request_tasks);
			$tasks = mysqli_fetch_all($result_request_tasks, MYSQLI_ASSOC);
	} else {
			$sql_request_tasks = "SELECT task_name, dt_deadline, status, projec_id, t.id, p.name 
			FROM tasks t
			JOIN projects p
			ON t.projec_id = p.id
			WHERE t.user_id = ".$user_id;
			$result_request_tasks = mysqli_query($connection_resource, $sql_request_tasks);
			$tasks = mysqli_fetch_all($result_request_tasks, MYSQLI_ASSOC);
	}


	//Получаю количество проектов по каждой из задач
	$count_tasks;
	foreach ($projects as $project) {
		$sql_request_count_t = "SELECT COUNT(*) FROM tasks WHERE projec_id = '".$project['id']."' AND user_id = '".$user_id."';";
		$result_request_count_t = mysqli_query($connection_resource, $sql_request_count_t);
		$count_task = mysqli_fetch_all($result_request_count_t, MYSQLI_ASSOC);
		$count_tasks[$project['id']] = $count_task[0]['COUNT(*)'];
	};
}

?>