<?php
session_start();
require('./dbconnect.php');

if(isset($_SESSION['id'])){
	$user_id = $db -> prepare('SELECT * FROM `users` WHERE `id` = ?');
	$user_id -> bindParam(1, $_SESSION['id'], PDO::PARAM_INT);
	$user_id -> execute();
	$user = $user_id -> fetch();
}elseif(isset($_COOKIE['email'])){
	$user_email = $db -> prepare('SELECT * FROM `users` WHERE `email` = ?');
	$user_email -> bindParam(1, $_COOKIE['email'], PDO::PARAM_STR);
	$user_email -> execute();
	$user = $user_email -> fetch();
}else{
	header('Location: index.php');
	exit();
}

if (empty($_POST)) {
	$error = array('nick' => '', 'email' => '',);
} else {
	if(!empty($_POST)){
		if(!empty($_POST['nick'])){
			$nick = $db -> prepare('SELECT COUNT(*) AS `pnt` FROM `users` WHERE `username` = ?');
			$nick -> execute(array($_POST['nick']));
			$have = $nick -> fetch();
			if ($have['pnt'] > 0) {
				$error['nick'] = 'duplicate';
			}else{
				$username = $db -> prepare('UPDATE `users` SET `username` = ? WHERE `id` = ?');
				$username -> bindParam(1,$_POST['nick'],PDO::PARAM_STR);
				$username -> bindParam(2,$user['id'],PDO::PARAM_INT);
				$username -> execute();
				$error['nick'] = '';
			}
		}else{
			$error['nick'] = '';
		}
		if(!empty($_POST['f_name'])){
			$f_name = $db -> prepare('UPDATE `users` SET `first_name` = ? WHERE `id` = ?');
			$f_name -> bindParam(1,$_POST['f_name'],PDO::PARAM_STR);
			$f_name -> bindParam(2,$user['id'],PDO::PARAM_INT);
			$f_name -> execute();
		}
		if(!empty($_POST['l_name'])){
			$l_name = $db -> prepare('UPDATE `users` SET `last_name` = ? WHERE `id` = ?');
			$l_name -> bindParam(1,$_POST['l_name'],PDO::PARAM_STR);
			$l_name -> bindParam(2,$user['id'],PDO::PARAM_INT);
			$l_name -> execute();
		}
		if(!empty($_POST['gender'])){
			$gender = $db -> prepare('UPDATE `users` SET `gender` = ? WHERE `id` = ?');
			$gender -> execute(array($_POST['gender'], $user['id']));
		}
		if(!empty($_POST['email'])){
			$mail = $db -> prepare('SELECT COUNT(*) AS ent FROM `users` WHERE `email`=?');
			$mail -> execute(array($_POST['email']));
			$member = $mail -> fetch();
			if ($member['ent'] > 0) {
				$error['email'] = 'duplicate';
			}else{
				$email = $db -> prepare('UPDATE `users` SET `email` = ? WHERE `id` = ?');
				$email -> bindParam(1,$_POST['email'],PDO::PARAM_STR);
				$email -> bindParam(2,$user['id'],PDO::PARAM_INT);
				$email -> execute();
				$error['email'] = '';
			}
		}else{
			$error['email'] = '';
		}
		if(!empty($_POST['birthday'])){
			$birthday = $db -> prepare('UPDATE `users` SET `birthday` = ? WHERE `id` = ?');
			$birthday -> execute(array($_POST['birthday'], $user['id']));
		}
		if(!empty($_POST['number'])){
			$numbers = $db -> prepare('SELECT COUNT(*) AS nb FROM `users` WHERE `number`=?');
			$numbers -> execute(array($_POST['number']));
			$handset = $numbers -> fetch();
			if ($handset['nb'] > 0) {
				$error['number'] = 'duplicate';
			}else{
				$number = $db -> prepare('UPDATE `users` SET `number` = ? WHERE `id` = ?');
				$number -> bindParam(1,$_POST['number'],PDO::PARAM_INT);
				$number -> bindParam(2,$user['id'],PDO::PARAM_INT);
				$number -> execute();
			}
		}
		if(!empty($_POST['country'])){
			$country = $db -> prepare('UPDATE `users` SET `country` = ? WHERE `id` = ?');
			$country -> bindParam(1,$_POST['country'],PDO::PARAM_STR);
			$country -> bindParam(2,$user['id'],PDO::PARAM_INT);
			$country -> execute();
		}
		
		if(!empty($_POST['state'])){
			$state = $db -> prepare('UPDATE `users` SET `state` = ? WHERE `id` = ?');
			$state -> bindParam(1,$_POST['state'],PDO::PARAM_STR);
			$state -> bindParam(2,$user['id'],PDO::PARAM_INT);
			$state -> execute();
		}
		if(!empty($_POST['town'])){
			$town = $db -> prepare('UPDATE `users` SET `town` = ? WHERE `id` = ?');
			$town -> bindParam(1,$_POST['town'],PDO::PARAM_STR);
			$town -> bindParam(2,$user['id'],PDO::PARAM_INT);
			$town -> execute();
		}
		if(!empty($_POST['mail'])){
			$mail = $db -> prepare('UPDATE `users` SET `mail_index` = ? WHERE `id` = ?');
			$mail -> bindParam(1,$_POST['mail'],PDO::PARAM_INT);
			$mail -> bindParam(2,$user['id'],PDO::PARAM_INT);
			$mail -> execute();
		}
		if(!empty($_POST['address'])){
			$address = $db -> prepare('UPDATE `users` SET `address` = ? WHERE `id` = ?');
			$address -> execute(array($_POST['address'], $user['id']));
		}
	}
}

