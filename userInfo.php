<?php
#ini_set("display_errors","1");
#error_reporting(E_ALL);
include("config.php");
session_start();

$w_id = $_GET['ider'];
####
if(isset($_POST['accept'])){
	$array=$_POST['employee'];
	$count=count($array);
	$query=$connection->prepare("update apply_list set etc = 'On' where w_id=:w_id and id=:id");
	for($i=0;$i < $count; $i++){
		$query->bindParam("w_id",$w_id,PDO::PARAM_INT);
		$query->bindParam("id",$array[$i],PDO::PARAM_INT);
		$query->execute();
	}	
}
?>
<html>
<head>
<meta charset="utf-8">
<link href="content_style.css" rel="stylesheet">
</head>
<script type="text/javascript">
	function detail_user(arg1){
		var valu = 'user_detail.php?userid='+arg1;
		window.open(valu,"_blank","width=400, height=300");
}
</script>

<body>
<div class = "work_summary">
<form method=POST action="emp_cancel.php">
<?php
$query=$connection->prepare("select * from work_list where w_id=:w_id");
$query->bindParam("w_id",$w_id,PDO::PARAM_INT);
$query->execute();

echo "<center><font size=30px>Work summary</font><table>";
$result=$query->fetch(PDO::FETCH_ASSOC);
$sl_title = $result['title'];
$sl_req = $result['require_pp'];

echo "<tr><td>Title</td><td>$sl_title</td></tr>
	<tr><td>Require</td><td>$sl_req</td></tr>";

$query=$connection->prepare("select wl.w_id, wl.title, wl.require_pp, ap.id, us.name, ap.etc 
from work_list as wl left join apply_list as ap 
on wl.w_id = ap.w_id 
left join users as us on ap.id = us.id 
where wl.w_id = :w_id and ap.etc = 'On' ");

$query->bindParam("w_id",$w_id,PDO::PARAM_INT);
$query->execute();
echo "<tr><td colspan = 2><center><b>Employee list</b></center></td></tr><tr>";
while($result=$query->fetch(PDO::FETCH_ASSOC)){
	$sl_name = $result['name'];
	$sl_id = $result['id'];
echo "<td>$sl_name</a></td><td><button type=submit name=cancel value=$sl_id>cancel<input type=hidden name=del_hidden value=$w_id><input type=hidden name=del_id_hidden value=$sl_id></td></tr><tr>";
}
echo "<td></td></tr></table></center>";
?>
</form>
</div>
<div class = "user_summary">
<form method=POST action="">

<?php
$query=$connection->prepare("select ap.w_id, us.name, us.id from apply_list as ap left join users as us on ap.id = us.id where w_id=:w_id and etc = 'off'");
$query->bindParam("w_id",$w_id,PDO::PARAM_INT);
$query->execute();
	echo "<font size=30px;>Applicants</font><table>
		<tr><td><b>Name</b></td><td></td></tr>";
while($result=$query->fetch(PDO::FETCH_ASSOC)){
	$name = $result['name'];
	$nameid = $result['id'];
	echo "<tr><td><a href='' onclick='detail_user($nameid)'>$name</a></td>
		<td><input type=checkbox name=employee[] value=$nameid></td>
		</tr>";
}
	echo "<tr><td colspan=2><input type=submit name=accept value=accept></td></tr></table>";
?>
</form>
</div>
</body>
</html>
