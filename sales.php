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
    <title>Sales</title>
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
               
            <h3>Sales</h3>
            <strong>S</strong>
                
            </div>

            <ul class="list-unstyled components">
            <li class="active">
                    <a href="sales.php?filter">
                        <i class="fas fa-image"></i>
                        View Sales
                    </a>
                </li>
                <li>
                    <a href="add_sale.php?select">
                        <i class="fas fa-image"></i>
                        Add New Sale
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
    $sql = "SELECT * FROM sales";
    if($result = mysqli_query($db, $sql)){
        if(mysqli_num_rows($result) > 0){
            echo '<div class="container-fluid center" style="text-align:center;">';
            echo '<div class="table-responsive">';
            echo '<table class="table">';
            echo '<thead>';
                echo "<tr>";
                    echo "<th>Sale Id</th>";
                    echo "<th>Sale Date</th>";
                    echo "<th>Payment</th>";
                    echo "<th>Showroom</th>";
                    echo "<th>Product</th>";
                    echo "<th>Customer</th>";
                    echo "<th>Sold By</th>";
                    echo "<th>Action</th>";
                echo "</tr>";
            echo '</thead>';
            echo '<tbody>';
            while($row = mysqli_fetch_array($result)){
                $sid = $row['sale_id'];
                $sdate = $row['sale_date'];
                $pay = $row['payment'];
                $pid = $row['product_id'];
                $cid = $row['cust_id'];
                $srid = $row['sr_id'];
                $uid = $row['user_id'];
                $result_t = mysqli_query(
                    $db, 
                    "SELECT user_name from users where user_id = $uid");
                if(mysqli_num_rows($result_t) > 0){
                    $row_t = mysqli_fetch_array($result_t);
                    $uname = $row_t['user_name'];
                } else {
                    $uname = NULL;
                }

                $result_s = mysqli_query(
                    $db,
                    "SELECT address FROM showroom where sr_id = $srid");

                    if(mysqli_num_rows($result_s) > 0){
                        $row_s = mysqli_fetch_array($result_s);
                        $sradd = $row_s['address'];
                    } else {
                        $sradd = NULL;
                    }

                    $result_c = mysqli_query(
                        $db,
                        "SELECT user_name FROM users natural join customer where cust_id = $cid");    
                  
                        if(mysqli_num_rows($result_c) > 0){
                            $row_c = mysqli_fetch_array($result_c);
                            $cuname = $row_c['user_name'];
                        } else {
                            $cuname = NULL;
                        }
                        
                echo "<tr>";
                    echo "<td>" . $sid . "</td>";
                    echo "<td>" . $sdate . "</td>";
                    echo "<td>" . $pay . "</td>";
                    echo "<td>" . $sradd . "</td>";
                    echo '<td><a href="products.php?filter_by_id='. $pid .'">'.$pid.'</a></td>';
                    echo '<td><a href="profile.php?filter='. $cuname .'">'.$cid.'</a></td>';
                    echo '<td><a href="profile.php?filter='. $uname .'">'.$uname.'</a></td>';
                    echo '<td><a href="sales.php?delete='. $sid .'">Delete</a></td>';
                echo "</tr>";
            }

            echo '</tbody>';
            echo "</table>";
            echo '</div>';
           
            echo "</div>";
            mysqli_free_result($result);
        } else{
            echo "No records matching your query were found.";
        }
    } else{
        echo "ERROR: Could not able to execute $sql. " . mysqli_error($db);
    }
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


              