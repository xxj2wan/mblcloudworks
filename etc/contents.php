<?php
session_start();
ini_set("display_errors","1");
error_reporting(E_ALL);

if(!isset($_SESSION['user_id'])){
	header('Location: login.php');
	exit;
}else{
	echo "hello users, welcome to page";
}
?>
