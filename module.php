<?php 


function db_con(){
$dsn = "mysql:dbname=ec_site;host=localhost;charset=utf8";
$user = "root";
$pass = "root";
$pdo = new PDO($dsn,$user,$pass);
return $pdo;
}


function session_debug() {
	echo"SESSIONの中身:<pre>";
	print_r($_SESSION);
	echo "</pre>";
}

function post_debug(){
	echo"Postの中身:<pre>";
	print_r($_POST);
	echo "</pre>";
}

//for debug
function add_cart(){
	foreach($_POST as $key => $val){
		$array["$key"]=$val;
	}
	$_SESSION["cart"][]=$array;
}

function add_cart_debug(){
	foreach($_POST as $key => $val){
		$array["$key"]=$val;
	}
	echo"array contents:<pre>";
	var_dump($array);
	echo "</pre>";
	$_SESSION["cart"][]=$array;
}

function get_table($db_name){
	$pdo = db_con();
	$sql ="select * from ".$db_name;
	$stmt= $pdo->query($sql);
 	$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
 	return $result;
}

// for getting purchase list in my page

function get_mypage_purchase(){
	$pdo = db_con();
	// SELECT * FROM `orders` join product on product_id = product.id WHERE user_id = 2 
	$sql ="select * from orders join product on product_id = product.id where user_id =".$_SESSION["login"]["id"];
	$stmt = $pdo->query($sql);
	$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
	return $result;
}

function get_table_debug($db_name){
	$pdo = db_con();
	$sql ="select * from ".$db_name;
	$stmt= $pdo->query($sql);
 	$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
 	echo $db_name."テーブル:の情報";
 	echo "<pre>";
 	print_r($result);
 	echo "</pre>";
}

function get_table_data($table_name){
	$count = 0;
	$pdo = db_con();
	$sql ="select * from ".$table_name;
	$stmt= $pdo->query($sql);
 	$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

 	echo $table_name."テーブルのレコード情報<br><br>";
 	echo "<table>";
 		foreach($result as $array){

 			if($table_name =="product"){
 				if($count == 0){
 					echo "<tr>";
 						echo "<th>登録ID</th>";
 						echo "<th>画像ID</th>";
 						echo "<th>商品名</th>";
 						echo "<th>詳細</th>";
 						echo "<th>価格</th>";
 						echo "<th>原価</th>";
 						echo "<th>在庫数</th>";
 					echo "</tr>";
 					echo "<tr>";
 					$count=1;
 				}
 			} else {
				echo "<tr>"; //table head not shown ver (else)
			}
 			  foreach($array as $key => $value){
 			  			echo "<td>";
		 			  		echo $value;
		 			  	echo "</td>";
 			  		}  			  			
 			  			echo "<td>";
		 			  		echo "<form method='post' style='display:inline-block;'>";
			 			  		echo "<input type='hidden' name='delete_id' value=".$array["id"].">";
			 			  		echo "<input type='submit' name='delete_btn' value='削除'>";
			 			  	echo "</form>";
		 			  	echo "</td>";	  		
 			  	echo "</tr>";
 			  				  	  	
 			  }			 	
 	echo "</table>";
}//function get_all_table end 


function insert($table_name) {
	$pdo = db_con();
	
	if($table_name == "product"){
		$sql = "insert into "
			.$table_name. "(img_id,name,description,price,cost,stock) 
			values (:img_id,:name,:description,:price,:cost,:stock) ";
		$stmt = $pdo->prepare($sql);

		foreach($_POST as $key => $val){	

			if($key != "insert_product"){

				$get_post[$key] = $val;
				$stmt->bindValue(":$key",$get_post[$key],PDO::PARAM_STR);
				//priceとstockはint型にするためにifで型変更
				if($key == "price" || $key == "stock" || $key ="cost"){
					//これ入れるとなんか登録できないhtmlspecialchars($val,ENT_QUOTE);
					$get_post[$key]=intval($val);
					$stmt->bindValue(":$key",$get_post[$key],PDO::PARAM_INT);
				}
			}			
		}//foreach end
		$stmt->execute();
	}//if end

	if($table_name == "users"){
		$sql = "insert into "
			.$table_name. "(name,email,password,postal_code,address,phone,created_at) 
			values (:name,:email,:password,:postal_code,:address,:phone,now()) ";

		$stmt = $pdo->prepare($sql);

		foreach($_POST as $key => $val){
			if($key != "user_register"){
				$get_post[$key] = $val;
				$stmt->bindValue(":$key",$get_post[$key],PDO::PARAM_STR);
			}			
		}//foreach end
		$stmt->execute();
	}//if end

	if($table_name == "orders"){
		$sql ="INSERT INTO orders (user_id,product_id,amount,purchased_at) VALUES(:user_id,:product_id,:amount,now())";

		$stmt = $pdo->prepare($sql);
		$array["user_id"]=intval($_SESSION["login"]["id"]);
		$stmt->bindValue(":user_id",$array["user_id"],PDO::PARAM_INT);

		foreach($_SESSION["cart"] as $key => $row){
			print("test");
			$array["product_id"]= intval($_SESSION["cart"][$key]["id"]);
			$array["amount"]= intval($_SESSION["cart"][$key]["amount"]);
			$stmt->bindValue(":product_id",$array["product_id"],PDO::PARAM_INT);
			$stmt->bindValue(":amount",$array["amount"],PDO::PARAM_INT);
			$stmt->execute();
		}//foreach end
	$_SESSION["cart"]=[];
	// echo "ご注文ありがとう";
	}//if end

	// $stmt->execute();
	// print_r($stmt -> errorInfo());

	if($_GET["debug"] == "on"){
		header("location:  http://localhost:8888/pdo/module_debug.php?module=switched");
		exit;
	}
	//this function should be used on register.php only .when i use de comment out.
	//header("location:  http://localhost:8888/pdo/register.php");
	//exit;
}


