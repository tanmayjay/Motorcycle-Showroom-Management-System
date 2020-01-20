<?php
   session_start();
   
   if(session_destroy()) {
      if(isset($_SESSION['url'])){
         $url = $_SESSION['url']; 
      } else {
         $url = "index.php?user=$myusername";
      }
      header("location: $url"); 
   }
?>