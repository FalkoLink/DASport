<?php
session_start();
require('../dbconnect.php');

if(!empty($_SESSION['id'])){
	$user_id = $db -> prepare('SELECT * FROM `users` WHERE `id` = ?');
	$user_id -> bindParam(1, $_SESSION['id'], PDO::PARAM_INT);
	$user_id -> execute();
    $user = $user_id -> fetch();
    if($user['type'] == 1){
		$orders_list = $db -> prepare('UPDATE `orders` SET `status` = 2 WHERE `id` = ?');
        $orders_list -> bindParam(1, $_REQUEST['ord'], PDO::PARAM_INT);
        $orders_list -> execute();
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
		$orders_list = $db -> prepare('UPDATE `orders` SET `status` = 2 WHERE `id` = ?');
        $orders_list -> bindParam(1, $_REQUEST['ord'], PDO::PARAM_INT);
        $orders_list -> execute();
	}else{
		header('Location: ../index.php');
		exit();
	}
}else{
	header('Location: ../index.php');
	exit();
}

header('Location: ../Personal_cabinet.php');
exit();