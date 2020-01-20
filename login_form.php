<!DOCTYPE html>
<html lang="en">
<head>
	<title>Login</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" type="image/png" href="images/icon-red.png"/>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/hamburgers.min.css">
	<link rel="stylesheet" type="text/css" href="css/icon-font.min.css">
	<link rel="stylesheet" type="text/css" href="css/form.css">
	<link rel="stylesheet" type="text/css" href="css/short.css">

</head>
<body>
	
	<div class="limiter">
		<div class="container-login100" style="background-image: url('images/stallion.jpg');">
			<div class="wrap-login100 p-t-30 p-b-50">
				<span class="login100-form-title p-b-41">
				<img src="images/icon-violet.png" alt="Logo" width=80px><br>
					Account Login
				</span>
				<?php

					if(isset($_GET['raMessage'])){
						echo '<div style="text-align:center;">';
						raMessage();
						echo '</div>';
					}
					elseif(isset($_GET['failMessage'])) {
						echo '<div style="text-align:center;">';
						failMessage();
						echo '</div>';
					}

			?>
				<form class="login100-form p-b-33 p-t-5" method="post" action="login.php">
				

					<div class="wrap-input100" data-validate = "Enter username">
						<input class="input100" type="text" <?php if(isset($_COOKIE["user_name"])){echo 'value="'.$_COOKIE["user_name"].'"';}?> name="user_name" placeholder="Username">
						<span class="focus-input100" data-placeholder="&#xe82a;"></span>
					</div>

					<div class="wrap-input100" data-validate="Enter password">
						<input class="input100" type="password" <?php if(isset($_COOKIE["password"])){echo 'value="'.$_COOKIE["password"].'"';}?> name="password" placeholder="Password">
						<span class="focus-input100" data-placeholder="&#xe80f;"></span>
					</div>
				
			
					<div class="wrap-input100">
					<div class="form-group form-check">
						<label class="form-check-label float-sm-left" style="font-family: Ubuntu-Regular; font-size:20px; margin-left:2em;">
						<input class="form-check-input" type="checkbox" name="remember"> 
						Remember Me
						</label>
					</div>
					</div>

					<div class="container-login100-form-btn m-t-32">
						<input class="login100-form-btn active" type="submit" value="Login">
							
						<a class="login100-form-btn" href="index.php">
							Back Home
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
			echo '<strong>Login Success</strong>';
			echo '</div>';
		}
		function failMessage(){
			echo '<div class="alert alert-danger">';
			echo '<strong>Login Failed</strong>';
			echo '</div>';
		}
	?>
	
	<script src="js/jquery.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/form.js"></script>

</body>
</html>