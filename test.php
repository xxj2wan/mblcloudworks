<?php
include("config.php");
session_start();
?>
<html>
<head>
<meta charset="utf-8">
<link href="content_style.css" rel="stylesheet">
</head>
<body>
<div class=confirmMail>
<form method="POST" action="mailing.php">
<?php
$w_id = $_GET['noticeid'];
$query=$connection->prepare("select * from work_list left join (select w_id, apply_list.id, users.name, users.username, users.email from apply_list left join users on apply_list.id = users.id where etc='On') as A on work_list.w_id = A.w_id where work_list.w_id =:w_id order by uploaded desc");
$query->bindParam("w_id",$w_id,PDO::PARAM_INT);
$query->execute();
echo "	<div class=\"confirmMail head\">해당 실험에 참가할 학생과 급여를 확인합니다.</div>
	<div class=\"confirmMail contents\">
	<table class=\"confT\"><tr>
        <td class=\"confT htdf\">실험</td><td class=\"confT htd\">이름</td><td class=\"confT htd\">학번</td><td class=\"confT htd\" colspan=2>기간</td><td class=\"confT htdl\">급여</td></tr>";
$workermail = array();
$workername = array();
while($result=$query->fetch(PDO::FETCH_ASSOC)){
$st = $result['status'];
$ti = $result['title'];
$re = $result['require_pp'];
$std = $result['start_date'];
$end = $result['end_date'];
$sal = $result['salary'];
$ch_sal = number_format($sal);
$who = $result['name'];
$whoid = $result['username'];
$whoemail = $result['email'];
echo "
	<tr>
	<td class=\"confT btd\">$ti</td><td class=\"confT btd\">$who</td><td class=\"confT btd\">$whoid</td><td class=\"confT btd\" colspan=2>$std ~ $end</td><td class=\"confT btd\">$ch_sal</td></tr><input type=hidden name=workermail[] value=$whoemail><input type=hidden name=\"exp_wid\" value=$w_id><input type=hidden name=workername[] value=$who>";
}
echo "</table></div>
<div class=\"confirmMail bottom\">
위 인원에게 확정메일을 발송하고 모집을 마감합니다.
<p><input type=submit name=\"yes\" value=Yes><input type=submit name=\"no\" value=No></p>
</div>";

?>
</form>
</div>
</body>

</html>
