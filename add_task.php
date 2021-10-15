<?php
require_once('helpers.php');
require_once('session.php');
require_once('mysqli_connect.php');

$form_errors = [];

if (isset($_POST['send'])) {
	$task_name = $_POST['name'];
	$task_date = $_POST['date'];
	$task_id_project = $_POST['project'];
	$task_status = 0;
	$file_link = NULL;

	if (isset($_FILES['file']) && $_FILES['file']['size'] != 0) {
	    $file_name = $_FILES['file']['name'];
	    $file_ext = pathinfo($file_name);
	    $current_date =date("Y-m-d-G-i-s");
	    $new_file_name = $current_date.'.'.$file_ext['extension'];
	    $file_path = __DIR__ . '/uploads/';
	    $file_link = '/uploads/' . $new_file_name;
	    
	    move_uploaded_file($_FILES['file']['tmp_name'], $file_path . $new_file_name);
	    
	}

	if ($task_name === '') {
		$form_errors['task_name'] = 'Поле не заполнено';
	}

	$sql_request_project_availability = "SELECT id FROM projects WHERE id = ".$task_id_project;

	$result_request_project_availability = mysqli_query($connection_resource, $sql_request_project_availability);

	$project_availability = mysqli_fetch_assoc($result_request_project_availability);

	if (!$project_availability['id']) {
		$form_errors['task_id_project'] = 'Идентификатор выбранного проекта не ссылается на реально существующий проект';
	}

	if ($task_date != '' and !is_date_valid($task_date)) {
		$form_errors['task_date'] = 'Содержимое поля должно быть датой в формате «ГГГГ-ММ-ДД»';
	} else if ($task_date != '' and !define_correctness_date($task_date)) {
		$form_errors['task_date'] = 'Дата должна быть больше или равна текущей';
	}

	if (!count($form_errors) > 0) {
		if ($task_date == '') {
			$sql_request_add_task = "INSERT INTO tasks (task_name, projec_id, user_id, status, file_link) VALUES ('" . $task_name . "', '" . $task_id_project . "', '" . $user_id . "', '" . $task_status . "', '" . $file_link . "')";
		} else {
			$sql_request_add_task = "INSERT INTO tasks (task_name, projec_id, user_id, status, dt_deadline, file_link) VALUES ('" . $task_name . "', '" . $task_id_project . "', '" . $user_id . "', '" . $task_status . "', '" . $task_date . "', '" . $file_link . "')";
		}
		
		$result_request_add_task = mysqli_query($connection_resource, $sql_request_add_task);

		if (!$result_request_add_task) { 
			$error = mysqli_error($connection_resource);
		} else {
			header("Location: http://doingsdone");
		}
	}
}

$main_navigation = include_template('main-navigation.php', ['projects' => $projects, 'tasks' => $tasks, 'count_tasks' => $count_tasks]);

$page_content = include_template('form-task.php', ['main_navigation' => $main_navigation, 'projects' => $projects, 'form_errors' => $form_errors]);

$layout_content = include_template('layout.php', ['page_content' => $page_content, 'title' => 'Дела в порядке', 'user_name' => $user_name]);

print($layout_content);

?>