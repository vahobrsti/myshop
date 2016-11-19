<?php
require_once __DIR__.'/../header.php';
require_once __DIR__.'/../config.php';
if(isset($_SESSION['user']) && $_SESSION['user']['role']==='admin') {
    $productModel = new Product();
    $product_id = $productModel->sanitize($_GET['id']);
    $query = "SELECT * FROM `products` WHERE `id`=" . $product_id;
    if (!($product = $productModel->readQuery($query))) {
        echo $productModel->error;
        exit();
    }
    $catModel = new Category();
    $query = "SELECT * FROM `categories`";
    $allCats = $catModel->readQuery($query);
}
if(! $catModel->checkForThree($allCats)){
    echo 'Not enough categories. Must be three';
    exit();
}
if(isset($_SESSION['user']) && $_SESSION['user']['role']==='admin' && $_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id']) && isset($_GET['action'])){
    $action=$_GET['action'];
    switch ($action){
        case 'update':

            ?>
            <form action="Update.php?action=update&id=<?php echo $product['id']?>" method="post" enctype="multipart/form-data">
                <label for="cat_id">Category Name: </label>
                <select name="cat_id" id="cat_id">
                    <?php
                    foreach ($allCats as $cat){
                        echo '<option value="'.$cat['id'].'" '.($cat['id']==$product['cat_id']?'Selected':'').'>'.$cat['name'].'</option>';
                    }
                    ?>
                </select><br>
                <br>
                <label for="name">Product Name: </label>
                <input type="text" name="name" id="name" value="<?php echo $product['name']?>"><br>
                <label for="price">Price: </label>
                <input type="text" name="price" id="price" value="<?php echo $product['price']; ?>"><br>

                <label for="description"> Description: </label>
                <textarea name="description" id="description" cols="30" rows="10" ><?php echo $product['description'] ;?></textarea>
                <br>
                <br>

                <label for="weight">Weight: </label>
                <input type="text" name="weight" id="weight" value="<?php echo $product['weight'];?>" ><br>

                <label for="stock">Stock Number: </label>
                <input type="text" name="stock" id="stock" value="<?php echo $product['stock'];?>"><br><br>
                <label for="pic">Picture</label>
                <p> Current Picture: <img height="150" width="150" src="/Public/Uploads/<?php echo $product['image'];?>"></p>
                <input type="file"  accept="image/*" name="pic" id="pic"><br><br>
                <input type="submit" value="Update">
            </form>
            <?php

            break;
        case 'delete':
            $query="DELETE FROM `products` WHERE `id`=".$product_id;
            if (! $productModel->updateQuery($query)){
                echo $productModel->error;
            }else{
                if(file_exists(__DIR__.'/../Public/Uploads/'.$product['image']))
                {
                    unlink(__DIR__ . '/../Public/Uploads/' . $product['image']);
                }
                echo 'Your product and its image have been deleted.';
                header("refresh:3;url=/");

            }
            break;
        default:
            echo 'what to do?';
            exit();
            break;
    }
}
if(isset($_SESSION['user']) && $_SESSION['user']['role']==='admin' && $_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['id']) && isset($_GET['action'])) {
    $cat_id = $product['cat_id']==$_POST['cat_id']?null:$productModel->sanitize($_POST['cat_id']);
    $name = $product['name']==$_POST['name']?null:$productModel->sanitize($_POST['name']);
    $price = $product['price']==$_POST['price']?null:($productModel->sanitize($_POST['price']));
    $description = $product['description']==$_POST['description']?null:$productModel->sanitize($_POST['description']);
    //var_dump($_POST);die();
    $weight = $product['weight']==$_POST['weight']?null:($productModel->sanitize($_POST['weight']));
    $stock = $product['stock']==$_POST['stock']?null:intval($productModel->sanitize($_POST['stock']));
    $text_change=!is_null($cat_id) || !is_null($name) || !is_null($price) || !is_null($description) || !is_null($weight) || !is_null($stock);
    $file_change=(file_exists($_FILES['pic']['tmp_name']) || is_uploaded_file($_FILES['pic']['tmp_name']));
    if($text_change || $file_change) {//there is an update
        $query = "UPDATE `products` SET ";
        if ($text_change) {
            $query .= is_null($cat_id) ? '' : " `cat_id`='$cat_id',";
            $query .= is_null($name) ? '' : " `name`='$name',";
            $query .= is_null($price) ? '' : " `price`='$price',";
            $query .= is_null($description) ? '' : " `description`='$description',";
            $query .= is_null($weight) ? '' : " `weight`='$weight',";
            $query .= is_null($stock) ? '' : " `stock`='$stock',";
        }
        if($file_change){
            if(!$_FILES['pic']['error']){
                $destination=__DIR__.'/../Public/Uploads/';
                $newName=ceil(rand(1,1000));
                if(!move_uploaded_file($_FILES['pic']['tmp_name'],$destination.$newName.$_FILES['pic']['name'])){
                    echo 'file successfully uploaded.<br>';
                };
                $image=$newName.$_FILES['pic']['name'];
                $query.= " `image`='".$image."' ";
            }
        }
        $query=rtrim($query, ",");
        $query.=" WHERE `id`=".$productModel->sanitize($product['id']);
       // var_dump($query);die();
        if(! $productModel->updateQuery($query)){
            echo $productModel->error;
            header("refresh:3;url=Show.php?id=".$product['id']);
        }else{
            echo "Update was successfull. Now redirection";
            header("refresh:3;url=Show.php?id=".$product['id']);
        }
    }

}
require_once __DIR__.'/../footer.php';