<?php 
//authを作る

session_start();
require("module.php");

auth();
// insert("orders");
// inserts();
if(!empty($_POST["transact"])){	
	insert("orders");
	// $url="http://localhost:8888/pdo/transaction.php";
	// header("Location: $url");
	// exit;
	// echo "ご注文ありがとうございましたd。";
	// print_r($stmt -> errorInfo());

}
// session_debug();
//get_table_debug("orders");

//necessary user_id product_id 
?>

<html>
<head>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
<link rel="stylesheet" href="./style.css">

</head>
<?php include("header.php");?>

<?php 
	if(!empty($_POST["transact"])){	
		echo "<div class='thankyou'>
				<h2>ご注文ありがとうございました。</h2><br>
				<a href='shopping.php'>Shopping Pageに戻る</a><br>
				<a href='mypage.php'>My Pageで購入したものを確認する。</a>
			</div>";
		exit;
	}
?>

<div class= "container">
<h1>最終購入確認ページ</h1>
<p>以下の宛先へ以下の商品をお届けします。
よろしいですか？</p>
<div>
	<?php show_user_info();?>
	<p>*連絡事項が発生した場合上記の電話番号に連絡します。</p>
</div>
<div>
	<?php foreach($_SESSION["cart"] as $val): ?>
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
</div>
	<form method="post">
		<input type= "submit" name="transact" value="購入する">
	</form>
</div>
</html>