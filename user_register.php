<?php 
session_start();
require("module.php");


// post_debug();

if(!empty($_POST["user_register"])){
	insert("users");
	login();
	//redirect("transaction");
	// header("location:  http://localhost:8888/pdo/transaction.php");
	// 	exit;
}
// get_table_debug("users");
?>
<html>
<head>
	<style>
	input {
	display:block;
}
</style>
	<link rel="stylesheet" href="./style.css">

</head>
<?php include("header.php");?>
<h1>送り先情報登録ページ</h1>
<p>購入に先立ち商品の送り先情報の入力と会員登録をお願いします。<br>
(このフォームを記入して下のボタンを押せば登録されます。)</p>
<p>すでに会員登録済みの方は、ログインをお願いします。<br>
<a href="login.php">ログインページへ</a></p>
<form method="post">
	名前：<input type="text" name="name" value="">
	メールアドレス：<input type="text" name="email" value="">
	パスワード：<input type="text" name="password" value="">
	郵便番号：<input type="text" name="postal_code" value="">
	住所：<input type="text" name="address" value="">
	電話番号<input type="text" name="phone" value="">
	<input type="submit" name="user_register" value="入力完了と同時に会員登録">
	
</form>

</html>