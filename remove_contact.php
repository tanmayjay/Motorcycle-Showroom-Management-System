<!DOCTYPE html>
<html lang="en">
<head>
	<title>Remove Contact</title>
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
					Remove Outlet
				</span>
				
				<?php
					if ($_SERVER["REQUEST_METHOD"] == "POST") {

                        $db = mysqli_connect(dbhost,dbuser,dbpass,database);

						$sql = "DELETE FROM showroom where sr_id = $srid";
                    
                        if($srid!=""){
                            if(mysqli_query($db,$sql)){
                                $foo = true;
                            } else {
                                echo "ERROR: Could not able to execute $sql. " . mysqli_error($db);
                                $foo = false;
                            }
						} else {
                            $foo = false;
                        }

                        if($foo == false){
                            echo '<div style="text-align:center;">';
							failMessage();
							echo '</div>';
                        } else {
                            echo '<div style="text-align:center;">';
							header('location:contact.php?remMessage');
							echo '</div>';
                        }

						mysqli_close($db);
					}
				?>
				
				<form class="login100-form p-b-33 p-t-5" method="post" action="remove_contact.php">
					<div style="text-align:right; padding-right:15px">
						<span class="error">* Required Field</span>
					</div>
                    
					<div class="wrap-input100">
						<select class="input100" name="sr_id">
							<option hidden>Select Outlet</option>

							<?php
								$db = mysqli_connect(dbhost,dbuser,dbpass,database);
								
								$sql = "SELECT sr_id, sr_name FROM showroom";

								if($result = mysqli_query($db, $sql)){
									if(mysqli_num_rows($result) > 0){
										while($row = mysqli_fetch_array($result)){
												$srid = $row['sr_id'] ;
												$srname = $row['sr_name'];
												echo '<option value='.$srid.'>'.$srname.'</option>';
										}
										mysqli_free_result($result);
									} else{
										echo '<div class="container">';
										echo '<div class="alert alert-warning" style="text-align:center;">';
										echo "No records found";
										echo '</div></div>';
									}
								} else{
									echo "ERROR: Could not able to execute $sql. " . mysqli_error($db);
								}
								mysqli_close($db);
							?>
					
						</select>	
						<span class="focus-input100" data-placeholder="&#xe60b;"></span>
						<div style="text-align:right; padding-right:15px">
							<span class="error">* <?php echo $srErr;?></span>
						</div>
                    </div>

                    <div class="container-login100-form-btn m-t-32">
						<input class="login100-form-btn active" type="submit" value="Remove">
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