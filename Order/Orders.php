<?php
require_once __DIR__.'/../header.php';
require_once  __DIR__.'/../config.php';
/**
 * Created by PhpStorm.
 * User: honey
 * Date: 19/11/16
 * Time: 5:25 PM
 */
if($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
echo 'hey basket';
    var_dump($_SESSION);
    $basket=array();
}