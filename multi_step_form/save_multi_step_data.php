<?php
session_start();
include 'db.php';

$database = new Database();
$conn = $database->getConnection();

if($_SERVER['REQUEST_METHOD'] == 'POST'){
   if($_POST['step'] == 'step-1'){
      $id = $_POST['id'];
      // echo $id; exit;
      // print_r($_POST); exit;
      $login_details = json_encode(['email'=>$_POST['email'], 'password'=>$_POST['password']]);
      try{

         if($id > 0){
            $sql = "UPDATE `multi_step_form_data` SET `login_details` = '$login_details' WHERE `id` = '$id'";
         }else{
            $sql = "insert into `multi_step_form_data`(`login_details`) VALUES('$login_details')";
         }
         $query = mysqli_query($conn, $sql);
         if(!$query){
            throw new Exception(mysqli_error($conn));
         }else{
            $_SESSION['id'] = $id > 0 ? $id : mysqli_insert_id($conn);
            echo json_encode(['status'=>200, 'message'=>'Login Details save successful']);
         }
      }
      catch(Exception $e){
         echo json_encode(['status'=>500, 'message'=>$e->getMessage()]);
      }
   }

   // step 2
   if($_POST['step'] == 'step-2'){
      $id = $_POST['id'];
      $personal_details = json_encode(['first_name'=>$_POST['first_name'], 'last_name'=>$_POST['last_name'], 'gender'=>$_POST['gender']]);
      try{

         if($id > 0){
            // print_r($_POST); exit;
            $sql = "UPDATE `multi_step_form_data` SET `personal_details` = '$personal_details' WHERE `id` = '$id'";
         }else{
            $sql = "insert into `multi_step_form_data`(`personal_details`) VALUES('$personal_details')";
         }
         $query = mysqli_query($conn, $sql);
         if(!$query){
            throw new Exception(mysqli_error($conn));
         }else{
            echo json_encode(['status'=>200, 'message'=>'Personal Details save successful']);
         }
      }
      catch(Exception $e){
         echo json_encode(['status'=>500, 'message'=>$e->getMessage()]);
      }
   }

   // step 3
   if($_POST['step'] == 'step-3'){
      $id = $_POST['id'];
      $contact_details = json_encode(['address'=>$_POST['address'], 'mobile_no'=>$_POST['mobile_no']]);
      try{

         if($id > 0){
            // print_r($_POST); exit;
            $sql = "UPDATE `multi_step_form_data` SET `contact_details` = '$contact_details' WHERE `id` = '$id'";
         }else{
            $sql = "insert into `multi_step_form_data`(`contact_details`) VALUES('$contact_details')";
         }
         $query = mysqli_query($conn, $sql);
         if(!$query){
            throw new Exception(mysqli_error($conn));
         }else{
            echo json_encode(['status'=>200, 'message'=>'Contact Details save successful']);
         }
      }
      catch(Exception $e){
         echo json_encode(['status'=>500, 'message'=>$e->getMessage()]);
      }
   }
}
?>