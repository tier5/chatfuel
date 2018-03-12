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

    <!-- Search Options -->
    <div class="row" id="search_row">
        <!-- Listing search -->
        <div class="col-md-12">
            <input type="radio" name="select_action" class="select_action" id="selectActionOne" value="0">Listing Search
        </div>
        <!-- Listing search -->
        <!-- Zillow search -->
        <div class="col-md-12">
            <input type="radio" name="select_action" class="select_action" id="selectActionTwo" value="1">Zillow Search
        </div>
        <!-- Zillow search -->
        <!-- Realtor search -->
        <div class="col-md-12">
            <input type="radio" name="select_action" class="select_action" id="selectActionThree" value="2">Find a REALTOR®
        </div>
        <!-- Realtor search -->
    </div>
    <!-- Search Options -->


    <!-- Listing search options -->
    <div class="row" id="listing_search_row" style="display:none">
        <!-- Search via listing id -->
        <div class="col-md-12">
            <input type="radio" name="listing_search_action" class="listing_select_action" id="listingselectActionOne" value="0">Listing Id
        </div>
        <!-- Search via listing id -->
        <!-- Search via City -->
        <div class="col-md-12">
            <input type="radio" name="listing_search_action" class="listing_select_action" id="listingselectActionTwo" value="1">City
        </div>
        <!-- Search via city -->
        <!-- Search via postal code -->
        <div class="col-md-12">
            <input type="radio" name="listing_search_action" class="listing_select_action" id="listingselectActionThree" value="2">Postal Code
        </div>
        <!-- Search via postal code -->
        <!-- Search via address -->
        <div class="col-md-12">
            <input type="radio" name="listing_search_action" class="listing_select_action" id="listingselectActionFour" value="3">Address
        </div>
        <!-- Search via address -->
        <!-- Back Button -->
        <div class="col-md-12">
            <button class="btn btn-sm btn-info" id="backSearchRowFromListing"> Back </button>
        </div>
        <!-- Back Button -->
    </div>
    <!-- Listing search options -->

    <!-- Zillow Search -->
    <div class="row" id="zillow_search" style="display:none">
        <form action="processindex.php" method="get">
            <!-- Address -->
            <div class="form-group">
                <div class="col-md-6">
                    <label>Address : </label>
                </div>
                <div class="col-md-6">
                    <input type="text" name="address" class="zillow_search_action" id="zillowActionOne" placeholder="Enter Address">
                </div>
            </div>
            <!-- Address -->
            <!-- Zip -->
            <div class="form-group">
                <div class="col-md-6">
                    <label>Zip : </label>
                </div>
                <div class="col-md-6">
                    <input type="text" name="zip" class="zillow_search_action" id="zillowActionTwo" placeholder="Enter Zip Code">
                </div>
            </div>

            <input type="hidden" name="psid" class="psid">
            <input type="hidden" name="type" value="1">
            <!-- Zip -->
            <div class="form-group">
                <div class="col-md-12">
                    <input type="submit">
                </div>
            </div>
        </form>
        <!-- Back button -->
        <div class="col-md-12">
            <button class="btn btn-sm btn-info" id="backSearchRowFromZillow"> Back </button>
        </div>
        <!-- Back button -->
    </div>
    <!-- Zillow Search -->

    <!-- Listing Search Inputs -->
    <div class="row" id="listing_search_row_values" style="display:none">
        <!-- Listing ID -->
        <div class="col-md-12" id="listing_id_row">
            <form action="processindex.php" method="get">
                <input type="hidden" name="psid" class="psid">
                <input type="hidden" name="type" value="2">
                <input type="text" name="listing_id" class="form-group" id="listing_id" placeholder="Listing id">
                <input type="submit" value="Submit">
            </form>
            <button class="btn btn-sm btn-info" id="backFromListingId"> Back </button>
        </div>
        <!-- Listing ID -->
        <!-- City -->
        <div class="col-md-12" id="city_row">
            <form action="processindex.php" method="get">
                <input type="hidden" name="psid" class="psid">
                <input type="hidden" name="type" value="2">
                <input type="text" name="city" class="form-group" id="city" placeholder="City">
                <input type="submit" value="Submit">
            </form>
            <button class="btn btn-sm btn-info" id="backFromCity"> Back </button>
        </div>
        <!-- City -->
        <!-- Postal Code -->
        <div class="col-md-12" id="postal_code_row">
            <form action="processindex.php" method="get">
                <input type="hidden" name="psid" class="psid">
                <input type="hidden" name="type" value="2">
                <input type="text" name="postal_code" class="form-group" id="postal_code" placeholder="Postal Code">
                <input type="submit" value="Submit">
            </form>
            <button class="btn btn-sm btn-info" id="backFromPostalCode"> Back </button>
        </div>
        <!-- Postal Code -->
        <!-- Address -->
        <div class="col-md-12" id="address_row">
            <form action="processindex.php" method="get">
                <input type="hidden" name="psid" class="psid">
                <input type="hidden" name="type" value="2">
                <input type="text" name="address" class="form-group" id="address" placeholder="Address">
                <input type="submit" value="Submit">
            </form>
            <button class="btn btn-sm btn-info" id="backFromAddress"> Back </button>
        </div>
        <!-- Address -->
    </div>
    <!-- Listing Search Inputs -->

    <!-- Find a Realtor Options -->
    <div class="row" id="realtor_search_row" style="display:none">
        <!-- Search via first name -->
        <div class="col-md-12">
            <input type="radio" name="realtor_search_action" class="realtor_select_action" id="realtorselectActionOne" value="0">First name
        </div>
        <!-- Search via first name -->
        <!-- Search via last name -->
        <div class="col-md-12">
            <input type="radio" name="realtor_search_action" class="realtor_select_action" id="realtorselectActionTwo" value="1">Last name
        </div>
        <!-- Search via last name -->
        <!-- Search via office name  -->
        <div class="col-md-12">
            <input type="radio" name="realtor_search_action" class="realtor_select_action" id="realtorselectActionThree" value="2">Office name
        </div>
        <!-- Search via office name  -->
        <!-- Back Button -->
        <div class="col-md-12">
            <button class="btn btn-sm btn-info" id="backSearchRowFromRealtor"> Back </button>
        </div>
        <!-- Back Button -->
    </div>
    <!-- Find a Realtor Options -->

    <!-- Realtor Search Inputs -->
    <div class="row" id="realtor_search_row_values" style="display:none">
        <!-- First name -->
        <div class="col-md-12" id="first_name_row">
            <form action="processindex.php" method="get">
                <input type="hidden" name="psid" class="psid">
                <input type="hidden" name="type" value="3">
                <input type="text" name="first_name" class="form-group" id="first_name" placeholder="First Name">
                <input type="submit" value="Submit">
            </form>
            <button class="btn btn-sm btn-info" id="backFromFirstName"> Back </button>
        </div>
        <!-- First name -->
        <!-- Last name -->
        <div class="col-md-12" id="last_name_row">
            <form action="processindex.php" method="get">
                <input type="hidden" name="psid" class="psid">
                <input type="hidden" name="type" value="3">
                <input type="text" name="last_name" class="form-group" id="last_name" placeholder="Last Name">
                <input type="submit" value="Submit">
            </form>
            <button class="btn btn-sm btn-info" id="backFromLastName"> Back </button>
        </div>
        <!-- Last name -->
        <!-- Office Name -->
        <div class="col-md-12" id="office_name_row">
            <form action="processindex.php" method="get">
                <input type="hidden" name="psid" class="psid">
                <input type="hidden" name="type" value="3">
                <input type="text" name="office_name" class="form-group" id="office_name" placeholder="Office Name">
                <input type="submit" value="Submit">
            </form>
            <button class="btn btn-sm btn-info" id="backFromOfficeName"> Back </button>
        </div>
        <!-- Office Name -->
    </div>
    <!-- Listing Search Inputs -->
