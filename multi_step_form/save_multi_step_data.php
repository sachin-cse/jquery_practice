<?php
include 'db.php';

$database = new Database();
$conn = $database->getConnection();

if($_SERVER['REQUEST_METHOD'] == 'POST'){
   if($_POST['step'] == 'step-1'){
    echo "Hare Krishna";
   }
}
?>