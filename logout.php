<?php 
	session_start();
	$_SESSION["login"]=[];
	session_destroy();
?>
<html>
<head>
	<link rel="stylesheet" href="./style.css">
</head>
<body>

	<h1>Log out</h1>
	<p>You are logged out</p>
	<a href="login.php">Log in</a>
	<a href="shopping.php">shopping pageへ</a>
</body>
	
</html>