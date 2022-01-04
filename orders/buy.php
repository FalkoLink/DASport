<?php
session_start();
require('../dbconnect.php');

if(!empty($_SESSION['id'])){
	$user_id = $db -> prepare('SELECT * FROM `users` WHERE `id` = ?');
	$user_id -> bindParam(1, $_SESSION['id'], PDO::PARAM_INT);
	$user_id -> execute();
	$user = $user_id -> fetch();
}elseif(!empty($_COOKIE['email'])){
	$user_email = $db -> prepare('SELECT * FROM `users` WHERE `email` = ?');
	$user_email -> bindParam(1, $_COOKIE['email'], PDO::PARAM_STR);	
	$user_email -> execute();
	$user = $user_email -> fetch();
}else{
	header('Location: ../index.php');
	exit();
}

if($_REQUEST['p']){
	$product = $db -> prepare('SELECT * FROM `products` WHERE `id` = ?');
	$product -> execute(array($_REQUEST['p']));
	$prod = $product -> fetch();
}else{
	header('Location: ../index.php');
	exit();
}

$sum = $prod['price'] * $_SESSION['order']['number'];

if (!empty($_POST)) {
	$orders = $db -> prepare('INSERT INTO `orders` SET `user_id` = ?, `prod_id`=?, `how_much`=?, `size`=?, `color` = ?, `price` = ?, `date_created`=NOW()');
	$orders -> execute(array($user['id'], $prod['id'], $_SESSION['order']['number'], $_SESSION['order']['size'], $_SESSION['order']['color'], $sum));
	unset($_SESSION['order']);

	header('Location: ../index.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>DASport</title>
	<style>
		* {
			padding: 0;
			margin: 0;
			box-sizing: border-box;
		}
		body {
			width: 100vw;
			height: 100vh;
			display: flex;
			justify-content: center;
			align-items: center;
			background: linear-gradient(45deg, rgb(0, 0, 0), rgb(32, 48, 92));
		}
		.buy_now {
			padding: 10px;
			display: flex;
			justify-content: center;
			align-items: center;
			width: 30%;
			background: rgba(255, 255, 255, 0.01);
	box-shadow: 0 10px 25px black;
	backdrop-filter: blur(8px);
	border-radius: 10px;
	color: white;
	font-family: monospace;
		}
		form {
			height: 100%;
			display: flex;
			flex-flow: column;
			justify-content: center;
			text-align: center;
			
		}
		form h1,h2,h3 {
			padding: 5px;
			border-bottom:2px solid orange; 
		}
		form img {
			margin-bottom: 20px;
			border-radius: 7px;
		}
		input{
			font-weight: 600;
			color: white;
			margin: 5px;
			width: 100px;
			padding: 10px 20px; 
			border-radius:7px; 
			border:1px solid #3c9;
			background: linear-gradient(45deg, rgb(0, 0, 0), rgb(32, 48, 92));
			transition: .3s ease-in-out;
		}
		input:hover{
			background: rgb(51, 204, 102);
			animation: animate .3s infinite ;
		}
		@keyframes animate {
			50%{
				transform: rotate(3deg);
			}
			100%{
				transform: rotate(-3deg);
			}
		}
		
	</style>
</head>
<body>
	<div class="buy_now">
		<form action="" method="POST">
			<input type="hidden" name="action" value="submit">
			<img src="../products_photo/<?= $prod['photos']?>" alt="photos" width="200px">
			<h2>Product Name:<?= $prod['title']?></h2>
			<h2>Cost:<?= $prod['price']?>$</h2>
			<h3>Size: <?= $_SESSION['order']['size']?></h3>
			<h3>How Much: <?= $_SESSION['order']['number']?></h3>
			<h3>Color: <?= $_SESSION['order']['color']?></h3>
			<h1>Total Cost: <?php echo $sum.'$'?></h1>
			
			<input type="submit" value="Buy">
		</form>
	</div>
</body>
</html>