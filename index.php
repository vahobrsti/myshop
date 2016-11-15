<?php
require_once __DIR__ . '/config.php';
function autoLoad($className){
    if(file_exists(ROOTFOLDER.'inc/class'.$className.'.php')){
        require_once ROOTFOLDER.'inc/class'.$className.'.php';
    }
}
spl_autoload_register('autoLoad');
require_once (ROOTFOLDER.'header.php');
require (ROOTFOLDER.'footer.php');
echo ROOTFOLDER.'inc/class'.'DB'.'.php';


//$db=new DB();
//var_dump($db->insertQuery("INSERT INTO  `users` (`name`, `user_name`, `password`, `email`, `role`)VALUES('mehdi','hash','mhd','medhi@email.com','admin')"));
//var_dump($db->error);
