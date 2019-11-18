<html>
<head>
<meta charset="utf-8">
<link href="teststyle.css" rel="stylesheet">
</head>
<?php
include("config.php");
ini_set("display_errors","1");
error_reporting(E_ALL);
session_start();
if(isset($_POST['in_login'])){
	$username=$_POST['in_username'];
	$password=$_POST['in_password'];
	$query=$connection->prepare("select * from users where USERNAME=:username");
	if($username == "" | $password == ""){
		echo '<script>alert("please check your id or password")</script>';
	}else{
	$query->bindParam("username", $username, PDO::PARAM_STR);
	$query->execute();
	$result = $query->fetch(PDO::FETCH_ASSOC);
	if(!$result){
		$mess="<font color=white>Something went wrong!</font>";
		 echo "<script>alert('please check your id or password');</script>";
/*		echo '<p class="error">Username password combination is wrong!</p>';*/
	}else{
		if (password_verify($password, $result['password'])){
			$_SESSION['user_id'] = $result['id'];
			header('Location: main.php');
		}else{
			echo '<script>alert("아이디와 비밀번호를 확인하세요.");</script>';	
			
		}
	}
}
}
if(isset($_POST['register'])){	
	$reg_username = $_POST['up_username'];
	$reg_email = $_POST['up_email'];
	$reg_password = $_POST['up_password'];
	$reg_name = $_POST['up_name'];
        $reg_password_hash = password_hash($reg_password, PASSWORD_BCRYPT);
        $query = $connection->prepare("SELECT * FROM users WHERE EMAIL=:email");
        if($reg_username == "" | $reg_email == ""){
		echo '<script>alert("Please check your id or email")</script>';
	}else{
	$query->bindParam("email", $reg_email, PDO::PARAM_STR);
	$query->execute();

        if($query->rowCount() > 0){
                echo '<script>alert("please check your id or mail!");location.href="test.php"</script>';
        }
        if($query->rowCount() == 0){
                $query = $connection->prepare("INSERT INTO users (USERNAME,PASSWORD,EMAIL,NAME) VALUES (:username, :password_hash, :email, :name)");
                $query->bindParam("username", $reg_username, PDO::PARAM_STR);
                $query->bindParam("password_hash", $reg_password_hash, PDO::PARAM_STR);
                $query->bindParam("email",$reg_email, PDO::PARAM_STR);
		$query->bindParam("name",$reg_name, PDO::PARAM_STR);
                $result = $query->execute();
                if($result){
                        echo "<script>alert('Your registration was successful')</script>";
                }else{
                       	echo "<script>alert('please check your password or email');</script>";
                }
        }
}
}

?>
<form method=POST action="" name="sigin-form">
<div class="login-wrap">
	<div class="login-html">
		<input id="tab-1" type="radio" name="tab" class="sign-in" checked><label for="tab-1" class="tab">로그인</label>
		<input id="tab-2" type="radio" name="tab" class="sign-up"><label for="tab-2" class="tab">회원가입</label>
		<div class="login-form">
			<div class="sign-in-htm">
				<div class="group">
					<label for="user" class="label">학번</label>
					<input id="user" type="text" class="input" name="in_username">
				</div>
				<div class="group">
					<label for="pass" class="label">비밀번호</label>
					<input id="pass" type="password" class="input" data-type="password" name="in_password" >
				</div>
				<div class="group">
					<label for="pass" class="label"><p id="loginerror"></p></label>
				</div>
				<div class="group">
					<input type="submit" class="button" value="Sign In" name="in_login">
				</div>
				<div class="hr"></div>
				<div class="foot-lnk">
					<!--<a href="#forgot">Forgot Password?</a>-->
				</div>
				<div class="group">
					<p class=input><font color=red>Internet explorer가 제대로 작동하지 않을 수 있습니다. Chrome 으로 사용을 권장합니다.</font></p>
				</div>
			</div>
			<div class="sign-up-htm">
				<div class="group">
					<label for="user" class="label">학번 &nbsp;&nbsp; ex) 2011105127</label>
					<input id="user" type="text" class="input" name="up_username" pattern="[a-zA-z0-9]+">
				</div>
				<div class="group">
					<label for="user" class="label">이름</label>
					<input id="user" type="text" class="input" name="up_name" >
				</div>
				<div class="group">
                                        <label for="pass" class="label">비밀번호</label>
                                        <input id="pass" type="password" class="input" data-type="password" name="up_password">
                                </div>
				<div class="group">
					<label for="pass" class="label">비밀번호 재입력</label>
					<input id="pass" type="password" class="input" data-type="password">
				</div>
				<div class="group">
					<label for="pass" class="label">Email</label>
					<input id="pass" type="text" class="input" name="up_email">
				</div>
				<div class="group">
					<input type="submit" class="button" value="Sign Up" name="register">
				</div>
				<div class="group">
					<p class=input><font color=red>- 다른 실험실에 소속된 학부생은 <font color=white>지도교수님의 허락</font>을 받아야함.<br><br>
					- 4대 보험 가입자 이용불가</font></p>

				</div>
			</div>
		</div>
	</div>
</div>
</form>
</html>
