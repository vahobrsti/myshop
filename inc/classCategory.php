<?php

class Category extends DB
{
    public function reachedMaximum()
    {
        $query='SELECT COUNT(*) as total  FROM `categories`';
        $run=$this->connection->query($query);
        $total=$run->fetch_assoc()['total'];
        return ($total>=3);
    }
    public function checkForThree(array $allcats){
        if(! array_key_exists('id',$allcats) && count($allcats)>=3){
            return true;
        }
        return false;
    }
}