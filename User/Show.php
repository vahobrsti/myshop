<?php
include __DIR__.'/../header.php';
if(isset($_SESSION['user'])){
    $userLoggedIn=$_SESSION['user'];
    echo 'Hi '.htmlentities($userLoggedIn['name']).'<br>';
    echo 'User Name: '.htmlentities($userLoggedIn['user_name']).'<br>';
    echo 'Name: '.htmlentities($userLoggedIn['name']).'<br>';
    echo 'Email: '.htmlentities($userLoggedIn['email']).'<br>';
    echo 'Last Login Date: '.htmlentities($userLoggedIn['last_login']).'<br>';
}else{
    header("Location: Login.php");
}
?>
<p>To update your details click the following link</p> <a href="/User/Update.php?id=<?php echo $userLoggedIn['id']?>">Update</a>
