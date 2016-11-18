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
}