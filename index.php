<?php
//include 'conn1.php';
session_start();
/*if($_POST)
{

    $fb = 1984582855143401;
    $name=$_POST["name"];
    $email=$_POST["email"];
    $password=$_POST["password"];
    $gender=$_POST["gender"];
    $address=$_POST["comment"];
    $password1=md5($password);
    $phone=$_POST["phone"];
    $_SESSION['last_id'] = $last_id;

    $query="INSERT INTO basic (name,email,password,gender,address,phone)
VALUES ('$name', '$email', '$password1','$gender','$address','$phone')";
    if ($conn->query($query) === TRUE) {
        $last_id = mysqli_insert_id($conn);
        //echo "New record created successfully. Last inserted ID is: " . $last_id;
        $_SESSION['last_id'] = $last_id;

    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }


}*/


?>
<html xmlns="http://www.w3.org/1999/html">
<head>
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body>
<script>
    (function(d, s, id){
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) {return;}
    js = d.createElement(s); js.id = id;
    js.src = "//connect.facebook.com/en_US/messenger.Extensions.js";
    fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'Messenger'));
</script>

<div class="container">
    <div class="row" id="search_row">
        <div class="col-md-12">
            <input type="radio" name="select_action" class="select_action" id="selectActionOne" value="0">Listing Search
        </div>

        <div class="col-md-12">
            <input type="radio" name="select_action" class="select_action" id="selectActionTwo" value="1">Zillow Search
        </div>
    </div>

    <div class="row" id="listing_search_row" style="display:none">
        <div class="col-md-12">
            <input type="radio" name="listing_search_action" class="listing_select_action" id="listingselectActionOne" value="0">Listing Id
        </div>

        <div class="col-md-12">
            <input type="radio" name="listing_search_action" class="listing_select_action" id="listingselectActionTwo" value="1">City
        </div>

        <div class="col-md-12">
            <input type="radio" name="listing_search_action" class="listing_select_action" id="listingselectActionThree" value="2">Postal Code
        </div>

        <div class="col-md-12">
            <input type="radio" name="listing_search_action" class="listing_select_action" id="listingselectActionFour" value="3">Address
        </div>

        <div class="col-md-12">
            <button class="btn btn-sm btn-info" id="backSearchRowFromListing"> Back </button>
        </div>
    </div>

    <div class="row" id="zillow_search" style="display:none">
        <div class="col-md-6">
            <label>Address : </label>
        </div>

        <div class="col-md-6">
            <input type="text" name="zillow_search_address" class="zillow_search_action" id="zillowActionOne" placeholder="Enter Address">Listing Search
        </div>

        <div class="col-md-6">
            <label>Zip : </label>
        </div>

        <div class="col-md-6">
            <input type="text" name="zillow_search_zip" class="zillow_search_action" id="zillowActionTwo" placeholder="Enter Zip Code">Zillow Search
        </div>

        <div class="col-md-12">
            <button class="btn btn-sm btn-info" id="backSearchRowFromZillow"> Back </button>
        </div>
    </div>

    <div class="row" id="listing_search_row_values" style="display:none">
        <div class="col-md-12" id="listing_id_row">
            <form action="listing_search.php" method="get">
                <input type="text" name="listing_id" class="form-group" id="listing_id" placeholder="Listing id">
                <input type="submit" value="Submit">
                <button class="btn btn-sm btn-info" id="backFromListingId"> Back </button>
            </form>
        </div>

        <div class="col-md-12" id="city_row">
            <form action="listing_search.php" method="get">
                <input type="text" name="city" class="form-group" id="city" placeholder="City">
                <input type="submit" value="Submit">
                <button class="btn btn-sm btn-info" id="backFromCity"> Back </button>
            </form>
        </div>

        <div class="col-md-12" id="postal_code_row">
            <form action="listing_search.php" method="get">
                <input type="text" name="postal_code" class="form-group" id="postal_code" placeholder="Postal Code">
                <input type="submit" value="Submit">
                <button class="btn btn-sm btn-info" id="backFromPostalCode"> Back </button>
            </form>
        </div>

        <div class="col-md-12" id="address_row">
            <form action="listing_search.php" method="get">
                <input type="text" name="address" class="form-group" id="address" placeholder="Address">
                <input type="submit" value="Submit">
                <button class="btn btn-sm btn-info" id="backFromAddress"> Back </button>
            </form>
        </div>
    </div>
