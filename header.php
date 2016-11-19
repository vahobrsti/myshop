<?php
session_start();
/**
 * Created by PhpStorm.
 * User: honey
 * Date: 14/11/16
 * Time: 9:01 PM
 */
if(isset($_SESSION['user'])){?>
    <p> Hi dear <?php echo $_SESSION['user']['name'] ?></p>
    <a href="/User/Login.php?action=logout">Log out</a><br>
<?php }
if(isset($_SESSION['msg'])){
    echo '<p style="color: green">'.$_SESSION['msg'].'</p>';
    unset($_SESSION['msg']);
}

?>