if (empty($_POST)) {
	$errorg = array('photos' => '', 'title' => '', 'price' => '', 'photos1' => '', 'photos2' => '', 'photos3' => '', 'categories' => '', 'sport' => '', 'brand' => '', 'content' => '',);
}else{
	if(!empty($_POST)){
		if($_POST['title'] == ''){
			$errorg['title'] = 'blank';
		}else{
			$errorg['title'] = '';
		}

		if($_POST['price'] == ''){
			$errorg['price'] = 'blank';
		}else{	
			$errorg['price'] = '';
		}

		if($_POST['categories'] == ''){
			$errorg['categories'] = 'blank';
		}else{
			$errorg['categories'] = '';
		}

		if($_POST['sport'] == ''){
			$errorg['sport'] = 'blank';
		}else{
			$errorg['sport'] = '';
		}

		if($_POST['brand'] == ''){
			$errorg['brand'] = 'blank';
		}else{
			$errorg['brand'] = '';
		}

		if($_POST['content'] == ''){
			$errorg['content'] = 'blank';
		}else{
			$errorg['content'] = '';
		}

		if(!empty($_FILES['photos'])){
			$imgname = $_FILES['photos']['name'];
			if (!empty($imgname)) {
				$ext = substr($imgname, -3);
				if ($ext != 'jpg' && $ext != 'png') {
					$errorg['photos'] = 'type';
				}else {
					$errorg['photos'] = '';
				}
			} else {
				$errorg['photos'] = 'blank';
			}
		}else{
			$errorg['photos'] = '';
		}
		if(!empty($_FILES['photos1'])){
			$imgname1 = $_FILES['photos1']['name'];
			if (!empty($imgname1)) {
				$ext1 = substr($imgname1, -3);
				if ($ext1 != 'jpg' && $ext1 != 'png') {
					$errorg['photos1'] = 'type';
				}else {
					$errorg['photos1'] = '';
				}
			} else {
				$errorg['photos1'] = 'blank';
			}
		}else{
			$errorg['photos1'] = '';
		}
		if(!empty($_FILES['photos2'])){
			$imgname2 = $_FILES['photos2']['name'];
			if (!empty($imgname2)) {
				$ext2 = substr($imgname2, -3);
				if ($ext2 != 'jpg' && $ext2 != 'png') {
					$errorg['photos2'] = 'type';
				}else {
					$errorg['photos2'] = '';
				}
			} else {
				$errorg['photos2'] = 'blank';
			}
		}else{
			$errorg['photos2'] = '';
		}
		if(!empty($_FILES['photos3'])){
			$imgname3 = $_FILES['photos3']['name'];
			if (!empty($imgname3)) {
				$ext3 = substr($imgname3, -3);
				if ($ext3 != 'jpg' && $ext3 != 'png') {
					$errorg['photos3'] = 'type';
				}else {
					$errorg['photos3'] = '';
				}
			} else {
				$errorg['photos3'] = 'blank';
			}
		}else{
			$errorg['photos3'] = '';
		}
		if ($errorg['photos'] == '' && $errorg['title'] == '' &&
		$errorg['price'] == '' && $errorg['categories'] == '' &&
		$errorg['sport'] == '' && $errorg['brand'] == '' &&
		$errorg['content'] == '' && $errorg['photos1'] == '' &&
		$errorg['photos2'] == '' && $errorg['photos3'] == ''){
			$image = date('YmdHis') .'_'. $_POST['title'] .'_'. $_FILES['photos']['name'];
			$image1 = date('YmdHis') .'_'. $_POST['title'] .'_'. $_FILES['photos1']['name'];
			$image2 = date('YmdHis') .'_'. $_POST['title'] .'_'. $_FILES['photos2']['name'];
			$image3 = date('YmdHis') .'_'. $_POST['title'] .'_'. $_FILES['photos3']['name'];
			move_uploaded_file($_FILES['photos']['tmp_name'], './products_photo/' . $image);
			move_uploaded_file($_FILES['photos1']['tmp_name'], './products_photo/' . $image1);
			move_uploaded_file($_FILES['photos2']['tmp_name'], './products_photo/' . $image2);
			move_uploaded_file($_FILES['photos3']['tmp_name'], './products_photo/' . $image3);
			

			$add = $db -> prepare('INSERT INTO `products` SET `photos` = ?, `title` = ?, `price` = ?, `categories_id` = ?, 
			`sport_id` = ?, `brand_id` = ?, `content` = ?, `photos1` = ?, `photos2` = ?, `photos3` = ?, `date_created`=NOW()');
			$add -> bindParam(1, $image, PDO::PARAM_STR);
			$add -> bindParam(2, $_POST['title'], PDO::PARAM_STR);
			$add -> bindParam(3, $_POST['price'], PDO::PARAM_INT);
			$add -> bindParam(4, $_POST['categories'], PDO::PARAM_INT);
			$add -> bindParam(5, $_POST['sport'], PDO::PARAM_INT);
			$add -> bindParam(6, $_POST['brand'], PDO::PARAM_INT);
			$add -> bindParam(7, $_POST['content'], PDO::PARAM_STR);
			$add -> bindParam(8, $image1, PDO::PARAM_STR);
			$add -> bindParam(9, $image2, PDO::PARAM_STR);
			$add -> bindParam(10, $image3, PDO::PARAM_STR);
			$add -> execute();
			
			header('Location: Personal_cabinet.php');
			exit();
		}
	}
}
function hsc($value)
{
    return htmlspecialchars($value, ENT_QUOTES);
}

if (!empty($_POST) && $error['nick'] != 'duplicate' && $error['email'] != 'duplicate') 
{ 
	header('Location: Personal_cabinet.php');
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
			display: flex;
			justify-content: space-between;
			padding: 10px 20px;
			font-size: 14px;
			font-weight: 600;
			font-family: monospace;
			background: linear-gradient(45deg, rgb(0, 0, 0), rgb(32, 48, 92));
  			background-repeat: no-repeat;
  			background-attachment: fixed;
  			background-size: 100%;
		}
		.personal {
			padding: 30px 10px;
			width: 22%;
			height: 96.5vh;
			box-shadow: 0 0 10px .1px #000;
			overflow-y: scroll;
			background: #169;
			color: #eee;
  			box-shadow: 0 10px 25px black;
  			backdrop-filter: blur(8px);
		}
		.personal img {
			margin: 0 auto;
			display: block;
			border-radius: 50%;
			box-shadow: 0 10px 25px black;
		}
		input:not([type=submit]) {
			display:block;
			margin-left: 10px;
			font-size: 18px;
			outline: none;
			border: none;
			width: 80%;
			background-color: #eee;
			padding: 0 5px;
			height: 35px;
			margin-bottom: 20px;
			font-family: monospace;
		}
		.text1:not([type=submit]):focus {
			background: #eee;
			border: 2px solid #69c;
		}
		.text1:not([type=submit]) {
			background: white;
			font-weight: 600;
			font-size: 20px;
			border-radius: 7px;
			padding: 10px;
  			
  			backdrop-filter: blur(8px);
		}
		.text1:not([type=submit]):focus{
            background: #fff;
			transform: scale(1.03);
            animation: animate1 .8s infinite ease-in-out;
		}
		
		@keyframes animate1 {
            50% {
                transform: scale(1);
            }
		}
		.personal input {
			margin: 10px;
			border-radius: 7px;
			
		}
		.personal input:focus{
			background: #eee;
			border: 3px solid orange;
			animation: animate2 .8s infinite ease-in-out;
		} 
		@keyframes animate2 {
            50% {
                transform: scale(1.05);
            }
		}
		.back {
			text-decoration: none;
			font-size: 30px;
			padding: 0px 8px;
			box-shadow: 0 0 5px 5px black;
			color: black;
			transition: .2s ease-in-out;
		}
		.back:hover{
			background: black;
			color: white;
		} 
		.personal h1 {
			margin-top: 10px;
			margin-bottom: 10px;
			text-align: center;
			color:   #eee;
		}
		.personal h3 {
			margin-bottom: 30px;
		}
		.confirm {
			display: flex;
			align-items: center;
			
		}
		.confirm a {
			text-decoration: none;
			font-size: 16px;
			color: #eee;
			background: red;
			margin-left: 20px;
			display: flex;
			padding: 10px 20px;
			font-size: 15px;
			border-radius: 7px;
		}
		.confirm a:hover {
			background: rgb(207, 0, 0);
			animation: animate .2s infinite ease-in-out;
		}
		.confirm input[type=submit] {
			float: right;
			border: none;
			background: rgb(0, 195, 255);
			padding: 10px 20px;
			font-size: 15px;
			border-radius: 10px;
			display: flex;
			font-family: monospace;
			align-self: flex-end;
			outline: none;
			font-weight: 600;
		}
		.confirm input[type=submit]:hover {
			background:  rgb(0, 225, 255);
			animation: animate .2s infinite ease-in-out;
		}
		.box-file{
			color: #000;
			
		}
		.groups{
			display: flex;
			
		}
		.group1 {
			margin: 10px;
		}
		.group2 {
			margin: 10px;
		}

		.myorder {
			width: 77%;
			height: 96.5vh;
			box-shadow: 0 0 10px .1px #000;
			padding: 20px;
			display: flex;
			color: white;
			background: rgba(255, 255, 255, 0.01);
  			box-shadow: 0 10px 25px black;
  			backdrop-filter: blur(8px);
		}
		.description {
			display: flex;
		}
		.description input {
			padding: 10px 20px;
			font-size: 15px;
			border-radius: 10px;
			background: rgb(123, 255, 0);
			margin: 0 0 10px 15px;
			float: right;
			align-self: flex-end;
			outline: none;
		}
		.description input:hover {
			background: rgb(0, 255, 42);
			animation: animate .2s infinite ease-in-out;
		}
		@keyframes animate {
			50%{
				transform: rotate(3deg);
			}
			100%{
				transform: rotate(-3deg);
			}
		}

		.please {
			background: rgb(255, 209, 209);
		}

		.tab_header {
			width: 22%;
			margin-top: 20px;
		}
		.tab_nav {
			padding: 10px 5px;
			cursor: pointer;
			border-radius: 7px;
			transition: .2s background;
		}
		.tab_nav.active {
			background-color: #369;
			padding: 10px 5px;
			cursor: pointer;
			transition: .3s background;
		}
		.tab_footer {
			width: 80%;
		}
		.tab_content {
			width: 90%;
			display: none;
		}
		.tab_nav:hover {
			background-color: #169;
		}
		.tab_content.tab-1.active .prod_ul {
			display: flex;
			justify-content: space-evenly;
		}
		.prod_ul .prod1 {
			width: 20%;
			display: flex;
			flex-flow: column;
		}
		.prod_ul .prod1:nth-of-type(2) {
			width: 40%;
		}
		.prod_ul .prod1:nth-of-type(3) {
			width: 30%;
		}
		.prod_ul .prod1 img {
			width: 100px;
		}
		
		.prod_ul a {
			text-decoration: none;
			color: white;
			display: flex;
			align-items: center;
		}
		.tab_content.active {
			width: 100%;
			border: 2px solid #369;
			display: block;
			height: 100%;
			overflow-y: scroll;
		}
		.tab_content.tab-2.active {
			padding-top: 20px;
		}
		.tab_content input:not([type=submit]){
			width: 200px;
			font-size: 13px;
			height: 25px;
		}
		.tab_content select {
			margin-bottom: 20px;
		}
		.tab_content textarea {
			margin-left: 20px;
		}
		.tab_content.tab-2.active form input{
			margin-top: 10px;
			display: block;
		}
		.tab_content.tab-2.active form input[type=submit] {
			margin-right: 20px;
		}
		.tab_content.tab-3.active form input{
			margin-top: 10px;
			display: block;
		}
		.tab_content.tab-3.active form input[type=submit] {
			margin-right: 20px;
		}
		input[name="gender"]{
			width: auto;
			height: auto;
			display: inline;
			margin: 0 30px 0 0;
		}
		.gender{
			display: flex;
			margin-bottom: 20px;
		}
		label{
			margin: 0 0 0 13px;
		}
		input[type="textarea"]{
			width: auto;
			height: auto;
		}
		.order{
			display: flex;
			justify-content: space-between;
		}
		.order a {
			text-decoration: none;
			color: white;
			display: flex;
			align-items: center;
			margin-right: 10px;
		}
		.order1{
			width: 15%;
			display: flex;
		}
		.order2{
			width: 35%;
			display: flex;
			flex-flow: column;
		}
		
		.cabinet_links {
			display: flex;
		}
		.myorders{
			display: flex;
		}
		.myorders1{
			width: 20%;
		}
		.myorders2{
			width: 20%;
		}
		.myorders3{
			width: 20%;
		}
		p.my_title{
			font-size: 30px;
		}
		p.my_price{
			font-size: 30px;
		}
		.post p{
			font-size: 18px;
			border: 2px solid white;
			padding: 5px 0 5px 5px;
		}
		.post p span {
			font-size: 20px;
			font-style: italic;
		}
		.cabinet_links {
			display: block;
		}
		.links1{
			background:  rgb(0, 153, 255);
			transition: .2s ease-in-out;
			padding: 10px 20px;
			margin: 8px;
			border-radius: 7px;
			font-weight: 500;
			align-items: center;
		}
		.links1:hover{
			background:rgb(0, 225, 255);
			animation: animate .2s infinite ease-in-out;
		}
		.links2{
			transition: .2s ease-in-out;
			background:  rgb(255, 94, 0);
			padding: 10px 20px;
			margin: 8px;
			border-radius: 7px;
			font-weight: 400;
			align-items: center;
		}
		.links2:hover{
			background: red;
			animation: animate .2s infinite ease-in-out;

		}
		.prod_ul {
			align-items: center;
			margin: 10px;
		}
		.products_img{
			border: 2px solid white;
			margin: auto;
		}
		.order2 {
			font-size: 18px;
			border: 2px solid white;
			
		}
		.order2 p {
			padding: 2px 0 2px 10px;
			margin: auto;
		}
		.order2 img {
			margin: auto;
			padding: 10px;
		}
		.order1 {
			font-size: 18px;
		}
		.order1 img{
			margin: auto;
			padding: 10px;
		}
		.look {
			margin: auto;
			padding: 10px 20px;
			background: #3c9;
			border-radius: 7px;
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
		}
		.look_d:hover {
			background: rgb(288, 50, 50);
			animation: animate .2s infinite ease-in-out;
		}
		.look_w{
			margin: auto;
			padding: 10px 20px;
			background: rgb(150, 150, 150);
			border-radius: 7px;
		}
		.look_w:hover {
			background: rgb(50, 50, 200);
			animation: animate .2s infinite ease-in-out;
		}
		.button-go {
			margin: auto;
			padding: 10px 20px;
			background: #3c9;
			border-radius: 7px;
		}
		.button-go a{
			color: white;
			text-decoration: none;
		}
		.button-go:hover {
			background: rgb(0, 255, 106);
			animation: animate .2s infinite ease-in-out;
		}
	</style>
</head>
<body>
	<div class="personal">
		<a class="back" href="./index.php"><</a>
		<img src="./users_picture/<?= $user['avatar']?>" alt="avatar" width="100%" height="260px">
		<h1><?= $user['username']?></h1>
		<h3>Edit</h3>
		<form action="" method="POST">
			<!-- nickname -->
			<label for="nick">Nick:</label>
			<?php if($error['nick'] == 'duplicate'):?>
				<p class="error">* This nickname is taken.</p>
			<?php endif?>
			<input class="personal-input" type="text" name="nick" placeholder="<?= $user['username']?>" value="<?= hsc(!empty($_POST['nick']) ? $_POST['nick'] : ''); ?>">
			<!-- first-name -->
			<label for="f_name">First-name:</label>
			<input class="personal-input" type="text" name="f_name" placeholder="<?= $user['first_name']?>" value="<?=hsc(!empty($_POST['f_name']) ? $_POST['f_name'] : ''); ?>">
			<!-- last-name -->
			<label for="l_name">Last-name:</label>
			<input class="personal-input" type="text" name="l_name" placeholder="<?= $user['last_name']?>" value="<?= hsc(!empty($_POST['l_name']) ? $_POST['l_name'] : ''); ?>">
			<!-- gender -->
			<div class="gender">
				<div>
					<label for="gender">Male:</label>
					<input class="personal-input" type="radio" name="gender" value="1" <?php if($user['gender'] == '1'){echo 'checked';}?>>
				</div>
				<div>
					<label for="gender">Female:</label>
					<input class="personal-input" type="radio" name="gender" value="2" <?php if($user['gender'] == '2'){echo 'checked';}?>>
				</div>
			</div>
			<!-- email -->
			<label for="email">Email:</label>
			<?php if($error['email'] == 'duplicate'):?>
				<p class="error">* Registared email address.</p>
			<?php endif?>
			<input type="email" name="email" placeholder="<?= $user['email']?>" value="<?= hsc(!empty($_POST['email']) ? $_POST['email'] : ''); ?>">
			<!-- birthday -->
			<label for="birthday">Birthday: <?= $user['birthday']?></label>
			<input type="date" name="birthday" value="<?= $_POST['birthday'] ?>">
			<!-- number -->
			<label for="number">Number:</label>
			<input type="tel" name="number" placeholder="<?= $user['number']?>" value="<?= hsc(!empty($_POST['number']) ? $_POST['number'] : ''); ?>">
			<!-- country -->
			<label for="country">Country:</label>
			<input type="text" name="country" placeholder="<?= $user['country']?>" value="<?= hsc(!empty($_POST['country']) ? $_POST['country'] : ''); ?>">
			<!-- state -->
			<label for="state">State:</label>
			<input type="text" name="state" placeholder="<?= $user['state']?>" value="<?= hsc(!empty($_POST['state']) ? $_POST['state'] : ''); ?>">
			<!-- town -->
			<label for="town">Town:</label>
			<input type="text" name="town" placeholder="<?= $user['town']?>" value="<?= hsc(!empty($_POST['town']) ? $_POST['town'] : '');?>">
			<!-- mail-index -->
			<label for="mail">Mail index:</label>
			<input type="int" name="mail" placeholder="<?= $user['mail_index']?>" value="<?= hsc(!empty($_POST['mail']) ? $_POST['mail'] : '');?>">
			<!-- address -->
			<label for="address">Address:</label>
			<input type="text" name="address" placeholder="<?= $user['address']?>" value="<?= hsc(!empty($_POST['address']) ? $_POST['address'] : '');?>">
			
			<div class="confirm">
				<a href="logout.php">Exit</a>
				<input type="submit" value="submit">
			</div>
		</form>
	</div>
	<div class="myorder">
			<div class="tab_header">
				<?php if($user['type'] == 1) :?>
				<h2 class="tab_nav active" data_tab="tab-2">New products</h2>
				<h2 class="tab_nav" data_tab="tab-1">Products</h2>
				<h2 class="tab_nav" data_tab="tab-3">Orders</h2>
				<?php endif ?>
				<?php if($user['type'] == 0) :?>
				<h2 class="tab_nav active" data_tab="tab-4"> My orders</h2>
				<?php endif?>
			</div>
			<div class="tab_footer">
				<?php if($user['type'] == 1) :?>
				<div class="tab_content tab-1">
					<div class="post">
						<?php 
						$prod_list = $db -> query('SELECT * FROM `products` ORDER BY `id` DESC');
						while($list = $prod_list -> fetch()):
						?><div class="prod_ul">
							<div class="prod1">
								<img class="products_img" src="./products_photo/<?= $list['photos']?>" alt="product" width="100px" height="100px">
							</div>
							<div class="prod1">
								<p>Product name: <span><?= $list['title']?></span>; </p>
								<p>Price: <span>x<?= $list['price']?>$</span>;</p>
								<p>Date created: <span><?= $list['date_created']?></span>;</p>
							</div>
							<div class="prod1">
								<p>Brand: <span><?php 
								$prod_brand = $db -> prepare('SELECT `brands` FROM `brand` WHERE `id` = ?');
								$prod_brand -> execute(array($list['brand_id']));
								$b = $prod_brand -> fetch();
								print($b['brands']);
								?> </span>;</p>
								<p>Category: <span><?php 
								$prod_cat = $db -> prepare('SELECT `category` FROM `categories` WHERE `id` = ?');
								$prod_cat -> execute(array($list['categories_id']));
								$c = $prod_cat -> fetch();
								print($c['category']);
								?> </span>;</p>
								<p>Sport: <span><?php 
								$prod_sp = $db -> prepare('SELECT `sport_products` FROM `sport` WHERE `id` = ?');
								$prod_sp -> execute(array($list['sport_id']));
								$s = $prod_sp -> fetch();
								print($s['sport_products']);
								?> </span>;</p>
							</div>
							<div class="cabinet_links">
							<a class="links1" href="./edit.php?id=<?= $list['id']?>">Edit</a>
							<a class="links2" href="./delete.php?id=<?= $list['id']?>">Delete</a>
							</div>
						</div>
						<hr>
						<?php endwhile;?>
					</div>
				</div>
				<div class="tab_content tab-2 active">
					<form action="" method="POST" enctype="multipart/form-data">
					<div class="groups">
						<div class="group1">
							<label>Main photos</label>
							<?php if($errorg['photos'] == 'type'):?>
								<p class="please">* only ".png" image.</p>
							<?php endif; ?>
							<?php if($errorg['photos'] == 'blank'):?>
								<p class="please">* select image.</p>
							<?php endif; ?>
							<input class="box-file" type="file" name="photos">
							<label  for="title">Name:</label>
							<?php if($errorg['title'] == 'blank'):?>
								<p class="please">* Please enter product name.</p>
							<?php endif; ?>
							<input class="text1" type="text" name="title" placeholder="Product name...">
							<label for="price">Cost:</label>
							<?php if($errorg['price'] == 'blank'):?>
								<p class="please">* Please enter cost.</p>
							<?php endif; ?>
							<input class="text1"  type="int" name="price" placeholder="Cost ...$" >
						</div>
							
						<div class="group2">
							<label for="photos1">photos 1</label>
							<?php if($errorg['photos1'] == 'type'):?>
								<p class="please">* only ".png" or ".jpg" image.</p>
							<?php endif; ?>
							<?php if($errorg['photos1'] == 'blank'):?>
								<p class="please">* select image.</p>
							<?php endif; ?>
							<input class="box-file" type="file" name="photos1">
							<label for="photos2">photos 2</label>
							<?php if($errorg['photos2'] == 'type'):?>
								<p class="please">* only ".png" or ".jpg" image.</p>
							<?php endif; ?>
							<?php if($errorg['photos2'] == 'blank'):?>
								<p class="please">* select image.</p>
							<?php endif; ?>
							<input class="box-file" type="file" name="photos2">
							<label for="photos3">photos 3</label>
							<?php if($errorg['photos3'] == 'type'):?>
								<p class="please">* only ".png" or ".jpg" image.</p>
							<?php endif; ?>
							<?php if($errorg['photos3'] == 'blank'):?>
								<p class="please">* select image.</p>
							<?php endif; ?>
							<input class="box-file" type="file" name="photos3">
						</div>
					</div>	
						
						<label for="categories">Category: </label>
						<?php if($errorg['categories'] == 'blank'):?>
							<p class="please">* Select a category.</p>
						<?php endif; ?>
						<select name="categories">
							<option value="7"> - </option>
							<option value="1">Headpiece</option>
							<option value="2">Glasses</option>
							<option value="3">Overwear</option>
							<option value="4">Lowerwear</option>
							<option value="5">Gloves</option>
							<option value="6">Shoes</option>
						</select>
						<label for="sport">Sport: </label>
						<?php if($errorg['categories'] == 'blank'):?>
							<p class="please">* Select a sport.</p>
						<?php endif; ?>
						<select name="sport">
							<option value="8"> - </option>
							<option value="1">Football</option>
							<option value="2">Basketball</option>
							<option value="3">Tennis</option>
							<option value="4">Boxing</option>
							<option value="5">UFC</option>
							<option value="6">Judo</option>
							<option value="7">Running</option>
						</select>
						<label for="brand">Brand: </label>
						<?php if($errorg['brand'] == 'blank'):?>
							<p class="please">* Select a brand.</p>
						<?php endif; ?>
						<select name="brand">
							<option value="6"> - </option>
							<option value="1">Nike</option>
							<option value="2">Adidas</option>
							<option value="3">Rebook</option>
							<option value="4">Puma</option>
							<option value="5">Fila</option>
						</select>
						<div class="description">
							<label for="content">Description: </label>
							<?php if($errorg['content'] == 'blank'):?>
								<p class="please">* Please enter description.</p>
							<?php endif; ?>
							<textarea name="content" cols="70" rows="25"></textarea>
							<input type="submit" value="submit">
						</div>
					</form>
				</div>
				<div class="tab_content tab-3">
					<?php $orders_list = $db -> query('SELECT * FROM `orders` ORDER BY `id` DESC');
					while($order = $orders_list -> fetch()): ?>
						<div class="order">
							<div class="order1">
								<img src="./users_picture/<?php 
								$users_data = $db -> prepare('SELECT * FROM `users` WHERE `id` = ?');
								$users_data -> bindParam(1, $order['user_id'], PDO::PARAM_INT);
								$users_data -> execute();
								$data = $users_data -> fetch(); 
								echo $data['avatar']?>" alt="avatar" width="100px" height="100px">
							</div>
							<div class="order2">
								<p><?= $data['first_name']?></p>
								<p><?= $data['last_name']?></p>
								<p><?= $data['email']?></p>
								<p><?= $data['number']?></p>
								<p><?= $data['country']?></p>
							</div>
							<div class="order1">
								<img src="./products_photo/<?php 
								$prod_data = $db -> prepare('SELECT * FROM `products` WHERE `id` = ?');
								$prod_data -> bindParam(1, $order['prod_id'], PDO::PARAM_INT);
								$prod_data -> execute();
								$p_data = $prod_data -> fetch();
								echo $p_data['photos']?>" alt="product" width="100px" height="100px">
							</div>
							<div class="order2">
								<p><?= $p_data['title']?></p>
								<p><?= $p_data['price']?>$</p>
								<p><?php $cat_id = $db -> prepare('SELECT `category` FROM `categories` WHERE `id` = ?');
								$cat_id -> bindParam(1, $p_data['categories_id'], PDO::PARAM_INT);
								$cat_id -> execute();
								$cat = $cat_id -> fetch();
								echo $cat['category']
								?></p>
								<p><?php $sp_id = $db -> prepare('SELECT `sport_products` FROM `sport` WHERE `id` = ?');
								$sp_id -> bindParam(1, $p_data['sport_id'], PDO::PARAM_INT);
								$sp_id -> execute();
								$sp = $sp_id -> fetch();
								echo $sp['sport_products']
								?></p>
								<p><?php $brand_id = $db -> prepare('SELECT `brands` FROM `brand` WHERE `id` = ?');
								$brand_id -> bindParam(1, $p_data['brand_id'], PDO::PARAM_INT);
								$brand_id -> execute();
								$br = $brand_id -> fetch();
								echo $br['brands']
								?></p>
							</div>
							<?php if($order['status'] == 0): ?><a class="look_w" href="./orders/look.php?ord=<?= $order['id']?>">Order...</a>
							<?php endif; ?>
							<?php if($order['status'] == 1): ?><a class="look" href="./orders/look.php?ord=<?= $order['id']?>">Success!</a>
							<?php endif; ?>
							<?php if($order['status'] == 2): ?><a class="look_d" href="./orders/look.php?ord=<?= $order['id']?>">[Denied]</a>
							<?php endif; ?>
						</div>
						<hr>
					<?php endwhile; ?>
				</div>
			<?php endif ?>
			<?php if($user['type'] == 0) :?>
				<div class="tab_content tab-4 active">
					<?php $orders_id = $db -> prepare('SELECT * FROM `orders` WHERE `user_id` = ?');
					$orders_id -> bindParam(1, $user['id'], PDO::PARAM_INT);
					$orders_id -> execute();
					while($order_id = $orders_id -> fetch()): ?>
						<div class="myorders">
							<div class="myorders1">
								<img src="./products_photo/<?php 
								$prod_data = $db -> prepare('SELECT * FROM `products` WHERE `id` = ?');
								$prod_data -> bindParam(1, $order_id['prod_id'], PDO::PARAM_INT);
								$prod_data -> execute();
								$p_data = $prod_data -> fetch();
								echo $p_data['photos']?>" alt="product_photos" width="100px" height="100px">
							</div>
							<div class="myorders2">
								<p class="my_title"><?= $p_data['title']?></p>
								<p class="my_price"><?= $p_data['price']?>$</p>
							</div>
							<div class="myorders3">
								<p>Category: <?php $cat_id = $db -> prepare('SELECT `category` FROM `categories` WHERE `id` = ?');
								$cat_id -> bindParam(1, $p_data['categories_id'], PDO::PARAM_INT);
								$cat_id -> execute();
								$cat = $cat_id -> fetch();
								echo $cat['category']
								?></p>
								<p>Sport: <?php $sp_id = $db -> prepare('SELECT `sport_products` FROM `sport` WHERE `id` = ?');
								$sp_id -> bindParam(1, $p_data['sport_id'], PDO::PARAM_INT);
								$sp_id -> execute();
								$sp = $sp_id -> fetch();
								echo $sp['sport_products']
								?></p>
								<p>Brand: <?php $brand_id = $db -> prepare('SELECT `brands` FROM `brand` WHERE `id` = ?');
								$brand_id -> bindParam(1, $p_data['brand_id'], PDO::PARAM_INT);
								$brand_id -> execute();
								$br = $brand_id -> fetch();
								echo $br['brands']
								?></p>
							</div>
							<div>
								<p>Status:</p>
								<?php if($order_id['status'] == 1): ?>
									<p>Success!</p>
									<p>The product will soon arrive, expect</p>
								<?php endif; ?>
								<?php if($order_id['status'] == 0): ?>
									<p>Waiting...</p>
									<p>Your order for consideration.</p>
								<?php endif; ?>
								<?php if($order_id['status'] == 2): ?>
									<p>Cancel</p>
									<p>Unfortunately, such product are not left.</p>
								<?php endif; ?>
							</div>
							<div class="button-go">
								<a href="./show.php?id=<?= $p_data['id']?>&back=po">Go to product</a>
							</div>
						</div>
						<hr>
					<?php endwhile; ?>
				</div>
				<?php endif ?>
			</div>
		</div>
		<script>
			let tabNav = document.querySelectorAll('.tab_nav');
			let tabContent = document.querySelectorAll('.tab_content');

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
