<?php
ini_set("display_errors","1");
error_reporting(E_ALL);
$servername='localhost';
$username='hgw';
$password='mbl1234';
$dbname='cloudworks_mbl';
$conn= new mysqli($servername, $username, $password, $dbname);
mysqli_query($conn, "set names utf8");
if($conn->connect_error){
	die("Connection error" .$conn->connect_error);
}
?>
