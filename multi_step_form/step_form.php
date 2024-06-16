<?php
session_start();
include 'db.php';
$database = new Database();
$conn = $database->getConnection();

if(!empty($_SESSION['id'])){
    $sql = "SELECT * FROM `multi_step_form_data` WHERE `id` = ".$_SESSION['id']."";
    $query = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($query);
    // print_r($row); exit;
} 

// print_r($row); exit;

$sessionVal = json_decode($row['login_details']??'', true);
$personaldetails = json_decode($row['personal_details']??'', true);
$contact_details = json_decode($row['contact_details']??'', true);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet" />
    <title>Multi Step Form</title>

<style>
  .box
  {
   width:800px;
   margin:0 auto;
  }
  .active_tab1
  {
   background-color:blue;
   color:white;
   font-weight: 600;
  }
  .inactive_tab1
  {
   background-color: #f5f5f5;
   color: #333;
   cursor: not-allowed;
  }
  .has-error
  {
   border-color:#cc0000;
   background-color:#ffff99;
  }
</style>
</head>
<body>
<div class="container box">
   <br />
   <h2 align="center">Multi Step Registration Form Using JQuery Bootstrap in PHP</h2><br />
   <?php echo $message??''; ?>
   <form method="post" id="register_form">
    <input type="hidden" value="<?= $_SESSION['id']??0; ?>" name="id" id="hidden_id">
    <ul class="nav nav-tabs">
     <li class="nav-item">
      <a class="nav-link active_tab1" style="border:1px solid #ccc" id="list_login_details">Login Details</a>
     </li>
     <li class="nav-item">
      <a class="nav-link inactive_tab1" id="list_personal_details" style="border:1px solid #ccc">Personal Details</a>
     </li>
     <li class="nav-item">
      <a class="nav-link inactive_tab1" id="list_contact_details" style="border:1px solid #ccc">Contact Details</a>
     </li>
    </ul>
    <div class="tab-content" style="margin-top:16px;">
     <div class="tab-pane active" id="login_details">
      <div class="panel panel-default">
       <div class="panel-heading">Login Details</div>
       <div class="panel-body">
        <div class="form-group">
         <label>Enter Email Address</label>
         <input type="text" name="email" value="<?=$sessionVal['email']??'';?>" id="email" class="form-control" />
         <span id="error_email" class="text-danger error_email"></span>
        </div>
        <div class="form-group">
         <label>Enter Password</label>
         <input type="password" name="password" value="<?=$sessionVal['password']??''?>" id="password" class="form-control" />
         <span id="error_password" class="text-danger"></span>
        </div>
        <br />
        <div align="center">
         <button type="button" name="btn_login_details" id="btn_login_details" class="btn btn-info btn-lg">Next</button>
        </div>
        <br />
       </div>
      </div>
     </div>
     <div class="tab-pane fade" id="personal_details">
      <div class="panel panel-default">
       <div class="panel-heading">Fill Personal Details</div>
       <div class="panel-body">
        <div class="form-group">
         <label>Enter First Name</label>
         <input type="text" name="first_name" id="first_name" class="form-control" value="<?=$personaldetails['first_name']??'';?>" />
         <span id="error_first_name" class="text-danger"></span>
        </div>
        <div class="form-group">
         <label>Enter Last Name</label>
         <input type="text" name="last_name" id="last_name" class="form-control" value="<?=$personaldetails['last_name']??'';?>"/>
         <span id="error_last_name" class="text-danger"></span>
        </div>
        <div class="form-group">
         <label>Gender</label>
         <label class="radio-inline">
          <input type="radio" name="gender" value="male" class="gender" <?php if(($personaldetails['gender']??'') == 'male') { echo 'checked';}?> > Male
         </label>
         <label class="radio-inline">
          <input type="radio" name="gender" value="female" class="gender" <?php if(($personaldetails['gender']??'') == 'female') { echo 'checked';}?>> Female
         </label>
         <span id="error_gender" class="text-danger"></span>
        </div>
        <br />
        <div align="center">
         <button type="button" name="previous_btn_personal_details" id="previous_btn_personal_details" class="btn btn-default btn-lg">Previous</button>
         <button type="button" name="btn_personal_details" id="btn_personal_details" class="btn btn-info btn-lg">Next</button>
        </div>
        <br />
       </div>
      </div>
     </div>
     <div class="tab-pane fade" id="contact_details">
      <div class="panel panel-default">
       <div class="panel-heading">Fill Contact Details</div>
       <div class="panel-body">
        <div class="form-group">
         <label>Enter Address</label>
         <textarea name="address" id="address" class="form-control"><?=$contact_details['address']??'' ?></textarea>
         <span id="error_address" class="text-danger"></span>
        </div>
        <div class="form-group">
         <label>Enter Mobile No.</label>
         <input type="text" name="mobile_no" id="mobile_no" class="form-control" value="<?=$contact_details['mobile_no']??'' ?>" />
         <span id="error_mobile_no" class="text-danger"></span>
        </div>
        <br />
        <div align="center">
         <button type="button" name="previous_btn_contact_details" id="previous_btn_contact_details" class="btn btn-default btn-lg">Previous</button>
         <button type="button" name="btn_contact_details" id="btn_contact_details" class="btn btn-success btn-lg">Register</button>
        </div>
        <br />
       </div>
      </div>
     </div>
    </div>
   </form>
  </div>

  <script>
    $(document).ready(function(){

        // login details
        $('#btn_login_details').on('click', function(){
            var email = $('#email').val().trim();
            var password = $('#password').val().trim();
            var id = $('#hidden_id').val();
            var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
            // $('#error_email').text('');
            var valid = true;
            
            if(email === ''){
                $('#error_email').text('email is required');
                $('#email').addClass('has-error');
                valid = false;
            } else if(!filter.test(email)) {
                $('#error_email').text('please enter your valid email address');
                $('#email').addClass('has-error');
                valid = false;
            } else {
                $('#error_email').text('');
                $('#email').removeClass('has-error');
            }

            if(password === ''){
                $('#error_password').text('password is required');
                $('#password').addClass('has-error');
                valid = false;
            }else{
                $('#error_password').text('');
                $('#password').removeClass('has-error');
            }

            if(valid){
                $.ajax({
                    type:"POST",
                    dataType:"json",
                    url:'save_multi_step_data.php',
                    data:{email:email, password:password, step:'step-1', id:id},
                    success:function(data){
                        $('#list_login_details').removeClass('active_tab1').addClass('inactive_tab1');
                        $('#list_personal_details').addClass('active_tab1').removeClass('inactive_tab1');
                        $('#login_details').removeClass('active').addClass('fade');
                        $('#personal_details').addClass('active').removeClass('fade');
                    }
                });
            }

            $(document).on('click', '#previous_btn_personal_details', function(){
                $('#list_login_details').addClass('active_tab1').removeClass('inactive_tab1');
                $('#list_personal_details').removeClass('active_tab1').addClass('inactive_tab1');
                $('#login_details').addClass('active').removeClass('fade');
                $('#personal_details').removeClass('active').addClass('fade');
            });

        });

        //personal details
        $('#btn_personal_details').on('click', function(){
            var first_name = $('#first_name').val().trim();
            var last_name = $('#last_name').val().trim();
            var gender = $("input[name='gender']:checked").val();
            var id = $('#hidden_id').val();
            // $('#error_email').text('');
            var valid = true;
            
            if(first_name === ''){
                $('#error_first_name').text('Please enter your first name');
                $('#first_name').addClass('has-error');
                valid = false;
            } 
            else {
                $('#error_first_name').text('');
                $('#last_name').removeClass('has-error');
            }

            if(last_name === ''){
                $('#error_last_name').text('Please enter your last name');
                $('#last_name').addClass('has-error');
                valid = false;
            }else{
                $('#error_last_name').text('');
                $('#last_name').removeClass('has-error');
            }

            if($("input[name='gender']:checked").val() === undefined){
                $('#error_gender').text('Please choose your gender');
                $('.gender').addClass('has-error');
                valid = false;
            }else{
                $('#error_gender').text('');
                $('.gender').removeClass('has-error');
            }

            if(valid){
                $.ajax({
                    type:"POST",
                    dataType:"json",
                    url:'save_multi_step_data.php',
                    data:{first_name:first_name, last_name:last_name, gender:gender,step:'step-2', id:id},
                    success:function(data){
                        $('#list_personal_details').removeClass('active_tab1').addClass('inactive_tab1');
                        $('#list_contact_details').addClass('active_tab1').removeClass('inactive_tab1');
                        $('#personal_details').removeClass('active').addClass('fade');
                        $('#contact_details').addClass('active').removeClass('fade');
                    }
                });
            }

            $(document).on('click', '#previous_btn_personal_details', function(){
                $('#list_login_details').addClass('active_tab1').removeClass('inactive_tab1');
                $('#list_personal_details').removeClass('active_tab1').addClass('inactive_tab1');
                $('#login_details').addClass('active').removeClass('fade');
                $('#personal_details').removeClass('active').addClass('fade');
            });

        });

        $(document).on('click', '#previous_btn_personal_details', function(){
            $('#list_login_details').addClass('active_tab1').removeClass('inactive_tab1');
            $('#list_personal_details').removeClass('active_tab1').addClass('inactive_tab1');
            $('#login_details').addClass('active').removeClass('fade');
            $('#personal_details').removeClass('active').addClass('fade');
        });

        // contact details
        $('#btn_contact_details').on('click', function(){
            var address = $('#address').val().trim();
            var mobile_no = $('#mobile_no').val().trim();
            var id = $('#hidden_id').val();
            // $('#error_email').text('');
            var valid = true;
            
            if(address === ''){
                $('#error_address').text('Please enter your address');
                $('#address').addClass('has-error');
                valid = false;
            } 
            else {
                $('#error_address').text('');
                $('#address').removeClass('has-error');
            }

            if(mobile_no === ''){
                $('#error_mobile_no').text('Please enter your mobile number');
                $('#mobile_no').addClass('has-error');
                valid = false;
            }else{
                $('#error_mobile_no').text('');
                $('#mobile_no').removeClass('has-error');
            }

            if(valid){
                $.ajax({
                    type:"POST",
                    dataType:"json",
                    url:'save_multi_step_data.php',
                    data:{address:address, mobile_no:mobile_no,step:'step-3', id:id},
                    success:function(data){
                        console.log(data);
                    }
                });
            }

        });

        $(document).on('click', '#previous_btn_contact_details', function(){
            $('#list_contact_details').removeClass('active_tab1').addClass('inactive_tab1');
            $('#list_personal_details').addClass('active_tab1').removeClass('inactive_tab1');
            $('#contact_details').removeClass('active').addClass('fade');
            $('#personal_details').addClass('active').removeClass('fade');
        });
    });
    </script>

</body>
</html>