<!DOCTYPE html>
<html>
<head>
	<title>select your office name</title>
<link href="//netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
</head>
<body>
<script type="text/javascript">
(function(d, s, id){
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) {return;}
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/messenger.Extensions.js";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'Messenger'));
</script>
<div class="banner-header">			
  <div class="container">
    <div class="row" class="row" style="padding: 5%;background: linear-gradient(to bottom, #417AC9 0%, #072573 100%);" >
      <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
	<a href="http://homelasvegas.com" data-slimstat="5">
          <img  src="https://glvar.tier5-development.us/dg-realty/dgrealty.jpg" alt="DG-logo logo icon" class="custom_logo img-responsive" style="height: 60px;margin-left:18%;">
	</a>
      </div>
    </div>

    <div class="panel panel-default" style="margin-top:4%;padding: 3px 1px 2px 0px;">
      <div class="panel-body">
    	<form method="post" id="office_list" >
	<input type = "hidden" value="<?php echo $_GET['user_id'];?>" name = "user_id">
	<div class="form-group">
	  <select class="form-control" name="office_name" >
	    <option value="Badge">Badger Realty</option>
	    <option value="Redefy Real Estate">Redefy Real Estate</option>
            <option value="Legend Realty ">Legend Realty </option>
            <option value="Leitch &amp; Associates Realty ">Leitch &amp; Associates Realty </option>
            <option value="Lennar Sales Corp">Lennar Sales Corp</option>
            <option value="Let's Make A Deal Realty &amp; Inv">Let's Make A Deal Realty &amp; Inv</option>
            <option value="Ideal Realty &amp; Management">Ideal Realty &amp; Management</option>
            <option value="Hyde &amp; Associates ">Hyde &amp; Associates </option>
            <option value="HUD">HUD</option>
            <option value="Inspections Las Vegas LLC">Inspections Las Vegas LLC</option>
           </select>
	</div></br></br> 
	<input type="submit" class="btn btn-info btn-block" value="Search">
	</form>
     </div>
    </div>
  </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
<script type="text/javascript">
	$(document).ready(function() {
		$('.js-example-basic-single').select2();
		console.log("<?php echo $_GET['user_id']; ?>")
	});
	$(function(){
  	  $('#office_list').submit(function(e){
 				e.preventDefault();
 				var formdata = $(this).serialize();
 				console.log(formdata);
 			$.post('callback.php', formdata, function(data){
 					console.log(data);
 				MessengerExtensions.requestCloseBrowser(function(){
 						console.log('window closed');
 					}, function(error){
 						console.log('There is an error');
 						console.log(error);
 					});
 			});
 		});
 	});
</script>

</select>
</body>
</html>
