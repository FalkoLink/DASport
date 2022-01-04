<?php
session_start();
require('../dbconnect.php');

if(!empty($_SESSION['id'])){
	$user_id = $db -> prepare('SELECT * FROM `users` WHERE `id` = ?');
	$user_id -> bindParam(1, $_SESSION['id'], PDO::PARAM_INT);
	$user_id -> execute();
    $user = $user_id -> fetch();
    if($user['type'] == 1){
		$orders_list = $db -> prepare('SELECT * FROM `orders` WHERE `id` = ?');
        $orders_list -> bindParam(1, $_REQUEST['ord'], PDO::PARAM_INT);
        $orders_list -> execute();
        $order = $orders_list -> fetch();
	}else{
		header('Location: ../index.php');
		exit();
	}
}elseif(!empty($_COOKIE['email'])){
	$user_email = $db -> prepare('SELECT * FROM `users` WHERE `email` = ?');
	$user_email -> bindParam(1, $_COOKIE['email'], PDO::PARAM_STR);
	$user_email -> execute();
    $user = $user_email -> fetch();
    if($user['type'] == 1){
		$orders_list = $db -> prepare('SELECT * FROM `orders` WHERE `id` = ?');
        $orders_list -> bindParam(1, $_REQUEST['ord'], PDO::PARAM_INT);
        $orders_list -> execute();
        $order = $orders_list -> fetch();
	}else{
		header('Location: ../index.php');
		exit();
	}
}else{
	header('Location: ../index.php');
	exit();
}

$user_id = $db -> prepare('SELECT * FROM `users` WHERE `id` = ?');
$user_id -> execute(array($order['user_id']));
$data = $user_id -> fetch();

$prod_id = $db -> prepare('SELECT * FROM `products` WHERE `id` = ?');
$prod_id -> execute(array($order['prod_id']));
$prod = $prod_id -> fetch();
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
        padding: 20px;
        justify-content: space-between;
        display: flex;
        background: linear-gradient(45deg, rgb(0, 0, 0), rgb(32, 48, 92));
        background-repeat: no-repeat;
  background-attachment: fixed;
  background-size: 100%;
    }
    .back {
        position:  absolute;
        text-decoration: none;
        font-size: 30px;
        padding: 0px 8px;
        box-shadow: 0 0 5px 5px black;
        color: white;
        transition: .2s ease-in-out;
        font-weight: bold;
        height:50px;
        display: flex;
        align-items: center;
    }
    
    .back:hover{
        background: black;
        color: white;
    } 
    .look {
        margin: 20px;
        padding: 10px 20px;
        background: #3c9;
        border-radius: 7px;
        color: black;
        text-decoration: none;
        font-family: monospace;
        font-weight: bold;
    }
    .look:hover {
        background: rgb(0, 255, 106);
        animation: animate .2s infinite ease-in-out;
    }
    .look_d{
        margin: auto;
        padding: 10px 20px;
        background: rgb(100, 50, 50);
        border-radius: 7px;
        color: white;
        text-decoration: none;
        font-family: monospace;
    }
    .look_d:hover {
        background: rgb(288, 50, 50);
        animation: animate .2s infinite ease-in-out;
    }
    .look_1 {
        width: 59%;
        height: 100vh;
        background: rgba(255, 255, 255, 0.01);
        box-shadow: 0 10px 25px black;
        backdrop-filter: blur(8px);
        border-radius: 10px;
        display: flex;
        padding: 20px;
    }
    .look_1 h1,h2,h3,h4 {
        border-bottom: 2px solid orange;
        padding: 0 0 5px;
    }
    .look_2 {
        width: 39%;
        height: 100vh;
        background: rgba(255, 255, 255, 0.01);
        box-shadow: 0 10px 25px black;
        backdrop-filter: blur(8px);
        border-radius: 10px;
        color: white;
        padding: 20px;
    }
    .look_2 a{
        position: ;
        margin: 0px 0px 0px 10px;
    }
    .box{
        display: flex;
    }
    .photos{
        display: flex;
        justify-content: center;
        margin: 10px auto;
    }
    .photos img {
        width: 150px;
        margin: auto;
    }
    .avatar{
        height: 100%;
    }
    .avatar .img-avatar {
        margin: 0px 0px 0px 50px;
        width: 300px;
        height: 300px;
        border-radius: 50%;
    }
    .logo {
        position: relative;
         top: 55%;
        width: 35%;
    }
    .name{
        color: white;
        margin: auto;
    }
    .links {
        margin: 150px 0 0 80px;
        align-items: center;
    }
    .refuse{
        text-decoration: none;
        border: 2px solid rgb(111, 0, 255);
        border-radius: 7px;
        padding: 10px 20px;
        font-weight: 600;
        color: white;
        transition: .2s ease-in-out;
    }
    .refuse:hover{
        background: rgb(204, 0, 255);
        color: white;
    }
    .perform {
        margin: 0 0 0 10px;
        color: white;
        transition: .2s ease-in-out;
        font-weight: 600;
        border-radius: 7px;
        border: 2px solid rgb(0, 255, 136);
        padding: 10px 20px;
        text-decoration: none;
    }
    .perform:hover{
        background: rgb(51, 255, 0);
        color: black;
    }
    .pbox {
        margin:30px;
    }
    
    </style>
