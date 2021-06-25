<?php

// ПОЛУЧЕНИЕ ДАННЫХ О ПОЛЬЗОВАТЕЛЕ

// print($_SERVER['HTTP_USER_AGENT']);
// print('<br>');
// print(substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2));

// header('Location: https://dmlvr.ru/'); // переадрессация в php

// GET ЗАПРОСЫ

// print($_GET['y'].' '.$_GET['m']);

// $y = filter_input(INPUT_GET, 'y');

// print($y);

?>

<form name="signup" method="POST" enctype="multipart/form-data">
 <!--  <label>E-mail: <input type="text" name="email"></label>
  <label>Логин: <input type="text" name="login"></label>
  <label>Сообщение: <textarea style="height: 1.6em;" rows="1" name="message"></textarea></label> -->
  <label>Ваш аватар: <input type="file" name="avatar"></label>
  <input type="submit" name="send" value="Отправить">
</form>

<?php if (isset($_POST['send'])): ?>

<?php
	if (isset($_FILES['avatar'])) {
	  $file_name = $_FILES['avatar']['name'];
	  $file_path = __DIR__ . '/uploads/';
	  $file_url = '/uploads/' . $file_name;
	  
	  // move_uploaded_file($_FILES['avatar']['tmp_name'], $file_path . $file_name);

	  print($file_path);
	  
	  // print("<a href="/php/12/book/06-forms/04-upload/$file_url">$file_name</a>");
	}
?>

<?php endif;?>

