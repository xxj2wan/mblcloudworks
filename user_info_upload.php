<?php
ini_set("display_errors","1");
error_reporting(E_ALL);
include("config.php");
session_start();

if(isset($_POST['my_info_upload'])){
$user_id = $_POST['my_info_hidden'];
$user_desc = $_POST['my_infotext'];
$query=$connection->prepare("update users set etc_desc=:etc_descs where username=:user_name");
$query->bindParam("etc_descs",$user_desc,PDO::PARAM_STR);
$query->bindParam("user_name",$user_id,PDO::PARAM_STR);
$query->execute();
if($query->rowCount() == 1){
	echo "<center><p>성공적으로 저장되었습니다.</p>
		<p><a href='mypage.php'>Okay</a></p></center>";
}else{
	echo "<center><p>에러가 발생했습니다. 다시 한번 확인해주세요.</p>
		<p><a href='mypage.php'>Okay</p></center>";
}
}
?>

