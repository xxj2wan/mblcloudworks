<?php
  
include("config.php");
ini_set("display_errors","1");
error_reporting(E_ALL);
session_start();

if(isset($_POST['login'])){
        $username = $_POST['username'];
        $password = $_POST['password'];
        $query = $connection->prepare("SELECT * FROM users WHERE USERNAME=:username");
        $query->bindParam("username", $username, PDO::PARAM_STR);
        $query->execute();
        $result = $query->fetch(PDO::FETCH_ASSOC);
        if (!$result){
                echo '<p class="error">Username password combination is wrong!</p>';
        } else {
                if (password_verify($password, $result['password'])) {
                        $_SESSION['user_id'] = $result['id'];
                        echo '<p class="success">Congratulations, you are logged in!</p>';
			header('Location: main.php');
                } else {
                        echo '<p class="error">Username password combination is wrong!</p>';
                }
        }
}

?>
<html>
<head>
<meta charset="utf-8">
<link href="style.css" rel="stylesheet">
<style>
</style>
</head>
<body class = "body-background">
<div id="body-right">
<form method="post" action="" name="signin-form" id="loginform">
	<div class="form-element">
	<label>Username</label>
	<input type="text" name="username" pattern="[a-zA-Z0-9]+" required />
	</div>
	<div class="form-element">
	<label>Password</label>
	<input type="password" name="password" required />
	</div>
	<button type="submit" name="login" value="login">Log in</button>
	<button type="submit" name="register" value="register">Register</button>
</form>
</div>
</body>
</html>
