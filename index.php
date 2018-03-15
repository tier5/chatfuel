<!DOCTYPE HTML>  
<html>
<head>
</head>
<body>  
<script>
      // Code copied from Facebook to load and initialise Messenger extensions
      (function(d, s, id){
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) {return;}
        js = d.createElement(s); js.id = id;
        js.src = "//connect.facebook.com/en_US/messenger.Extensions.js";
        fjs.parentNode.insertBefore(js, fjs);
      }(document, 'script', 'Messenger'));
 </script>





<form id="enter_name_form">
First name:<input type="text" name="fname">
<br><br>
Last name: <input type="text" name="lname">
<br><br>
<input type="submit" name="submit" value="Submit">  
</form>

<script src="https://code.jquery.com/jquery-2.2.1.min.js"
            integrity="sha256-gvQgAFzTH6trSrAWoH1iPo9Xc96QxSZ3feW6kem+O00="
            crossorigin="anonymous"></script>
    <script>
    	$(function(){
    		$('#enter_name_form').submit(function(e){
    			e.preventDefault();
    			var formData = $('#enter_name_form').serialize();
    			// console.log(formData);
    			$.post('/Tuhina_webview/curl_webview.php', formData, function(data){
    				console.log(data);
    				MessengerExtensions.requestCloseBrowser(function () {
		              console.log('Window will be closed');
		            }, function (error) {
		              console.log('There is an error');
		              console.log(error);
		            });
    			});
    		});
    	});


</body>
</html>
