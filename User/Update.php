<?php
include __DIR__.'/../header.php';
require_once __DIR__.'/../config.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Update </title>
</head>
<body>
<?php
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id']) && isset($_SESSION['user'])):?>
    <form action="Update.php" method="post">
        <label for="name">Name: </label>
        <input type="text" name="name" id="name" value="<?php echo htmlentities($_SESSION['user']['name']);?>"><br>

        <label for="password"> Your Password: </label>
        <input type="password" name="password" id="password"><br>
        <label for="email">E-Mail</label>
        <input type="email" name="email" id="email" value="<?php echo htmlentities($_SESSION['user']['email']);?>"><br>
        <input type="submit" value="Update">
    </form>
<?php endif;?>
</body>
</html>

<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user=new User();
    $name=$user->sanitize($_POST['name']);
    $password=password_hash($_POST['password'],PASSWORD_BCRYPT);
    $email=$user->sanitize($_POST['email']);
    $id=$_SESSION['user']['id'];
    if(!empty($_POST['password'])){
        $query="UPDATE `users` SET `name`='$name', `password`='$password', `email`='$email' WHERE id='$id' ";
        if($user->updateQuery($query)){
            $query="SELECT * FROM `users` WHERE `id`=".$_SESSION['user']['id'];
            $userDB=$user->readQuery($query);
            $_SESSION['user']=$userDB;
            echo 'You have successfully updated your account.';
            header("refresh:3;url=" . HOST . "Show.php");
        }
    }
    else{
        echo 'Password cannot be empty. Try again';
        header("refresh:3;url=" . HOST . "Update.php?id=".$_SESSION['user']['id']);
    }

}
?>
