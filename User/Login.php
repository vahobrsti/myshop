<?php
session_start();
require_once __DIR__.'/../config.php';
//logout
if(isset($_GET['action']) && $_GET['action']==='logout' && isset($_SESSION['user'])){
    unset($_SESSION['user']);
    echo 'You have successfully logged out';
    header("refresh:3;url=/User/Login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Login</title>
</head>
<body>
<?php if ($_SERVER['REQUEST_METHOD'] === 'GET' && !isset($_SESSION['user'])) {?>

    <form action="Login.php" method="post">
    <label for="user_name" >Your User Name: </label>
    <input type="text" id="user_name" name="user_name"><br>
    <label for="password"> Password: </label>
    <input type="password" name="password" id="password">
    <input type="submit" value="Login">
</form>
    <p> if you dont have a user, please click <a href="Create.php">here</a> for registeration</p>
    <?php }
    if(isset($_SESSION['user'])){
    header("Location: /User/Show.php");
}
require_once __DIR__.'/../footer.php';
?>
</body>
</html>
<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //var_dump($_POST);die();
    if(trim($_POST['user_name'])!==''){
        $user=new User();
        $user_name=$user->sanitize($_POST['user_name']);
        $query="SELECT * FROM `users` WHERE `user_name`='$user_name' OR `email`='$user_name' ";
        $userDB=$user->readQuery($query);
        //var_dump($userDB);die();//var_dump(password_verify($_POST['password'],$userDB['password']));die();
        if(count($userDB)>0 && password_verify($_POST['password'],$userDB['password']))
        {
            //user exist and password is correct,update the login, set the session
            $_SESSION['user']=$userDB;
            $query="UPDATE `users` SET `last_login`=NOW() WHERE `id`={$userDB['id']}";
            $user->updateQuery($query);
            echo 'You have successfully logged in.Now you will redirect to your home page.';
            header("refresh:3;url=/User/Show.php");

        }else{
            echo 'something went wrong ..... redirection to Login page';
            header("refresh:3;url=/User/Login.php");
        }

    }else{
        echo 'You have not filled out the fileds correctly';
        header("refresh:3;url=/User/Login.php");
    }
}
?>