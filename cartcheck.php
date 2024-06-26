<?php 

session_start();

require("module.php");

// echo "カートを空にするボタン：";
if(!empty($_POST["empty_cart"])){
	destroy_cart_debug();
	//session_destroy();
}else {
	// echo "not clicked yet<br>";
}

// session_debug();

// foreach($_SESSION["cart"] as $key => $row){
// 	echo $key."<br>";
// 	print_r($row);
	
// }
$sum;
$total=0;


?>

<html>
<head>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
	<link rel="stylesheet" href="./style.css">
</head>


<body>
	<?php include("header.php");?>
	<div class="container">
		<h1>商品カート</h1><br>
		<p>カートの中身は以下です。</p>
		<?php foreach($_SESSION["cart"] as $val): ?>
			<!-- <?php print_r($_SESSION);?> -->
			<div class="check-box">
				<div class="row">
					<div class="col-sm-4">
						<img class="product_img" src="<?php echo $val["img_id"]; ?>.jpg">
					</div>
					<div class="col-sm-4">
						<div class="item_block2">
							<p>商品名：<?php echo $val["name"];?></p>
							<p>購入数：<?php echo $val["amount"];?></p>
						</div>
					</div>
					<div class="col-sm-4">
						<p class="item_block3">小計：
							<?php 
							$sum = $val["price"]*$val["amount"];
							echo $sum;
							$total = $total + $sum;
							?>	
						</p>
					</div>
				</div>
			</div>
		<?php endforeach; ?>
		<p>合計：<?php echo $total;?>円</p>
		<form method="post">
			<input type="hidden" name="empty_cart" value="clicked">
			<input type ="submit" value="カートを空にする">
 		</form>
 		<p>
			<a href="shopping.php">商品選択画面に戻る</a>
		</p>
		<p>
			<a href="transaction.php">購入画面へ</a>
		</p>
	</div>
</body>
</html>