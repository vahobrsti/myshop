<?php
require_once __DIR__ . '/../header.php';

if(isset($_SESSION['user']) && $_SESSION['user']['role']==='admin' && $_SERVER['REQUEST_METHOD'] === 'GET') {

    require_once __DIR__ . '/../config.php';

    $catHandler = new Category();
    $query = "SELECT * FROM `categories`";
    $allcats = $catHandler->readQuery($query);
    if(count($allcats)==0){
        echo 'you dont have any cat. please go this link and create them.<br>';
        echo '<a href="Create.php">create</a>';
        exit();
    }
    if(array_key_exists('id',$allcats) && array_key_exists('name',$allcats)){
        echo 'Name: ';
        echo htmlentities($allcats['name']);
        echo "<a href='/Category/Update.php?id=" . $allcats['id'] . "'> Update </a><br>";
    }else {
        foreach ($allcats as $category) {
            echo 'Name: ';
            echo htmlentities($category['name']);
            echo "<a href='/Category/Update.php?id=" . $category['id'] . "'> Update </a><br>";
        }
    }
    if(count($allcats)<3 || array_key_exists('id',$allcats)) {
        echo '<a href="Create.php">create</a>';
    }
        $catHandler->closeConnection();
}
 require_once __DIR__.'/../footer.php';
