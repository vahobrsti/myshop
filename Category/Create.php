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
<?php }else{
    header("Location: /User/Login.php");
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_SESSION['user']['role']==='admin') {
$cat=new Category();
    if(! $cat->reachedMaximum()){
        $name=$cat->sanitize($_POST['name']);

    };
}
?>