<?php
require_once __DIR__.'/../config.php';
require_once __DIR__.'/../header.php';
if(isset($_SESSION['user']) && $_SESSION['user']['role']==='admin' && $_SERVER['REQUEST_METHOD'] === 'GET'){
    $catModel=new Category();
    $query="SELECT * FROM `categories`";
    $allCats=$catModel->readQuery($query);
    if(count($allCats) <3 || array_key_exists('id',$allCats)){
        echo 'You do not have enough cat numbers: At least three';
        header("refresh:3;url=/Category/Create.php");
        exit();
    }

    ?>
    <html>
    <head>

    </head>
    <body>
    <form action="Create.php" method="post" enctype="multipart/form-data">
        <label for="cat_id">Category Name: </label>
        <select name="cat_id" id="cat_id">
        <?php
        foreach ($allCats as $cat){
            echo '<option value='.$cat['id'].'>'.$cat['name'].'</option>';
        }
        ?>
        </select><br>
        <br>
        <label for="name">Product Name: </label>
        <input type="text" name="name" id="name"><br>
        <label for="price">Price: </label>
        <input type="text" name="price" id="price"><br>

        <label for="description"> Description: </label>
        <textarea name="description" id="description" cols="30" rows="10"></textarea>
        <br>
        <br>

        <label for="weight">Weight: </label>
        <input type="text" name="weight" id="weight"><br>

        <label for="stock">Stock Number: </label>
        <input type="text" name="stock" id="stock"><br><br>
        <label for="pic">Picture</label>
        <input type="file"  accept="image/*" name="pic" id="pic"><br><br>
        <input type="submit" value="Add">
    </form>
    </body>
    </html>
    <?php
}
if(! isset($_SESSION['user']))
{
    header("Location: /User/Login.php");
}
if(isset($_SESSION['user']) && $_SESSION['user']['role']!='admin'){
    echo 'You dont have access to this page.';
}
//create the product
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_SESSION['user']['role']==='admin') {
    //var_dump($_POST);
    $productModel=new Product();
    $cat_id=$productModel->sanitize($_POST['cat_id']);
    $name=$productModel->sanitize($_POST['name']);
    $price=($productModel->sanitize($_POST['price']));
    $description=$productModel->sanitize($_POST['description']);
    //var_dump($_POST);die();
    $weight=($productModel->sanitize($_POST['weight']));
    $stock=intval($productModel->sanitize($_POST['stock']));
    $active=1;
    $query="INSERT INTO `products` (`cat_id`,`name`,`price`,`description`,`active`,`weight`,`stock`)VALUES ('$cat_id','$name','$price','$description',$active,'$weight','$stock')";
    if(file_exists($_FILES['pic']['tmp_name']) || is_uploaded_file($_FILES['pic']['tmp_name'])) {
        //there is a file to upload.
        if(!$_FILES['pic']['error']){
            $destination=__DIR__.'/../Public/Uploads/';
            $newName=ceil(rand(1,1000));
            if(!move_uploaded_file($_FILES['pic']['tmp_name'],$destination.$newName.$_FILES['pic']['name'])){
                echo 'file successfully uploaded.<br>';
            };
            $image=$newName.$_FILES['pic']['name'];
            $query="INSERT INTO `products` (`cat_id`,`name`,`price`,`description`,`active`,`weight`,`image`,`stock`)VALUES ('$cat_id','$name','$price','$description',$active,'$weight','$image','$stock')";
        }
        if(! $productModel->insertQuery($query)){
            echo $productModel->error;
        }else{
            $productId=$productModel->getLastId();
            echo 'You have created your product successfully. Now Redirection to its page';
            header("refresh:3;url=Show.php?id=".$productId);

        };
    }

}
