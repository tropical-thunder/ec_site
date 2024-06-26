<?php 
session_start();
require('module.php');

// echo "<pre>";
// print_r($_SESSION);
// echo "</pre>";

// if(empty($_SESSION["login"])){
// 	$url = "http://localhost:8888/pdo/login.php";
// 	header("Location: $url");
// 	exit;
// }

// function Auth(){
// 	if(empty($_SESSION["login"])){
// 		$url = "http://localhost:8888/pdo/login.php";
// 		header("Location: $url");
// 		exit;
// 	}
// }
Auth();
// ログインしてるこのユーザーが今まで買った商品をデータベースから取得する部分
$result = get_mypage_purchase();

// print_r($result);
?>

<html>
<head>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
	<link rel="stylesheet" href="./style.css">
</head>

<?php include("header.php");?>
	
	<div class="container">
	<h1>Welcome to Mypage</h1>
	<p>Hello <?php echo $_SESSION["login"]["name"];?> さん</p>
	<h2 class="mypage_title">今までにご注文いただいた商品</h2>
	<?php foreach($result as $key => $row): ?>
			<!-- <?php print_r($_SESSION);?> -->
			<div class="check-box">
				<div class="row">
					<div class="col-sm-4">
						<img class="product_img" src="<?php echo $row["img_id"]; ?>.jpg">
					</div>
					<div class="col-sm-4">
						<div class="item_block2">
							<p>商品名：<?php echo $row["name"];?></p>
							<p>購入数：<?php echo $row["amount"];?> 個</p>
						</div>
					</div>
					<div class="col-sm-4">
						<p class="item_block3">小計：
							<?php 
							$sum = $row["price"]*$row["amount"];
							echo $sum;
							$total = $total + $sum;
							?>円	
						</p>
						<p>購入日：<?php echo $row["purchased_at"];?></p>
					</div>
				</div>
			</div>
		<?php endforeach; ?>
	</div>
	<a href="logout.php">Log out </a>
	<a href="shopping.php">Shop page </a>

</html>