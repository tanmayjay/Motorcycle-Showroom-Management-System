<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/fonts.css">
    <link rel="stylesheet" type="text/css" href="css/sidebar.css">
    <link rel="stylesheet" type="text/css" href="css/_table.css">
    <link rel="stylesheet" type="text/css" href="css/jquery.mCustomScrollbar.min.css">
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js" integrity="sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ" crossorigin="anonymous"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js" integrity="sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY" crossorigin="anonymous"></script>
    <link rel="icon" type="image/png" href="images/icon-red.png"/>
    <title>Bokings</title>
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
               
            <h3>Bookings</h3>
            <strong>B</strong>
                
            </div>

            <ul class="list-unstyled components">
            <li class="active">
                    <a href="bookings.php?filter">
                        <i class="fas fa-image"></i>
                        View Bookings
                    </a>
                </li>
            </ul>
        </nav>

    <div id="content">

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">

        <button type="button" id="sidebarCollapse" class="btn btn-info">
            <i class="fas fa-align-justify"></i>
            
        </button>
        <button class="btn btn-dark d-inline-block d-lg-none ml-auto" type="button" data-toggle="collapse" 
        data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" 
        aria-label="Toggle navigation">
            <i class="fas fa-align-justify"></i>
        </button>

    </div>
</nav>

<?php

if(isset($_GET['raMessage'])){
    echo '<div style="text-align:center;">';
	raMessage();
	echo '</div>';
}

if(isset($_GET['remMessage'])){
    echo '<div style="text-align:center;">';
	remMessage();
	echo '</div>';
}

if(isset($_GET['upMessage'])){
    echo '<div style="text-align:center;">';
	upMessage();
	echo '</div>';
}

if($_SESSION['logged']){
    if($_SESSION['user_type']!='Visitor'){
        if(isset($_GET['filter'])){
            filter();
        }
    } else {
        echo "You don't have privileges to visit this page!"; 
    }
} else {
    header('location:index.php');
}
?>

</div>
</div>


<?php
function filter(){
    $db = mysqli_connect(dbhost,dbuser,dbpass,database);                        
    $sql = "SELECT * FROM booking";

                                                         
                            echo '<div class="container-fluid" style="padding-top:30px; margin-left:0px;">'; 
                        echo '<div class="row">';
                        if($result = mysqli_query($db, $sql)){
                            if(mysqli_num_rows($result) > 0){
                                while($row = mysqli_fetch_array($result)){
                                        $bdate = $row['booking_date']; 
                                        $bkid = $row['booking_id'];
                                        $pid = $row['product_id'];
                                        $uid = $row['user_id'];
                                        $tsql = "SELECT * FROM product WHERE product_id = $pid";
                                        if($res = mysqli_query($db, $tsql)){
                                            $row2 = mysqli_fetch_assoc($res);
                                            $pname = $row2['product_name'];
                                            $image = $row2['image_file'];
                                            $type = $row2['product_type'];
                                            $brand = $row2['brand'];
                                            $price = $row2['price'];
                                           
                                        }

                                        $tsql2 = "SELECT * FROM users WHERE user_id = $uid";
                                        if($res2 = mysqli_query($db, $tsql2)){
                                            $row3 = mysqli_fetch_assoc($res2);
                                            $uname = $row3['user_name'];
                                            $utype = $row3['user_type'];
                                            if($utype != 'Visitor'){
                                                $tsql3 = "SELECT fname,lname FROM user_info WHERE user_id = $uid";
                                            } else {
                                                $tsql3 = "SELECT fname,lname FROM customer WHERE user_id = $uid";
                                            }

                                            if($res3 = mysqli_query($db, $tsql3)){
                                                $row4 = mysqli_fetch_assoc($res3);
                                                $ufname = $row4['fname'];
                                                $ulname = $row4['lname'];
                                            }
                                        }

                                        
                                        echo '<div class="col-md-3 d-flex align-items-stretch">';
                                        echo '<div class="card" style="width:400px">';
                                        echo '<div class="container-fluid">';
                                        echo    '<img class="card-img-top" src="'.$image.'" alt="Card image" style="width:100%">';
                                        echo '</div';
                                        echo    '<div class="card-body">';
                                        echo    '<h4 class="card-title">'.$pname.'</h4>';
                                        
                                        echo    '<p class="card-text">Type: '.$type .'</p>';
                                        echo    '<p class="card-text">Brand: ' .$brand.'</p>';
                                        echo    '<p class="card-text">Price: ৳ ' .$price.'</p>';
                                        echo    '<h5 class="card-text">Booking Date:<br>'.$bdate.'</h5>';
                                        echo    '<h5 class="card-text">Booked By:<br>'.$ufname.' '.$ulname.' ('.$uname.')</h5>';
                                        /*echo   '<a class="btn btn-warning float-right" href="booking.php?cancel_booking='.$pid.'">
                                                Cancel</a>';
                                        echo '<form method="post" action="?confirm='.$bkid.'">
                                                <input type="hidden" value="'.$bkid.'" name="bkid">';*/
                                        
                                        echo    '</div>';
                                        echo '</div>';
                                        echo '</div>';
                                }
                                mysqli_free_result($result);
                            } else{
                                echo "No records matching your query were found.";
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
    echo '<strong>Sale Added  Successfully</strong>';
    echo '</div>';
}

function remMessage(){
    echo '<div class="alert alert-success">';
    echo '<strong>Sale Deleted Successfully</strong>';
    echo '</div>';
}
?>
    
    <script src="js/jquery.slim.min.js"></script>
    <script src="js/jquery.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.mCustomScrollbar.concat.min.js"></script>

    <script type="text/javascript">
        $(document).ready(function () {
            $('#sidebarCollapse').on('click', function () {
                $('#sidebar').toggleClass('active');
            });
        });
    </script>
</body>
</html>


              