<?php
ini_set("display_errors","1");
error_reporting(E_ALL);
include("config.php");
session_start();
##
if(isset($_POST['close'])){
	print_r($_POST);
	$wkid = $_POST['close'];
	$query=$connection->prepare("update work_list set status = \"closed\" where w_id=:w_id");
	$query->bindParam("w_id",$wkid,PDO::PARAM_INT);
	$query->execute();
	print_r($query);
	print_r($query->rowCount());
	if($query->rowCount() == 0){
		$mess="Something went wrong";
		echo "<script>alert('{$mess}');</script>";
	}
	if($query->rowCount() == 1){
		$mess = "This work's status is closed from now.thank you";
		echo "<script>location.href='management.php'</script>";
		exit;
	}
}
if(isset($_POST['nonclose'])){
	print_r($_POST);
	$wkid = $_POST['nonclose'];
	$query=$connection->prepare("update work_list set status = \"recruit\" where w_id=:w_id");
	$query->bindParam("w_id",$wkid,PDO::PARAM_INT);
	$query->execute();
	print_r($query);
	print_r($query->rowCount());
	if($query->rowCount() == 0){
		$mess = "Something went wrong";
		echo "<script>alert('{$mess}');</script>";
	}
	if($query->rowCount() == 1){
		$mess = "This work's staus is recruit from now. thank you";
		echo "<script>location.href='management.php'</script>"; 
		exit;
	}
}
if(isset($_POST['edit'])){
	$wkid = $_POST['edit'];
	$query = $connection->prepare("select * from work_list where w_id=:w_id");
	$query->bindParam("w_id",$wkid,PDO::PARAM_INT);
	$query->execute();
	$result=$query->fetch(PDO::FETCH_ASSOC);
	
	$wktitle = $result['title'];
	$wkrequire = $result['require_pp'];
	$wksdate = $result['start_date'];
	$wkedate = $result['end_date'];
	$unit = $result['unit'];
	$ETE = $result['ETE'];
	$salary = $result['salary'];
	$work_desc = $result['work_desc'];
	
}
if(isset($_POST['save'])){
	$chtitle = $_POST['reg_title'];
	$chrepp = $_POST['reg_number'];
	$chsdate = $_POST['reg_s_date'];
	$chedate = $_POST['reg_e_date'];
	$chsal = $_POST['reg_salary'];
	$chunit = $_POST['unit'];
	$chETE = $_POST['ETE'];
	$chdesc = $_POST['reg_desc'];
	$index_wid = $_POST['hidden'];

	$query=$connection->prepare("update work_list set title=:title, require_pp=:repp, start_date=:sdate, end_date=:edate, salary=:sal, unit=:unit, ETE=:ETE, work_desc=:wdesc where w_id=:w_id");
	$query->bindParam("title",$chtitle,PDO::PARAM_STR);
	$query->bindParam("repp",$chrepp,PDO::PARAM_INT);
	$query->bindParam("sdate",$chsdate,PDO::PARAM_STR);
	$query->bindParam("edate",$chedate,PDO::PARAM_STR);
	$query->bindParam("sal",$chsal,PDO::PARAM_INT);
	$query->bindParam("unit",$chunit,PDO::PARAM_STR);
	$query->bindParam("ETE",$chETE,PDO::PARAM_INT);
	$query->bindParam("wdesc",$chdesc,PDO::PARAM_STR);
	$query->bindParam("w_id",$index_wid,PDO::PARAM_INT);
	$query->execute();
	if($query->rowCount() == 0){
		$mess = "nothing to change, or something went wrong, please check";
		echo "<script>alert('{$mess}')</script>";
	}elseif($query->rowCount() == 1){
		$mess = "success to change";
		echo "<script>alert('{$mess}');location.href='management.php'</script>";
	}
	
	
}
if(isset($_POST['list_del'])){
	$wkid = $_POST['hidden'];
	$query=$connection->prepare("delete from work_list where w_id=:w_id");
	$query->bindParam("w_id",$wkid,PDO::PARAM_INT);
	$query->execute();
	if($query->rowCount() == 0){
		$mess = "Something went wrong";
		echo "<script>alert('{$mess}')</script>";
	}
	if($query->rowCount() == 1){
		$mess = "delete have successed";
		echo "<script>alert('{$mess}')</script>";
	}
}
?>
<html>
<head>
<meta charset="utf-8">
<link href="content_style.css" rel="stylesheet">
</head>
<body>
<form method="POST" action="">
	<center>
	<table id="upload_tb">
        <tr><td class=upload_ctg>실험주제</td><td class=upload_input><input type="text" name="reg_title" id="reg_title" class="input" <?php echo "value=$wktitle";?>></td></tr>
	<tr><td class=upload_ctg>필요인원</td><td class=upload_input><input type="number" name="reg_number" id="reg_number" class="input" <?php echo "value=$wkrequire";?>> 명 </td></tr>
	<tr><td class=upload_ctg>기간</td><td>
            <input type="date" name="reg_s_date" id="reg_s_date" class="input" <?php echo "value=$wksdate";?>> 부터 
            <input type="date" name="reg_e_date" id="reg_e_date" class="input" <?php echo "value=$wkedate";?>> 까지
	</td></tr>
	<tr><td class=upload_ctg>예상소요시간</td><td class=upload_input><input type="number" name="ETE" id="ETE" class="input" <?php echo "value=$ETE";?>></td></tr>
	<tr><td class=upload_ctg>급여</td><td class=upload_input><input type="number" name="reg_salary" id="reg_salary" class="input" <?php echo "value=$salary";?>> 원 / <input type="text" name="unit" id="unit" class="input" <?php echo "value=$unit";?>></td></tr>
	<tr><td class=upload_ctg>설명</td><td class=upload_input><textarea rows="5" cols="50" name="reg_desc" id="reg_desc" ><?php echo "$work_desc";?></textarea></td></tr>
	<tr><td class=upload_ctg></td><td class=upload_input>
	    <input type=hidden name=hidden value=<?php echo "$wkid";?>>
            <input type="submit" class=button value="save" name="save">
            <input type="submit" class=button value="back" name="back">
	    <input type="submit" class=button value="del" name="list_del">
	</td></tr>
	</table>
	</center>
</form>
</div>
</body>
</html>
