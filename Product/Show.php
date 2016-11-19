<html>
<head>

</head>
<body>
<?php
require_once __DIR__.'/../header.php';
require_once __DIR__.'/../config.php';

if($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id']) ){
    $productModel=new Product();
    $query="SELECT * FROM `products` WHERE `id`=".$_GET['id'];
    $product=$productModel->readQuery($query);

    if(! $product){
        echo 'something went wrong. try again.refresh the page';
        exit();
    }
    $categoryModel=new Category();
    $query="SELECT * FROM `categories` WHERE `id`=".$product['cat_id'];
    $cat=$categoryModel->readQuery($query);
    //var_dump($product);die();
    $catName=$cat['name'];
    echo '<p>Product Name:'.htmlentities($product['name']).'</p>';
    echo '<br>Category Name: '.htmlentities($catName).'<br>';
    echo '<br>Price: '.htmlentities($product['price']).'<br>';
    echo '<img width="200" height="200" src="/Public/Uploads/'.($product['image']).'"><br><br>';
    echo '<p>Stock Number: '.htmlentities($product['stock']).'</p>';
    echo '<p>Weight: '.htmlentities($product['weight']).'</p>';
    echo 'Description: '.htmlentities($product['description']);
    if(isset($_SESSION['user']) && $_SESSION['user']['role']==='admin'):?>
        <br><a href="<?php  echo 'Update.php?action=update&id='.$product['id'] ?>">Edit this product</a><br>
        <a style="color: red;" href="<?php  echo 'Update.php?action=delete&id='.$product['id'] ?>" onclick="return confirm('Are You sure to delete this?')"><b>Delete</b></a><br>

    <?php endif;?>
    <a href="Orders.php?action=add&id=<?php echo htmlentities($product['id']); ?>">Add To basket</a>
    <?php
}
require_once __DIR__.'/../footer.php';
?>
</body>
</html>