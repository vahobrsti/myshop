<?php

/**
 * Created by PhpStorm.
 * User: honey
 * Date: 14/11/16
 * Time: 10:26 PM
 */
class Product extends DB
{
    /**
     * @return mysqli
     */
    public function getLastId()
    {
        return $this->connection->insert_id;
    }
    public function getAll($query){
        $result=array();
        $runResult=$this->connection->query($query);
        if(!$runResult){
            $this->error=$this->connection->error;
            $this->closeConnection();
            return false;
        }
        while ($row=$runResult->fetch_assoc()){
            $result[]=$row;
        }
        return $result;

    }

}