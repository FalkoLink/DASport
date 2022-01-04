<?php
require_once('../dbconnect.php');
session_start();

if(isset($_COOKIE['email'])){
    if ($_COOKIE['email'] != '') {
        $_POST['email'] = $_COOKIE['email'];
        $_POST['password'] = $_COOKIE['password'];
        $_POST['save'] = 'on';
    }
}

if (empty($_POST)) {
    $error = array('login' => '');
} else {
    if ($_POST['email'] != '' && $_POST['password'] != '') {
        $login = $db->prepare('SELECT * FROM `users` WHERE `email`=? AND `pass`=?');
        $login->execute(array(
            $_POST['email'],
            md5($_POST['password'])
        ));
        $member = $login->fetch();

        if ($member) {
            $_SESSION['id'] = $member['id'];
            $_SESSION['time_in'] = time();

            if ($_POST['save'] == 'on') {
                setcookie('email', $_POST['email'], time() + 60 * 60 * 24 * 14);
                setcookie('password', $_POST['password'], time() + 60 * 60 * 24 * 14);
            }
            header('Location: ../index.php');
            exit();
        } else {
            $error['login'] = 'failed';
        }
    } else {
        $error['login'] = 'blank';
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sing in</title>

    <style>
		* {
			margin: 0;
			padding: 0;
			box-sizing: border-box;
		}
		body {
			font-size: 16px;
			line-height: 1.6;
			color: #eee;
            font-family: monospace;
            background: url("../images/purple-material-design-abstract-4k-de-1536x864.jpg");
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-size: 100%;
        }
        .back {
            display: flex;
            align-items: center;
        }
        .back a {
            color: white;
            text-decoration: none;
            padding: 5px 15px;
            line-height: 10px;
            color: white;
            border:1px solid #3c9;
			background: none;
			transition: .3s ease-in-out;
            border-radius: 5px;
            font-weight: 600;
        }
        .back a:hover {
            transition: .3s ease-in-out;
        background: rgb(51, 204, 102);
            animation: animation .2s infinite;
        }
		.tab {
			max-width: 500px;
			margin: 30px auto;
		}
		.tab_header {
			display: flex;
            font-size: 1.2em;
            font-family: cursive;
		}
		.tab_nav {
            margin: 20px 1px;
			padding: 10px 5px;
			width: 100%;
			text-align: center;
			cursor: pointer;
            transition: .3s background;
        }
        
		.tab_footer {
            
            padding: 20px 20px 10px ;
            background: rgba(255, 255, 255, 0.05);
            box-shadow: 0 10px 25px black;
            backdrop-filter: blur(8px);
            font-family: cursive;
        }
        .tab_content p{
            margin: 0 0 15px;
        }
		input {
			display: block;
			outline-style: none;
			border: none;
			margin-bottom: 30px;
            border-radius: 7px;
            font-family: cursive;
		}
		input:not([type=submit]) {
            font-family: cursive;
			width: 200px;
			height: 30px;
			font-size: 17px;
            padding-left: 5px;
            color: white;
            background: rgba(255, 255, 255, 0.01);
            box-shadow: 0 0 8px 3px rgba(255, 255, 255, 0.582);
            backdrop-filter: blur(8px);
            transition: .5s ease-in-out;
        }
        input:not([type=submit]):hover{
            transform: scale(1.03);
            animation: animate1 .8s infinite ease-in-out;
        }
        @keyframes animate1 {
            50% {
                transform: scale(1);
            }
        }
		input[type=submit] {
            padding: 8px 20px;
            font-family: cursive;
            font-weight: 600;
            box-shadow: 0 0 8px 3px rgba(255, 255, 255, 0.582);
        }
        input[type=submit]:hover{
            background: rgba(255, 255, 255, 1);
            animation: animation .2s infinite;
        }
        @keyframes animation{
            50% {
                transform: rotate(3deg);
            }
            100% {
                transform: rotate(-3deg);
            }
        }
		img {
            width: 180px;
            height: 50px;
            margin: auto;
            transform: translate(50%);
        }
        input[name = "save"]{
            display: inline;
            width: auto;
            height: auto;
            margin-right: 10px;
        };
        .registir {
            padding: 8px 20px;
            font-family: cursive;
            font-weight: 600;
            box-shadow: 0 0 8px 3px rgba(255, 255, 255, 0.582);
        }
        .registir:hover{
            background: rgba(255, 255, 255, 1);
            animation: animation .2s infinite;
        }
	</style>

</head>

<body>
<div class="tab">
    <div class="tab_header">
        <div class="tab_nav active" data_tab="tab-1">Sign In</div>
    </div>
    <div class="tab_footer">
        <div class="tab_content">
            <form action="" method="POST">
                <p>Please login with your email address and password. </p>
                <input style="width: 300px;" type="mail" name="email"  placeholder="Your Mail...">
                <input style="width: 300px;" type="password" name="password"  placeholder="Password...">
                <input id="save" type="checkbox" name="save" value="on">auto login
            <?php if ($error['login'] == 'blank') : ?>
                <p>Please enter your email address and password.</p>
            <?php elseif ($error['login'] == 'filed') : ?>
                <p>Email or Password failed. Please enter correctly.</p>
            <?php endif; ?>
                <input class="registir" type="submit" value="Submit">
            </form>

            <p>If you have not registered yet, please click here</p>
            <div class="back">
                <a href="./registration.php">Sign up</a>
                <img src="../images/logo1.png" alt="LOGO">
            </div>
        </div>
    </div>
</div>

    
</body>

</html>