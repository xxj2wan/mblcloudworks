<html>
<head>
<meta charset="utf-8">
</head>
<body>
<?php
include("config.php");
session_start();

if(isset($_POST['yes'])){
$w_id=$_POST['exp_wid'];
$query=$connection->prepare("select * from work_list where w_id=:w_id");
$query->bindParam("w_id",$w_id,PDO::PARAM_INT);
$query->execute();
$count=count($_POST['workermail']);

$result=$query->fetch(PDO::FETCH_ASSOC);
$w_title = $result['title'];
$w_sduring = $result['start_date'];
$w_eduring = $result['end_date'];
$w_during = "$w_sduring"." ~ "."$w_eduring";
$w_sal = $result['salary'];
$ch_w_sal = number_format($w_sal);
	for($i=0; $i < $count; $i++){
		$who_mail = $_POST['workermail'][$i];
		$who_name = $_POST['workername'][$i];
		system("echo \"$who_name 님, 반갑습니다.\n운노타쯔야 교수님 연구실입니다.\n귀하는 $w_title 실험 part-time에 선정되었습니다.\n본 실험은 $w_during 동안 진행될 예정이며, 실험이 끝난 후 $ch_w_sal 원 을 수령할 수 있습니다. \n본 실험 part-time에 지원해주셔서 감사합니다.\"|mail -s 'MBL cloudworks' $who_mail");
	
	}
##after mail sending
$query=$connection->prepare("update work_list set status='progress' where w_id=:w_id");
$query->bindParam("w_id",$w_id,PDO::PARAM_INT);
$query->execute();
	if($query->rowCount() == 1){
		echo "<script>alert('메일이 성공적으로 전송되었습니다. 모집을 마감합니다');location.href='management.php';</script>";
	}else{
		echo "<script>alert('모집을 마감할 수 없습니다. 다시 한번 확인하세요.');</script>";
	}
}
?>
</body>
</html>
