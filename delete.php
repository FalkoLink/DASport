<?php 
session_start();
require('./dbconnect.php');

if(!empty($_SESSION['id'])){
	$user_id = $db -> prepare('SELECT * FROM `users` WHERE `id` = ?');
	$user_id -> bindParam(1, $_SESSION['id'], PDO::PARAM_INT);
	$user_id -> execute();
	$user = $user_id -> fetch();
	if($user['type'] == 1){
		$product = $db -> prepare('DELETE FROM `products` WHERE `id` = ?');
		$product -> execute(array($_REQUEST['id']));
	}else{
		header('Location: index.php');
		exit();
	}
}elseif(!empty($_COOKIE['email'])){
	$user_email = $db -> prepare('SELECT * FROM `users` WHERE `email` = ?');
	$user_email -> bindParam(1, $_COOKIE['email'], PDO::PARAM_STR);
	$user_email -> execute();
	$user = $user_email -> fetch();
	if($user['type'] == 1){
		$product = $db -> prepare('DELETE FROM `products` WHERE `id` = ?');
		$product -> execute(array($_REQUEST['id']));
	}else{
		header('Location: index.php');
		exit();
	}
}else{
	header('Location: index.php');
	exit();
}


header('Location: Personal_cabinet.php');
exit();
?>