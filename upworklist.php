<html>
<head>
<meta charset="utf-8">
<?php
ini_set("display_errors","1");
error_reporting(E_ALL);
include("server_con.php");
include("config.php");
session_start();
if(!isset($_SESSION['user_id'])){
	echo "<script>alert('로그인이 필요한 서비스 입니다.');</script>";
	echo "<meta http-equiv='refresh' content='0;url=index.php'>";
	exit;
}
if(isset($_POST['submit'])){
    $title = $_POST['reg_title'];
    $require = $_POST['reg_number'];
    $s_date = $_POST['reg_s_date'];
    $e_date = $_POST['reg_e_date'];
    $unit = $_POST['unit'];
    $ETE = $_POST['ETE'];
    $sal = $_POST['reg_salary'];
    $desc = $_POST['reg_desc'];
    $lab = $_POST['labselector'];
    $command = "insert into work_list (title, require_pp, start_date, end_date, salary, unit, ETE, work_desc, lab ) values ( \"$title\" , $require , \"$s_date\" , \"$e_date\" , $sal , \"$unit\" , $ETE , \"$desc\" , \"$lab\")";
	$result = $conn ->query($command); 
    if($result){
	$mess = "Success to upload";
	echo "<script>alert('{$mess}')</script>";
    }else{
	$mess = "Something went wrong";
	echo "<script>alert('{$mess}')</script>";
    }
}

?>
<link href=content_style.css rel="stylesheet">
</head>
<body>
<form method="POST" action="">
<center>
    <table id="upload_tb">
<?php 
$query=$connection->prepare("select distinct(lab) from work_list");
$query->execute();
echo "<tr><td class=upload_ctg>소속실험실</td><td class=upload_input><select name=labselector>";
while($result=$query->fetch(PDO::FETCH_ASSOC)){
        $lab=$result['lab'];
	echo "<option value=$lab>$lab</option>";
}
echo "</td></tr>";
?>
    <tr><td class=upload_ctg>실험 주제</td><td class=upload_input><input type="text" name="reg_title" id="reg_title" class="input_text"></td></tr>
    <tr><td class=upload_ctg>필요 인원</td><td class=upload_input><input type="number" name="reg_number" id="reg_number" class="input_number"> 명</td></tr>
    <tr><td class=upload_ctg>시작일</td><td class=upload_input><input type="date" name="reg_s_date" id="reg_s_date" class="input"></td></tr>
    <tr><td class=upload_ctg>종료일</td><td class=upload_input><input type="date" name="reg_e_date" id="reg_e_date" class="input"></td></tr>
    <tr><td class=upload_ctg>예상소요시간</td><td class=upload_input><input type="number" name="ETE" id="ETE" class="input_number"> 시간 </td></tr>
    <tr><td class=upload_ctg>급여</td><td class=upload_input> <input type="number" name="reg_salary" id="reg_salary" class="input"> / 
<input type="text" name="unit" id="unit" class="input" value="ex)1plate, 1회, 1개"></td></tr>
    <tr><td class=upload_ctg>내용</td><td class=upload_input><textarea rows="5" cols="50" name="reg_desc" id="reg_desc"></textarea></td></tr>
    <tr><td></td><td class=upload_btn><input type="submit" class=button value="submit" name="submit"><input type="submit" class=button value=cancel name=cancel></td></tr>
    </table>
</center>
</form>
</body>
</html>