</div>


<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script>
    var psID = '';
    window.extAsyncInit = function() {
        // the Messenger Extensions JS SDK is done loading

        /*var handleUserAction = function(psID) {
            element = document.getElementsByClassName('psid');
            var n;
            for (n = 0; n < element.length; ++n) {
                element[n].value=psID;
            }
            MessengerExtensions.requestCloseBrowser();
        };*/

        MessengerExtensions.getContext('228036937769463',
            function success(thread_context) {
                console.log(thread_context);
                console.log(thread_context.psid);
               // handleUserAction(thread_context.psid);
                psID = thread_context.psid;
            }, function error(error) {
                console.log(error);
            }
        );

    };

    $(document).ready(function () {
        $('#selectActionOne').prop('checked',false);
        $('#selectActionTwo').prop('checked',false);
        $('#selectActionThree').prop('checked',false);
    });

    $('.select_action').click(function ()  {
        var choice = $(this).val();
        $('#search_row').hide();
        switch(choice) {
            case '0':   $('#listing_search_row').show();
                        $('#zillow_search').hide();
                        $('#listing_search_row_values').hide();
                        $('#realtor_search_row').hide();
                        break;
            case '1':   $('#zillow_search').show();
                        $('#listing_search_row_values').hide();
                        $('#listing_search_row').hide();
                        $('#realtor_search_row').hide();
                        $('.psid').val(psID);
                        break;
            case '2':   $('#zillow_search').hide();
                        $('#listing_search_row_values').hide();
                        $('#listing_search_row').hide();
                        $('#realtor_search_row').show();
                        break;
        }

    });

    $('.realtor_select_action').click(function ()  {
        var choice = $(this).val();
        $('#realtor_search_row').hide();
        switch(choice) {
            case '0':   $('#realtor_search_row_values').show();
                        $('#first_name').attr('required','required');
                        $('#first_name_row').show();
                        $('#last_name_row').hide();
                        $('#office_name_row').hide();
                        break;

            case '1':   $('#realtor_search_row_values').show();
                        $('#last_name').attr('required','required');
                        $('#first_name_row').hide();
                        $('#last_name_row').show();
                        $('#office_name_row').hide();
                        break;

            case '2':   $('#realtor_search_row_values').show();
                        $('#office_name').attr('required','required');
                        $('#first_name_row').hide();
                        $('#last_name_row').hide();
                        $('#office_name_row').show();
                        break;
        }
    });

    $('.listing_select_action').click(function ()  {
        var choice = $(this).val();
        $('#listing_search_row').hide();
        switch(choice) {
            case '0':   $('#listing_search_row_values').show();
                        $('#listing_id').attr('required','required');
                        $('#listing_id_row').show();
                        $('#city_row').hide();
                        $('#postal_code_row').hide();
                        $('#address_row').hide();
                        $('.psid').val(psID);
                        break;

            case '1':   $('#listing_search_row_values').show();
                        $('#city').attr('required','required');
                        $('#listing_id_row').hide();
                        $('#city_row').show();
                        $('#postal_code_row').hide();
                        $('#address_row').hide();
                        $('.psid').val(psID);
                        break;

            case '2':   $('#listing_search_row_values').show();
                        $('#postal_code').attr('required','required');
                        $('#listing_id_row').hide();
                        $('#city_row').hide();
                        $('#postal_code_row').show();
                        $('#address_row').hide();
                        $('.psid').val(psID);
                        break;

            case '3':   $('#listing_search_row_values').show();
                        $('#address').attr('required','required');
                        $('#listing_id_row').hide();
                        $('#city_row').hide();
                        $('#postal_code_row').hide();
                        $('#address_row').show();
                        $('.psid').val(psID);
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
        $('#selectActionThree').prop('checked',false);
    });

    $('#backSearchRowFromZillow').click(function () {
        $('#search_row').show();
        $('#listing_search_row').hide();
        $('#zillow_search').hide();
        $('#listing_search_row_values').hide();
        $('#selectActionOne').prop('checked',false);
        $('#selectActionTwo').prop('checked',false);
        $('#selectActionThree').prop('checked',false);
    });

    $('#backSearchRowFromRealtor').click(function () {
        $('#search_row').show();
        $('#listing_search_row').hide();
        $('#zillow_search').hide();
        $('#realtor_search_row').hide();
        $('#listing_search_row_values').hide();
        $('#selectActionOne').prop('checked',false);
        $('#selectActionTwo').prop('checked',false);
        $('#selectActionThree').prop('checked',false);
    });


    $('#backFromFirstName').click(function () {
        $('#realtor_search_row').show();
        $('#realtor_search_row_values').hide();
        $('#realtorselectActionOne').prop('checked',false);
        $('#realtorselectActionTwo').prop('checked',false);
        $('#realtorselectActionThree').prop('checked',false);
        $('#realtorselectActionFour').prop('checked',false);
        $('#first_name').removeAttr('required')
    });

    $('#backFromLastName').click(function () {
        $('#realtor_search_row').show();
        $('#realtor_search_row_values').hide();
        $('#realtorselectActionOne').prop('checked',false);
        $('#realtorselectActionTwo').prop('checked',false);
        $('#realtorselectActionThree').prop('checked',false);
        $('#realtorselectActionFour').prop('checked',false);
        $('#last_name').removeAttr('required')
    });

    $('#backFromOfficeName').click(function () {
        $('#realtor_search_row').show();
        $('#realtor_search_row_values').hide();
        $('#realtorselectActionOne').prop('checked',false);
        $('#realtorselectActionTwo').prop('checked',false);
        $('#realtorselectActionThree').prop('checked',false);
        $('#realtorselectActionFour').prop('checked',false);
        $('#office_name').removeAttr('required')
    });
</script>
</body>
</html>