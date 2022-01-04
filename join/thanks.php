<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Completed</title>
    <style>
        body {
            background: url("../images/purple-material-design-abstract-4k-de-1536x864.jpg");
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-size: 100%;
        }
        .logo_photo {
            position: relative;
            top: 400px;
            
                  
        }
        .logo_photo img {
            width: 10%;
        }
        main{
            position: relative;
            text-align: center;
            width: 400px;
            top: 200px;
            margin: auto;
            color: white;
            border-radius: 7px;
            padding: 15px;
            background: rgba(255, 255, 255, 0.01);
            box-shadow: 0 10px 25px black;
            backdrop-filter: blur(8px);
        }
        main h1 {
            font-family: monospace;
        }
        main p {
            font-family: monospace;
            font-size: 18px;
        }
        .login {
            text-decoration: none;
            color: black;
            background:   rgb(123, 255, 0);
            padding: 8px 20px;
            border-radius: 7px; 
            font-family: monospace;
            font-size: 18px;
            transition: .2s ease-in-out;
        }
        .login:hover {
            background: rgb(0, 255, 13);
        }
    </style>
</head>
    
<body>
    <main>
            <h1>Thankyou</h1>
            <p>User Registration Completed!</p>
            <a class="login" href="./signin.php">Login</a>
    </main>
    <div class="logo_photo">
    <img src="../images/logo1.png" alt="LOGO">
    </div>
</body>

</html>