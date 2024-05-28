<?php
class Database {
    protected $host = 'localhost';
    protected $db_name = 'dependent-select-box';
    protected $db_username = 'root';
    protected $db_password = '';
    protected $port = 3306;
    protected $conn;

    function __construct(){
        $this->conn = mysqli_connect($this->host, $this->db_username, $this->db_password, $this->db_name, $this->port);

        if($this->conn){
            echo "Connection established";
        }else{
            echo "Connection failed".mysqli_connect_error();
        }
    }

}

$newConn = new Database();


?>

