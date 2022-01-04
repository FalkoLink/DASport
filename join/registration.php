<?php
require('../dbconnect.php');
session_start();

if (empty($_POST)) {
    $error = array('username' => '', 'first_name' => '', 'last_name' => '', 'birthday' => '', 'se' => '', 'email' => '', 'password' => '', 'image' => '',);
} else {
    if (!empty($_POST)) {
        // username
        $username = $db -> prepare('SELECT COUNT(*) AS pnt FROM users WHERE username=?');
        $username -> execute(array($_POST['email']));
        $have = $username -> fetch();
        if ($_POST['username'] == '') {
            $error['username'] = 'blank';
        } elseif ($have['pnt'] > 0) {
            $error['username'] = 'duplicate';
        } else {
            $error['username'] = '';
        }

        // first_name
        if ($_POST['first_name'] == '') {
            $error['first_name'] = 'blank';
        } else {
            $error['first_name'] = '';
        }

        // last_name
        if ($_POST['last_name'] == '') {
            $error['last_name'] = 'blank';
        } else {
            $error['last_name'] = '';
        }

        // birthday
        if ($_POST['birthday'] == '') {
            $error['birthday'] = 'blank';
        } else {
            $error['birthday'] = '';
        }

        //gender
        if ($_POST['se'] == '') {
            $error['se'] = 'blank';
        } else {
            $error['se'] = '';
        }

        // email
        $member = $db->prepare('SELECT COUNT(*) AS cnt FROM users WHERE email=?');
        $member->execute(array($_POST['email']));
        $record = $member->fetch();
        if ($_POST['email'] == '') {
            $error['email'] = 'blank';
        } elseif ($record['cnt'] > 0) {
            $error['email'] = 'duplicate';
        } else {
            $error['email'] = '';
        }

        // password
        if ($_POST['password'] == '') {
            $error['password'] = 'blank';
        } elseif (strlen($_POST['password']) < 4) {
            $error['password'] = 'length';
        } else {
            $error['password'] = '';
        }

        // picture
        $fileName = $_FILES['image']['name'];
        if (!empty($fileName)) {
            $ext = substr($fileName, -3);
            if ($ext != 'jpg' && $ext != 'gif' && $ext != 'png') {
                $error['image'] = 'type';
            }else {
                $error['image'] = '';
            }
        } else {
            $error['image'] = '';
        }



        if ($error['username'] == '' && $error['first_name'] == '' && $error['last_name'] == '' && $error['birthday'] == '' && $error['se'] == '' && $error['email'] == '' && $error['password'] == '' && $error['image'] == '') {
            $image = date('YmdHis') .'_'. $_POST['username'] .'_'. $_FILES['image']['name'];
            move_uploaded_file($_FILES['image']['tmp_name'], '../users_picture/' . $image);

            $_SESSION['join'] = $_POST;
            $_SESSION['join']['image'] = $image;
            header('Location:check.php');
            exit();
        }
    }
}

