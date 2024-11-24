<?php
session_start();
include 'db.php';

$database = new Database();
$conn = $database->getConnection();

// get result from table
$query = "SELECT * FROM `quick_edit_data`";

$result = mysqli_query($conn, $query);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link type="text/css" rel="stylesheet" href="style.css" />

    <link type="text/css" rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.dataTables.min.css" />

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

    <link type="text/css" rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />

    <title>Quick Edit</title>
</head>
<body>
<div class="container">
  <h1>Quick Edit</h1>
  <div class="table-wrapper">
    <table id="quick_edit">
      <thead>
        <tr>
          <th>ID</th>
          <th>Name</th>
          <th>Email</th>
          <th>CREATED AT</th>
        </tr>
      </thead>
      <tbody>
        <?php 
        while($row = mysqli_fetch_assoc($result)){
          ?>
            <tr>
              <td><?php echo $row['id']; ?></td>
              <td class="quick_edit" data-name="<?php echo $row['name']; ?>" data-id="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></td>
              <td><?php echo $row['email']; ?></td>
              <td><?php echo $row['created_at']; ?></td>
            </tr>
          <?php
        }
        ?>
      </tbody>
    </table>
  </div>
  <p class="table-credits">Table info by <a href="https://en.wikipedia.org/wiki/List_of_countries_by_past_and_projected_future_population" target="_blank">Wikipedia</a></p>
</div>
<footer class="page-footer">
  <span>made by </span>
  <a href="https://georgemartsoukos.com/" target="_blank">
    <img width="24" height="24" src="https://assets.codepen.io/162656/george-martsoukos-small-logo.svg" alt="George Martsoukos logo">
  </a>
</footer>

<script type="text/javascript" src="https://cdn.datatables.net/2.1.8/js/dataTables.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
</body>
</html>

<script>

  // toastr option
  toastr.options = {
    "closeButton": true,
    "newestOnTop": false,
    "progressBar": true,
    "positionClass": "toast-top-right",
    "preventDuplicates": false,
    "onclick": null,
    "showDuration": "300",
    "hideDuration": "1000",
    "timeOut": "5000",
    "extendedTimeOut": "1000",
    "showEasing": "swing",
    "hideEasing": "linear",
    "showMethod": "fadeIn",
    "hideMethod": "fadeOut"
  }

    $(document).ready(function(){
        // load dataTable;
        $('#quick_edit').DataTable();

        let previousId = null;

        // quick edit
        $(document).on('click','.quick_edit', function(e){
            e.preventDefault();

            const $currentId = $(this);
            const getName = $currentId.data('name');
            const getId = $currentId.data('id');

            if(previousId && previousId[0] !== $currentId[0]){
              revertPrevioustd(previousId);
            }

            previousId = $currentId;

            $currentId.html(`<input type="text" class="edit-input" name="name" data-id="${getId}" value="${getName}">
            <button class="save_edit" data-id="${getId}">Save</button>`);

            $currentId.find('.edit-input').focus();
        });

          // save button
        $(document).on('click', '.save_edit', function(){
          // get current id
          var getId = $(this).attr('data-id');
          // get current name
          var getName = $(this).siblings('.edit-input').val();
          // call ajax
          if(getName != null && getId != null){
            $.ajax({
              url:'save_quick_edit.php',
              type:'post',
              data:{id:getId,name:getName},
              dataType:'json',
              success:function(data){
                if(data.success != ""){
                  toastr.success(data.success);

                  setTimeout(function(){
                    location.reload(true);
                  },500);
               
                }else{
                  toastr.success(data.error);
                }
              }
            });
          }
        });

       
    });

    function revertPrevioustd(previousData){
      const name = previousData.data('name');
      const id = previousData.data('id');
      const className = previousData.data('class');
      previousData.html(name)  // Restore the name as the content
                      .attr('data-id', id)  // Restore the id
                      .attr('data-name', name)  // Restore the name attribute
                      .attr('class', className); // Restore the class
    }
</script>

