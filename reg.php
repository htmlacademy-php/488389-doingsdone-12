<?php
require_once('helpers.php');
require_once('session.php');
require_once('mysqli_connect.php');

$form_errors = [];

if (isset($_POST['send'])) {
	$reg_email = $_POST['email'];
	$reg_pass = $_POST['password'];
	$reg_name = $_POST['name'];

	//Проверка почтового адреса
	$sql_request_check_email = "SELECT email FROM users WHERE email = ".'"'.$reg_email.'"';
	$result_request_check_email = mysqli_query($connection_resource, $sql_request_check_email);
	$check_email = mysqli_fetch_assoc($result_request_check_email); 
	$check_email = $check_email['email'];

	$filter_email = filter_var($reg_email, FILTER_VALIDATE_EMAIL);

	if ($reg_email === '') {
		$form_errors['email'] = 'Поле не заполнено';
	}	else if (iconv_strlen($reg_email) > 128) {
		$form_errors['email'] = 'Длинна поля «email» превышает максимально допустимую (128 символов)';
	} else if ($check_email) {
		$form_errors['email'] = 'Указанный email уже используется';
	}  else if (!$filter_email) {
		$form_errors['email'] = 'Значение из поля «email» не является валидным E-mail адресом';
	}

	if ($reg_pass === '') {
		$form_errors['password'] = 'Поле не заполнено';
	} else if (iconv_strlen($reg_pass) > 255) {
		$form_errors['password'] = 'Длинна поля «Пароль» превышает максимально допустимую (255 символов)';
	} else {
		$reg_pass = password_hash($reg_pass, PASSWORD_DEFAULT);
	}

	if ($reg_name === '') {
		$form_errors['name'] = 'Поле не заполнено';
	} else if (iconv_strlen($reg_name) > 64) {
		$form_errors['name'] = 'Длинна поля «Имя» превышает максимально допустимую (64 символа)';
	}

	if (!count($form_errors) > 0) {
		$sql_request_add_user = "INSERT INTO users (name, password, email) VALUES ('" . $reg_name . "', '" . $reg_pass . "', '" . $reg_email . "')";

		$result_request_add_user = mysqli_query($connection_resource, $sql_request_add_user);

		if (!$result_request_add_user) { 
			$error = mysqli_error($connection_resource); 
			print($error);
		} else {
			$url = ((!empty($_SERVER['HTTPS'])) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'];
			header("Location: ".$url);
		}
	}

}

if (isset($_SESSION['user_id'])) {
	$url = ((!empty($_SERVER['HTTPS'])) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'];
	header("Location: ".$url);
} else {
	$page_content = include_template('register.php', ['form_errors' => $form_errors]);
	$layout_content = include_template('layout.php', ['page_content' => $page_content, 'title' => 'Дела в порядке']);
	print($layout_content);
}