<?php
include("config.php");
#include("repaging.php");
ini_set("display_errors","1");
error_reporting(E_ALL);
session_start();
###
###
if(isset($_POST['logout'])){
	session_unset();
	session_destroy();
	header('Location: index.php');
	exit;
}
if(!isset($_SESSION['user_id'])){
	header('Location: index.php');
	exit;
}else{
$userid=$_SESSION['user_id'];
$query=$connection->prepare("select * from users where id=:id");
$query->bindParam("id",$userid,PDO::PARAM_STR);
$query->execute();
$result = $query->fetch(PDO::FETCH_ASSOC);
$etc_desc = $result['etc_desc'];
if($etc_desc == NULL){
	$mess="Mypage에서 자기소개를 간단하게 입력해주세요";
	echo "<script>alert('{$mess}');</script>";
}
$username = $result['username'];
$grade = $result['grade'];

?>
<html>
<head>
<meta charset="utf-8">
<link href="content_style.css" rel="stylesheet"/>
</head>
<body>
	<div class=divtop>
	<div class=divtop_mbllogo>
	<font size=30px;><a href=""><span id="headertext"><b>알 바 모 집</b></span></a></font>
	</div>
		<div id=userinfo>
		<form method=POST action="">
			<center><ul>
				<li><?php if($grade == "manager"){ echo "$username <font color=\"green\">(manager)</font>";}else{ echo "$username";}?> 님 반갑습니다. </li>
			<?php if($grade == "manager"){echo '<li><a href="upworklist.php" target="content_main"><b>Task 등록</b></a></li>'; echo '<li><a href="management.php" target="content_main"><b>Task 관리</b></a></li>'; echo '<li><a href="usermanagement.php" target="content_main"><b>사용자 관리</b></a></li>';} ?>
				<li><a href="mypage.php" target="content_main"><b>마이페이지</b></a></li>
				<li><button type="submit" name="logout" id="logout"><b>로그아웃</b></button></li>
			</ul> 
			</center>
		</form>
		</div>
	</div>
	<div class=divmiddle>
<iframe name="content_main" src="mainframe.php">

</iframe>
	</div>
</body>
</html>
<?php
}
?>
