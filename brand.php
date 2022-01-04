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
}

if(!empty($_POST['search'])){
	$search_con = $_POST['search'];
	$search = $db->query("SELECT * FROM `products` WHERE `title` LIKE '%$search_con%'");
	$search_act = 'true';
}else{
	$search_act = '';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="./style/style.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" />
	<title>DASport</title>
	<style>
	footer {
		color: #fff;
		margin: 20px auto 0;
		padding: 20px;
		width: 100%;
		height: 100%;
		background: #252525;
		box-shadow: 0 10px 25px black;
		backdrop-filter: blur(8px);
	}
	.about_us {
		width: 90%;
		margin: 0 auto 15px auto;
		line-height: 20px;
		text-align: justify;
	}
	footer h2 {
		margin-bottom: 10px;
	}	
	.sultan {
		margin: auto;
		width: 100px;
		display: flex;
		justify-content: space-between;
	}
	.sultan i {
		font-size: 25px;
		color: #fff;
	}
	.copy{
		display: flex;
		justify-content: center;
		margin-top: 10px;
	}
	</style>
</head>
<body>
	<header>
		<div class="logo">
			<a href="./index.php"><img src="./images/logo1.png" alt="LOGO"></a>
		</div>
		<form action="" method="post">
			<input type="text" name="search" placeholder="Search..." style="font-family: cursive;">
			<button type="submit">
				<i class="fas fa-search"></i>
			</button>
		</form>
		<div class="form">
			<?php
				if($signin == 'entered'):
			?>
			<div class="profile">
				<div class="pro_photo">
					<img src="./users_picture/<?= $user['avatar']?>" alt="prof" class="myphoto" id="myphoto" onclick="myPhoto">
					<div class="menu" id="menu">
						<a href="./Personal_cabinet.php">Personal Cabinet</a>
						<a href="./logout.php">Exit</a>					
					</div>
					
				</div>
			</div>
			<?php
				endif;
			if($signin == 'not_entered'):
			?>
			<div class="signs">
			<a class="signin" href="./join/signin.php">Sign in</a>
			<a class="signup" href="./join/registration.php">Sign up</a>
			</div>
			<?php
				endif;
			?>
		</div>
	</header>
	<main>
		<?php require "./catalog.php";?>
		<div class="posts">
			<?php if($search_act == 'true'):
				 while($search_sel = $search -> fetch()) :?>
					<div class="container">
						<div class="post">
							<div class="imgpost">
							<img src="./products_photo/<?= $search_sel['photos'];?>" alt="product">
								<h2><?= $search_sel['title'];?></h2>
							</div>
							<div class="content">
								<h2>Price : $<?= $search_sel['price'];?></h2>
								<a href="./show.php?id=<?= $search_sel['id']?>&back=i">View</a>
							</div>
						</div>
					</div>
				<?php endwhile ;
			endif; ?>
			<?php if($search_act == ''):
			$products = $db -> prepare('SELECT * FROM `products` WHERE `brand_id` = ?');
			$products -> bindParam(1, $_REQUEST["b"],  PDO::PARAM_INT);
			$products ->execute();
			while($product = $products -> fetch()):
			?>
				<div class="container">
					<div class="post">
						<div class="imgpost">
						<img src="./products_photo/<?= $product['photos'];?>" alt="product">
							<h2><?= $product['title'];?></h2>
						</div>
						<div class="content">
							<h2>Price : $<?= $product['price'];?></h2>
							<a href="
							<?php if($signin == 'not_entered'):?>
                                ./join/signin.php
                            <?php else:?>
                                ./show.php?id=<?= $product['id']?>&back=b&b=<?= $_REQUEST['b']?>
                            <?php endif;?>
							">View</a>
						</div>
					</div>
				</div>
			<?php endwhile;
			endif; ?>
		</div>
</main>
<footer>
	<div class="footer_links">
        <div class="about_us">
            <h2>
                About Us
            </h2>
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Fuga minus itaque expedita optio laborum ex corporis praesentium eos asperiores sequi necessitatibus dolor architecto cum, numquam velit odit minima autem culpa nobis dolorem dicta molestiae soluta tenetur neque. Autem doloribus sint, reiciendis, blanditiis excepturi eaque at recusandae, sit fugiat assumenda incidunt.
        </div>
        <div class="sultan">
            <a href="mailto:ainolhuawei@gmail.com"><i class="fab fa-google"></i></a>
            <a href="http://t.me/FalkoLink"><i class="fab fa-telegram"></i></a>
            <a href="Instagram.com"><i class="fab fa-instagram"></i></a>
        </div>
		<div class="copy">
			&copy; 2021 DASport
		</div>
    </div>
</footer>
	<script src="./script/script.js"></script>
</body>
</html>