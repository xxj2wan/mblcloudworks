<html>
<head>
<meta charset="utf-8">
<link href="content_style.css" rel="stylesheet"/>
</head>
<script type="text/javascript">
        function paging(arg1){
                var adres = 'mainframe.php?page='+arg1;
/*              alert(adres);*/
                location.href=adres;
}
	function summarywork(arg1){
		var wklist = 'summarywork.php?wid='+arg1;
		window.open(wklist,'','width=600,height=500,left=500,top=300');
}
</script>
<?php
#ini_set("display_errors","1");
#error_reporting(E_ALL);
include("config.php");
session_start();

$user_id = $_SESSION['user_id'];
if(isset($_POST['apply'])){
	$app_list_wid = $_POST['apply'];
	$query=$connection->prepare("select * from apply_list where w_id=:w_id and id=:id");
	$query->bindParam("w_id",$app_list_wid,PDO::PARAM_INT);
	$query->bindParam("id",$user_id,PDO::PARAM_INT);
	$query->execute();
	if($query->rowCount() > 0){
		$message = "이미 지원했습니다.";
		echo "<script>alert('{$message}');</script>";
	}else if($query->rowCount() == 0){
		$query=$connection->prepare("INSERT INTO apply_list (w_id,id) VALUES (:w_id, :id)");
	        $query->bindParam("w_id",$app_list_wid,PDO::PARAM_INT);
		$query->bindParam("id",$user_id,PDO::PARAM_INT);
	        $query->execute(); 
	        if($query->rowCount() > 0){
			$suc = "성공적으로 등록되었습니다.";
			echo "<script>alert('{$suc}');</script>";
		}else{
			$err = "에러가 발생했습니다. 관리자에게 문의하세요.";
			echo "<script>alert('{$err}');</script>";
	        }
	}else{

}

}

?>
<body>
<div class=wklist_wrap>
	<div class=middle_worklist1>
	<table id=middle_table>
		<thead>
			<td class="maintd">No</td>
			<td class="maintd"></td>
			<td class="maintd">실험 주제</td>
			<td class="maintd">모집 인원</td>
			<td class="maintd" colspan=2>실험기간</td>
		<!--	<td class="maintd">종료일</td>-->
			<td class="maintd">급여(원)</td>
			<td class="maintd">예상소요시간</td>
			<td class="maintd">설명</td>
		</thead>
		<form method=POST action="">
		<tbody>
<?php
$query=$connection->prepare("select * from work_list as wl left join (select count(w_id), w_id as DD from apply_list where etc='off' group by DD) as A on wl.w_id = A.DD order by uploaded desc");
$query->execute();
if($query->rowCount() > 0){
$k=$query->rowCount();
$limitnum = 10;
$totalpage = $k;
$query=$connection->prepare("select * from work_list as wl left join (select count(w_id), w_id as DD from apply_list where etc='off' group by DD) as A on wl.w_id = A.DD order by uploaded desc limit :limitnum");

if(isset($_GET['page'])||$_GET['page'] > 1){
$cur_page = $_GET['page'];
$limitN = 10*($cur_page - 1);
$query=$connection->prepare("select * from work_list as wl left join (select count(w_id), w_id as DD from apply_list where etc='off' group by DD ) as A on wl.w_id = A.DD order by uploaded desc limit :hmlimit, :limitnum");
$query->bindParam("hmlimit",$limitN,PDO::PARAM_INT);
}

$query->bindParam("limitnum",$limitnum,PDO::PARAM_INT);
$query->execute();
while($result = $query->fetch(PDO::FETCH_ASSOC)){
        $wid=$result['w_id'];
	$recru=$result['status'];
        $title=$result['title'];
        $require=$result['require_pp'];
        $startday=$result['start_date'];
	$unit=$result['unit'];
	$ETE=$result['ETE'];
        $endday=$result['end_date'];
        $salary=$result['salary'];
        $workdesc=$result['work_desc'];
	if($result['count(w_id)'] == NULL){
		$count_wid = 0;
	}else{
		$count_wid = $result['count(w_id)'];
	}
	$chsal = number_format($salary);
			echo "<tr><td class=cont_td>$k</td>";
		if($recru == "recruit"){
			$font_col="blue";
			$recru_text="모집 중";
		}else if($recru == "closed"){
			$font_col="red";
			$recru_text="완료";
		}else if($recru == "inspection"){
			$font_col="orange";
			$recru_text="검수 중";
		}else if($recru == "progress"){
			$font_col="orange";
			$recru_text="진행 중";
		}else{
			$font_col="orange";
			$recru_text="지불 진행중";
		}
			echo "<td class=cont_td><font color=$font_col>$recru_text</font></td>
				<td class=cont_td><b><a href='javascript:void(0);' onclick='summarywork($wid);'>$title</a></b></td>
				<td class=cont_td>$count_wid / $require</td>";
		if($startday == '0000-00-00' || $endday == '0000-00-00'){
			echo "<td class=cont_td colspan=2>협의 후 조정</td>";
		}else{
			echo "<td class=cont_td colspan=2>$startday ~ $endday</td>";
		}
			echo "<td class=cont_td>$chsal / $unit</td>";
		if($ETE == NULL || $ETE == 0){
			echo "<td class=cont_td>협의 후 조정</td>";
		}else{
			echo "<td class=cont_td>$ETE 시간</td>";
		}
			echo "<td class=cont_td><p id=ctd_p>$workdesc</p></td>";
			if($recru == "recruit"){
			echo "<td><button name=apply value=$wid>apply</td>";
			}
			echo "</tr>";
$k--;
	}
}
			?>
		</tbody>
		</form>
	</table>
	</div>
	<div class="mainF paging">
	<form method=GET action=''>
                <?php
$totalPage = ceil($totalpage/10);
for($l=1; $l < $totalPage+1; $l++){
        echo "<a href='javascript:void(0);' name=paging id=paging onclick=\"paging($l);\">$l\t</a>";
}
                ?>
                </form>
	</div>
</div>
</body>
</html>
