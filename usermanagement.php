<?php
ini_set("display_errors","1");
error_reporting(E_ALL);
session_start();
include("config.php");
if(!isset($_SESSION['user_id'])){
echo "<script>alert('로그인이 필요한 서비스입니다.');</script>";
exit;
}
?>

<html>
<head>
<meta charset="utf-8">
<link href="content_style.css" rel="stylesheet"/>
</head>
<script type="text/javascript">
function chStatus(arg1,arg2){
	var getBox = document.getElementById("std_grade["+arg1+"]");
	var getval = getBox.options[getBox.options.selectedIndex].value;
/*	alert(getBox.options[getBox.options.selectedIndex].value + arg2);*/
	var siteloc = "ChgGrade.php?stdId="+arg2+"&grade="+getval;
	window.open(siteloc,'','width=300,height=100,left=300,top=200,location=no,status=no,toolbar=no');
	
}
</script>
<body>
<div class=middle_worklist>
	<center>
	<table id=middle_table>
		<thead>
		<tr>
		<td class="middle_worklist_no">No</td>
		<td class="middle_worklist_head">학번</td>
		<td class="middle_worklist_head">이름</td>
		<td class="middle_worklist_head">Email</td>
		<td class="middle_worklist_head">등급</td>
		</tr>
		</thead>
		<tbody>
<?php
$query=$connection->prepare("select * from users");
$query->execute();
$k = 0;
$l = 0;
while($result=$query->fetch(PDO::FETCH_ASSOC)){
	$k++;
	$std_id = $result['username'];
	$std_name = $result['name'];
	$std_email = $result['email'];
	$std_grade = $result['grade'];
	echo "	<tr><td class=middle_worklist_no>$k</td>
		<td class=middle_worklist_head>$std_id</td>
		<td class=middle_worklist_head>$std_name</td>
		<td class=middle_worklist_head>$std_email</td>
		<td class=middle_worklist_head>
		<select name=std_grade[$l] id=std_grade[$l] onchange=\"chStatus($l,$std_id);\">
		<option value=manager";if($std_grade == "manager"){echo " selected";}echo ">Manager</option>";
	echo "  <option value=student";if($std_grade == "student"){echo " selected";}echo ">Student</option>";
	echo "  </select>
		</td></tr>";
$l++;
}
?>
		</tbody>
	</table>
</center>
</div>
</body>
</html>
