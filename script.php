<html>
<head>
</head>
<body>

<?php

$mes_id=$_POST["messenger_user_id"];
?>

<script src="https://code.jquery.com/jquery-2.2.1.min.js"
            integrity="sha256-gvQgAFzTH6trSrAWoH1iPo9Xc96QxSZ3feW6kem+O00="
            crossorigin="anonymous"></script>
    <script>
        $(function(){
			$('$mes_id').submit(function(e){
    			e.preventDefault();
                        var chatData = $('$mes_id').serialize();

                        $.post('/Tuhina_projects/curl_webview.php', chatData, function(data){
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
