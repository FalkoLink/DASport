<?php
session_start();
require('../dbconnect.php');

if (!isset($_SESSION['join'])) {
    header('Location:registration.php');
    exit();
}

if (!empty($_POST)) {
    $statement = $db->prepare('INSERT INTO `users` SET `username`=?,`first_name`=?,`last_name`=?, `birthday`=?, `gender`=?, `email`=?, `pass`=?, `avatar`=?, `date_created`=NOW();');
    $statement->execute(array(
        $_SESSION['join']['username'],
        $_SESSION['join']['first_name'],
        $_SESSION['join']['last_name'],
        $_SESSION['join']['birthday'],
        $_SESSION['join']['se'],
        ($_SESSION['join']['email']),
        md5($_SESSION['join']['password']),
        $_SESSION['join']['image'],
    ));
    unset($_SESSION['join']);
    header('Location: thanks.php');
    exit();
}

function hsc($value)
{
    return htmlspecialchars($value, ENT_QUOTES);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cheking</title>
    <style>
        body {
            background: url('../images/purple-material-design-abstract-4k-de-1536x864.jpg');
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-size: 100%;
        }
        .back {
            background: rgb(255, 44, 44);
            color: white;
            text-decoration: none;
            padding: 10px 10px;
            margin: 0 10px;
            font-size: 18px;
            font-weight: 600;
            border-radius: 7px;
            transition: .2s ease-in-out;
            font-family: monospace;
        }
        .back:hover {
            background: red;
        }
        .registar {
            background: rgb(0, 255, 76);
            color: white;
            text-decoration: none;
            padding: 8px 10px;
            margin: 0 10px;
            font-size: 18px;
            font-weight: 600;
            border-radius: 7px;
            transition: .2s ease-in-out;
            font-family: monospace;
        }
        .registar:hover {
            background: rgb(0, 255, 0);
            animation: animate .3s infinite;
        }
        @keyframes animate{
            50%{
                transform: rotate(3deg);
            }
            100% {
                transform: rotate(-3deg);
            }
        }
        main {
            position: relative;
            text-align: center;
            width: 400px;
            top: 120px;
            margin: auto;
            color: white;
            border-radius: 7px;
            padding: 5px;
            background: rgba(255, 255, 255, 0.01);
            box-shadow: 0 10px 25px black;
            backdrop-filter: blur(8px);
        }
        .username{
            display: flex;
            font-size: 11px;
            width: 300px;
            margin-left: 10px;
        }
        .username h2 {
            font-family: monospace
        }
        .confirm {
            position: relative;
            bottom: 18px;
            display: block;
        }
        .header-style{
            display: flex;
        }           
    </style>
</head>

<body>
    <main>
        <h1 style="font-family:monospace;">Confirm</h1>
        <form action="" method="POST">
            <input type="hidden" name="submit" value="true">
            <div class="header-style">
            <!-- image -->
                <img src="../users_picture/<?php echo hsc($_SESSION['join']['image']); ?>" alt="avatar" width="100" height="100">
                <div class="confirm">
                    <div class="username">
                        <h2>Username: <?php echo hsc($_SESSION['join']['username']); ?></h2>
                        <!-- username -->
                    </div>
                    <div class="username">
                        <!-- first_name -->
                        <h2>First name: <?php echo hsc($_SESSION['join']['first_name']); ?></h2>
                    </div>
                    <div class="username">
                        <h2>Last name: <?php echo hsc($_SESSION['join']['last_name']); ?></h2>
                        <!-- last_name -->
                        
                    </div>
                    <div class="username">
                        <h2>Email: <?php echo hsc($_SESSION['join']['email']); ?></h2>
                        <!-- email -->
                    </div>
                </div>
            </div>
            <p>
            <a class="back" href="../join/registration.php?action=rewrite"><< Return</a><input class="registar" type="submit" value="Registar">
            </p>
        </form>
    </main>
</body>

</html>