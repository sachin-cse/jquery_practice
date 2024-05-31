<?php

include_once 'header.php';

include_once 'db.php';


$database = new Database();
$conn = $database->getConnection();
$country = "SELECT * FROM `country`";

$getCountry = mysqli_query($conn, $country);


?>
<select name="country_id" id="country_id">
    <option value="">Select Country</option>
    <?php
    while($row = mysqli_fetch_assoc($getCountry)){
        ?>
        <option value="<?=$row['country_id']?>"><?= $row['country_name'];?></option>
        <?php
    }
    ?>
</select>
<?php

?>
<select name="state_id" id="state_id">
    <option vale="">Select State</option>
</select>
<?php

?>
<select name="city_id" id="city_id">
    <option vale="">Select City</option>
</select>
<?php

?>

<!-- get state -->

<script>
    $(document).ready(function() {
        $('#country_id').on('change', function(){
            var val = $(this).val();
            $('#state_id').html('');
            $.ajax({
                url: 'helper.php',
                type: 'get',
                data: {country_id:val},
                success: function(data) { 
                    console.log(data);
                    if(data.status == 500){
                        alert(data.message);
                    }
                    $('#state_id').html(data);
                }
            });
        });

        $('#state_id').on('change', function(){
            var val = $(this).val();
            $('#city_id').html('');
            $.ajax({
                url: 'helper.php',
                type: 'get',
                data: {state_id:val},
                success: function(data) { 
                    console.log(data);
                    if(data.status == 500){
                        alert(data.message);
                    }
                    $('#city_id').html(data);
                }
            });
        });
    });
</script>

</body>
</html>