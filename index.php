<?php
require_once('helpers.php');
require_once('mysqli_connect.php');

// показывать или нет выполненные задачи
$show_complete_tasks = 1;

$main_navigation = include_template('main-navigation.php', ['projects' => $projects, 'tasks' => $tasks]);

$page_content = include_template('main.php', ['main_navigation' => $main_navigation, 'projects' => $projects, 'tasks' => $tasks, 'show_complete_tasks' => $show_complete_tasks]);

$layout_content = include_template('layout.php', ['page_content' => $page_content, 'title' => 'Дела в порядке', 'user_name' => $user_name]);

print($layout_content);

?>