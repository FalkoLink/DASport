<?php
session_start();
require('./dbconnect.php');

if(isset($_SESSION['id'])){
	$user_id = $db -> prepare('SELECT * FROM `users` WHERE `id` = ?');
	$user_id -> bindParam(1, $_SESSION['id'], PDO::PARAM_INT);
	$user_id -> execute();
	$user = $user_id -> fetch();
	if($user['type'] == 1){
		$product = $db -> prepare('SELECT * FROM `products` WHERE `id` = ?');
		$product -> execute(array($_REQUEST['id']));
		$prod = $product -> fetch();
	}else{
		header('Location: index.php');
		exit();
	}
}elseif(isset($_COOKIE['email'])){
	$user_email = $db -> prepare('SELECT * FROM `users` WHERE `email` = ?');
	$user_email -> bindParam(1, $_COOKIE['email'], PDO::PARAM_STR);
	$user_email -> execute();
	$user = $user_email -> fetch();
	if($user['type'] == 1){
		$product = $db -> prepare('SELECT * FROM `products` WHERE `id` = ?');
		$product -> execute(array($_REQUEST['id']));
		$prod = $product -> fetch();
	}else{
		header('Location: index.php');
		exit();
	}
}else{
	header('Location: index.php');
	exit();
}

if (empty($_POST)) {
	$errorg = array('photos' => '', 'photos1' => '', 'photos2' => '', 'photos3' => '',);
}else{
	if(!empty($_POST)){
		if(!empty($_POST['title'])){
			$title = $db -> prepare('UPDATE `products` SET `title` = ? WHERE `id` = ?');
			$title -> bindParam(1,$_POST['title'],PDO::PARAM_STR);
			$title -> bindParam(2,$_REQUEST['id'],PDO::PARAM_INT);
			$title -> execute();
		}
		if(!empty($_POST['price'])){
			$price = $db -> prepare('UPDATE `products` SET `price` = ? WHERE `id` = ?');
			$price -> bindParam(1,$_POST['price'],PDO::PARAM_INT);
			$price -> bindParam(2,$_REQUEST['id'],PDO::PARAM_INT);
			$price -> execute();
		}
		if(!empty($_POST['categories'])){
			$category = $db -> prepare('UPDATE `products` SET `categories_id` = ? WHERE `id` = ?');
			$category -> bindParam(1,$_POST['categories'],PDO::PARAM_INT);
			$category -> bindParam(2,$_REQUEST['id'],PDO::PARAM_INT);
			$category -> execute();
		}
		if(!empty($_POST['sport'])){
			$sport = $db -> prepare('UPDATE `products` SET `sport_id` = ? WHERE `id` = ?');
			$sport -> bindParam(1,$_POST['sport'],PDO::PARAM_INT);
			$sport -> bindParam(2,$_REQUEST['id'],PDO::PARAM_INT);
			$sport -> execute();
		}
		if(!empty($_POST['brand'])){
			$brand = $db -> prepare('UPDATE `products` SET `brand_id` = ? WHERE `id` = ?');
			$brand -> bindParam(1,$_POST['brand'],PDO::PARAM_INT);
			$brand -> bindParam(2,$_REQUEST['id'],PDO::PARAM_INT);
			$brand -> execute();
		}
		if(!empty($_POST['content'])){
			$content = $db -> prepare('UPDATE `products` SET `content` = ? WHERE `id` = ?');
			$content -> bindParam(1,$_POST['content'],PDO::PARAM_STR);
			$content -> bindParam(2,$_REQUEST['id'],PDO::PARAM_INT);
			$content -> execute();
		}

		if(!empty($_FILES['photos'])){
			$imgname = $_FILES['photos']['name'];
			if (!empty($imgname)) {
				$ext = substr($imgname, -3);
				if ($ext != 'png') {
					$errorg['photos'] = 'type';
				}else {
					$image = date('YmdHis') .'_'. $_POST['title'] .'_'. $imgname;
					move_uploaded_file($_FILES['photos']['tmp_name'], './products_photo/' . $image);
					$photos = $db -> prepare('UPDATE `products` SET `photos` = ? WHERE `id` = ?');
					$photos -> bindParam(1, $image, PDO::PARAM_STR);
					$photos -> bindParam(2, $_REQUEST['id'], PDO::PARAM_INT);
					$photos -> execute();
				}
			}
		}

		if(!empty($_FILES['photos1'])){
			$imgname1 = $_FILES['photos1']['name'];
			if (!empty($imgname1)) {
				$ext1 = substr($imgname1, -3);
				if ($ext1 != 'jpg' && $ext1 != 'png') {
					$errorg['photos1'] = 'type';
				}else {
					$image1 = date('YmdHis') .'_'. $_POST['title'] .'_'. $imgname1;
					move_uploaded_file($_FILES['photos1']['tmp_name'], './products_photo/' . $image1);
					$photos1 = $db -> prepare('UPDATE `products` SET `photos1` = ? WHERE `id` = ?');
					$photos1 -> bindParam(1, $image1, PDO::PARAM_STR);
					$photos1 -> bindParam(2, $_REQUEST['id'], PDO::PARAM_INT);
					$photos1 -> execute();
				}
			}
		}
		
		if(!empty($_FILES['photos2'])){
			$imgname2 = $_FILES['photos2']['name'];
			if (!empty($imgname2)) {
				$ext2 = substr($imgname2, -3);
				if ($ext2 != 'jpg' && $ext2 != 'png') {
					$errorg['photos2'] = 'type';
				}else {
					$image2 = date('YmdHis') .'_'. $_POST['title'] .'_'. $imgname2;
					move_uploaded_file($_FILES['photos2']['tmp_name'], './products_photo/' . $image2);
					$photos2 = $db -> prepare('UPDATE `products` SET `photos2` = ? WHERE `id` = ?');
					$photos2 -> bindParam(1, $image2, PDO::PARAM_STR);
					$photos2 -> bindParam(2, $_REQUEST['id'], PDO::PARAM_INT);
					$photos2 -> execute();
				}
			} 
		}
		if(!empty($_FILES['photos3'])){
			$imgname3 = $_FILES['photos3']['name'];
			if (!empty($imgname3)) {
				$ext3 = substr($imgname3, -3);
				if ($ext3 != 'jpg' && $ext3 != 'png') {
					$errorg['photos3'] = 'type';
				}else {
					$image3 = date('YmdHis') .'_'. $_POST['title'] .'_'. $imgname3;
					move_uploaded_file($_FILES['photos3']['tmp_name'], './products_photo/' . $image3);
					$photos3 = $db -> prepare('UPDATE `products` SET `photos3` = ? WHERE `id` = ?');
					$photos3 -> bindParam(1, $image3, PDO::PARAM_STR);
					$photos3 -> bindParam(2, $_REQUEST['id'], PDO::PARAM_INT);
					$photos3 -> execute();
				}
			}
		}
		header('Location: Personal_cabinet.php');
		exit();
	}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>DASport</title>
	<style>
		::-webkit-scrollbar {
			width: 0;
		}
		* {
			padding: 0;
			margin: 0;
			box-sizing: border-box;
		}
		body {
			background-repeat: no-repeat;
  			background-attachment: fixed;
  			background-size: 100%;
			font-family: monospace;
			background: linear-gradient(45deg, rgb(0, 0, 0), rgb(32, 48, 92), black);
		}
		.edit {
			width: 100%;
			height: 100%;
			display: flex;
		}
		.groups1 {
			justify-content: center;
			width: 100%;
			display: flex;
		}
		.groups2 {
			display: flex;
			background: rgba(255, 255, 255, 0.01);
  			box-shadow: 0 10px 25px black;
  			backdrop-filter: blur(8px);
			transition: 0.5s ease-in-out;
			
			width: 500px;
		}
		.group1 {
			margin: 40px;
			display: flex;
			flex-flow: column;
			align-items: center;
			width: 200px;
  			transition: 0.5s ease-in-out;
		}
		.group1 label {
			color: white; 
			margin: 10px;
			font-size: 18px;
		}
		.group1 input {
			width: 80px;
			height: 3%;
			margin: 20px;

		}
		.group2{
			margin: 40px;
			display: flex;
			flex-flow: column;
			align-items: center;
			width: 200px;
  			transition: 0.5s ease-in-out;
		}
		.group2 label{
			color: white; 
			margin: 10px;
			font-size: 18px;
		}
		.group2 input {
			width: 80px;
			height: 3%;
			margin: 20px;
		}
		.group3{
			margin: 50px;
			
		}
		form {
			display: flex;
			width: 100%;
			height: 100%;
			flex-flow: column;
			align-items: center;
		}
		input {
			outline: none;
			border: 2px solid #fff;
			margin-bottom: 20px;
			display: flex;
		}
		input:not([type=submit], [type=file]) {
			width: 50%;
			height: 30px;
			background: #f0f0f0;
			padding-left: 10px;
			font-size: 17px;
			border-radius: 15px;
		}
		input:not([type=submit]):focus {
			background: #fff;
			border: 2px solid #369;
		}
		input[type=submit] {
			padding: 10px 20px;
			border-radius: 20px;
		}
		input[type=file] {
			outline: none;
		}
		select {
			width: 50%;
			border: 2px solid #fff;
			padding-left: 10px;
			border-radius: 10px;
			background: #f0f0f0;
			outline: none;
			height: 25px;
			margin-bottom: 10px;
		}
		select:focus {
			border: 2px solid #369;
		}
		textarea {
			width: 100%;
			height: 300px;
			margin-bottom: 10px;
		}
	</style>
</head>
<body>
	<div class="edit">
		<form action="" method="POST" enctype="multipart/form-data">
		<div class="groups1">
			<div class="group1">
				<label>Main photos:</label>
				<?php if($errorg['photos'] == 'type'):?>
					<p>* only ".png" image.</p>
				<?php endif; ?>
				<img src="./products_photo/<?= $prod['photos']?>" alt="main_photo" width="200" height="200">
				<input type="file" name="photos"><br>
				<label for="title">Name:</label><br>
				<input style="width: 200px;" type="text" name="title" placeholder="<?= $prod['title']?>"><br>
				<label for="price">Cost:</label><br>
				<input style="width: 200px;" type="int" name="price" placeholder="<?= $prod['price']?>" ><br>
			</div>
			<div class="group2">
			<label for="photos1">photos 1:</label><br>
				<?php if($errorg['photos1'] == 'type'):?>
					<p>* only ".png" or ".jpg" image.</p>
				<?php endif; ?>
				<img src="./products_photo/<?= $prod['photos1']?>" alt="main_photo_1" width="100" height="100"><br>
				<input type="file" name="photos1"><br>
				<label for="photos2">photos 2:</label><br>
				<?php if($errorg['photos2'] == 'type'):?><br>
					<p>* only ".png" or ".jpg" image.</p>
				<?php endif; ?>
				<img src="./products_photo/<?= $prod['photos2']?>" alt="main_photo_2" width="100" height="100"><br>
				<input type="file" name="photos2"><br>
				<label for="photos3">photos 3:</label><br>
				<?php if($errorg['photos3'] == 'type'):?>
					<p>* only ".png" or ".jpg" image.</p>
				<?php endif; ?>
				<img src="./products_photo/<?= $prod['photos3']?>" alt="main_photo_3" width="100" height="100"><br>	
				<input type="file" name="photos3"><br>
			</div>
		</div>
		<div class="groups2">
			<div class="group3">
				<label for="categories" style="color:#fff">Category: </label><br>
				<select style="width: 150px;" name="categories">
					<option value="1" <?php if($prod['categories_id'] == '1'){ echo 'selected';}?>>Headpiece</option>
					<option value="2" <?php if($prod['categories_id'] == 2){ echo 'selected';}?>>Glasses</option>
					<option value="3" <?php if($prod['categories_id'] == 3){ echo 'selected';}?>>Overwear</option>
					<option value="4" <?php if($prod['categories_id'] == 4){ echo 'selected';}?>>Lowerwear</option>
					<option value="5" <?php if($prod['categories_id'] == 5){ echo 'selected';}?>>Gloves</option>
					<option value="6" <?php if($prod['categories_id'] == 6){ echo 'selected';}?>>Shoes</option>
					<option value="7" <?php if($prod['categories_id'] == 7){ echo 'selected';}?>> - </option>
				</select><br>
				<label for="sport" style="color:#fff">Sport: </label><br>
				<select style="width: 150px; name="sport">
					<option value="1" <?php if($prod['sport_id'] == '1'){ echo 'selected';}?>>Football</option>
					<option value="2" <?php if($prod['sport_id'] == 2){ echo 'selected';}?>>Basketball</option>
					<option value="3" <?php if($prod['sport_id'] == 3){ echo 'selected';}?>>Tennis</option>
					<option value="4" <?php if($prod['sport_id'] == 4){ echo 'selected';}?>>Boxing</option>
					<option value="5" <?php if($prod['sport_id'] == 5){ echo 'selected';}?>>UFC</option>
					<option value="6" <?php if($prod['sport_id'] == 6){ echo 'selected';}?>>Judo</option>
					<option value="7" <?php if($prod['sport_id'] == 7){ echo 'selected';}?>>Running</option>
					<option value="8" <?php if($prod['sport_id'] == 8){ echo 'selected';}?>> - </option>
				</select><br>
				<label for="brand" style="color:#fff">Brand: </label><br>
				<select style="width: 150px;" name="brand">
					<option value="1" <?php if($prod['brand_id'] == '1'){ echo 'selected';}?>>Nike</option>
					<option value="2" <?php if($prod['brand_id'] == 2){ echo 'selected';}?>>Adidas</option>
					<option value="3" <?php if($prod['brand_id'] == 3){ echo 'selected';}?>>Rebook</option>
					<option value="4" <?php if($prod['brand_id'] == 4){ echo 'selected';}?>>Puma</option>
					<option value="5" <?php if($prod['brand_id'] == 5){ echo 'selected';}?>>Fila</option>
					<option value="6" <?php if($prod['brand_id'] == 6){ echo 'selected';}?>> - </option>
				</select>
			</div>
			<div class="group4">
				<label for="content" style="color:#fff">Description: </label>
				<textarea name="content" id="" cols="85" rows="30"><?= $prod['content']?></textarea>
				<input type="submit" value="submit">
				</div>
				</div>
			</div>
		</form>
	</div>
</body>
</html>