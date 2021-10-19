<?php
require_once('helpers.php');
require_once('session.php');
require_once('mysqli_connect.php');

if (isset($_SESSION)) {

	$show_complete_tasks = 1;
	if (isset($_GET['show_completed'])) {
		$show_complete_tasks = $_GET['show_completed'];
	}

	$main_navigation = include_template('main-navigation.php', ['projects' => $projects, 'tasks' => $tasks, 'count_tasks' => $count_tasks]);

	$page_content = include_template('main.php', ['main_navigation' => $main_navigation, 'projects' => $projects, 'tasks' => $tasks, 'show_complete_tasks' => $show_complete_tasks]);

	$layout_content = include_template('layout.php', ['page_content' => $page_content, 'title' => 'Дела в порядке', 'user_name' => $user_name]);
} else {
	$layout_content = include_template('guest.php', ['title' => 'Дела в порядке']);
}

print($layout_content);


?>