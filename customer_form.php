<!DOCTYPE html>
<html lang="en">
<head>
	<title>Registration</title>
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
include("config.php");

?>
	


	<div class="limiter">
		<div class="container-login100" style="background-image: url('images/stallion.jpg');">
			
			<div class="wrap-login100 p-t-30 p-b-50">
				<span class="login100-form-title p-b-41">
				<img src="images/icon-violet.png" alt="Logo" width=80px><br>
					Register
				</span>
				<?php
                if(isset($_GET['raMessage'])){
                    raMessage();
                }
                if(isset($_GET['register'])){
                    register();
                }
				function register(){
                    include_once('validation.php');
                    session_start();
					if ($_SERVER["REQUEST_METHOD"] == "POST") {

						$db = mysqli_connect(dbhost,dbuser,dbpass,database);
                        $img = $_POST['image'];
                        $utype = 'Visitor';

                        $sql = "INSERT INTO users 
						(user_name, email, password, user_type)
                        values (?,?,?,?)";

                        $sql2 = "INSERT INTO customer 
                        (user_id, fname, lname, gender, phone_no, address, dob)
                        values (?,?,?,?,?,?,?)";

                        $stmt = $db->prepare($sql);
                        $stmt->bind_param("ssss", $uname, $email, $password, $utype);
					
					
						if($uname!="" && $fname!="" && $lname!="" && $sex!="" && $email!="" && $password!="" && $addr!="" && $phone!=""){
                            if($stmt->execute()){
                                $sql_t = "SELECT user_id from users WHERE user_name = '$uname'";
                                $result = mysqli_query($db, $sql_t);
                                $row = mysqli_fetch_array($result);
                                $uid = $row['user_id'];
                                $stmt = $db->prepare($sql2);
                                $stmt->bind_param("issssss", $uid, $fname, $lname, $sex, $phone, $addr, $dob);
                                if($stmt->execute()){

                                    header('location:customer_form.php?raMessage');
                                }
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
				
				echo '<form class="login100-form p-b-33 p-t-5" method="post" action="customer_form.php?register">
					<div style="text-align:right; padding-right:15px">
						<span class="error">* Required Field</span>
					</div>';
                    
                echo    '<div class="wrap-input100">
						<input class="input100" type="text" name="fname" placeholder="First Name">
						<span class="focus-input100" data-placeholder="&#xe60b;"></span>
						<div style="text-align:right; padding-right:15px">
							<span class="error">* '.$fnameErr.'</span>
						</div>
                    </div>';
                    
                echo    '<div class="wrap-input100">
						<input class="input100" type="text" name="lname" placeholder="Last Name">
						<span class="focus-input100" data-placeholder="&#xe60b;"></span>
						<div style="text-align:right; padding-right:15px">
							<span class="error">* '.$lnameErr.'</span>
						</div>
					</div>';

				echo	'<div class="wrap-input100">
					<select class="input100" name="gender">
						<option hidden>Gender</option>
						<option value="Male">Male</option>
						<option value="Female">Female</option>
						<option value="Other">Other</option>
						<option value="Secret">Secret</option>
					</select>
						<span class="focus-input100" data-placeholder="&#xe60b;"></span>
						<div style="text-align:right; padding-right:15px">
							<span class="error">* '.$sexErr.'</span>
						</div>	
                    </div>';
                    
                echo    '<div class="wrap-input100">
						<input class="input100" type="text" name="phone_no" placeholder="Phone No">
						<span class="focus-input100" data-placeholder="&#xe60b;"></span>
						<div style="text-align:right; padding-right:15px">
							<span class="error">* '.$phoneErr.'</span>
						</div>
                    </div>';

                echo    '<div class="wrap-input100">
						<input class="input100" type="email" name="email" placeholder="Email">
						<span class="focus-input100" data-placeholder="&#xe60b;"></span>
						<div style="text-align:right; padding-right:15px">
							<span class="error">* '.$emailErr.'</span>
						</div>
					</div>';
                    
                echo    '<div class="wrap-input100">
                        <p class="input100" placeholder="Date of Birth">Date of Birth</p>
						<input class="input100" type="date" name="dob" placeholder="Date of Birth">
						<span class="focus-input100" data-placeholder="&#xe60b;"></span>
						<div style="text-align:right; padding-right:15px">
							<span class="error">* '.$dobErr.'</span>
						</div>
                    </div>';
                    
                echo    '<div class="wrap-input100">
						<textarea class="input100" name="address" placeholder="Address"></textarea>
						<span class="focus-input100" data-placeholder="&#xe60b;"></span>
						<div style="text-align:right; padding-right:15px">
							<span class="error">* '.$addrErr.'</span>
						</div>
                    </div>';

                    
                echo    '<div class="wrap-input100">
						<input class="input100" type="text" name="username" placeholder="Username">
						<span class="focus-input100" data-placeholder="&#xe60b;"></span>
						<div style="text-align:right; padding-right:15px">
							<span class="error">* '.$unameErr.'</span>
						</div>
                    </div>';

                echo    '<div class="wrap-input100">
						<input class="input100" type="password" name="password" placeholder="Password">
						<span class="focus-input100" data-placeholder="&#xe60b;"></span>
						<div style="text-align:right; padding-right:15px">
							<span class="error">* '.$passErr.'</span>
						</div>
                    </div>';

                echo    '<div class="wrap-input100">
						<input class="input100" type="password" name="cpassword" placeholder="Confirm Password">
						<span class="focus-input100" data-placeholder="&#xe60b;"></span>
						<div style="text-align:right; padding-right:15px">
							<span class="error">* '.$passErr2.'</span>
						</div>
                    </div>';

               /* echo    '<div class="wrap-input100">
                        <p class="input100" placeholder="Image">Image</p>
						<input class="input100" type="text" name="image" placeholder="Image">
						<span class="focus-input100" data-placeholder="&#xe60b;"></span>
                    </div>';*/

                echo    '<div class="container-login100-form-btn m-t-32">
						<input class="login100-form-btn active" type="submit" value="Register">
						<a class="login100-form-btn" href="'.$_SESSION['url'].'">
							Back
						</a>
                    </div>';

                echo '</form>';
				}
				
				function uploadImage(){
					echo '<form class="login100-form p-b-33 p-t-5" method="post" 
					action="customer_form.php?uploadImage" enctype="multipart/form_data">';

					echo    '<div class="wrap-input100">
                        <p class="input100" placeholder="Image">Image</p>
						<input class="input100" type="file" name="image" placeholder="Image">
						<span class="focus-input100" data-placeholder="&#xe60b;"></span>
                    </div>';

					echo '<form>';

					if ($_SERVER["REQUEST_METHOD"] == "POST") {

					}
				}
                ?>
			</div>
		</div>
	</div>	

	<div id="dropDownSelect1"></div>

	<?php

	function raMessage(){
        echo '<div style="text-align:center;">';
		echo '<div class="alert alert-success">';
		echo '<strong>Registration Successful</strong>';
        echo '</div>';
        echo '</div>';
        echo '<div class="container-login100-form-btn m-t-32">';
        echo                '<a class="login100-form-btn active" href="login_form.php">Login</a>';
                                       
		echo				'<a class="login100-form-btn" href="index.php">BACK HOME</a>';
							
						
        echo            '</div>';
    }
    
	function failMessage(){
		echo '<div class="alert alert-danger">';
		echo '<strong>Registration Fail</strong>';
		echo '</div>';
	}

	?>
	
	<script src="js/jquery.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/form.js"></script>

</body>
</html>