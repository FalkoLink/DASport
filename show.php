<?php
session_start();
require('./dbconnect.php');

if(!empty($_SESSION['id'])){
	$user_id = $db -> prepare('SELECT * FROM `users` WHERE `id` = ?');
	$user_id -> bindParam(1, $_SESSION['id'], PDO::PARAM_INT);
	$user_id -> execute();
	$user = $user_id -> fetch();
	$signin = 'entered';
}elseif(!empty($_COOKIE['email'])){
	$user_email = $db -> prepare('SELECT * FROM `users` WHERE `email` = ?');
	$user_email -> bindParam(1, $_COOKIE['email'], PDO::PARAM_STR);
	$user_email -> execute();
	$user = $user_email -> fetch();
	$signin = 'entered';
}else{
	$signin = 'not_entered';
	header("Location: index.php");
}

$product = $db -> prepare('SELECT * FROM `products` WHERE `id` = ?');
$product -> execute(array($_REQUEST['id']));
$prod = $product -> fetch();


if(!empty($_POST['number'])){
	$_SESSION['order'] = $_POST;
	header('Location: ./orders/buy.php?p='. $_REQUEST['id']);
	exit();
}

if($user['number'] == '' || $user['address'] == '' || $user['country'] == '' || $user['state'] == '' ||
$user['town'] == '' || $user['mail_index'] == ''){
	$blank = 1;
}else
	$blank = '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="style/style.css">
<title>DASport</title>
<style>
* {
	padding: 0;
	margin: 0;
	box-sizing: border-box;
}
body {
	padding: 20px;
	margin: auto;
	font-family: monospace;
	display: flex;
	justify-content: space-between;
	font-size: 16px;
	height: 100vh;
}
a {
	text-decoration: none;
	
}
.show_post {
	width: 40%;
	height: 95%;
	display: flex;
	flex-flow: wrap;
	background: rgba(255, 255, 255, 0.01);
	box-shadow: 0 10px 25px black;
	backdrop-filter: blur(8px);
	border-radius: 10px;
	padding: 10px;
}
.back{
	z-index: 1;
	font-size: 30px;
	margin: 10px;
	padding: 0px 10px;
	box-shadow: 0 0 5px 5px white;
	height: 5%;
}
.back:hover{
	background: black;
  box-shadow: 0 0 5px 5px rgb(0, 0, 0);
  color: white;
}
.show_post .photo.active {
	width: 100%;
	height: 400px;
	order: 1;
}
.show_post .photo {
	width: 150px;
	height: 128px;
	cursor: pointer;
	order: 2;
	margin: 0 7px 0 10px;
	
}
.show_pictures {
	margin-top: 10px;
}
.photo {
	transition: .3s ease-in-out;
}
.photo:hover {
	transform: scale(1.05);
	z-index: 1;
}
p {
	line-height: 23px;
	font-family: monospace;
}
h1 {
	margin-top: 10px;
}
h1 span {
	color: #bc1339;
}
.post_buy {
	margin: 10px 20px 0 40px;
	width: 35%;
	height: 90%;
	display: flex;
	flex-flow: column;
	background: rgba(255, 255, 255, 0.01);
	box-shadow: 0 10px 25px black;
	backdrop-filter: blur(8px);
	border-radius: 10px;
	padding: 20px;
}
.post_buy h1 {
	margin-bottom: 10px;
	font-family: monospace;
}
.post_buy p {
	margin-bottom: 20px;
	font-family: monospace;
	transition: 1s ease-in-out;
}
.post_buy p:hover{
	transform: scale(1.1);
	transition: 3s ease-in-out;
}
.alinks {
	display: flex;
	margin-top: 45%;
	margin-left: 0%;
	
}


.alinks input{
	padding: 7px 20px;
	border-radius: 7px;
	box-shadow: 0 10px 25px black;
		backdrop-filter: blur(8px);
		
		font-weight: 600;
}
.alinks input{
	color: #000;
	margin-left: 40px;
	background:  rgb(195, 255, 0);
	transition: .3s ease-in-out;
}
.alinks input:hover{
	background: rgb(115, 255, 0);
}
.catalog {
	overflow-y: scroll;
}
.catalog::-webkit-scrollbar {
	width: 0;
}
.size {
  display: block;
  margin: 10px 10px 0 5px;
}
.size h3 {
  color: white;
  font-weight: 300;
  font-size: 14px;
  text-transform: uppercase;
  letter-spacing: 2px;
  margin-right: 15px;
}


