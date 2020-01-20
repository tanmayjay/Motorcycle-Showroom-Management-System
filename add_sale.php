<!DOCTYPE html>
<html lang="en">
<head>
	<title>Add New Sale</title>
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
					Add New Sale
				</span>
				
				<?php
                if(isset($_GET['sale'])){
                    sale();
                }
                if(isset($_GET['select'])){
                    select();
                }

               
                ?>
			</div>
		</div>
	</div>	

	<div id="dropDownSelect1"></div>

	<?php

	function saleMessage(){
		echo '<div class="alert alert-success">';
		echo '<strong>You just sold a product. Congrats!</strong>';
		echo '</div>';
    }
    
	function failMessage(){
		echo '<div class="alert alert-danger">';
		echo '<strong>Operation Failed!!</strong>';
		echo '</div>';
    }

    function delMessage(){
		echo '<div class="alert alert-danger">';
		echo '<strong>Record Deleted!!</strong>';
		echo '</div>';
    }

    function delete($sid){
        $db = mysqli_connect(dbhost,dbuser,dbpass,database);
        $sql = "DELETE from sales where sale_id = $sid";
        if(mysqli_query($db,$sql)){
            delMessage();
        } else {
            failMessage();
        }
    }
    
    function select(){
        echo '<div class="container-login100-form-btn m-t-32">
            <a class="login100-form-btn active" href="customer_form.php?register">
            New Customer
            </a><br><br>
            <a class="login100-form-btn active" href="add_sale.php?sale">
            Existing Customer
            </a><br><br>
            <a class="login100-form-btn" href="sales.php?filter">
                Back
            </a>
        </div>';
    }

    function sale(){
        $db = mysqli_connect(dbhost,dbuser,dbpass,database);
        $pay = $pid = $cid = "";
            $pidErr = $cidErr = "";
        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            
            if(empty($_POST["pro_id"])) {
                $pidErr = "Product cannot be empty";
              } else {
                if($_POST["pro_id"]=="Select Available Product"){
                  $pidErr = "Product cannot be empty";
                } else {
                  $pid = $_POST["pro_id"];
                  $res = mysqli_query(
                    $db,
                    "SELECT price from product where product_id = $pid"
                  );
                  $rw = mysqli_fetch_assoc($res);
                  $pay = $rw['price'];
                }
              }
            
              if(empty($_POST["cust_id"])) {
                $cidErr = "Customer cannot be empty";
              } else {
                if($_POST["pro_id"]=="Select Customer"){
                  $cidErr = "Customer cannot be empty";
                } else {
                  $cid = $_POST["cust_id"];
                }
              }

            $sql = "INSERT INTO sales (payment, product_id, cust_id, user_id, sr_id)
            values (?,?,?,?,?)";
            
            $uname = $_SESSION['username'];
            if($res = mysqli_query(
                $db,
                "SELECT user_id, sr_id FROM users natural join user_info where user_name = '$uname'"
            )){
                $rw = mysqli_fetch_assoc($res);
            } else {
                echo mysqli_error($db);
            }
            
            $uid = $rw['user_id'];
            $srid = $rw['sr_id'];
        
            $stmt = $db->prepare($sql);
            
        
            if($pay!="" && $pid!="" && $cid!="" && $_SESSION['logged'] && $_SESSION['user_type']!='Visitor'){
                $stmt->bind_param("diiii",$pay,$pid,$cid,$uid,$srid);
                if($stmt->execute()){
                    $sql2 = "SELECT sale_count, storage from product where product_id = $pid";
                    $result2 = mysqli_query($db, $sql2);
                    $row2 = mysqli_fetch_array($result2);
                    $scnt = $row2['sale_count'];
                    $stcnt = $row2['storage'];
                    if ($scnt == NULL){
                        $scnt = 1;
                    } else {
                        $scnt = $scnt + 1;
                    }

                    if($stcnt>0){
                        $stcnt = $stcnt - 1;
                    }

                    $sql3 = "UPDATE product SET sale_count = $scnt, storage = $stcnt WHERE product_id = $pid";
                    if (mysqli_query($db,$sql3)){
                        echo '<div style="text-align:center;">';
                        saleMessage();
                        echo '</div>';
                    } else {
                        echo '<div style="text-align:center;">';
                        failMessage();
                        echo '</div>';
                        echo mysqli_error($db);
                    }
                    
                } else {
                    failMessage();
                    echo mysqli_error($db);
                    
                }
            } else {
                echo '<div style="text-align:center;">';
                failMessage();
                echo '</div>';
            }
        }
    
    echo '<form class="login100-form p-b-33 p-t-5" method="post" action="add_sale.php?sale">
        <div style="text-align:right; padding-right:15px">
            <span class="error">* Required Field</span>
        </div>';

    echo	'<div class="wrap-input100">
            <select class="input100" name="pro_id">
                <option hidden>Select Available Product</option>';
                if($result = mysqli_query(
                    $db,
                    "SELECT product_id, product_name from product where storage > 0"
                )){
                if (mysqli_num_rows($result)>0){
                    while($row = mysqli_fetch_assoc($result)){
                        echo '<option value="'.$row['product_id'].'">'.$row['product_name'].'</option>';
                    }
                }
            } else {
                echo mysqli_error($db);
            }

        echo    '</select>';
        echo	'<span class="focus-input100" data-placeholder="&#xe60b;"></span>
            <div style="text-align:right; padding-right:15px">
                <span class="error">*'.$pidErr.'</span>
            </div>	
        </div>';

        echo	'<div class="wrap-input100">
            <select class="input100" name="cust_id">
                <option hidden>Select Customer</option>';
                $result2 = mysqli_query(
                    $db,
                    "SELECT cust_id, fname, lname from customer"
                );
                if (mysqli_num_rows($result2)>0){
                    while($row2 = mysqli_fetch_assoc($result2)){
                        echo '<option value="'.$row2['cust_id'].'">'.$row2['fname'].' '.$row2['lname'].'</option>';
                    }
                }					
        echo    '</select>';
        echo	'<span class="focus-input100" data-placeholder="&#xe60b;"></span>
            <div style="text-align:right; padding-right:15px">
                <span class="error">*'.$cidErr.'</span>
            </div>	
        </div>';

       echo '<div class="container-login100-form-btn m-t-32">
            <input class="login100-form-btn active" type="submit" value="ADD">
            <a class="login100-form-btn" href="sales.php?filter">
                Back
            </a>
        </div>';

    echo '</form>';
    }

	?>
	
	<script src="js/jquery.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/form.js"></script>

</body>
</html>