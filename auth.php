<?php
require_once('helpers.php');
require_once('session.php');
require_once('mysqli_connect.php');

$form_errors = [];

if (isset($_POST['send'])) {
	$auth_email = $_POST['email'];
	$auth_pass = $_POST['password'];

	if ($auth_email === '') {
		$form_errors['email'] = 'Поле не заполнено';
	} else {

		$sql_request_check_email = "SELECT email FROM users WHERE email = ".'"'.$auth_email.'"';
		$result_request_check_email = mysqli_query($connection_resource, $sql_request_check_email);
		$check_email = mysqli_fetch_assoc($result_request_check_email); 
		$check_email = $check_email['email'];

		if (!$check_email) {
			$form_errors['email'] = 'Пользователь с данным адресом не найден';
		}
	}

	if ($auth_pass === '') {
		$form_errors['pass'] = 'Поле не заполнено';
	} else {
		$sql_request_check_pass = "SELECT password FROM users WHERE email = ".'"'.$auth_email.'"';
		$result_request_check_pass = mysqli_query($connection_resource, $sql_request_check_pass);
		$check_pass = mysqli_fetch_assoc($result_request_check_pass);
		$check_pass = $check_pass['password'];

		if (!password_verify($auth_pass, $check_pass)) {
			$form_errors['pass'] = 'Пароль не верный';
		}
	}

	if (!count($form_errors) > 0) {
		$sql_request_user_id = "SELECT id FROM users WHERE email = ".'"'.$auth_email.'"';
		$result_request_user_id = mysqli_query($connection_resource, $sql_request_user_id);
		$auth_user_id = mysqli_fetch_assoc($result_request_user_id);
		$auth_user_id = $auth_user_id['id'];

		record_cookie('user_id', $auth_user_id);

		header("Location: http://doingsdone");
	}

}

$page_content = include_template('auth.php', ['form_errors' => $form_errors]);

$layout_content = include_template('layout.php', ['page_content' => $page_content, 'title' => 'Дела в порядке']);

print($layout_content);

?>