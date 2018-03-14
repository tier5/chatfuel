<!DOCTYPE html>
<html>
<head>
	<title>Webview</title>
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
	<form id="schedule_call_form">
		<table border="1">
			<tr>
				<td>First Name</td>
				<td><input type="text" name="f_name" placeholder="First Name"></td>
			</tr>
			<tr>
				<td>Last Name</td>
				<td><input type="text" name="l_name" placeholder="Last Name"></td>
			</tr>
			<tr>
				<td>Phone Number</td>
				<td><input type="text" name="phone_number" placeholder="Phone Number"></td>
			</tr>
			<tr>
				<td>Date</td>
				<td><input type="text" name="date" placeholder="Date"></td>
			</tr>
			<tr>
				<td>Time</td>
				<td><input type="text" name="time" placeholder="Time"></td>
			</tr>
			<tr>
				<td>Notes</td>
				<td><textarea name="note" placeholder="Notes" rows="5"></textarea></td>
			</tr>
		</table>
		<p><button type="submit">Schedule</button></p>
	</form>
	<script src="https://code.jquery.com/jquery-2.2.1.min.js"
            integrity="sha256-gvQgAFzTH6trSrAWoH1iPo9Xc96QxSZ3feW6kem+O00="
            crossorigin="anonymous"></script>
    <script>
    	$(function(){
    		$('#schedule_call_form').submit(function(e){
    			e.preventDefault();
    			var formData = $('#schedule_call_form').serialize();
    			// console.log(formData);
    			$.post('/chatfuel/postBackChatfuel.php', formData, function(data){
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
    </script>
</body>
</html>