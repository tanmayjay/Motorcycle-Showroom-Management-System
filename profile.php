<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/fonts.css">
    <link rel="stylesheet" type="text/css" href="css/sidebar.css">
    <link rel="stylesheet" type="text/css" href="css/jquery.mCustomScrollbar.min.css">
    <link rel="stylesheet" type="text/css" href="css/fontawesome.min.css">
    <link rel="stylesheet" type="text/css" href="css/all.min.css">

    <link rel="icon" type="image/png" href="images/icon-red.png"/>
    <title>Profile</title>
</head>

<body>
<div class="container-fluid">
    <?php
     include_once('url.php');
     include_once('navbar.php'); 
     include("config.php");
    
     ?>
     </div>
    <div class="wrapper">
    
    <nav id="sidebar">
            <div class="sidebar-header">
               
            <h3>Profile Information</h3>
            <strong>Info</strong>
                
            </div>

<?php
       $db = mysqli_connect(dbhost,dbuser,dbpass,database);
                            
       if($_SESSION['logged']){
           $b = $_SESSION['username'];
           $t = $_SESSION['user_type'];
       }
       
       if($t == 'Visitor') {
            $sql = "SELECT * FROM users,customer where users.user_id = customer.user_id and users.user_name = '$b'";
       } else {
            $sql = "SELECT * FROM users,user_info where users.user_id = user_info.user_id and users.user_name = '$b'";
       }

       if($result = mysqli_query($db, $sql)){
            if(mysqli_num_rows($result) > 0){
                $row = mysqli_fetch_array($result);
                if ($row['fname']==NULL){
                    $foo = false;
                } else {
                    $foo = true;
                }
                mysqli_free_result($result);
                
            } else{
                $foo = false;
            }
        } else{
            echo "ERROR: Could not able to execute $sql. " . mysqli_error($db);
        }
    mysqli_close($db);

       if(isset($_GET['filter'])){
           $reqUser = $_GET['filter'];
       } else {
           $reqUser = "";
       }
       echo    '<ul class="list-unstyled components">';
       $currUser = $_SESSION['username'];
       if($currUser == $reqUser){
            
            echo '<li class="active">
                        <a href="profile.php?filter='.$currUser.'">
                                <i class="fas fa-image"></i>
                                Profile
                            </a>
                        </li>';
                if($foo == false) {
                    echo '<li>
                        <a href="create_profile.php">
                                <i class="fas fa-image"></i>
                                Create Profile
                            </a>
                        </li>';
                } else {
                    echo '<li>';
                    echo '<a href="#homeSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">';
                    echo '<i class="fas fa-braille"></i>';
                    echo     'Update Info';
                    echo '</a>';
                    echo '<ul class="collapse list-unstyled" id="homeSubmenu">';
                    echo '<li><a href="update_profile.php?changeName">Change Name</a></li>';                  
                    echo '<li><a href="update_profile.php?changeAddr">Change Address</a></li>';                  
                    echo '<li><a href="update_profile.php?changeEmail">Change Email</a></li>';
                    echo '<li><a href="update_profile.php?changePhone">Change Phone No.</a></li>';
                    echo '</ul>';
                echo '</li>';
                }
                        
                        echo '<li>
                        <a href="update_profile.php?uploadImage">
                            <i class="fas fa-image"></i>
                            Upload/Update Photo
                        </a>
                        </li>';

                        echo '<li>
                            <a href="update_pass.php?currentPass">
                                <i class="fas fa-image"></i>
                                Update Password
                            </a>
                        </li>';
                        if($t != 'Visitor'){
                        echo '<li>
                            <a href="resign.php?currentPass">
                                <i class="fas fa-image"></i>
                                Resign
                            </a>
                        </li>';
                    echo '</ul>';
                        } else {
                            echo '<li>
                            <a href="resign.php?currentPass">
                                <i class="fas fa-image"></i>
                                Delete Account
                            </a>
                        </li>';
                    
                        }
            } else {
                echo '<li>
                <a href="users.php?filter">
                    <i class="fas fa-image"></i>
                    Back
                </a>
                </li>';
                
            }
            echo '</ul>';
            ?>
        </nav>

    <div id="content">

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">

        <button type="button" id="sidebarCollapse" class="btn btn-info">
            <i class="fas fa-align-justify"></i>
            
        </button>
        <button class="btn btn-dark d-inline-block d-lg-none ml-auto" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <i class="fas fa-align-justify"></i>
        </button>

    </div>
</nav>
<?php

if(isset($_GET['filter'])){
    $u = $_GET['filter'];
    filter($u);
}
if(isset($_GET['raMessage'])){
    echo '<div style="text-align:center;">';
    raMessage();
    echo '</div>';
}
if(isset($_GET['sucMessage'])){
    echo '<div style="text-align:center;">';
    sucMessage();
    echo '</div>';
}
if(isset($_GET['upMessage'])){
    echo '<div style="text-align:center;">';
	upMessage();
	echo '</div>';
}
if(isset($_GET['imupMessage'])){
    echo '<div style="text-align:center;">';
	imupMessage();
	echo '</div>';
}
?>

