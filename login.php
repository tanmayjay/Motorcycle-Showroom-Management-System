
<?php

include("config.php");
session_start();

if($_SERVER["REQUEST_METHOD"] == "POST") {
   
   $myusername = mysqli_real_escape_string($db,$_POST['user_name']);
   $mypassword = mysqli_real_escape_string($db,$_POST['password']);
   
   if($_POST["remember"]){
      $cookie_user = "user_name";
      $cookie_pass = "password";
      setcookie($cookie_user, $myusername, time() + (3600 * 30), "/"); // 3600 = 1 hour
      setcookie($cookie_pass, $mypassword, time() + (3600 * 30), "/");
   }
   
   $sql = "SELECT user_name FROM users WHERE user_name = '$myusername' and password = '$mypassword'";
   $result = mysqli_query($db,$sql);
   $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
   $active = $row['active'];
   
   $count = mysqli_num_rows($result);
   
   if($count == 1) {
      
      $_SESSION['logged'] = true;
      $_SESSION['username']=$myusername;
      
      $sql = "SELECT user_type FROM users WHERE user_name = '$myusername' and password = '$mypassword'";
      $result = mysqli_query($db,$sql);
      $row = $result->fetch_assoc();
     
      $type = $row['user_type'];
      
      $_SESSION['user_type'] = $type;
      if(isset($_SESSION['url'])){
         $url = $_SESSION['url']; 
      } else {
         $url = "index.php?user=$myusername";
      }
      header("location: $url");      
   } else {
      header('location:login_form.php?failMessage');
   }
}

?>