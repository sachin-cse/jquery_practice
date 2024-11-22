<?php 
session_start();
include 'db.php';

$database = new Database();
$conn = $database->getConnection();

if($_SERVER['REQUEST_METHOD'] == 'POST'){

    $actMsg['success'] = '';
    $actMst['error'] = '';

    $getId = $_POST['id'];
    $getName = $_POST['name'];

    try{

        // update query
        $sql = "UPDATE `quick_edit_data` SET `name` = '$getName' WHERE `id` = $getId";

        $query = mysqli_query($conn, $sql);

        if($query){
            $actMsg['success'] = 'Update Successfully';
        }else{
            throw new Exception("Database Error".mysqli_error($conn));
        }

    }
    catch(Exception $e){
        $actMsg['error'] = $e->getMessage();
    }

    echo json_encode($actMsg);

}
?>