<?php
include("config.php");
ini_set("display_errors","1");
error_reporting(E_ALL);
session_start();

if(isset($_POST['cancel'])){
	$del_user_id = $_POST['cancel'];
	$del_wklist = $_POST['del_hidden'];
	$query=$connection->prepare("update apply_list set etc = 'off' where w_id=:w_id and id=:id");
	$query->bindParam("w_id",$del_wklist,PDO::PARAM_INT);
	$query->bindParam("id",$del_user_id,PDO::PARAM_INT);
	$query->execute();
	if($query->rowCount() == 0){
		$mess = "something went wrong, please ask to manager";
		echo "<script>alert('{$mess}')</script>";
		exit;
	}
	if($query->rowCount() == 1){
		$mess = "delete was successed";
		echo "<script>alert('{$mess}');location.href='userInfo.php?ider=$del_wklist';</script>";
		
	}
}

?>
