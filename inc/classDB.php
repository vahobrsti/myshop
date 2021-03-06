<?php
require_once __DIR__ . '/../config.php';
class DB
{
    protected $connection;
    public $error;

    public function __construct($dbUser=DBUSER,$dbhost=DBHOST,$dbpass=DBPASS,$dbname=DBNAME)
    {
        $this->connection=new mysqli($dbhost,$dbUser,$dbpass,$dbname);

        if($this->connection->connect_errno!=0){
            $this->error=$this->connection->connect_error;
            return false;
        }
        return $this->connection;
    }
    public function sanitize($input){
        return $this->connection->real_escape_string($input);
    }

    public function readQuery($query){
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
        if(count($result)==1){
            return array_shift($result);
        }
        return $result;

    }
    public function insertQuery($query){
        $runResult=$this->connection->query($query);
        if(! $runResult){
            $this->error=$this->connection->error;
            $this->closeConnection();
            return false;
        }
        return $this->connection->affected_rows;
    }
    public function updateQuery($query)
    {
        $runResult=$this->connection->query($query);
        if(! $runResult){
            $this->error=$this->connection->error;
            $this->closeConnection();
            return false;
        }
        return $this->connection->affected_rows;
    }
    public function closeConnection(){
        $this->connection->close();
    }

}