<!DOCTYPE html>
<html lang="en">
<head>
	<title>Create Profile</title>
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
include_once('validation.php');
session_start();
?>
	


	<div class="limiter">
		<div class="container-login100" style="background-image: url('images/stallion.jpg');">
			
			<div class="wrap-login100 p-t-30 p-b-50">
				<span class="login100-form-title p-b-41">
				<img src="images/icon-violet.png" alt="Logo" width=80px><br>
					Create Profile
				</span>
				
				<?php
					if ($_SERVER["REQUEST_METHOD"] == "POST") {

						$db = mysqli_connect(dbhost,dbuser,dbpass,database);

						$uid = "";
                            
								if($_SESSION['logged']){
									$b = $_SESSION['username'];
								} else {
									$b = "";
								}
								
								$sql_t = "SELECT user_id FROM users where user_name = '$b'";
								$re = mysqli_query($db, $sql_t);
								$row = mysqli_fetch_array($re);
								$uid = $row['user_id'];

								
						$sql = "UPDATE user_info 
						SET
						fname = '$fname',
						lname = '$lname',
						address = '$addr',
						dob = '$dob',
						gender = '$sex', 
						phone_no = '$phone'
						WHERE
						user_id = $uid";

						$url = $_SESSION['url'];
						
						if($fname!="" && $lname!="" && $addr!="" && $dob!="" && $sex!="" && $phone!=""){	
							if(mysqli_query($db,$sql)){
								header('location:'.$url.'?raMessage');
							} else {
								echo mysqli_error($db);
							}
						} else {
							echo '<div style="text-align:center;">';
							failMessage();
							echo '</div>';
						}
						mysqli_close($db);
					}
				?>
				
				<form class="login100-form p-b-33 p-t-5" method="post" action="create_profile.php">
					<div style="text-align:right; padding-right:15px">
						<span class="error">* Required Field</span>
					</div>
                    
                    
                    <div class="wrap-input100">
						<input class="input100" type="text" name="fname" placeholder="First Name">
						<span class="focus-input100" data-placeholder="&#xe60b;"></span>
						<div style="text-align:right; padding-right:15px">
							<span class="error">* <?php echo $fnameErr;?></span>
						</div>
                    </div>
                    
                    <div class="wrap-input100">
						<input class="input100" type="text" name="lname" placeholder="Last Name">
						<span class="focus-input100" data-placeholder="&#xe60b;"></span>
						<div style="text-align:right; padding-right:15px">
							<span class="error">* <?php echo $lnameErr;?></span>
						</div>
					</div>

					<div class="wrap-input100">
					
					<select class="input100" name="gender">
						<option hidden>Gender</option>
						<option value="Male">Male</option>
						<option value="Female">Female</option>
						<option value="Other">Other</option>
						<option value="Secret">Secret</option>
					
					</select>

						<span class="focus-input100" data-placeholder="&#xe60b;"></span>
						<div style="text-align:right; padding-right:15px">
							<span class="error">* <?php echo $sexErr;?></span>
						</div>	
                    </div>
                    
                    <div class="wrap-input100">
						<input class="input100" type="text" name="phone_no" placeholder="Phone No">
						<span class="focus-input100" data-placeholder="&#xe60b;"></span>
						<div style="text-align:right; padding-right:15px">
							<span class="error">* <?php echo $phoneErr;?></span>
						</div>
                    </div>
                    
                    <div class="wrap-input100">
					<p class="input100" placeholder="Date of Birth">Date of Birth</p>
						<input class="input100" type="date" name="dob" placeholder="Date of Birth">
						<span class="focus-input100" data-placeholder="&#xe60b;"></span>
						<div style="text-align:right; padding-right:15px">
							<span class="error">* <?php echo $dobErr;?></span>
						</div>
                    </div>
                    
                    <div class="wrap-input100">
						<textarea class="input100" name="address" placeholder="Address"></textarea>
						<span class="focus-input100" data-placeholder="&#xe60b;"></span>
						<div style="text-align:right; padding-right:15px">
							<span class="error">* <?php echo $addrErr;?></span>
						</div>
                    </div>

                    <div class="container-login100-form-btn m-t-32">
						<input class="login100-form-btn active" type="submit" value="ADD">
						<a class="login100-form-btn" href="<?php echo $_SESSION['url']?>">
							Back
						</a>
                    </div>

				</form>
			</div>
		</div>
	</div>	

	<div id="dropDownSelect1"></div>

	<?php

	function raMessage(){
		echo '<div class="alert alert-success">';
		echo '<strong>Profile Created Successfully</strong>';
		echo '</div>';
	}
	function failMessage(){
		echo '<div class="alert alert-danger">';
		echo '<strong>Profile Creation Failed!!</strong>';
		echo '</div>';
	}

	?>
	
	<script src="js/jquery.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/form.js"></script>

</body>
</html>