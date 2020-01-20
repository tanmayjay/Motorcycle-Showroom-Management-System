<!DOCTYPE html>
<html lang="en">
<head>
	<title>Update Products</title>
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
					Update Product
				</span>
				
				<?php
                if(isset($_GET['update'])){
                    $pid = $_GET['update'];
                    update($pid);
                }
                function update($pid){
                    $db = mysqli_connect(dbhost,dbuser,dbpass,database);

                    $sql_t = "SELECT * from product WHERE product_id = $pid";

                    if($res = mysqli_query($db,$sql_t)){
                        $rw = mysqli_fetch_assoc($res);
                    } else {
                        $rw = [
                            'product_name'=>"",
                            'product_type'=>"",
                            'status'=>"",
                            'brand'=>"",
                            'price'=>"",
                            'date_arrived'=>"",
                            'mileage'=>"",
                            'status'=>"",
                            'storage'=>"",
                            'image_file'=>""
                        ];
                    }

                    $pnameErr = $typeErr = $statusErr = $brandErr = $priceErr = $stockErr = $mileErr = "";
                    $pname = $type = $status = $brand = $price = $stock = $mile = "";

					if ($_SERVER["REQUEST_METHOD"] == "POST") {


                        if (empty($_POST["pname"])) {
                            $nameErr = "Name is required";
                          } else {
                            $name = test_input($_POST["pname"]);
                          }
                        
                          if (empty($_POST["type"])) {
                            $typeErr = "Type is required";
                          } else {
                            $type = test_input($_POST["type"]);
                          }
                        
                          if (empty($_POST["brand"])) {
                            $brandErr = "Brand is required";
                          } else {
                            $brand = test_input($_POST["brand"]);
                          }
                        
                          if (empty($_POST["status"])) {
                            $statusErr = "Status is required";
                          } elseif ($_POST["status"] == "Status") {
                            $statusErr = "Status is required";
                          } else {
                            $status = test_input($_POST["status"]);
                          }
                        
                          if (empty($_POST["stock"]) && $_POST["stock"]!=0) {
                            $stockErr = "Stock is required";
                          } elseif (!is_numeric($_POST["stock"])) {
                            $stockErr = "Should be a number";
                          } else {
                            $stock = test_input($_POST["stock"]);
                          }
                        
                          if (empty($_POST["mileage"])) {
                            $mileErr = "Speed is required";
                          } elseif (!is_numeric($_POST["mileage"])) {
                            $mileErr = "Should be a number";
                          } else {
                            $mile = test_input($_POST["mileage"]);
                          }
                        
                          if (empty($_POST["price"])){
                            $price = "";
                          } else {
                            $num = $_POST["price"];
                            if($num<0){
                              $priceErr = "Price must be Non-negative";
                              $price = "";
                            } else {
                              $price = test_input($_POST["price"]);
                            }
                          }

                        $img = $_POST['image'];
                        $date = $_POST['date'];

						$sql = "UPDATE product SET 
                        product_name = '$name', 
                        product_type = '$type',
                        brand = '$brand',
                        mileage = $mile,
                        storage = $stock,
                        status = '$status',
                        price = $price,
                        image_file = '$img',
                        date_arrived = '$date'
                        WHERE product_id = $pid
                        ";
					
						if($name!="" && $type!="" && $brand!="" && $status!="" && $price!=""){
							if(mysqli_query($db,$sql)){
                           
                                header('location:edit_products.php?upMessage');
           
                            } else {
                                echo mysqli_error($db);
        
                            }	
						} else {
							echo '<div style="text-align:center;">';
							failMessage();
							echo '</div>';
						}
					}
				
				
				echo '<form class="login100-form p-b-33 p-t-5" method="post" action="update_products.php?update='.$pid.'">
					<div style="text-align:right; padding-right:15px">
						<span class="error">* Required Field</span>
					</div>';

                echo    '<div class="wrap-input100">
						<input class="input100" type="text" name="pname" placeholder="Product Name" value="'.$rw['product_name'].'">
						<span class="focus-input100" data-placeholder="&#xe60b;"></span>
						<div style="text-align:right; padding-right:15px">
							<span class="error">* '.$pnameErr.'</span>
						</div>
					</div>';

				echo	'<div class="wrap-input100">
						<input class="input100" type="text" name="type" placeholder="Product Type" value="'.$rw['product_type'].'">
						<span class="focus-input100" data-placeholder="&#xe60b;"></span>
						<div style="text-align:right; padding-right:15px">
							<span class="error">* '.$typeErr.'</span>
						</div>	
                    </div>';
                    
                echo    '<div class="wrap-input100">
						<input class="input100" type="text" name="brand" placeholder="Brand Name" value="'.$rw['brand'].'">
						<span class="focus-input100" data-placeholder="&#xe60b;"></span>
						<div style="text-align:right; padding-right:15px">
							<span class="error">* '.$brandErr.'</span>
						</div>
                    </div>';

				echo	'<div class="wrap-input100">
						<input class="input100" type="number" name="mileage" placeholder="Speed" value="'.$rw['mileage'].'">
						<span class="focus-input100" data-placeholder="&#xe60b;"></span>
						<div style="text-align:right; padding-right:15px">
							<span class="error">* '.$mileErr.'</span>
						</div>
                    </div>';

				echo	'<div class="wrap-input100">
                        <select class="input100" name="status">';
                        if($rw['status']==""){
                            echo '<option hidden>Status</option>';
                        } else {
                            echo '<option value="'.$rw['status'].'">'.$rw['status'].'</option>';
                        }
                            
                    echo        '<option value="In Stock">In Stock</option>
                            <option value="Upcoming">Upcoming</option>
							<option value="Stock Out">Stock Out</option>					
                        </select>
						<span class="focus-input100" data-placeholder="&#xe60b;"></span>
						<div style="text-align:right; padding-right:15px">
							<span class="error">* '.$statusErr.'</span>
						</div>	
                    </div>';

				echo	'<div class="wrap-input100">
						<input class="input100" type="number" name="stock" placeholder="Number of Stock" value="'.$rw['storage'].'">
						<span class="focus-input100" data-placeholder="&#xe60b;"></span>
						<div style="text-align:right; padding-right:15px">
							<span class="error">* '.$stockErr.'</span>
						</div>
                    </div>';
                    
                echo    '<div class="wrap-input100">
						<input class="input100" type="number" name="price" placeholder="Product Price" value="'.$rw['price'].'">
						<span class="focus-input100" data-placeholder="&#xe60b;"></span>
						<div style="text-align:right; padding-right:15px">
							<span class="error">'.$priceErr.'</span>
						</div>
                    </div>';
                    
                echo    '<div class="wrap-input100">
					<p class="input100">Arrival Date</p>
						<input class="input100" type="date" name="date" placeholder="Arrival Date" value="'.$rw['date_arrived'].'">
						<span class="focus-input100" data-placeholder="&#xe60b;"></span>
					</div>';
                    
                echo    '<div class="wrap-input100">
						<input class="input100" type="text" name="image" placeholder="Image Location" value="'.$rw['image_file'].'">
						<span class="focus-input100" data-placeholder="&#xe60b;"></span>
                    </div>';

                echo    '<div class="container-login100-form-btn m-t-32">
						<input class="login100-form-btn active" type="submit" value="Update">
						<a class="login100-form-btn" href="edit_products.php?filter">
							Back
						</a>
                    </div>';

				echo '</form>';
                }
                ?>
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