<html>
<head>
<meta charset="utf-8">
</head>
<script type="text/javascript">
function wdclose(){
	window.close();
}
</script>
<?php
include("config.php");
session_start();
#####################
$who = $_GET['stdId'];
$who_grd = $_GET['grade'];
#####################
$query=$connection->prepare("update users set grade=:gradee where username=:username");
$query->bindParam("gradee",$who_grd,PDO::PARAM_STR);
$query->bindParam("username",$who,PDO::PARAM_STR);
$query->execute();
$result=$query->fetch(PDO::FETCH_ASSOC);
if($query->rowCount() > 0 ){
	echo "<center><p>성공적으로 변경하였습니다.</p><p><a href='javascript:void(0);' onclick='wdclose();'>확인</a></p></center>";
}else{
	echo "<center><p>에러가 발생했습니다. 관리자에게 문의하세요</p><p><a href='javascript:void(0);' onclick='wdclose();'>확인</a></p></center>";
}
?>
<body>
</body>
</html>
