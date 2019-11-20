<html>
<head>
<meta charset="utf-8">
<link href="content_style.css" rel="stylesheet">
</head>
<?php 
include("config.php");
session_start();
#ini_set("display_errors","1");
#error_reporting(E_ALL);
######################
$wid=$_GET['wid'];
#print_r($_GET);
######################
$query=$connection->prepare("select * from work_list where w_id=:w_ids");
$query->bindParam("w_ids",$wid,PDO::PARAM_INT);
$query->execute();
$result=$query->fetch(PDO::FETCH_ASSOC);
######################
$w_title=$result['title'];
$w_req=$result['require_pp'];
$w_sd=$result['start_date'];
$w_ed=$result['end_date'];
$w_sal=$result['salary'];
$w_des=$result['work_desc'];
######################
?>
<body>
<table>
	<tr>
	<td class="sum htd">실험 주제</td><td class="sum btd"><?php echo $w_title;?></td>
	</tr>
	<tr>
	<td class="sum htd">모집 인원</td><td class="sum btd"><?php echo $w_req;?></td>
	</tr>
	<tr>
	<td class="sum htd">기간</td><td class="sum btd"><?php if($w_sd == '0000-00-00'||$w_ed == '0000-00-00'){ echo "협의 후 조정";}else {
	echo "$w_sd ~ $w_ed";}?></td>
	</tr>
	<tr>
	<td class="sum htd">급여(원)</td><td class="sum btd"><?php echo $w_sal;?></td>
	</tr>
	<tr>
	<td class="sum htd">실험 소개</td><td class="sum btd"><?php echo $w_des;?></td>
	</tr>
</table>
</body>
</html>
