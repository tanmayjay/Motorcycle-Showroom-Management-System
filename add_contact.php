<!DOCTYPE html>
<html lang="en">
<head>
	<title>Add Contact</title>
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
					Add Outlet
				</span>
				
				<?php
					if ($_SERVER["REQUEST_METHOD"] == "POST") {

						$db = mysqli_connect(dbhost,dbuser,dbpass,database);
								
						$sql = "INSERT INTO showroom
						(sr_name, address, email, contact_no)
						values (?,?,?,?)";
					
						$stmt = $db->prepare($sql);
                        $stmt->bind_param("ssss", $srname, $addr, $email, $phone);
					
						if($srname!="" && $addr!="" && $email!="" && $phone!="" && $_SESSION['user_type']=='Admin'){
							$stmt->execute();
							header('location:contact.php?raMessage');
						} else {
							echo '<div style="text-align:center;">';
							failMessage();
							echo '</div>';
						}
						mysqli_close($db);
					}
				?>
				
				<form class="login100-form p-b-33 p-t-5" method="post" action="add_contact.php">
					<div style="text-align:right; padding-right:15px">
						<span class="error">* Required Field</span>
					</div>
                    
                    
                    <div class="wrap-input100">
						<input class="input100" type="text" name="sr_name" placeholder="Outlet Name">
						<span class="focus-input100" data-placeholder="&#xe60b;"></span>
						<div style="text-align:right; padding-right:15px">
							<span class="error">* <?php echo $srnameErr;?></span>
						</div>
                    </div>

                    <div class="wrap-input100">
						<input class="input100" type="email" name="email" placeholder="Email">
						<span class="focus-input100" data-placeholder="&#xe60b;"></span>
						<div style="text-align:right; padding-right:15px">
							<span class="error">* <?php echo $emailErr;?></span>
						</div>
					</div>
                    
                    <div class="wrap-input100">
						<input class="input100" type="text" name="phone_no" placeholder="Contact No">
						<span class="focus-input100" data-placeholder="&#xe60b;"></span>
						<div style="text-align:right; padding-right:15px">
							<span class="error">* <?php echo $phoneErr;?></span>
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
						<a class="login100-form-btn" href="contact.php?filter">
							Back
						</a>
                    </div>

				</form>
			</div>
		</div>
	</div>	

	<div id="dropDownSelect1"></div>

	<?php
	function failMessage(){
		echo '<div class="alert alert-danger">';
		echo '<strong>Operation Failed!!</strong>';
		echo '</div>';
	}

	?>
	
	<script src="js/jquery.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/form.js"></script>

</body>
</html>