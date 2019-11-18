<?php
ini_set("display_errors","1");
error_reporting(E_ALL);
session_start();
include("config.php");

$userid = $_GET['userid'];

##mysql prepare
$query=$connection->prepare("select * from users where id=:id");
$query->bindParam("id",$userid,PDO::PARAM_INT);
$query->execute();
if($query->rowCount() == 1){
	$result=$query->fetch(PDO::FETCH_ASSOC);
	$userstdname = $result['username'];
	$useremail = $result['email'];
	$username = $result['name'];
	$userdesc = $result['etc_desc'];
}else{

}
?>
<html>
<head>
<meta charset="utf-8">
</head>
<body>
<table>
	<tr><td>학번</td><td><?php echo $userstdname;?></td></tr>
	<tr><td>Email</td><td><?php echo $useremail;?></td></tr>
	<tr><td>이름</td><td><?php echo $username;?></td></tr>
	<tr><td></td><td><?php echo $userdesc;?></td></tr>
</table>
</body>
</html>
