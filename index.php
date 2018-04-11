<?php
require_once __DIR__ . '/config.php';
require_once (ROOTFOLDER.'header.php');
//I made a change from outside. 
?>
    <a href="/Order/Orders.php?action=view">View your basket</a><br>
<?php
if(!isset($_SESSION['user'])) {
    ?>
    <a href="User/Login.php">Login Page</a><br>
    <a href="User/Create.php">User Registration</a><br>

    <?php
}else{
    ?>
    <a href="/User/Show.php">View You User</a><br>
    <a href="/User/Update.php">Update You User Specs</a>

<?php
    if($_SESSION['user']['role']==='admin')
    {
        echo '<br><b>You are an admin</b><br>';
        echo '<a href="/Category/Show.php"> Manage Categories </a><br>';
        echo '<a href="/Product/Create.php"> Add Products </a><br>';
    }
}
$productModel=new Product();
$query='SELECT * FROM `products`';
$allProducts=$productModel->getAll($query);
foreach ($allProducts as $product) {
    ?>
    <div style="border: dashed 2px blue;float: left">
    <?php
    echo '<p> Product name:' . $product['name'] . '</p>';
    ?>
        <img height="200px" width="200px" src="/Public/Uploads/<?php echo $product['image'];?>" alt="<?php echo $product['name']?>">
        <p>Price: <?php echo $product['price'];?></p>
        <p id="test">Stock Number: <?php echo $product['stock'];?></p>
        <p><a href="/Product/Show.php?id=<?php echo $product['id'];?>"> View details</a></p>
        <p><a href="/Order/Orders.php?action=add&id=<?php echo $product['id'];?>"> Add to basket</a></p>
        <?php if(isset($_SESSION['user']) && $_SESSION['user']['role']==='admin'){
            echo '<a href="/Product/Update.php?action=update&id='.$product['id'].'"> Edit </a>';
        }

        ?>

    </div>
    <?php
}
?>
    <div style="clear: both"></div>
<?php
require 'footer.php';

