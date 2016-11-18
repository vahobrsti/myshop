<?php
require_once __DIR__ . '/config.php';
require_once (ROOTFOLDER.'header.php');
if(!isset($_SESSION['user'])) {
    ?>
    <a href="User/Login.php">Login Page</a><br>
    <a href="User/Create.php">User Registration</a>

    <?php
}else{
    ?>
    <a href="/User/Show.php">View You User</a><br>
    <a href="/User/Update.php">Update You User Specs</a>

<?php
    if($_SESSION['user']['role']==='admin')
    {
        echo '<br><b>You are an admin</b><br>';
        echo '<a href="/Category/Show.php"> Manage Categories </a>';
    }
}
require (ROOTFOLDER.'footer.php');
