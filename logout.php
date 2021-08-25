<?php
require_once('helpers.php');

record_cookie('user_id', '');
session_start();
$_SESSION = [];
header("Location: http://doingsdone");
?>