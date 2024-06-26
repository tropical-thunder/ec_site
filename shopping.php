<?php 

session_start();
require('module.php');
// linkbook();

//カートに入れるボタンが押されたら、セッションに追加
if(!empty($_POST)){
	add_cart();
	// redirect("shopping");
}
//session_debug();
//get_table_debug("product");
$result = get_table("product");

$count=0;
?>

<html>
	<head>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
		<link rel="stylesheet" href="./style.css">
	</head>

	<body>
		<?php include("header.php");?>
		<div class="eyecatch">
			<img src ="logo.png">
		</div>
		<div class="container">
			<div class="mypage_box">
					
				<div>
					<h1>商品一覧</h1>
					<p class="align_l">
						<a href="cartcheck.php">カートを見る</a>
					</p>
				</div>
				<div>
						<?php if($_SESSION["login"]){
							echo "<p>".$_SESSION["login"]["name"]."さん、こんにちは</p>";
							echo "<p><a href='logout.php'>Log out</a></p>";
						} else {
							echo "<a href='login.php'>Log in</a>";
						} ?>
				</div>
					
					
					
			</div>

			<div>		
				<?php foreach($result as $array):?>
					<!-- <?php print_r($array);?> -->
					<?php if($count == 0):?>
						<div class="row">
					<?php endif; $count++; ?>
						<div class="col-4">
							<div class="product_block">
								<?php //echo $count;?>
								<form method="post" action="#">
									<img class="d_block product_img" src="<?php echo $array["img_id"];?>.jpg">
									<input type="hidden" name="img_id" value="<?php echo $array["img_id"];?>">
									<input class="d_block product_list" type="hidden" name="id" value="<?php echo $array["id"];?>">
									<input class="d_block product_list" type="text" name="name" value="<?php echo $array["name"];?>"readonly>
									<input class="d_block product_list" type="hidden" name="description" value="<?php echo $array["description"];?>">
									<input class="d_block product_list align_r" type="text" name="price" value="<?php echo $array["price"];?>円"readonly>
									個数：<select class="d_block" name="amount">
										<?php for($i=1; $i <= $array["stock"] ; $i++):?>
										<option><?php echo $i;?></option>
										<?php endfor;?>
									</select>
									<input type="submit" value="カートに入れる">
								</form>
							</div>
						</div>

					<?php if($count == 3):?>
						</div>
					<?php endif;  if($count== 3){ $count=0;} ?>
				
				<?php endforeach;?>
					
				
			</div>

			
		</div>
	</body>
</html>