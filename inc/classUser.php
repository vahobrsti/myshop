<?php

/**
 * Created by PhpStorm.
 * User: honey
 * Date: 14/11/16
 * Time: 10:23 PM
 */
class User extends DB
{
    public function iskDuplicate($email,$username){
        $query="SELECT * FROM `users` WHERE `email`='$email' OR `user_name`='$username'";
        $result=$this->readQuery($query);
        if(count($result)>0){
            return true;
        }
        return false;
    }
}