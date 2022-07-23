<?php

ob_start();
session_start();

date_default_timezone_set("Asia/Tehran");

$_SESSION['user_ip'] = $_SERVER['REMOTE_ADDR'];


?>