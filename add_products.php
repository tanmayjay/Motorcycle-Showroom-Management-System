<!DOCTYPE html>
<html lang="en">
<head>
	<title>Add Products</title>
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
include_once('url.php');
include_once('validation.php');
?>
	


	<div class="limiter">
		<div class="container-login100" style="background-image: url('images/stallion.jpg');">
			
			<div class="wrap-login100 p-t-30 p-b-50">
				<span class="login100-form-title p-b-41">
				<img src="images/icon-violet.png" alt="Logo" width=80px><br>
					Add Product
				</span>
				
				<?php
					if ($_SERVER["REQUEST_METHOD"] == "POST") {

						$sql = "INSERT INTO product (product_name, product_type, brand, mileage, storage, status, price, image_file, date_arrived)
						values (?,?,?,?,?,?,?,?,?)";
					
						$stmt = $db->prepare($sql);
						$stmt->bind_param("sssiissss",$name,$type,$brand,$mile,$stock,$status,$price,$_POST['image'],$_POST['date']);
					
						if($name!="" && $type!="" && $brand!="" && $status!="" && $price!="" && $_SESSION['logged'] && $_SESSION['user_type']!='Visitor'){
							$stmt->execute();
							echo '<div style="text-align:center;">';
							raMessage();
							echo '</div>';
						} else {
							echo '<div style="text-align:center;">';
							failMessage();
							echo '</div>';
						}
						mysqli_close($db);
					}
				?>
				
				<form class="login100-form p-b-33 p-t-5" method="post" action="add_products.php">
					<div style="text-align:right; padding-right:15px">
						<span class="error">* Required Field</span>
					</div>

                    <div class="wrap-input100">
						<input class="input100" type="text" name="pname" placeholder="Product Name">
						<span class="focus-input100" data-placeholder="&#xe60b;"></span>
						<div style="text-align:right; padding-right:15px">
							<span class="error">* <?php echo $pnameErr;?></span>
						</div>
					</div>

					<div class="wrap-input100">
						<input class="input100" type="text" name="type" placeholder="Product Type">
						<span class="focus-input100" data-placeholder="&#xe60b;"></span>
						<div style="text-align:right; padding-right:15px">
							<span class="error">* <?php echo $typeErr;?></span>
						</div>	
                    </div>
                    
                    <div class="wrap-input100">
						<input class="input100" type="text" name="brand" placeholder="Brand Name">
						<span class="focus-input100" data-placeholder="&#xe60b;"></span>
						<div style="text-align:right; padding-right:15px">
							<span class="error">* <?php echo $brandErr;?></span>
						</div>
                    </div>

					<div class="wrap-input100">
						<input class="input100" type="number" name="mileage" placeholder="Speed">
						<span class="focus-input100" data-placeholder="&#xe60b;"></span>
						<div style="text-align:right; padding-right:15px">
							<span class="error">* <?php echo $mileErr;?></span>
						</div>
                    </div>

					<div class="wrap-input100">
                        <select class="input100" name="status">
                            <option hidden>Status</option>
                            <option value="In Stock">In Stock</option>
                            <option value="Upcoming">Upcoming</option>
							<option value="Stock Out">Stock Out</option>					
                        </select>
						<span class="focus-input100" data-placeholder="&#xe60b;"></span>
						<div style="text-align:right; padding-right:15px">
							<span class="error">* <?php echo $statusErr;?></span>
						</div>	
                    </div>

					<div class="wrap-input100">
						<input class="input100" type="number" name="stock" placeholder="Number of Stock">
						<span class="focus-input100" data-placeholder="&#xe60b;"></span>
						<div style="text-align:right; padding-right:15px">
							<span class="error">* <?php echo $stockErr;?></span>
						</div>
                    </div>
                    
                    <div class="wrap-input100">
						<input class="input100" type="number" name="price" placeholder="Product Price">
						<span class="focus-input100" data-placeholder="&#xe60b;"></span>
						<div style="text-align:right; padding-right:15px">
							<span class="error"><?php echo $priceErr;?></span>
						</div>
                    </div>
                    
                    <div class="wrap-input100">
					<p class="input100">Arrival Date</p>
						<input class="input100" type="date" name="date" placeholder="Arrival Date">
						<span class="focus-input100" data-placeholder="&#xe60b;"></span>
					</div>
                    
                    <div class="wrap-input100">
						<input class="input100" type="text" name="image" placeholder="Image Location">
						<span class="focus-input100" data-placeholder="&#xe60b;"></span>
                    </div>

                    <div class="container-login100-form-btn m-t-32">
						<input class="login100-form-btn active" type="submit" value="ADD">
						<a class="login100-form-btn" href="products.php">
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
		echo '<strong>Product added successfully</strong>';
		echo '</div>';
	}
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