<?php 
     $host_name ='localhost';
     $user_name ='dwip_nandi';
     $password ='';
     $database ='sms';
     
     $conn=new mysqli( $host_name,$user_name,$password,$database);
     if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
      }
 ?>
