<?php
 define('dbhost', 'localhost');
   define('dbuser', 'root');
   define('dbpass', '');
   define('database', 'SHOWROOM');
   $db = mysqli_connect(dbhost,dbuser,dbpass,database);
   if(!$db){
      die("ERROR: Could not connect. " . mysqli_connect_error());
  }

$sql = file_get_contents('showroom.sql');

if(mysqli_query($db,$sql)){
    echo "Execution Successful";
} else{
    echo "ERROR: Could not able to execute" . mysqli_error($db);
}
 
mysqli_close($db);
?>