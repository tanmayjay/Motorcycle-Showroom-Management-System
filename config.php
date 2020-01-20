<?php
   define('dbhost', 'localhost');
   define('dbuser', 'root');
   define('dbpass', '');
   define('database', 'SHOWROOM');
   $db = mysqli_connect(dbhost,dbuser,dbpass,database);
   if(!$db){
      die("ERROR: Could not connect. " . mysqli_connect_error());
  }
?>