</div>


<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script>
    var choice = '0';
    window.extAsyncInit = function() {
        // the Messenger Extensions JS SDK is done loading
    };

    $('.select_action').click(function ()  {
        choice = $(this).val();
        $('#search_row').hide();
        if(choice == '0') {
            $('#listing_search_row').show();
            $('#zillow_search').hide();
            $('#listing_search_row_values').hide();
        }
    });

    $('.listing_select_action').click(function ()  {
        choice = $(this).val();
        $('#listing_search_row').hide();
        switch(choice) {
            case '0':   $('#listing_search_row_values').show();
                        $('#listing_id').attr('required','required');
                        $('#listing_id_row').show();
                        $('#city_row').hide();
                        $('#postal_code_row').hide();
                        $('#address_row').hide();
                        break;

            case '1':   $('#listing_search_row_values').show();
                        $('#city').attr('required','required');
                        $('#listing_id_row').hide();
                        $('#city_row').show();
                        $('#postal_code_row').hide();
                        $('#address_row').hide();
                        break;

            case '2':   $('#listing_search_row_values').show();
                        $('#postal_code').attr('required','required');
                        $('#listing_id_row').hide();
                        $('#city_row').hide();
                        $('#postal_code_row').show();
                        $('#address_row').hide();
                        break;

            case '3':   $('#listing_search_row_values').show();
                        $('#address').attr('required','required');
                        $('#listing_id_row').hide();
                        $('#city_row').hide();
                        $('#postal_code_row').hide();
                        $('#address_row').show();
                        break;
        }
    });

    $('#backFromListingId').click(function () {
        $('#listing_search_row').show();
        $('#listing_search_row_values').hide();
        $('#listingselectActionOne').prop('checked',false);
        $('#listingselectActionTwo').prop('checked',false);
        $('#listingselectActionThree').prop('checked',false);
        $('#listingselectActionFour').prop('checked',false);
        $('#listing_id').removeAttr('required');
    });

    $('#backFromCity').click(function () {
        $('#listing_search_row').show();
        $('#listing_search_row_values').hide();
        $('#listingselectActionOne').prop('checked',false);
        $('#listingselectActionTwo').prop('checked',false);
        $('#listingselectActionThree').prop('checked',false);
        $('#listingselectActionFour').prop('checked',false);
        $('#city').removeAttr('required')
    });

    $('#backFromPostalCode').click(function () {
        $('#listing_search_row').show();
        $('#listing_search_row_values').hide();
        $('#listingselectActionOne').prop('checked',false);
        $('#listingselectActionTwo').prop('checked',false);
        $('#listingselectActionThree').prop('checked',false);
        $('#listingselectActionFour').prop('checked',false);
        $('#postal_code').removeAttr('required')
    });

    $('#backFromAddress').click(function () {
        $('#listing_search_row').show();
        $('#listing_search_row_values').hide();
        $('#listingselectActionOne').prop('checked',false);
        $('#listingselectActionTwo').prop('checked',false);
        $('#listingselectActionThree').prop('checked',false);
        $('#listingselectActionFour').prop('checked',false);
        $('#address').removeAttr('required')
    });

    $('#backSearchRowFromListing').click(function () {
        $('#search_row').show();
        $('#listing_search_row').hide();
        $('#zillow_search').hide();
        $('#listing_search_row_values').hide();
        $('#selectActionOne').prop('checked',false);
        $('#selectActionTwo').prop('checked',false);
    });

    $('#backSearchRowFromZillow').click(function () {
        $('#search_row').show();
        $('#listing_search_row').hide();
        $('#zillow_search').hide();
        $('#listing_search_row_values').hide();
        $('#selectActionOne').prop('checked',false);
        $('#selectActionTwo').prop('checked',false);
    });
</script>
</body>
</html>