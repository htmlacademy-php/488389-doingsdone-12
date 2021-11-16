<?php
require_once('session.php');
$_SESSION = [];
$url = ((!empty($_SERVER['HTTPS'])) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'];
header("Location: ".$url);
?>