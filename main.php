<?php
include("config.php");
#include("repaging.php");
ini_set("display_errors","1");
error_reporting(E_ALL);
session_start();
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
	<font size=30px;><a href=""><b>알바할사람여기모여라</b></a></font>
	</div>
		<div id=userinfo>
		<form method=POST action="">
			<ul>
				<li><?php echo $username;?> 님 반갑습니다.</li>
			<?php if($grade == "manager"){echo '<li><a href="upworklist.php" target="content_main"><b>Upload_work</b></a></li>'; echo '<li><a href="management.php" target="content_main"><b>Management</b></a></li>'; echo '<li><a href="usermanagement.php" target="content_main"><b>User_list</b></a></li>';} ?>
				<li><a href="mypage.php" target="content_main"><b>Mypage</b></a></li>
				<li><button type="submit" name="logout" id="logout"><b>Log out</b></button></li>
			</ul> 
		</form>
		</div>
	</div>
<hr>
	<div class=divmiddle>
<iframe name="content_main" src="mainframe.php">

</iframe>
	</div>
</body>
</html>
<?php
}
?>
