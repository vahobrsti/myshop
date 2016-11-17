<?php
session_start();
/**
 * Created by PhpStorm.
 * User: honey
 * Date: 14/11/16
 * Time: 9:01 PM
 */
if(isset($_SESSION['user'])){?>
<a href="/User/Login.php?action=logout">Log out</a><br>
<?php }?>

