<?php

require_once('vendor/autoload.php');

$connection_resource = mysqli_connect("localhost", "root", "root", "doingsdone");
mysqli_set_charset($connection_resource, "utf8");

if ($connection_resource == false) {
   print("Ошибка подключения: " . mysqli_connect_error());
}

$current_date = date("Y-m-d");
$users_id = [];

$sql_request_tasks = "SELECT task_name, user_id 
	FROM tasks
	WHERE status = 0
	AND dt_deadline = "."'".$current_date."'";


$result_request_tasks = mysqli_query($connection_resource, $sql_request_tasks);
$tasks = mysqli_fetch_all($result_request_tasks, MYSQLI_ASSOC);

//Настройки почтового ящика
$transport = (new Swift_SmtpTransport('smtp.beget.com', 25))
  ->setUsername('demo@dmlvr.ru')
  ->setPassword('eis4S%bs')
;

foreach ($tasks as $task) {
	if (!in_array($task['user_id'], $users_id)) {
		array_push($users_id, $task['user_id']);
	}
}

foreach ($users_id as $user_id) {
	$mailBody = '';
	foreach($tasks as $task) {
		if($task['user_id'] == $user_id) {
			$mailBody .= $task['task_name'] . ', ';
		}
	}

	$sql_request_user = "SELECT name, email 
	FROM users
	WHERE id = ".$user_id;
	$result_request_user = mysqli_query($connection_resource, $sql_request_user);
	$user = mysqli_fetch_array($result_request_user, MYSQLI_ASSOC);
	$user_name = $user['name'];
	$user_email = $user['email'];

	// Формирование сообщения
	$message = new Swift_Message("Уведомление от сервиса «Дела в порядке»");
	$message->setTo(["$user_email" => "$user_name"]);
	$message->setBody("Уважаемый, ".$user_name.". У вас запланирована задача ".$mailBody."на ".$current_date);
	$message->setFrom("demo@dmlvr.ru", "Кекс");

	// Отправка сообщения
	$mailer = new Swift_Mailer($transport);
	$mailer->send($message);

}