</div>
</div>


    <script src="js/jquery.slim.min.js"></script>
    <script src="js/jquery.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.mCustomScrollbar.concat.min.js"></script>
    <script src="js/fontawesome.min.js"></script>
    <script src="js/all.min.js"></script>

    <?php               

                        function filter($user){
                            $db = mysqli_connect(dbhost,dbuser,dbpass,database);
                            
                            $r = mysqli_query(
                                $db,
                                "SELECT user_type, user_id from users where user_name = '$user'"
                            );
                            $re = mysqli_fetch_assoc($r);
                            $uid = $re['user_id'];
                            $t = $re['user_type'];
                            if(!$_SESSION['logged']){
                                header('location:index.php');
                            }
                            if($t == 'Visitor'){
                                $sql = "SELECT * FROM users,customer where users.user_id = customer.user_id and users.user_id = '$uid'";
                            } else {
                                $sql = "SELECT * FROM users,user_info where users.user_id = user_info.user_id and users.user_id = '$uid'";
                            }
                            
                        
                                
                                
                                echo '<div class="container-fluid" style="padding-top:30px; margin-left:30px; margin-right:auto;">'; 
                            echo '<div class="row">';

                            $re = mysqli_query(
                                $db,
                                "SELECT count(*) as tot_book from booking where user_id = $uid"
                            );
                            $rw = mysqli_fetch_assoc($re);
                            $tb = $rw['tot_book'];

                            $re2 = mysqli_query(
                                $db,
                                "SELECT count(*) as tot_buy from sales, customer 
                                where sales.cust_id = customer.cust_id and customer.user_id = $uid"
                            );
                            $rw2 = mysqli_fetch_assoc($re2);
                            $ts = $rw2['tot_buy'];

                            if($result = mysqli_query($db, $sql)){
                                if(mysqli_num_rows($result) > 0){
                                    while($row = mysqli_fetch_array($result)){
                                            $uid = $row['user_id'] ;
                                            $ufname = $row['fname'];
                                            $ulname = $row['lname'];
                                            $image = $row['image'];
                                            $type = $row['user_type'];
                                            $email = $row['email'];
                                            $phone = $row['phone_no'];
                                            $gender = $row['gender'];
                                            $dob = $row['dob'];
                                            $addr = $row['address'];
                                            if($t != 'Visitor') {
                                                $sid = $row['sr_id'];
                                                $sql2 = "SELECT * from showroom where sr_id = $sid";
                                                $result2 = mysqli_query($db, $sql2);
                                                if(!is_bool($result2)){
                                                    $row2 = mysqli_fetch_array($result2);
                                                    $srname = $row2['sr_name'];
                                                    $sraddr = $row2['address'];
                                                } else {
                                                    $srname = 'N/A';
                                                    $sraddr = 'N/A';
                                                }
                                            } else {
                                                $srname = 'N/A';
                                                    $sraddr = 'N/A';
                                            }
                                            echo '<div>';
                                            
                                            echo '<div class="card" style="width:130%;">';
                                            echo '<div class="container-fluid">';
                                            echo    '<img class="card-img" <img src="data:image/jpeg;base64,'.base64_encode($image).'" alt="Card image" 
                                            style="width:25%;padding-top:20px;margin-left:10px">';
                                            echo '</div>';
                                            echo    '<div class="card-body" >';
                                            echo '<h4 class="card-title" style="padding-top:20px;margin-left:10px;">'.$ufname. ' ' .$ulname. '</h4>';   
                                            echo    '<p class="card-text">Address: '.$addr .'</p>';
                                            echo    '<p class="card-text">Sex: '.$gender .'</p>';
                                            echo    '<p class="card-text">Email: ' .$email.'</p>';
                                            echo    '<p class="card-text">Phone No: ' .$phone.'</p>';
                                            echo    '<p class="card-text">Date of Birth: ' .$dob.'</p>';
                                            echo    '<p class="card-text">Showroom: ' .$srname.' ( '.$sraddr.' )</p>';
                                            echo    '<p class="card-text">Total Booking: ' .$tb.'</p>';
                                            echo    '<p class="card-text">Total Buy: ' .$ts.'</p>';
                                            echo    '</div>';
                                            echo '</div>';
                                            echo '</div>';
                                    }
                                    mysqli_free_result($result);
                                } else{
                                    
                                    echo '<div class="container">';
                                    echo '<div class="alert alert-warning" style="text-align:center;">';
                                    echo "No records found";
                                    echo '</div>';
                                    $foo = true;
                                }
                            } else{
                                echo "ERROR: Could not able to execute $sql. " . mysqli_error($db);
                            }
                            mysqli_close($db);
                            echo '</div>';
                            echo '</div>';
                            
                        }

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
    function sucMessage(){
		echo '<div class="alert alert-success">';
		echo '<strong>Password changed successfully.</strong>';
		echo '</div>';
    }
    
    function upMessage(){
        echo '<div class="alert alert-success">';
        echo '<strong>Profile Updated Successfully.</strong>';
        echo '</div>';
    }

    function imupMessage(){
        echo '<div class="alert alert-success">';
        echo '<strong>Photo Updated.</strong>';
        echo '</div>';
    }

	?>
                

    <script type="text/javascript">
        $(document).ready(function () {
            $('#sidebarCollapse').on('click', function () {
                $('#sidebar').toggleClass('active');
            });
        });
    </script>
</body>
</html>


              