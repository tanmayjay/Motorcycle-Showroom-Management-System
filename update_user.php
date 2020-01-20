<!DOCTYPE html>
<html lang="en">
<head>
	<title>Update User</title>
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
					Update User
                </span>
					
						
				
				<?php
                    
                    if($_SESSION['logged']){
                        if($_SESSION['user_type']=='Admin'){
                            if (isset($_GET['changeUName'])){
                                changeUName();
                            }
                            if (isset($_GET['changeRole'])){
                                changeRole();
                            }
                            if (isset($_GET['changeSR'])){
                                changeSR();
                            }
                        } else {
                            echo '<div style="text-align:center;">';
                            privMessage();
                            echo '</div>';
                        }
                    } else {
                        header('location:index.php');
                    }
                    

				?>                  

                    
			</div>
		</div>
	</div>	

	<div id="dropDownSelect1"></div>

	<?php


    function changeUName(){
        
        $uname = "";
        $unameErr = "";
        $userid = "";
        $uidErr = "";
                        
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            
            $db = mysqli_connect(dbhost,dbuser,dbpass,database);

            if (empty($_POST["username"])) {
                $unameErr = "Username is required";
              } elseif (is_numeric($_POST["username"])) {
                $unameErr = "Username must contain alphabet";
              } else {
                $db = mysqli_connect(dbhost,dbuser,dbpass,database);
                    $user =		$_POST["username"];				            
                $sql = "SELECT * FROM users where user_name = '$user'";
            
                    if($result = mysqli_query($db, $sql)){
                        if(mysqli_num_rows($result) > 0){
                            $unameErr = "Username exists! Choose another.";
                            mysqli_free_result($result);
                        } else{
                            $uname = test_input($_POST["username"]);
                        }
                    } else{
                        echo "ERROR: Could not able to execute $sql. " . mysqli_error($db);
                    }
              }

              if (empty($_POST["user_id"])) {
                $uidErr = "User is required";
              } elseif ($_POST["user_id"] == "Select User") {
                $uidErr = "User is required";
                $uid = "";
              } else {
                $userid = test_input($_POST["user_id"]);
              }

            $sql = "UPDATE users SET user_name = '$uname' WHERE user_id = $userid";
            $cunm = $_SESSION['username'];
            $re = mysqli_query(
                $db,
                "SELECT user_id from users where user_name = $cunm"
            );

            $r = mysqli_fetch_assoc($re);
            $cuid = $r['user_id'];

            if($uname!="" && $userid!=""){
                if(mysqli_query($db, $sql)){  
                    if($userid == $cuid){
                        header('location:logout.php');
                    } else {
                        header('location:users.php?upMessage');
                    }
                    
                } else {
                    echo $userid;                
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
        
        echo '<form class="login100-form p-b-33 p-t-5" method="post" action="update_user.php?changeUName">';

        echo '<div style="text-align:right; padding-right:15px">
						<span class="error">* Required Field</span>
                    </div>';

        selectUser();

        echo '<div class="wrap-input100">
                    <input class="input100" type="text" name="username" placeholder="Enter New Username">
                    <span class="focus-input100" data-placeholder="&#xe60b;"></span>
                    <div style="text-align:right; padding-right:15px">
                        <span class="error">* '.$unameErr.'</span>
                    </div>
                </div>';
        

         echo '<div class="container-login100-form-btn m-t-32">
                    <input class="login100-form-btn active" type="submit" value="Update">
                    <a class="login100-form-btn" href="users.php?filter">
                        Back
                    </a>
                </div>';

        echo '</form>'; 
    }

    function changeRole(){
        
        $role = "";
        $roleErr = "";
        $userid = "";
        $uidErr = "";
                        
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            
            $db = mysqli_connect(dbhost,dbuser,dbpass,database);

            if (empty($_POST["utype"])) {
                $roleErr = "Role is required";
              } elseif ($_POST["utype"] == "Select New Role") {
                $roleErr = "Role is required";
              } else {
                $role = test_input($_POST["utype"]);
              }

              if (empty($_POST["user_id"])) {
                $uidErr = "User is required";
              } elseif ($_POST["user_id"] == "Select User") {
                $uidErr = "User is required";
              } else {
                $userid = test_input($_POST["user_id"]);
              }

            $sql = "UPDATE users SET user_type = '$role' WHERE user_id = $userid";

            $re = mysqli_query(
                $db,
                "SELECT user_id from users where user_name = $cunm"
            );

            $r = mysqli_fetch_assoc($re);
            $cuid = $r['user_id'];
                        
            if($role!="" && $userid!=""){
                if(mysqli_query($db, $sql)){
                    if($userid == $cuid){
                        header('location:logout.php');
                    } else {
                        header('location:users.php?upMessage');
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
        
        echo '<form class="login100-form p-b-33 p-t-5" method="post" action="update_user.php?changeRole">';

        echo '<div style="text-align:right; padding-right:15px">
						<span class="error">* Required Field</span>
                    </div>';

        selectUser();

        echo '<div class="wrap-input100">
        <select class="input100" name="utype">
            <option hidden>Select New Role</option>
            <option value="Admin">Admin</option>
            <option value="Staff">Staff</option>					
        </select>

        <span class="focus-input100" data-placeholder="&#xe60b;"></span>
        <div style="text-align:right; padding-right:15px">
            <span class="error">* <?php echo $roleErr;?></span>
        </div>	
    </div>';
        

         echo '<div class="container-login100-form-btn m-t-32">
                    <input class="login100-form-btn active" type="submit" value="Update">
                    <a class="login100-form-btn" href="users.php?filter">
                        Back
                    </a>
                </div>';

        echo '</form>'; 
    }

    function changeSR(){
        
        $userid = "";
        $uidErr = "";
        $srid = "";
        $srErr = "";
                        
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            
            $db = mysqli_connect(dbhost,dbuser,dbpass,database);

            if (empty($_POST["user_id"])) {
                $uidErr = "User is required";
              } elseif ($_POST["user_id"] == "Select User") {
                $uidErr = "User is required";
              } else {
                $userid = test_input($_POST["user_id"]);
              }

              if (empty($_POST["sr_id"])) {
                $srErr = "Showroom is required";
              } elseif ($_POST["sr_id"] == "Select New Outlet") {
                $srErr = "Showroom is required";
              } else {
                $srid = test_input($_POST["sr_id"]);
              }

            $sql = "UPDATE user_info SET sr_id = $srid WHERE user_id = $userid";
            $re = mysqli_query(
                $db,
                "SELECT user_id from users where user_name = $cunm"
            );

            $r = mysqli_fetch_assoc($re);
            $cuid = $r['user_id'];
                        
            if($userid!="" && $srid!=""){
                if(mysqli_query($db, $sql)){
                    if($userid == $cuid){
                        header('location:logout.php');
                    } else {
                        header('location:users.php?upMessage');
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
        
        echo '<form class="login100-form p-b-33 p-t-5" method="post" action="update_user.php?changeSR">';

        echo '<div style="text-align:right; padding-right:15px">
						<span class="error">* Required Field</span>
                    </div>';

                    selectUser();
                    selectSR();
        

         echo '<div class="container-login100-form-btn m-t-32">
                    <input class="login100-form-btn active" type="submit" value="Update">
                    <a class="login100-form-btn" href="users.php?filter">
                        Back
                    </a>
                </div>';

        echo '</form>'; 
    }

    function selectUser() {
        echo '<div class="wrap-input100">
						<select class="input100" name="user_id">
                            <option hidden>Select User</option>';
                            $db = mysqli_connect(dbhost,dbuser,dbpass,database);

                            $cuser = $_SESSION['user_name'];
								
                            $sql = "SELECT user_id, user_name FROM users where user_name!='$cuser'";

                            if($result = mysqli_query($db, $sql)){
                                if(mysqli_num_rows($result) > 0){
                                    while($row = mysqli_fetch_array($result)){
                                            $uid = $row['user_id'] ;
                                            $uname = $row['user_name'];
                                            echo '<option value='.$uid.'>'.$uname.'</option>';
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
                                <span class="error">* '.$uidErr.'</span>
                            </div>
                        </div>';
    }

    function selectSR(){
        
        echo '<div class="wrap-input100">
						<select class="input100" name="sr_id">
                            <option hidden>Select New Outlet</option>';
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

    function privMessage(){
		echo '<div class="alert alert-danger">';
		echo '<strong>You do not have privileges to do this action!</strong>';
		echo '</div>';
    }

	?>
	
	<script src="js/jquery.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/form.js"></script>

</body>
</html>