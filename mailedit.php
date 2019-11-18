<html>
<head>
<meta charset="utf-8">
<link href="content_style.css" rel="stylesheet">
</head>
<script type="text/javascript">
function CheckChar(){
	var BanChar = /[<>=\%\"\']/gi;
	var obj = document.getElementsByName("chMail")[0];
	if (BanChar.test(obj.value)){
		alert("특수문자는 입력할 수 없습니다");
		obj.value = obj.value.substring(0,obj.value.length -1);
	}
}
function winclose(){
	window.close();
}
</script>
<body>
<?php
include("config.php");
session_start();
#####################
$userName = $_GET['mail'];
$query=$connection->prepare("select * from users where id=:id");
$query->bindParam("id",$userName,PDO::PARAM_INT);
$query->execute();
$result=$query->fetch(PDO::FETCH_ASSOC);
#####
$user_mail = $result['email'];
?>
<form method=POST action=''>
<div class=chmail id=divchmail>
<table>
<tr>
<td class="chmail htd">메일</td>
<td class="chmail btd">
<input type=text name=chMail id=chMail onkeyup="CheckChar();" onkeydown="CheckChar();" value="<?php echo $user_mail;?>" required>
</td>
<td class="chmail submit">
<input type=submit name=chmail_submit value="변경">
</td>
</tr>
</table>
</div>
</form>
<?php

if(isset($_POST['chmail_submit'])){
$ch_usermail = $_POST['chMail'];
$query=$connection->prepare("update users set email=:email where username=:username");
$query->bindParam("email",$ch_usermail,PDO::PARAM_STR);
$query->bindParam("username",$userName,PDO::PARAM_STR);
$query->execute();
if($query->rowCount() > 0){
	$mess = '성공적으로 변경하였습니다. <a href="javascript:void(0);" onclick="winclose()">확인</a>';
	echo "<script>document.getElementById(\"divchmail\").innerHTML='$mess';</script>";
}else{
	echo "<script>alert('오류가 발생했습니다. 메일을 다시 한번 확인해 주세요.');</script>";
}
}
?>
</body>
</html>
