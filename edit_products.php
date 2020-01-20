<!DOCTYPE html>
<html lang="en">
<head>
	<title>Edit Products</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" type="image/png" href="images/icon-red.png"/>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/fonts.css">
	<link rel="stylesheet" type="text/css" href="css/hamburgers.min.css">
	<link rel="stylesheet" type="text/css" href="css/icon-font.min.css">
    <link rel="stylesheet" type="text/css" href="css/sidebar.css">
    <link rel="stylesheet" type="text/css" href="css/jquery.mCustomScrollbar.min.css">
	<link rel="stylesheet" type="text/css" href="css/short.css">

</head>
<body style="padding-top:150px;">

<div class="container-fluid">
    <?php
     session_start();
   
     if(!isset($_SESSION['logged'])){
        header("location: products.php");
        die();
     }

     include_once('navbar.php');
     include_once('config.php');
     if(isset($_GET['confirm'])){
        confirm();
    }
     if(isset($_GET['delete'])){
         delete();
     }

     if(isset($_GET['upMessage'])){
        echo '<div style="text-align:center;">';
        upMessage();
        echo '</div>';
     }

     ?>
</div>
    <div class="wrapper">
    
<?php
        filter();
    function filter(){
        $db = mysqli_connect(dbhost,dbuser,dbpass,database);                        
        $sql = "SELECT * FROM product";
                                                             
                                echo '<div class="container-fluid" style="padding-top:30px; margin-left:0px;">'; 
                            echo '<div class="row">';
                            if($result = mysqli_query($db, $sql)){
                                if(mysqli_num_rows($result) > 0){
                                    while($row = mysqli_fetch_array($result)){
                                            $pid = $row['product_id'] ;
                                            $pname = $row['product_name'];
                                            $image = $row['image_file'];
                                            $type = $row['product_type'];
                                            $mile = $row['mileage'];
                                            $brand = $row['brand'];
                                            $price = $row['price'];
                                            $status = $row['status'];
                                            echo '<div class="col-md-3 d-flex align-items-stretch">';
                                            echo '<div class="card" style="width:400px">';
                                            echo '<div class="container-fluid">';
                                            echo    '<img class="card-img-top" src="'.$image.'" alt="Card image" style="width:100%">';
                                            echo '</div';
                                            echo    '<div class="card-body">';
                                            echo    '<h4 class="card-title">'.$pname.'</h4>';
                                            echo    '<p class="card-text">Type: '.$type .'</p>';
                                            echo    '<p class="card-text">Speed: '.$mile .'</p>';
                                            echo    '<p class="card-text">Brand: ' .$brand.'</p>';
                                            echo    '<p class="card-text">Price: ৳ ' .$price.'</p>';
                                            echo    '<p class="card-text">Status: ' .$status.'</p>';
                                            echo   '<a class="btn btn-warning float-left" href="update_products.php?update='.$pid.'">
                                                    Update</a>';
                                            echo '<form method="post" action="?confirm='.$pid.'">
                                                    <input type="hidden" value="'.$pid.'" name="pid">';
                                                    
                                                    echo   '<button class="btn btn-danger float-right">
                                                    Delete</button>';
                                            echo '</form>';
                                            
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

                        function confirm(){
                            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                                $pid = $_POST['pid'];
                                echo '<div style="text-align:center;font-size:25px;">';
                                    echo '<div class="alert alert-danger">';
                                    echo '<strong>Product '.$pid.' will be deleted</strong><br>';
                                    echo '<form method="post" action="?delete='.$pid.'">
                                    <input type="hidden" value="'.$pid.'" name="pid">';
                                    echo   '<button class="btn btn-danger float-center" href="?delete='.$pid.'">
                                    Confirm</button>';
                                    echo   '<a class="btn btn-secondary inline float-center" href="edit_products.php">
                                    Cancel</a>';
                                    echo '</form>';
                                   
                                    echo '</div>';
                                    echo '</div>';
                                
                                    
                                    
                            }
                                }

                        function delete(){
                            $db = mysqli_connect(dbhost,dbuser,dbpass,database);
                            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                                $pid = $_POST['pid'];

                                $sql = "delete from Product where product_id = $pid";
                                if($result = mysqli_query($db, $sql)){
                                    echo '<div style="text-align:center;">';
                                    echo '<div class="alert alert-danger">';
                                    echo '<strong>Product '.$pid.' deleted successfully.</strong>';
                                    echo '</div>';
                                    echo '</div>';
                                } else {
                                    echo "ERROR: Could not able to execute $sql. " . mysqli_error($db);
                                }
                            mysqli_close($db);
                            }
                            
                        //header("location: $url"); 
                    }

                    function upMessage(){
                        echo '<div class="alert alert-success">';
                        echo '<strong>Product Updated.</strong>';
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