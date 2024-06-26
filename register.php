<?php 

require('module.php');

if(!empty($_POST["insert_product"])){
	insert("product");
}

if(!empty($_POST["delete_btn"])){
	delete("product");
}
?>


<html>
<head>
	<link rel="stylesheet" href="./style.css">
</head>
	<body>
		<?php include("header.php");?>
		管理者用
		<h1>商品登録ページ</h1>
		<p>以下を入力して送信するとDBに登録されます</p>
		<form method="post">
			<label for="name" class="register_label">
				商品名：
				<input type="text" name="name" value="" id="name">
			</label>
			
			<label for="description" class="register_label">
				商品の説明：
				<input type="text" name="description" value="" id="description">
			</label>
			<label for="price" class="register_label">商品価格：
				<input type="text" name="price" value="" id="price">
			</label>
			<label for="stock" class="register_label">在庫数：
				<input type="text" name="stock" value="" id="stock">
			</label>
			<label for="img_id" class="register_label">商品画像：
				<input type="text" name="img_id" value="" id="img_id">
			</label>
			<input type="submit" name="insert_product" value="商品登録する">
		</form>
	</body>
</html>

<?php 
	get_table_data("product");
?>