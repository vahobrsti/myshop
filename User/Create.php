<?php require_once __DIR__.'/../config.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Create</title>
</head>
<body>
<?php if ($_SERVER['REQUEST_METHOD'] === 'GET') :?>
<form action="Create.php" method="post">
    <label for="name">Name: </label>
    <input type="text" name="name" id="name"><br>
    <label for="user_name">User Name: </label>
    <input type="text" name="user_name" id="user_name"><br>
    <label for="password"> Your Password: </label>
    <input type="password" name="password" id="password"><br>
    <label for="email">E-Mail</label>
    <input type="email" name="email" id="email"><br>
    <input type="submit" value="Register">
</form>
<?php endif;
require_once __DIR__.'/../footer.php';
?>
</body>
</html>

<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user=new User();
    $name=$user->sanitize($_POST['name']);
    $user_name=$user->sanitize($_POST['user_name']);
    $password=password_hash($_POST['password'],PASSWORD_BCRYPT);
    $email=$user->sanitize($_POST['email']);
    $role='user';
    //var_dump($_SERVER);
    $query="INSERT INTO `users` (`name`, `user_name`, `password`, `email`, `role`, `created_at`, `last_login`)".
            " VALUES('$name','$user_name','$password','$email','$role',NOW(),NOW())";
    if(!($user->iskDuplicate($email,$user_name))) {
        if ($user->insertQuery($query)) {
            echo 'welcomee, Your registeration was successfull. Now you will be redirected to index page after 2 sec';
            $user->closeConnection();
            header("refresh:3;url=/");
        }
    }else{
        echo 'please pay attention to errors';
    }

}
?>
