<?php 
session_start();

require('module.php');

// to_debug();

if(!empty($_POST["login"])){
	login();
	redirect("mypage");
}

//session_debug();
//get_table_debug("users");

//sessionにユーザー情報格納を一度のみにするためにこの場所に書く必要がある
// if($_POST["submit"]){
	
// 	//echo "submitされt";
// 	$url="http://localhost:8888/pdo/login.php";
// 	header("Location: $url");
// 	exit;
// }
?>

<html>
<head>
	<link rel="stylesheet" href="./style.css">
</head>
<?php include("header.php");?>
	<h1>ログインページ</h1>
	<p>ログイン情報を入力してください。</p>
	<form method="post">
		Email<input type="text" name="email" value="">
		Password<input type="text" name="password" value="">
		<input type="submit" value="submit" name="login">
	</form>
	<form method="post">
		<input type="submit" name="delete_session" value ="deleteSession">

	</form>
	<p>テストログイン用： Email：test@gmail.com Pass=：pass　</p>
	<p>テスト管理者ログイン用： Email：admin@gmail.com Pass=：admin　</p>
	<!-- <a href="mypage.php">My page</a>
	<a href="shopping.php">Shop page</a>
	<a href="signup.php">Sign up</a> -->
</html>
