<?php

if (isset($_COOKIE['user_id'])) {
  session_start();
  $_SESSION['user_id'] = $_COOKIE['user_id'];
}

?>