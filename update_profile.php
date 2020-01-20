<!DOCTYPE html>
<html lang="en">
<head>
	<title>Update Info</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" type="image/png" href="images/icon-red.png"/>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/hamburgers.min.css">
	<link rel="stylesheet" type="text/css" href="css/fonts.css">
	<link rel="stylesheet" type="text/css" href="css/icon-font.min.css">
	<link rel="stylesheet" type="text/css" href="css/form.css">
	<link rel="stylesheet" type="text/css" href="css/short.css">
	<style> .error {color: #FF0000;} </style>

</head>
<body>

<?php
session_start();
include('config.php');
?>
	


	<div class="limiter">
		<div class="container-login100" style="background-image: url('images/stallion.jpg');">
			
			<div class="wrap-login100 p-t-30 p-b-50">
				<span class="login100-form-title p-b-41">
				<img src="images/icon-violet.png" alt="Logo" width=80px><br>
					Update Profile
                </span>
					
						
				
				<?php
                    
                    if (isset($_GET['changeName'])){
                        changeName();
                    }
                    if (isset($_GET['changeAddr'])){
                        changeAddr();
                    }
                    if (isset($_GET['changeEmail'])){
                        changeEmail();
                    }
                    if (isset($_GET['changePhone'])){
                        changePhone();
                    }
                    if (isset($_GET['uploadImage'])){
                        uploadImage();
                    }

				?>                  

                    
			</div>
		</div>
	</div>	

	<div id="dropDownSelect1"></div>

	<?php

    function uploadImage(){
        if ($_SERVER["REQUEST_METHOD"] == "POST"){
            $db = mysqli_connect(dbhost,dbuser,dbpass,database);
    
    $file = $_FILES['image']['tmp_name'];
    
    if (!isset($file))
      echo "Please select a photo";
    else
    {
      $image = addslashes(file_get_contents($_FILES['image']['tmp_name']));
      $image_name = addslashes($FILES['image']['name']);
      $image_size = getimagesize($_FILES['image']['tmp_name']);
    
      if ($image_size==FALSE)
        echo "That is not an image.";
      else
      {
        $utype = $_SESSION['user_type'];
        $uname = $_SESSION['username'];
        $r = mysqli_query($db,"SELECT user_id from users where user_name = '$uname'");
        $u = mysqli_fetch_assoc($r);
        $uid = $u['user_id'];
        if ($utype == 'Visitor'){
            $r = mysqli_query($db,"SELECT image from customer where user_id = $uid");
            if(mysqli_num_rows($r)>0){
                $sql = "UPDATE customer SET image = '$image' where user_id = $uid";
            } else {
                $sql = "INSERT INTO customer (image) VALUES ('$image') where user_id = $uid";
            }
        } else {
            $r = mysqli_query($db,"SELECT image from user_info where user_id = $uid");
            if(mysqli_num_rows($r)>0){
                $sql = "UPDATE user_info SET image = '$image' where user_id = $uid";
            } else {
                $sql = "INSERT INTO user_info (image) VALUES ('$image') where user_id = $uid";
            }
        }
    
        if(mysqli_query($db,$sql)){
            $url = $_SESSION['url'];
            header('location:$url?imupMessage');
        } else {
            echo '<div style="text-align:center;">';
                    failMessage();
                    echo '</div>';
            }
        }
        }
    }
        echo '<form class="login100-form p-b-33 p-t-5" method="post" action="update_profile.php?uploadImage" enctype="multipart/form-data">';
        echo '<div class="wrap-input100">
                        <p class="input100" placeholder="Image">Image</p>
						<input class="input100" type="file" name="image" placeholder="Image">
						<span class="focus-input100" data-placeholder="&#xe60b;"></span>
                    </div>';

        echo '<div class="container-login100-form-btn m-t-32">
                    <input class="login100-form-btn active" type="submit" value="Upload">
                    <a class="login100-form-btn" href="'.$_SESSION['url'].'">
                        Back
                    </a>
                </div>';

        echo '</form>';
    }


    function changeName(){
        
        include('validation.php');
                        
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            
            $db = mysqli_connect(dbhost,dbuser,dbpass,database);

            $username = $_SESSION['username'];
            $type = $_SESSION['user_type'];
            $db = mysqli_connect(dbhost,dbuser,dbpass,database);

        $sql_t = "SELECT user_id FROM users WHERE user_name = '$username'";
        $result_t = mysqli_query($db,$sql_t);
        $row_t = mysqli_fetch_array($result_t,MYSQLI_ASSOC);
        $uid = $row_t['user_id'];

if($type == 'Visitor'){
    $sql1 = "UPDATE customer SET fname = '$fname' WHERE user_id = $uid";
    $sql2 = "UPDATE customer SET lname = '$lname' WHERE user_id = $uid";
} else {
    $sql1 = "UPDATE user_info SET fname = '$fname' WHERE user_id = $uid";
    $sql2 = "UPDATE user_info SET lname = '$lname' WHERE user_id = $uid";
}
                        
            if($fname!="" && $lname!=""){
                if(mysqli_query($db, $sql1) && mysqli_query($db, $sql2)){
                     
                    header('location:profile.php?upMessage');
                } else {               
                    echo '<div style="text-align:center;">';
                    echo mysqli_error($db);
                    failMessage();
                    echo '</div>';
                }
            } else {
                                
                echo '<div style="text-align:center;">';
                failMessage();
                echo '</div>';
            }
            mysqli_close($db);
        }
        
        echo '<form class="login100-form p-b-33 p-t-5" method="post" action="update_profile.php?changeName">';

        echo '<div style="text-align:right; padding-right:15px">
						<span class="error">* Required Field</span>
                    </div>';

        echo '<div class="wrap-input100">
        <input class="input100" type="text" name="fname" placeholder="First Name">
        <span class="focus-input100" data-placeholder="&#xe60b;"></span>
        <div style="text-align:right; padding-right:15px">
            <span class="error">* '.$fnameErr.'</span>
        </div>
    </div>
    
    <div class="wrap-input100">
        <input class="input100" type="text" name="lname" placeholder="Last Name">
        <span class="focus-input100" data-placeholder="&#xe60b;"></span>
        <div style="text-align:right; padding-right:15px">
            <span class="error">* '.$lnameErr.'</span>
        </div>
    </div>';
        

         echo '<div class="container-login100-form-btn m-t-32">
                    <input class="login100-form-btn active" type="submit" value="Update">
                    <a class="login100-form-btn" href="'.$_SESSION['url'].'">
                        Back
                    </a>
                </div>';

        echo '</form>'; 
    }

    function changeAddr(){
        
        include_once('validation.php');
                        

            if ($_SERVER["REQUEST_METHOD"] == "POST") {
            
                $db = mysqli_connect(dbhost,dbuser,dbpass,database);
    
                $username = $_SESSION['username'];
                $type = $_SESSION['user_type'];
                $db = mysqli_connect(dbhost,dbuser,dbpass,database);
    
            $sql_t = "SELECT user_id FROM users WHERE user_name = '$username'";
            $result_t = mysqli_query($db,$sql_t);
            $row_t = mysqli_fetch_array($result_t,MYSQLI_ASSOC);
            $uid = $row_t['user_id'];

              if($type == 'Visitor'){
                $sql = "UPDATE customer SET address = '$addr' WHERE user_id = $uid";
            } else {
                $sql = "UPDATE user_info SET address = '$addr' WHERE user_id = $uid";
            }
                        
            if($addr!=""){
                if(mysqli_query($db, $sql)){
                    header('location:profile.php?upMessage');
                } else {
                                    
                    echo '<div style="text-align:center;">';
                    failMessage();
                    echo '</div>';
                }
            } else {
                                
                echo '<div style="text-align:center;">';
                failMessage();
                echo '</div>';
            }
            mysqli_close($db);
        }
        
        echo '<form class="login100-form p-b-33 p-t-5" method="post" action="update_profile.php?changeAddr">';

        echo '<div style="text-align:right; padding-right:15px">
						<span class="error">* Required Field</span>
                    </div>';

        echo '<div class="wrap-input100">
                    <textarea class="input100" type="text" name="address" placeholder="Enter New Address"></textarea>
                    <span class="focus-input100" data-placeholder="&#xe60b;"></span>
                    <div style="text-align:right; padding-right:15px">
                        <span class="error">* '.$addrErr.'</span>
                    </div>
                </div>';
        

         echo '<div class="container-login100-form-btn m-t-32">
                    <input class="login100-form-btn active" type="submit" value="Update">
                    <a class="login100-form-btn" href="'.$_SESSION['url'].'">
                        Back
                    </a>
                </div>';

        echo '</form>'; 
    }

    function changeEmail(){
        
        include_once('validation.php');


            if ($_SERVER["REQUEST_METHOD"] == "POST") {
            
                $db = mysqli_connect(dbhost,dbuser,dbpass,database);
    
                $username = $_SESSION['username'];
                $type = $_SESSION['user_type'];
                $db = mysqli_connect(dbhost,dbuser,dbpass,database);
    
            $sql_t = "SELECT user_id, email FROM users WHERE user_name = '$username'";
            $result_t = mysqli_query($db,$sql_t);
            $row_t = mysqli_fetch_array($result_t,MYSQLI_ASSOC);
            $uid = $row_t['user_id'];

                $sql = "UPDATE users SET email = '$email' WHERE user_id = $uid";
                        
            if($email!=""){
                if(mysqli_query($db, $sql)){
                    header('location:profile.php?upMessage');
                } else {                
                    echo '<div style="text-align:center;">';
                    failMessage();
                    echo '</div>';
                }
            } else {
                                
                echo '<div style="text-align:center;">';
                failMessage();
                echo '</div>';
            }
            mysqli_close($db);
        }
        
        echo '<form class="login100-form p-b-33 p-t-5" method="post" action="update_profile.php?changeEmail">';

        echo '<div style="text-align:right; padding-right:15px">
						<span class="error">* Required Field</span>
                    </div>';


        echo '<div class="wrap-input100">
                    <input class="input100" type="email" name="email" placeholder="Enter New Email" value="'.$row_t['email'].'">
                    <span class="focus-input100" data-placeholder="&#xe60b;"></span>
                    <div style="text-align:right; padding-right:15px">
                        <span class="error">* '.$emailErr.'</span>
                    </div>
                </div>';
        

         echo '<div class="container-login100-form-btn m-t-32">
                    <input class="login100-form-btn active" type="submit" value="Update">
                    <a class="login100-form-btn" href="'.$_SESSION['url'].'">
                        Back
                    </a>
                </div>';

        echo '</form>'; 
    }

    function changePhone(){
        
        include_once('validation.php');
                        

            if ($_SERVER["REQUEST_METHOD"] == "POST") {
            
                $db = mysqli_connect(dbhost,dbuser,dbpass,database);
    
                $username = $_SESSION['username'];
                $type = $_SESSION['user_type'];
                $db = mysqli_connect(dbhost,dbuser,dbpass,database);
    
            $sql_t = "SELECT user_id FROM users WHERE user_name = '$username'";
            $result_t = mysqli_query($db,$sql_t);
            $row_t = mysqli_fetch_array($result_t,MYSQLI_ASSOC);
            $uid = $row_t['user_id'];

            if($type == 'Visitor'){
              $sql = "UPDATE customer SET phone_no = '$phone' WHERE user_id = $uid";
            } else {
                $sql = "UPDATE user_info SET phone_no = '$phone' WHERE user_id = $uid";
            }
                        
            if($phone!=""){
                if(mysqli_query($db, $sql)){
                    header('location:profile.php?upMessage');
                } else {
                                    
                    echo '<div style="text-align:center;">';
                    failMessage();
                    echo '</div>';
                }
            } else {
                                
                echo '<div style="text-align:center;">';
                failMessage();
                echo '</div>';
            }
            mysqli_close($db);
        }
        
        echo '<form class="login100-form p-b-33 p-t-5" method="post" action="update_profile.php?changePhone">';

        echo '<div style="text-align:right; padding-right:15px">
						<span class="error">* Required Field</span>
                    </div>';

        echo '<div class="wrap-input100">
                    <input class="input100" type="text" name="phone_no" placeholder="Enter New Contact No">
                    <span class="focus-input100" data-placeholder="&#xe60b;"></span>
                    <div style="text-align:right; padding-right:15px">
                        <span class="error">* '.$phoneErr.'</span>
                    </div>
                </div>';
        

         echo '<div class="container-login100-form-btn m-t-32">
                    <input class="login100-form-btn active" type="submit" value="Update">
                    <a class="login100-form-btn" href="'.$_SESSION['url'].'">
                        Back
                    </a>
                </div>';

        echo '</form>'; 
    }


	function failMessage(){
		echo '<div class="alert alert-danger">';
		echo '<strong>Operation failed!!</strong>';
		echo '</div>';
    }

	?>
	
	<script src="js/jquery.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/form.js"></script>

</body>
</html>