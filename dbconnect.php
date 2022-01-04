<?php
try{
    $db = new PDO('mysql:dbname=das;host=localhost;charset=utf8;','root','');
}catch(PDOException $e){
    echo 'DB error: '. $e -> getMessage();
}
?>