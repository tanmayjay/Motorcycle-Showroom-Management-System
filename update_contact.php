<!DOCTYPE html>
<html lang="en">
<head>
	<title>Update Contact</title>
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
					Update Outlet
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
                    if (isset($_GET['changeContact'])){
                        changeContact();
                    }

				?>                  

                    
			</div>
		</div>
	</div>	

	<div id="dropDownSelect1"></div>

	<?php

    function changeName(){
        
        $srname = "";
        $srnameErr = "";
        $srid = "";
        $srErr = "";
                        
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            
            $db = mysqli_connect(dbhost,dbuser,dbpass,database);

            if (empty($_POST["sr_name"])) {
                $srnameErr = "Outlet Name is required";
              } elseif (is_numeric($_POST["sr_name"])) {
                $unameErr = "Name must contain alphabet";
              } else {
                    $sr = $_POST["sr_name"];				            
                $sql = "SELECT * FROM showroom where sr_name = '$sr'";
            
                    if($result = mysqli_query($db, $sql)){
                        if(mysqli_num_rows($result) > 0){
                            $srnameErr = "Outlet name exists! Choose another.";
                            mysqli_free_result($result);
                        } else{
                            $srname = test_input($_POST["sr_name"]);
                        }
                    } else{
                        echo "ERROR: Could not able to execute $sql. " . mysqli_error($db);
                    }
              }

              if (empty($_POST["sr_id"])) {
                $srErr = "Showroom is required";
              } elseif ($_POST["sr_id"] == "Select Outlet") {
                $srErr = "Showroom is required";
              } else {
                $srid = test_input($_POST["sr_id"]);
              }

            $sql = "UPDATE showroom SET sr_name = '$srname' WHERE sr_id = $srid";
                        
            if($srname!="" && $srid!=""){
                if(mysqli_query($db, $sql)){
                    header('location:contact.php?upMessage');
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
        
        echo '<form class="login100-form p-b-33 p-t-5" method="post" action="update_contact.php?changeName">';

        echo '<div style="text-align:right; padding-right:15px">
						<span class="error">* Required Field</span>
                    </div>';

        selectSR();

        echo '<div class="wrap-input100">
                    <input class="input100" type="text" name="sr_name" placeholder="Enter New Name">
                    <span class="focus-input100" data-placeholder="&#xe60b;"></span>
                    <div style="text-align:right; padding-right:15px">
                        <span class="error">* '.$srnameErr.'</span>
                    </div>
                </div>';
        

         echo '<div class="container-login100-form-btn m-t-32">
                    <input class="login100-form-btn active" type="submit" value="Update">
                    <a class="login100-form-btn" href="contact.php?filter">
                        Back
                    </a>
                </div>';

        echo '</form>'; 
    }

    function changeAddr(){
        
        $addr = "";
        $addrErr = "";
        $srid = "";
        $srErr = "";
                        
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            
            $db = mysqli_connect(dbhost,dbuser,dbpass,database);

            if (empty($_POST["address"])) {
                $addrErr = "Address is required";
              } else {
                $addr = test_input($_POST["address"]);
              }

              if (empty($_POST["sr_id"])) {
                $srErr = "Showroom is required";
              } elseif ($_POST["sr_id"] == "Select Outlet") {
                $srErr = "Showroom is required";
              } else {
                $srid = test_input($_POST["sr_id"]);
              }

            $sql = "UPDATE showroom SET address = '$addr' WHERE sr_id = $srid";
                        
            if($addr!="" && $srid!=""){
                if(mysqli_query($db, $sql)){
                    header('location:contact.php?upMessage');
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
        
        echo '<form class="login100-form p-b-33 p-t-5" method="post" action="update_contact.php?changeAddr">';

        echo '<div style="text-align:right; padding-right:15px">
						<span class="error">* Required Field</span>
                    </div>';

        selectSR();

        echo '<div class="wrap-input100">
                    <textarea class="input100" type="text" name="address" placeholder="Enter New Address"></textarea>
                    <span class="focus-input100" data-placeholder="&#xe60b;"></span>
                    <div style="text-align:right; padding-right:15px">
                        <span class="error">* '.$addrErr.'</span>
                    </div>
                </div>';
        

         echo '<div class="container-login100-form-btn m-t-32">
                    <input class="login100-form-btn active" type="submit" value="Update">
                    <a class="login100-form-btn" href="contact.php?filter">
                        Back
                    </a>
                </div>';

        echo '</form>'; 
    }

    function changeEmail(){
        
        $email = "";
        $emailErr = "";
        $srid = "";
        $srErr = "";
                        
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            
            $db = mysqli_connect(dbhost,dbuser,dbpass,database);

            if (empty($_POST["email"])) {
                $emailErr = "Email is required";
              } else {
                $email = test_input($_POST["email"]);
              }

              if (empty($_POST["sr_id"])) {
                $srErr = "Showroom is required";
              } elseif ($_POST["sr_id"] == "Select Outlet") {
                $srErr = "Showroom is required";
              } else {
                $srid = test_input($_POST["sr_id"]);
              }

            $sql = "UPDATE showroom SET email = '$email' WHERE sr_id = $srid";
                        
            if($email!="" && $srid!=""){
                if(mysqli_query($db, $sql)){
                    header('location:contact.php?upMessage');
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
        
        echo '<form class="login100-form p-b-33 p-t-5" method="post" action="update_contact.php?changeEmail">';

        echo '<div style="text-align:right; padding-right:15px">
						<span class="error">* Required Field</span>
                    </div>';

        selectSR();

        echo '<div class="wrap-input100">
                    <input class="input100" type="email" name="email" placeholder="Enter New Email">
                    <span class="focus-input100" data-placeholder="&#xe60b;"></span>
                    <div style="text-align:right; padding-right:15px">
                        <span class="error">* '.$emailErr.'</span>
                    </div>
                </div>';
        

         echo '<div class="container-login100-form-btn m-t-32">
                    <input class="login100-form-btn active" type="submit" value="Update">
                    <a class="login100-form-btn" href="contact.php?filter">
                        Back
                    </a>
                </div>';

        echo '</form>'; 
    }

    function changeContact(){
        
        $phone = "";
        $phoneErr = "";
        $srid = "";
        $srErr = "";
                        
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            
            $db = mysqli_connect(dbhost,dbuser,dbpass,database);

            if (empty($_POST["phone_no"])) {
                $phoneErr = "Phone number is required";
              } elseif (!is_numeric($_POST["phone_no"])) {
                $phoneErr = "Phone number cannot contain charecter";
              } else {
                $phone = test_input($_POST["phone_no"]);
              }

              if (empty($_POST["sr_id"])) {
                $srErr = "Showroom is required";
              } elseif ($_POST["sr_id"] == "Select Outlet") {
                $srErr = "Showroom is required";
              } else {
                $srid = test_input($_POST["sr_id"]);
              }

            $sql = "UPDATE showroom SET contact_no = '$phone' WHERE sr_id = $srid";
                        
            if($phone!="" && $srid!=""){
                if(mysqli_query($db, $sql)){
                    header('location:contact.php?upMessage');
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
        
        echo '<form class="login100-form p-b-33 p-t-5" method="post" action="update_contact.php?changeContact">';

        echo '<div style="text-align:right; padding-right:15px">
						<span class="error">* Required Field</span>
                    </div>';

        selectSR();

        echo '<div class="wrap-input100">
                    <input class="input100" type="text" name="phone_no" placeholder="Enter New Contact No">
                    <span class="focus-input100" data-placeholder="&#xe60b;"></span>
                    <div style="text-align:right; padding-right:15px">
                        <span class="error">* '.$phoneErr.'</span>
                    </div>
                </div>';
        

         echo '<div class="container-login100-form-btn m-t-32">
                    <input class="login100-form-btn active" type="submit" value="Update">
                    <a class="login100-form-btn" href="contact.php?filter">
                        Back
                    </a>
                </div>';

        echo '</form>'; 
    }

    function selectSR(){
        
        echo '<div class="wrap-input100">
						<select class="input100" name="sr_id">
                            <option hidden>Select Outlet</option>';
                            $db = mysqli_connect(dbhost,dbuser,dbpass,database);
								
                            $sql = "SELECT sr_id, sr_name FROM showroom";

                            if($result = mysqli_query($db, $sql)){
                                if(mysqli_num_rows($result) > 0){
                                    while($row = mysqli_fetch_array($result)){
                                            $sr_id = $row['sr_id'] ;
                                            $sr_name = $row['sr_name'];
                                            echo '<option value='.$sr_id.'>'.$sr_name.'</option>';
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
                            echo '</select>	
                            <span class="focus-input100" data-placeholder="&#xe60b;"></span>
                            <div style="text-align:right; padding-right:15px">
                                <span class="error">* '.$srErr.'</span>
                            </div>
                        </div>';
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