// rewrite
if(!empty($_REQUEST['action'])){
    if($_REQUEST['action'] =='rewrite'){
        $_POST = $_SESSION['join'];
        $error['rewrite'] = true;
    }
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
    <title>Sign up</title>
    <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }
    body {
      font-size: 16px;
      line-height: 1.6;
      background: #699;
      color: #eee;
      font-family: monospace;
      background: url("../images/purple-material-design-abstract-4k-de-1536x864.jpg");
      background-repeat: no-repeat;
      background-attachment: fixed;
      background-size: 100%;
    }
    .tab {
      max-width: 500px;
      margin: 30px auto;
    }
    .tab_header {
      display: flex;
      font-size: 1.2em;
      font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
    }
    
    .tab_nav {
      padding: 10px 5px;
      width: 100%;
      text-align: center;
      cursor: pointer;
      transition: .3s background;
    }
    .tab_footer {
      padding: 20px 20px 10px ;
      background: rgba(255, 255, 255, 0.02);
      box-shadow: 0 10px 25px black;
      backdrop-filter: blur(8px);
      font-family: cursive;
    }
    input {
      display: block;
      outline-style: none;
      border: none;
      margin-bottom: 20px;
      border-radius: 10px;
      font-family: cursive;
    }
    .inputt {
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
    .inputt:hover{
            transform: scale(1.03);
            animation: animate1 .8s infinite ease-in-out;
        }
        @keyframes animate1 {
            50% {
                transform: scale(1);
            }
        }
    input[type=submit] {
      padding: 10px 20px;
    }
    input[type=radio] {
        display: inline;
        width: auto;
        height: auto;
        margin-right: 10px;
    }
    .file {
        box-shadow: 0 10px 25px black;
        padding: 5px 5px;
        border-radius: 10px;
        
    }
    .submit1 {
        color: white;
        padding: 8px 20px;
        font-family: cursive;
        font-weight: 600;
        border:1px solid #3c9;
			background: none;
			transition: .3s ease-in-out;
    }
    .submit1:hover{
        transition: .3s ease-in-out;
        background: rgb(51, 204, 102);
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
        .error {
            margin: 10px;
            padding-left: 5px;
            background: rgb(253, 156, 156);
            width: 250px;
            border-radius: 7px;
            color: black;
        }
    .LOGO {
      margin: 60px 0 0 20px;
      width: 10%;
    }

    </style>
</head>

<body>
<div class="tab">
    <div class="tab_header">
      <div class="tab_nav active" data_tab="tab-1">Sign up</div>
    </div>
    <div class="tab_footer">
        <div class="tab_content">
            <form action="" method="POST" enctype="multipart/form-data">
            <!-- username-->
            <input style="width: 300px;" class="inputt" type="text" name="username" placeholder="Your Nickname..." value="<?php echo hsc(!empty($_POST['username']) ? $_POST['username'] : ''); ?>">
                <?php if ($error['username'] == 'blank') : ?>
                    <p class="error">* Enter your nickname.</p>
                <?php endif; ?>
                <?php if ($error['username'] == 'duplicate') : ?>
                    <p class="error">* This nickname is taken.</p>
                <?php endif; ?>

            <!-- first_name -->
            <input style="width: 300px;" class="inputt" type="text" name="first_name" placeholder="Your first-name..." value="<?php echo hsc(!empty($_POST['first_name']) ? $_POST['first_name'] : ''); ?>">
                <?php if ($error['first_name'] == 'blank') : ?>
                    <p class="error">* Enter your first-name.</p>
                <?php endif; ?>

            <!-- last_name -->
            <input style="width: 300px;" class="inputt" type="text" name="last_name" placeholder="Your last-name..." value="<?php echo hsc(!empty($_POST['last_name']) ? $_POST['last_name'] : ''); ?>">
                <?php if ($error['last_name'] == 'blank') : ?>
                    <p class="error">* Enter your last-name.</p>
                <?php endif; ?>

            <!-- date -->
            <input class="inputt" type="date" name="birthday" value="$_POST['birthday']">
                <?php if ($error['birthday'] == 'blank') : ?>
                    <p class="error">* Enter your birth date.</p>
                <?php endif; ?>
            
            <!-- gender -->
            male
            <input type="radio" name="se" value="1" checked>
            female
            <input type="radio" name="se" value="2">

            <!-- email -->
            <input style="width: 300px;" class="inputt" type="email" name="email" placeholder="Your email..." value="<?php echo hsc(!empty($_POST['email']) ? $_POST['email'] : ''); ?>">
                <?php if ($error['email'] == 'blank') : ?>
                    <p class="error">* Please enter email.</p>
                <?php endif; ?>
                <?php if ($error['email'] == 'duplicate') : ?>
                    <p class="error">* Registared email address.</p>
                <?php endif; ?>
            
            <!-- password -->
            <input style="width: 300px;" class="inputt" type="password" name="password" placeholder="Your password..."value="<?php echo hsc(!empty($_POST['password']) ? $_POST['password'] : ''); ?>">
                <?php if ($error['password'] == 'blank') : ?>
                    <p class="error">* Please enter the password.</p>
                <?php endif; ?>
                <?php if ($error['password'] == 'length') : ?>
                    <p class="error">* Please enter a minimum of four characters.</p>
                <?php endif; ?>
            
            <!-- picture -->
            
            <input class="file" type="file" name="image">
                <?php if ($error['image'] == 'type') : ?>
                    <p class="error">* Uploaded a ".jpg" or ".gif" image.</p>
                <?php endif; ?>
            
            <!-- submit -->
            <input class="submit1" type="submit" value="submit">
            </form>
        </div>
    </div>
</div>
<img class="LOGO" src="../images/logo1.png" alt="LOGO">
</body>

</html>