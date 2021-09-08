<?php
require_once('helpers.php');
require_once('session.php');
require_once('mysqli_connect.php');

$form_errors = [];
$project_name = '';

if (isset($_POST['send'])) {
	$project_name = $_POST['project_name'];


	if ($project_name === '') {
		$form_errors['project_name'] = 'Поле не заполнено';
	} else {
		$sql_request_check_project_name = "SELECT name FROM projects 
		WHERE name = '" . $project_name . "'
		AND user_id = ".$user_id;

		$result_request_check_project_name = mysqli_query($connection_resource, $sql_request_check_project_name);

		$check_project_name = mysqli_fetch_assoc($result_request_check_project_name);

			if($check_project_name['name']) {
				$form_errors['project_name'] = 'Такой проект уже существует';
			}
		}


	if (!count($form_errors) > 0) {
		$sql_request_add_project = "INSERT INTO projects (name, user_id) 
		VALUES ('" . $project_name . "', '" . $user_id . "')";
		$result_request_add_project = mysqli_query($connection_resource, $sql_request_add_project);

			if (!$result_request_add_project) { 
				$error = mysqli_error($connection_resource); 
				print($error);
			} else {
				header("Location: http://doingsdone");
			}
	}
}

$main_navigation = include_template('main-navigation.php', ['projects' => $projects, 'count_tasks' => $count_tasks]);

$page_content = include_template('form_project.php', ['main_navigation' => $main_navigation, 'form_errors' => $form_errors, 'project_name' => $project_name]);

$layout_content = include_template('layout.php', ['page_content' => $page_content, 'title' => 'Дела в порядке', 'user_name' => $user_name]);

print($layout_content);

?>