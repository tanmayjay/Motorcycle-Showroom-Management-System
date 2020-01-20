<!DOCTYPE html>
<html lang="en">
<head>
	<title>Update Password</title>
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
include_once('validation.php');
session_start();
?>
	


	<div class="limiter">
		<div class="container-login100" style="background-image: url('images/stallion.jpg');">
			
			<div class="wrap-login100 p-t-30 p-b-50">
				<span class="login100-form-title p-b-41">
				<img src="images/icon-violet.png" alt="Logo" width=80px><br>
					Update Password
				</span>
				
				<?php
                    
                    if (isset($_GET['currentPass'])){
                        currentPass();
                    }

                    if (isset($_GET['changePass'])){
                        changePass();
                    }
				?>                  

                    
			</div>
		</div>
	</div>	

	<div id="dropDownSelect1"></div>

	<?php

    function currentPass(){
       
        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            $db = mysqli_connect(dbhost,dbuser,dbpass,database);

            $username = $_SESSION['username'];
            $password = mysqli_real_escape_string($db,$_POST['pass']);
            
            $sql = "SELECT user_name FROM users WHERE user_name = '$username' and password = '$password'";
            $result = mysqli_query($db,$sql);
            $row = mysqli_fetch_array($result,MYSQLI_ASSOC);

            $count = mysqli_num_rows($result);

            if($count == 1) {
                header('location:update_pass.php?changePass');
            } else {
                
                echo '<div style="text-align:center;">';
                failMessage();
                echo '</div>';
            }
        }

        echo '<form class="login100-form p-b-33 p-t-5" method="post" action="update_pass.php?currentPass">';

		echo '<div style="text-align:right; padding-right:15px">
						<span class="error">* Required Field</span>
                    </div>';

        echo '<div class="wrap-input100">
                    <input class="input100" type="password" name="pass" placeholder="Enter Current Password">
                    <span class="focus-input100" data-placeholder="&#xe60b;"></span>
                    <div style="text-align:right; padding-right:15px">
                        <span class="error">*</span>
                    </div>
                </div>';

        echo '<div class="container-login100-form-btn m-t-32">
                <input class="login100-form-btn active" type="submit" value="NEXT">
                <a class="login100-form-btn" href="'.$_SESSION['url'].'">
                    Back
                </a>
            </div>';

        echo '</form>';   

    }

    function changePass(){
        
        $tpassword = $password = "";
        $passErr = $passErr2 = "";
                        
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (empty($_POST["password"])) {
                $passErr = "Password is required";
            } else {
                if(preg_match("/^.*(?=.{8,})(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z]).*$/", $_POST["password"]) === 0){
                    $passErr = "Must contain at least one number and one uppercase and lowercase letter";
                } else {
                    $tpassword = test_input($_POST["password"]);
                }    
            }
                            
            if(empty($_POST["cpassword"])){
                $passErr2 = "Password is required";
            } else if($_POST["password"]!=$_POST["cpassword"]){
                $passErr2 = "Password not matched";
            } else {
                $password = test_input($_POST["cpassword"]);
            }

            $db = mysqli_connect(dbhost,dbuser,dbpass,database);
            $username = $_SESSION['username'];

            $sql = "UPDATE users SET password = '$password' WHERE users.user_name = '$username'";
                        
            if($password!=""){
                if(mysqli_query($db, $sql)){
                    header('location:profile.php?sucMessage');
                } else {
                                    
                    echo '<div style="text-align:center;">';
                    unsucMessage();
                    echo '</div>';
                }
            } else {
                                
                echo '<div style="text-align:center;">';
                unsucMessage();
                echo '</div>';
            }
            mysqli_close($db);
        }
        
        echo '<form class="login100-form p-b-33 p-t-5" method="post" action="update_pass.php?changePass">';

        echo '<div style="text-align:right; padding-right:15px">
						<span class="error">* Required Field</span>
                    </div>';

        echo '<div class="wrap-input100">
                    <input class="input100" type="password" name="password" placeholder="Enter New Password">
                    <span class="focus-input100" data-placeholder="&#xe60b;"></span>
                    <div style="text-align:right; padding-right:15px">
                        <span class="error">* '.$passErr.'</span>
                    </div>
                </div>';
        
        echo '<div class="wrap-input100">
						<input class="input100" type="password" name="cpassword" placeholder="Confirm New Password">
						<span class="focus-input100" data-placeholder="&#xe60b;"></span>
						<div style="text-align:right; padding-right:15px">
							<span class="error">* '.$passErr2.'</span>
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
		echo '<strong>Incorrect Password</strong>';
		echo '</div>';
    }
    
    function unsucMessage(){
		echo '<div class="alert alert-danger">';
		echo '<strong>Attemt Unsuccessful!!</strong>';
		echo '</div>';
	}

	?>
	
	<script src="js/jquery.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/form.js"></script>

</body>
</html>