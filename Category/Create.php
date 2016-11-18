<?php
require_once __DIR__.'/../config.php';
require_once __DIR__.'/../header.php';
if(isset($_SESSION['user']) && $_SESSION['user']['role']==='admin' && $_SERVER['REQUEST_METHOD'] === 'GET'){
?>
<html>
<head>

</head>
<body>
<form action="Create.php" method="post">
    <label for="name">Category Name: </label>
    <input type="text" name="name" id="name"><br>
    <input type="submit" value="Add">
</form>
</body>
</html>
<?php
}
if((isset($_SESSION['user']) && $_SESSION['user']['role']!=='admin') || (!isset($_SESSION['user']) ) ) {
    echo 'You dont have permission to access this page';
    header("refresh:3;url=/User/Login.php");
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_SESSION['user']['role']==='admin') {
$cat=new Category();

    if(! $cat->reachedMaximum()){
        $name=$cat->sanitize($_POST['name']);
        $query="INSERT INTO `categories` (`name`) VALUES ('$name')";
        if(! $cat->insertQuery($query)){
            echo $cat->error;
            exit();
        }
        if($cat->insertQuery($query)  ==1){
            echo 'You have created your cat successfully.';
            header("refresh:3;url=/Category/Show.php");
        }
    }else{
        echo 'You already have 3 categories. You cannot create more.';
        header("refresh:3;url=/Category/Show.php");
    };
}
?>