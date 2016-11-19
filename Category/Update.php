<?php
require_once __DIR__.'/../config.php';
require_once __DIR__.'/../header.php';
if(isset($_SESSION['user']) && $_SESSION['user']['role']==='admin' && $_SERVER['REQUEST_METHOD'] === 'GET'){
    $catHandler = new Category();
    $cat_id=$catHandler->sanitize($_GET['id']);
    $query='SELECT id,name FROM `categories` WHERE id='.$cat_id;
    $cat=$catHandler->readQuery($query);
    if(count($cat)==0 || !$cat){
        echo 'something went wrong. Try again';
        header("refresh:3;url=/Category/Show.php");
        exit();

    }
    $catHandler->closeConnection();

?>
<html>
<head>

</head>
<body>
<form action="" method="post">
    <label for="name">Category Name: </label>
    <input type="text" name="name" id="name" value="<?php echo $cat['name']?>"><br>
    <input type="submit" value="Update">
</form>
<a href="/Category/Show.php" style="display: block;color: #4cae4c">Back to Previous page</a>
<?php require_once __DIR__.'/../footer.php'?>
</body>
</html>
<?php }
if (isset($_SESSION['user']) && $_SESSION['user']['role']==='admin' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $catHandler=new Category();
    $cat_id=$catHandler->sanitize($_GET['id']);
    $name=$catHandler->sanitize($_POST['name']);
    $query="UPDATE `categories` SET `name`='$name' WHERE `id`=".$cat_id;
    $run=$catHandler->updateQuery($query);
    if(!$run){
        echo 'Try again';
    }else{
        echo 'Update was successfull';
        header("refresh:3;url=/Category/Show.php");

    }
}


?>