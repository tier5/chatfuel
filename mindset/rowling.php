<!DOCTYPE HTML>  
<html>
<head>
</head>
<body>  

<?php

$m_id_php = $_GET['id'];

?>


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

<iframe width="350" height="315"
src="https://www.youtube.com/embed/wHGqp8lz36c">
</iframe>
<br><br>

<button type="close" name="close" value="close" onclick="self.close()">Close</button>          
                                                                                              
<script src="https://code.jquery.com/jquery-2.2.1.min.js"                                     
        integrity="sha256-gvQgAFzTH6trSrAWoH1iPo9Xc96QxSZ3feW6kem+O00="                       
        crossorigin="anonymous"></script>                                                     
                                                                                              
<script>                                                                                      
$(function(){                                                                                 
            var m_id = "<?php echo $m_id_php?>";                                              
            $('button').click(function(e){                                                    
               // e.preventDefault();                                                         
                                                                                              
                 $.post("/Tuhina_projects/mindset/curl_webview.php", {m_id: m_id}          
                                  ,function(){                                                
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

