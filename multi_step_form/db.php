<?php
class DATABASE{
    protected $db_host = 'localhost';
    protected $db_name = 'multi-step-form';
    protected $db_username = 'root';
    protected $db_password = '';
    protected $port = 3306;

    protected $conn;

    function __construct(){
        $this->conn = mysqli_connect($this->db_host, $this->db_username, $this->db_password, $this->db_name, $this->port);

        try{
            if(!$this->conn){
                throw new Exception(mysqli_error($conn));
            }
        }catch(Exception $e){
            echo "Error: ".$e->getMessage();
        }
    }

    public function getConnection(){
        return $this->conn;
    }



}

$newConn = new DATABASE();
$newConn->getConnection();
?>