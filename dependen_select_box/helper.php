<?php

include_once 'db.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);



$database = new Database();
$conn = $database->getConnection();

if($_SERVER["REQUEST_METHOD"] == "GET"){

    if(isset($_GET['country_id'])){

        try{
            $country_id = $_GET['country_id'];

            $sql = "SELECT * FROM `state` WHERE `country_id` = '$country_id'";
            $query = mysqli_query($conn, $sql);

            if(!$query){
                throw new Exception('Query failed'.mysqli_error($conn));
            }

            $html = '';
            $html.='<option value="" selected disabled>select state</option>';
            while($row = mysqli_fetch_assoc($query)){
                $html.='<option value='.$row['state_id'].'>'.$row['state_name'].'</option>';
            }

            echo $html;
        }
        catch(Exception $e){
            echo json_encode(['status'=>500, 'message'=>$e->getMessage()]);
        }
    }

    // for state
    if(isset($_GET['state_id'])){

        try{
            $state_id = $_GET['state_id'];

            $sql = "SELECT * FROM `city` WHERE `state_id` = '$state_id'";
            $query = mysqli_query($conn, $sql);

            $html = '';
            while($row = mysqli_fetch_assoc($query)){
                $html.='<option value='.$row['city_id'].'>'.$row['city_name'].'</option>';
            }

            echo $html;
        }
        catch(Exception $e){
            echo json_encode(['status'=>500, 'message'=>$e->getMessage()]);
        }
    }
}
?>