p{
	color: #fff;
}
.choose{
	display: flex;
}
</style>
</head>
<body>
	<?php require "./catalog.php"; ?>
	<a class="back" href="<?php if($_REQUEST['back'] == 'p'){
			echo './products.php?c='. $_REQUEST['c'];
		}elseif($_REQUEST['back'] == 's'){
			echo './sport.php?s='. $_REQUEST['s'];
		}elseif($_REQUEST['back'] == 'b'){
			echo './brand.php?b='. $_REQUEST['b'];
		}elseif($_REQUEST['back'] == 'i'){
			echo './index.php';
		}elseif($_REQUEST['back'] == 'po'){
			echo './Personal_cabinet.php';
		}
		?>"><</a>
	<div class="show_post">
		
		<img class="photo active" src="./products_photo/<?= $prod['photos']?>" alt="Photo">
		<img class="photo" src="./products_photo/<?= $prod['photos1']?>" alt="Photo">
		<img class="photo" src="./products_photo/<?= $prod['photos2']?>" alt="Photo">
		<img class="photo" src="./products_photo/<?= $prod['photos3']?>" alt="Photo">
	</div>
</div>
<div class="post_buy">
	<?php if($user['type'] == 1): ?>
	<a href="./edit.php?id=<?= $prod['id']?>">Edit</a>
	<a href="./delete.php?id=<?= $prod['id']?>">Delete</a>
	<?php endif; ?>
	<h1 style="color: #fff;"><?= $prod['title']?> <span><?= $prod['price']?>$</span></h1>
	<p>Brand: <?php 
	$prod_brand = $db -> prepare('SELECT `brands` FROM `brand` WHERE `id` = ?');
	$prod_brand -> execute(array($prod['brand_id']));
	$b = $prod_brand -> fetch();
	print($b['brands']);
	?> ;</p>
	<p>Category: <?php 
	$prod_cat = $db -> prepare('SELECT `category` FROM `categories` WHERE `id` = ?');
	$prod_cat -> execute(array($prod['categories_id']));
	$c = $prod_cat -> fetch();
	print($c['category']);
	?> ;</p>
	<p>Sport: <?php 
	$prod_sp = $db -> prepare('SELECT `sport_products` FROM `sport` WHERE `id` = ?');
	$prod_sp -> execute(array($prod['sport_id']));
	$s = $prod_sp -> fetch();
	print($s['sport_products']);
	?> ;</p>
	<p><?= $prod['content']?></p>
	<form action="" method="POST">
			<div class="choose">
			<div class="size">
				<p>Size:</p>
				<select name="size" style="width:60px;">
				<?php if($prod['categories_id'] == 1 || $prod['categories_id'] == 3 || $prod['categories_id'] == 4 || $prod['categories_id'] == 5): ?>
				<option value="XXS">XXS</option>
				<option value="XS">XS</option>
				<option value="S">S</option>
				<option value="M">M</option>
				<option value="L">L</option>
				<option value="XL">XL</option>
				<option value="XxL">XXL</option>
				<?php endif; ?>
				<?php if($prod['categories_id'] == 2): ?>
				<option value="136x145">136mm x 145mm</option>
				<option value="138x148">138mm x 148mm</option>
				<option value="140x150">140mm x 150mm</option>
				<option value="144x152">144mm x 152mm</option>
				<option value="147x155">147mm x 155mm</option>
				<?php endif; ?>
				<?php if($prod['categories_id'] == 6): ?>
				<option value="6.5">6.5</option>
				<option value="7.5">7.5</option>
				<option value="8.5">8.5</option>
				<option value="9.5">9.5</option>
				<option value="10.5">10.5</option>
				<?php endif; ?>	
				</select>
			</div>
			<div class="size">
			<p>choose color:</p>
			<select name="color" style="width: 50px;">
				<option value="blue">Blue</option>
				<option value="red">Red</option>
				<option value="green">Green</option>
				<option value="black">Black</option>
				<option value="white">White</option>
			</select>
			</div>
			<div class="size">
			<p>How much:</p> <input type="number" name="number" min="1" max="100" autocomplete="off" value="1" style="width: 60px;">
			</div>
			</div>
			<?php if($signin == 'not_entered'): ?>
			<p>* Please log in to buy something.</p>
			<a href="./join/signin.php">Sign up</a>
			<?php elseif($blank == 1): ?>
			<p>* Please fill in your Personal information.</p>
			<a href="./Personal_cabinet.php">Personal cabinet</a>
			<?php elseif($signin == 'entered'): ?>
				<div class="alinks">
		<input  type="submit" value="Buy">
	</div>
			
			<?php endif; ?>
			
		</form>
	
</div>
<script>
	let tabNav = document.querySelectorAll('.photo');
	let tabContent = document.querySelectorAll('.tab_conten');

	tabNav.forEach(function(elem) {
		elem.addEventListener('click', activeTab);
	})

	function activeTab() {
		tabNav.forEach(function(elem) {
			elem.classList.remove('active');
		})

		this.classList.add('active');
		let tabName = this.getAttribute('data_tab');

		activeTabContent(tabName);
	}

	function activeTabContent(tabName) {
		tabContent.forEach(function(item) {
			item.classList.contains(tabName) ? item.classList.add('active') : item.classList.remove('active')
		})
	}
</script>
</body>
</html>