function delete($table_name) {
	$pdo = db_con();
	$delete_id = $_POST["delete_id"];
	$sql = "delete from ".$table_name." where id = :delete_id;";
	$stmt = $pdo->prepare($sql);
	$stmt->bindValue(":delete_id",$delete_id,PDO::PARAM_INT);
	$stmt->execute();
}


function login() {
	echo "<br>loginでpostしたやつ：<pre>";
	print_r($_POST);
	echo "</pre>";
	$email = $_POST["email"];
	$password=$_POST["password"];
	$pdo = db_con();
	$sql = "select * from users where email = :email";
	$stmt = $pdo->prepare($sql);
	$stmt->bindValue(":email",$email,PDO::PARAM_STR);
	$stmt->execute(); //userいるか確認
	echo "ログイン認証のためのquery result : ";
	print_r($stmt -> errorInfo());
	echo "<br><br>";
	$user_info=$stmt->fetch(PDO::FETCH_ASSOC);
	echo "user_infoの中(fetchでとってきたやつ)：<pre>";
	print_r($user_info);
	echo "</pre>";
	
	if($user_info && $user_info["password"] == $password){
		$_SESSION["login"]=$user_info;	
	}
	echo "session loginの中身:";
	if($_SESSION["login"]){
		echo "<pre>";
		print_r($_SESSION["login"]);
		echo "</pre>";
	} else {
		echo "nothing in session<br><br>";
	}
	
	echo "login state : ";
	if($_SESSION["login"]){
		echo "login successfully<br><br>";
		//redirect("transaction");
	}else {
		echo "login failed<br><br>";
	}
}

function destroy_login(){
	$_SESSION["login"]=[];
	session_destroy();
}

function to_debug(){
	echo "<a href='module_debug.php'>GO module debug</a><br><br>";
}

function redirect($file){
	$url="http://localhost:8888/ec_site/".$file.".php";
	header("Location: $url");
	exit;
}

function destroy_cart_debug() {
	echo "blank car button is clicked<br>";
	$_SESSION["cart"]=[];
}

function destroy_cart() {
	$_SESSION["cart"]=[];
}

function linkbook() {
	if($_SESSION["login"]["name"]=="管理者"){
		echo "<a href='register.php'>商品登録ページ</a>";
	}
	echo "<a href='shopping.php'>Shopping Page</a>
		<a href='mypage.php'>My Page</a>
		";

	if(empty($_SESSION["login"])){
		echo "<a href='login.php'>Log In</a>
		<a href='user_register.php'>会員登録ページ</a>	";
	}
	if(!empty($_SESSION["login"])){

		echo "<a href='logout.php'>Log out</a>";
	}
	


}

function show_sales_daily(){
	$pdo = db_con();
			$sql = "select purchased_at,sum(price*amount) from orders 
					join product 
					on orders.product_id = product.id
					group by purchased_at
					;
					";
			$stmt= $pdo->query($sql);
 			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
 		 	$count = 0;
 		 	echo "<table>";
 		 	foreach($result as $row){		
 		 		if($count != 0){
 		 			echo "<tr>";
 		 		}	
	 		 		if($count == 0){
	 		 			echo "<tr>";
		 		 			echo "<th>";
		 		 				echo "日付";
		 		 			echo "</th>";
		 		 			echo "<th>";
		 		 				echo "売上";
		 		 			echo "</th>";
	 		 			echo "</tr>";
	 		 			echo "<tr>";
	 		 		}
		 		 		echo "<td>";
		 		 			echo $row["purchased_at"];
		 		 		echo "</td>";
		 		 		echo "<td>";
		 		 			echo $row["sum(price*amount)"];
		 		 		echo "</td>";
	 		 		echo "</tr>";
	 		 		
 		 		$count = $count +1;
 		 	}
 		 	echo "</table>";
}

function show_sales_debug(){
	$pdo = db_con();
	$sql = "select purchased_at,sum(price*amount) from orders 
			join product 
			on orders.product_id = product.id
			group by purchased_at
			;
			";
	$stmt= $pdo->query($sql);
	$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
	echo "<pre>";
	print_r($result);
	echo "</pre>";
}

function show_orders() {
	$pdo = db_con();
	$sql = "select * from orders 
			join product 
			on orders.product_id = product.id
			join users 
			on orders.user_id = users.id;
			";
	$stmt= $pdo->query($sql);
	$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
	echo "<pre>";
	print_r($result);
	echo "</pre>";
}

function auth(){
	if(empty($_SESSION["login"])){
		redirect("user_register");
	}
}

function show_user_info(){
	$keys=array(
		"name"=>"名前",
		"postal_code"=>"郵便番号",
		"address"=>"住所",
		"phone"=>"電話番号");

	foreach($_SESSION["login"] as $key => $val){

		if($key == "name" || $key == "postal_code" || $key == "address" || $key == "phone"){
			$key = $keys[$key];
			echo "<p>".$key.":".$val."</p>";
		}
	}
}
// linkbook();
?>

