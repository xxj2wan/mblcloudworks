<?php
include("config.php");
ini_set("display_errors","1");
error_reporting(E_ALL);
session_start();
#print_r($_SESSION);
$userid=$_SESSION['user_id'];
if(isset($_POST['cancel'])){
        $cancel_wkid = $_POST['cancel'];
        $query=$connection->prepare("delete from apply_list where id=:id and w_id=:w_id");
        $query->bindParam("id",$userid,PDO::PARAM_INT);
	$query->bindParam("w_id",$cancel_wkid,PDO::PARAM_INT);
	$query->execute();
	$cancel_message = "Cancel was successed";
	echo "<script>alert('{$cancel_message}')</script>";
}
$query=$connection->prepare("select * from users where id=:id");
$query->bindParam("id",$userid,PDO::PARAM_STR);
$query->execute();
$result = $query->fetch(PDO::FETCH_ASSOC);
$username = $result['username'];
$name = $result['name'];
$email = $result['email'];
$user_desc = $result['etc_desc'];
?>
<html>
<head>
	<meta charset="utf-8">
	<link href="content_style.css" rel="stylesheet"/>
<script type="text/javascript">
	function chkbyte(data){
		var ko_maxbyte= 400;
		var str = data.value;
		var str_len = str.length;
		document.getElementById('text_char_num').innerHTML=str_len;	
		if ( str_len > ko_maxbyte ){
			alert("200자 이내로 작성해주시기 바랍니다.");
			document.getElementById('sp_my_infotext').innerText = val_char;
		}
}
	function maileditt(arg1){
		var editText = 'mailedit.php?mail='+arg1;
		window.open(editText,'','width=600, height=70, left=500, top=200, location=no,status=no, toolbar=no');
}
	function nameeditt(arg1){
		var editText = 'nameedit.php?name='+arg1;
		window.open(editText,'','width=600, height=70, left=500, top=200, location=no, status=no, toolbar=no');
}
</script>
</head>
<body>
	<div class=con_left>
	<b>User profile</b>
	<table>
	<tr><td class="my_ctg">이름</td><td class="my_info"><span id=whomail><?php echo $name;?></span><span id=maileditText><?php echo "<a href='javascript:void(0);' name=nameedit id=nameedit onclick='nameeditt(\"$username\")'>Edit</a>";?></span></td></tr>
	<tr><td class="my_ctg">학번</td><td class="my_info"><?php echo $username;?></td></tr>
	<tr><td class="my_ctg">Email</td><td class="my_info"><span id=whomail><?php echo $email;?></span><span id=maileditText><?php echo "<a href='javascript:void(0);' name=mailedit id=mailedit onclick='maileditt(\"$username\")'>Edit</a>"; ?></span></td></tr>
	<tr></tr>
	<form method=POST action="user_info_upload.php">
	<tr><td class="my_ctg"></td><td class="my_info"><textarea name="my_infotext" id="my_infotext" placeholder="자신을 어필 할 수 있는 내용을 200자 이내로 기재해 주세요." onkeyup="chkbyte(this);"><?php echo $user_desc;?></textarea></td></tr>
	<tr><td class="my_ctg"></td><td class="my_info"><span id="text_char_num"></span>/200 자 <input type=submit name=my_info_upload id=my_info_upload value="저장"></td></tr>
	<input type=hidden name=my_info_hidden value=<?php echo $username;?>>
	</form>
	<!--<tr><td class="my_ctg"></td><td class="my_info"><a href="">change your information</a></td></tr>-->
	</table>
	</div>

	<div class=con_right>
	<form method=POST action="">
		<div class=con_right_up>
		<b>진행중인 프로젝트</b>
		<table>
		<thead>
			<td></td>
			<td class=wklist>Title</td>
			<td id=wklistdate>Start</td>
			<td id=wklistdate>End</td>
			<td id=wklistsal>Salary</td>
		</thead>
		<tbody>
<?php
$query=$connection->prepare("select wl.w_id, wl.title, wl.start_date, wl.end_date, wl.salary, al.id, us.name, al.etc from apply_list as al left join work_list as wl on wl.w_id = al.w_id left join users as us on al.id = us.id where al.id=:id and al.etc = 'On'");
$query->bindParam("id",$userid,PDO::PARAM_INT);
$query->execute();
$l=0;
while($result=$query->fetch(PDO::PARAM_INT)){
$l++;
	$on_wkid = $result['w_id'];
	$on_title = $result['title'];
	$on_sdate = $result['start_date'];
	$on_edate = $result['end_date'];
	$on_sal = $result['salary'];
	$ch_on_sal = number_format($on_sal);
	echo "<td>$l</td>
		<td class=wklist>$on_title</td>
		<td id=wklistdate>$on_sdate</td>
		<td id=wklistdate>$on_edate</td>
		<td id=wklistsal>$ch_on_sal</td>
		<td><button type=submit name=cancel value=$on_wkid>cancel</button></td></tr>";
}
?>
		</tbody>
		</table>
		</div>
		<div class=con_right_down>
		<b>신청현황</b>
	<table>
	<thead>
		<td></td>
		<td class=wklist>Title</td>
		<td id=wklistdate>Start</td>
		<td id=wklistdate>End</td>
		<td id=wklistsal>Salary</td>
	</thead>
	<tbody>
<?php
$query=$connection->prepare("select apply_list.w_id, work_list.title, work_list.start_date, work_list.end_date, work_list.salary, users.id, apply_list.etc from apply_list left join work_list on apply_list.w_id = work_list.w_id left join users on apply_list.id = users.id where users.id=:id and apply_list.etc = 'off'");
$query->bindParam("id",$userid,PDO::PARAM_INT);
$query->execute();
$count =$query->rowCount();
$i=0;
while($result=$query->fetch(PDO::FETCH_ASSOC)){
$i++;
	$worklist = $result['title'];
	$startday = $result['start_date'];
	$endday = $result['end_date'];
	$wkid = $result['w_id'];
	$wksal = $result['salary'];
	$chwksal = number_format($wksal);
	echo "<tr><td>$i</td>
		<td class=wklist>$worklist</td>
		<td id=wklistdate>$startday</td>
		<td id=wklistdate>$endday</td>
		<td id=wklistsal>$chwksal</td>
		<td><button type=submit name=cancel value=$wkid>cancel</button></td></tr>";	
}
?>
	</tbody>
	</form>
	</table>
	</div>
	<div class="conright third">
	<b>기타</b>
	<p id=deleteAccP><button name=deleteAcc id=deleteAcc>탈퇴하기</button></p>	
	</div>
	</div>
</body>
</html>