</head>
<body>
<div class="look_1">
<a class="back" href="../Personal_cabinet.php"><</a>
    <div class="avatar">
        <img class="img-avatar" src="../users_picture/<?= $data['avatar']?>" width="300">
        <br>
        <img class="logo" src="../images/logo1.png" alt="LOGO">
    </div>

<div class="name">
    <h1><?= $data['username']?></h1>
    <br>
    <h2>First-Name:  <?= $data['first_name']?></h2>
    <br>
    <h2>Last-Name:  <?= $data['last_name']?></h2>
    <br>
    <br>
    <br>
    <h3>Email: <?= $data['email']?></h3>
    <br>
    <h3>Gender: <?php if($data['gender'] == 1){echo 'Male';}
    if($data['gender'] == 2){echo 'Female';}?></h3>
    <br>
    <h3>Date of Birth: <?= $data['birthday']?></h3>
    <br>
    <h3>Country: <?= $data['country']?></h3>
    <br>
    <h3>State: <?= $data['state']?></h3>
    <br>
    <h3>Town: <?= $data['town']?></h3>
    <br>
    <h3>Mail-index: <?= $data['mail_index']?></h3>
    <br>
    <h3>Number: <?= $data['number']?></h3>
    <br>
    <h3>Address: <?= $data['address']?></h3>
    <br>
    <h4>Data created: <?= $data['date_created']?></h4>
</div>
</div>

<div class="look_2">
    <div class="box">
    <div>
    <img class="photo" src="../products_photo/<?= $prod['photos']?>" alt="product_photo" width="200px">
    </div>
    <div>
        <h2>Product Name: <?= $prod['title']?></h2>
        <br>
        <h2>Cost: <?= $prod['price']?>$</h2>
        <br>
        <h2>Categories: <?php $cat_id = $db -> prepare('SELECT `category` FROM `categories` WHERE `id` = ?');
        $cat_id -> bindParam(1, $prod['categories_id'], PDO::PARAM_INT);
        $cat_id -> execute();
        $cat = $cat_id -> fetch();
        echo $cat['category']
        ?></h2>
        <br>
        <h2>Sport: <?php $sp_id = $db -> prepare('SELECT `sport_products` FROM `sport` WHERE `id` = ?');
        $sp_id -> bindParam(1, $prod['sport_id'], PDO::PARAM_INT);
        $sp_id -> execute();
        $sp = $sp_id -> fetch();
        echo $sp['sport_products']
        ?></h2>
        <br>
        <h2>Brands: <?php $brand_id = $db -> prepare('SELECT `brands` FROM `brand` WHERE `id` = ?');
        $brand_id -> bindParam(1, $prod['brand_id'], PDO::PARAM_INT);
        $brand_id -> execute();
        $br = $brand_id -> fetch();
        echo $br['brands']
        ?></h2>
        <h2>Size: <?php $size_id = $db -> prepare('SELECT `size` FROM `orders` WHERE `id` = ?');
        $size_id -> bindParam(1, $order['id'], PDO::PARAM_INT);
        $size_id -> execute();
        $sz = $size_id -> fetch();
        echo $sz['size']
        ?></h2>
        <h2>Color: <?php $color_id = $db -> prepare('SELECT `color` FROM `orders` WHERE `id` = ?');
        $color_id -> bindParam(1, $order['id'], PDO::PARAM_INT);
        $color_id -> execute();
        $cl = $color_id -> fetch();
        echo $cl['color']
        ?></h2>
        <h2>How much: <?php $how_id = $db -> prepare('SELECT `how_much` FROM `orders` WHERE `id` = ?');
        $how_id -> bindParam(1, $order['id'], PDO::PARAM_INT);
        $how_id -> execute();
        $hw = $how_id -> fetch();
        echo $hw['how_much']
        ?></h2>
        <h2>Total Cost: <?= $hw['how_much'] * $prod['price']?></h2>
    </div>
    </div>
    <div class="photos">
    <img src="../products_photo/<?= $prod['photos1']?>" alt="product_photo" width="20%" >
    <img src="../products_photo/<?= $prod['photos2']?>" alt="product_photo" width="20%" >
    <img src="../products_photo/<?= $prod['photos3']?>" alt="product_photo" width="20%" >
    </div>
    <div class="pbox">
        <p><?= $prod['content']?></p>
        
    </div>
    <?php if($order['status'] == 0): ?>
        <a class="refuse" href="./refuse.php?ord=<?= $_REQUEST['ord']?>">Refuse</a> 
        <a class="perform" href="./perform.php?ord=<?= $_REQUEST['ord']?>">Send</a>
        <a class="perform" href="../show.php?id=<?= $order['prod_id']?>&back=po">Go to product</a>
    <?php endif; ?>
    <?php if($order['status'] == 1): ?>
        <a class="look" href="#">Success!</a>
        <a class="perform" href="../show.php?id=<?= $order['prod_id']?>&back=po">Go to product</a>
    <?php endif; ?>
    <?php if($order['status'] == 2): ?>
        <a class="look_d" href="#">[Denied]</a>
        <a class="perform" href="../show.php?id=<?= $order['prod_id']?>&back=po">Go to product</a>
    <?php endif; ?>
    <div class="links"></div>
    
    </div>
    
</div>
</body>
</html>