<?php
require_once __DIR__.'/../header.php';
require_once  __DIR__.'/../config.php';
/**
 * Created by PhpStorm.
 * User: honey
 * Date: 19/11/16
 * Time: 5:25 PM
 */
//var_dump($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id']) && isset($_GET['action']) && $_GET['action']=='add');
if($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id']) && isset($_GET['action']) && $_GET['action']=='add') {
    $productModel=new Product();
    $id=$productModel->sanitize($_GET['id']);
    $product=$productModel->readQuery("SELECT `price`,`name`, `id` FROM `products` WHERE `id`=".$id);
    var_dump($product);
    if(! $product  ) {
        $_SESSION['msg']='I cant add to your basket :(';
    }else{
        $_SESSION['basket'][$product['id']] = $product;
        $_SESSION['msg']='You have added to your basket';
    }
    header('Location: /');
}

if($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action']==='view')
{
    if(!isset($_SESSION['basket']) || (isset($_SESSION['basket']) && !count($_SESSION['basket']) > 0)){
        echo 'You dont have anything in your basket. Go to <a href="/">Here </a> and add a product';
    }
    if(isset($_SESSION['basket']) && count($_SESSION['basket'])> 0){
        if(isset($_SESSION['msg'])){
            echo '<p style="color:green">'.$_SESSION['msg'].'</p>';
            unset($_SESSION['msg']);
        }
        $counter=1;
        $total_price=0;
        foreach ($_SESSION['basket'] as $id=>$specs){
            echo '<div style="border: dashed blue 2px"><p>Number: '.$counter.'</p>';
            echo '<p>Product Name:'.$specs['name'].'</p>';
            echo '<p>price: '.$specs['price'].' $</p>';
            echo '<a href="/Order/Orders.php?action=delete&id='.$id.'" onClick="return confirm(\' Are you sure? \')"> delete this from basket</a></div>';
            $counter++;
            $total_price=$total_price+$specs['price'];
        }
        echo '<hr>';
        echo '<p>total: '.$total_price.'$</p>';
        echo '<a style="display: block;color: green" href="/Order/Orders.php?action=finalise"> Finalize</a>';

    }
}
if($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id']) && isset($_GET['action']) && $_GET['action']=='delete' && isset($_SESSION['basket']) && count($_SESSION['basket'])>0 ) {

    $ids=array_keys($_SESSION['basket']);
    $name=$_SESSION['basket'][$_GET['id']]['name'];
    //var_dump(in_array($_GET['id'],$ids));die();
    if(in_array($_GET['id'],$ids)) {
        unset($_SESSION['basket'][$_GET['id']]);
        $_SESSION['msg']='You have successfully deleted '.$name;
        header('Location: /Order/Orders.php?action=view');
    }
}
if($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action']==='finalize')
{
    echo 'final';
}
require_once  __DIR__.'/../footer.php';
