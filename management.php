<html>
<head>
<meta charset="utf-8">
<?php
ini_set("display_errors","1");
error_reporting(E_ALL);
include("config.php");
session_start();
if(!isset($_SESSION['user_id'])){
	echo "<script>alert('로그인이 필요한 서비스 입니다.');</script>";
	echo "<meta http-equiv='refresh' content='0;url=index.php'>";
	exit;
}
$user_id = $_SESSION['user_id'];
?>
<link href="content_style.css" rel="stylesheet"/>
<script type="text/javascript">
	function statusWork(arg1){
		var ko_word = escape(arg1);
		var add = "userInfo.php?ider="+ko_word;
		window.open(add,'','width=500,height=700,left=600');
}
	function ch_status(arg1,arg2){
		var stv = document.getElementById("now_status["+arg1+"]");
		var stv_val = arg2;
		var site = "chstatus.php?status="+stv.options[stv.options.selectedIndex].value+"&wid="+stv_val;
		location.href=site;
}
	function noticebtn(arg1){
		var loSite = 'test.php?noticeid='+arg1;
		window.open(loSite,'','width=1000,height=500,left=600,top=300');
}
</script>
</head>
<body>
<div class=wklist_wrap>
	<div class=middle_worklist>
	<table id=middle_table>
		<thead>
			<td class="maintd">No</td>
			<td class="maintd"></td>
			<td class="maintd">실험</td>
			<td class="maintd">필요인원</td>
			<td class="maintd" colspan=2>기간</td>
			<td class="maintd">급여</td>
			<td class="maintd">예상소요시간</td>
			<td class="maintd">설명</td>
		</thead>
		<form method=POST action="edit.php" name='mainform'>
		<tbody>
<?php
$query=$connection->prepare("select * from work_list as wl left join (select count(w_id) as count, w_id as DD from apply_list where etc='off' group by DD) as A on wl.w_id = A.DD order by uploaded desc");
$query->execute();
$m=$query->rowCount();
$n=0;
while($result = $query->fetch(PDO::FETCH_ASSOC)){
        $wid=$result['w_id'];
	$status=$result['status'];
        $title=$result['title'];
        $require=$result['require_pp'];
        $startday=$result['start_date'];
        $endday=$result['end_date'];
	$unit=$result['unit'];
	$ETE=$result['ETE'];
        $salary=$result['salary'];
        $workdesc=$result['work_desc'];
	$chsal = number_format($salary);
	if($result['count'] == NULL){
		$count_wid = 0;
	}else{
		$count_wid = $result['count'];
	}
	echo "<tr><td class=cont_td>$m</td>";
	echo "<td class=cont_td><select name=now_status[$n] id=now_status[$n] onchange=\"ch_status($n,$wid)\">";
	echo "<option value=recruit"; if($status == "recruit"){ echo " selected ";}echo ">모집 중</option>";
	echo "<option value=progress"; if($status == "progress"){ echo " selected "; }echo ">진행 중</option>";
	echo "<option value=inspection"; if($status == "inspection"){ echo " selected "; } echo ">검수 중</option>";
	echo "<option value=payment"; if($status == "payment"){ echo " selected "; } echo ">정산 중</option>";
	echo "<option value=closed"; if($status == "closed"){ echo " selected "; } echo ">완료</option></select></td>";
	echo "
	<td class=cont_td><a href='javascript:void(0);' onclick=\"statusWork($wid);\"><font color=grey>$title</font></a></td>
	<td class=cont_td><a href='javascript:void(0);' onclick=\"statusWork($wid);\"><font color=blue>$count_wid / $require</font></a></td>";
	
	if($startday == '0000-00-00' || $endday == '0000-00-00'){
                        echo "<td class=cont_td colspan=2>협의 후 조정</td>";
                }else{
                        echo "<td class=cont_td colspan=2>$startday ~ $endday</td>";
                }

	echo"	<td class=cont_td>$chsal / $unit</td>
	<td class=cont_td>$ETE</td>
	<td class=cont_td><p id=ctd_p>$workdesc</p></td>
	<td><button class=button2 type=submit name=edit value=$wid>edit</td>";
	if($status == "recruit"){
	echo "<td class=noticebtn><a href='javascript:void(0)' id=notice name=notice onclick=\"noticebtn($wid);\">notice</a></td>";
	}
	echo "</tr>";
$n++;
$m--;
}
			?>
		</tbody>
		</form>
	</table>
	</div>
</div>
</body>
</html>
