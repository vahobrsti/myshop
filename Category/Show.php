<?php
require_once __DIR__ . '/../header.php';

if(isset($_SESSION['user']) && $_SESSION['user']['role']==='admin' && $_SERVER['REQUEST_METHOD'] === 'GET') {

    require_once __DIR__ . '/../config.php';

    $catHandler = new Category();
    $query = "SELECT * FROM `categories`";
    $allcats = $catHandler->readQuery($query);
    foreach ($allcats as $category) {
        echo 'Name: ';
        echo htmlentities($category['name']);
        echo "<a href='/Category/Update.php?id=" . $category['id'] . "'> Update </a><br>";
    }
    $catHandler->closeConnection();
}