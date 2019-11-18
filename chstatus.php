<?php
include("config.php");
ini_set("display_errors","1");
error_reporting(E_ALL);
session_start();

$ch_status = $_GET['status'];
$ch_wid = $_GET['wid'];

$query=$connection->prepare("update work_list set status=:status where w_id=:w_id");
$query->bindParam("status",$ch_status,PDO::PARAM_STR);
$query->bindParam("w_id",$ch_wid,PDO::PARAM_INT);
$query->execute();
$result=$query->fetch(PDO::FETCH_ASSOC);
$count=$query->rowCount();
if($query->rowCount() == 1){
	$mess="success";
	echo "<center><p>성공적으로 변경되었습니다.</p>
		<p><a href='management.php'>확인(Y)</a></p></center>";
}else{
	$mess="fail to change";
	echo "<center><p>변경에 실패하였습니다.</p>
		<p><a href='management.php'>back</a></p></center>";

}


?>
