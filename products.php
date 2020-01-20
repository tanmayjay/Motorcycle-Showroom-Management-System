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
    <title>Products</title>
</head>

<body>
<div class="container-fluid">
    <?php
     include_once('url.php');
     include_once('navbar.php'); 
     
     ?>
     </div>
    <div class="wrapper">
    
    <nav id="sidebar">
            <div class="sidebar-header">
               
            <h3>Products</h3>
            <strong>P</strong>
                
            </div>

            <ul class="list-unstyled components">
            <li class="active">
                    <a href="products.php?filter">
                        <i class="fas fa-image"></i>
                        View Products
                    </a>
                 </li>
                <li>
                    <a href="#homeSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                    <i class="fas fa-braille"></i>
                        Brands
                    </a>
                    <ul class="collapse list-unstyled" id="homeSubmenu">
                    <?php
                        include_once("config.php");
                        $sql = "SELECT DISTINCT brand FROM product ORDER BY brand";

                        if($result = mysqli_query($db, $sql)){
                            if(mysqli_num_rows($result) > 0){
                                while($row = mysqli_fetch_array($result)){
                                        $brand = $row['brand'] ;
                        echo '<li>';
                       
                        echo '<a href="?filter='.$brand.'">'.$brand.'</a>';                      
                        echo '</li>';
                                }
                                mysqli_free_result($result);
                            } else{
                                echo "No records matching your query were found.";
                            }
                        } else{
                            echo "ERROR: Could not able to execute $sql. " . mysqli_error($db);
                        }
                        echo '</ul>';
                        echo '</li>';
                        echo '<li>';     
                if($_SESSION['logged']==true){
                    if($_SESSION['user_type']!='Visitor'){
                    echo '<a href="#pageSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">';
                     echo   '<i class="fas fa-copy"></i>';
                    echo ' Manage';
                    echo '</a>';
                    echo '<ul class="collapse list-unstyled" id="pageSubmenu">';
                    echo   '<li>';
                    echo        '<a href="add_products.php">Add Product</a>';
                    echo    '</li>';
                    echo    '<li>';
                    echo        '<a href="edit_products.php">Update / Delete</a>';
                    echo    '</li>';
                    echo '</ul>';
                    }
                }
                

            echo '</li>';
            function _count(){
                $db = mysqli_connect(dbhost,dbuser,dbpass,database);
                $count = 0;
            if($_SESSION['logged']){
                $user = $_SESSION['username'];
                            $sql_t = "SELECT user_id FROM users WHERE user_name = '$user'";
                            $result_t = mysqli_query($db, $sql_t);
                            $row = mysqli_fetch_array($result_t);
                            $uid = $row['user_id'];
                $sql = "SELECT * FROM booking WHERE user_id = $uid";
                if($result = mysqli_query($db, $sql)){
                    
                    while(mysqli_fetch_array($result)){
                        $count =$count+1;
                    }
                }
                
            }
            return $count;
        }

            $count = _count();
            if(isset($_GET['_count'])){
                $count = _count();
            }
        
            if($_SESSION['logged']){                  
            echo '<li>
            <a href="?filter_booking">
            <i class="fas fa-image"></i>
            Booking <span class="badge badge-light">'.$count.'</span></a>
            </li>'; 
            }
            ?> 
            </ul>
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

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="nav navbar-nav ml-auto pagination">
            <?php
             $db = mysqli_connect(dbhost,dbuser,dbpass,database);
                
            
             if($_SESSION['logged']){

                $user = $_SESSION['username'];

                if (isset($_GET['filter'])){
                    $b = $_GET['filter'];
                    if ($b == "" || $b == "ALL"){
                        $result = mysqli_query(
                            $db,
                            "SELECT * FROM product"
                        );
                    } else{
                        $result = mysqli_query(
                            $db,
                            "SELECT * FROM product where brand = '$b'"
                        );
                    }
                    $tot_records = mysqli_num_rows($result);
                    pagination($tot_records);

                }
             } else {
                $b = $_GET['filter'];
                if ($b == "" || $b == "ALL"){
                    $result = mysqli_query(
                        $db,
                        "SELECT * FROM product"
                    );
                } else{
                    $result = mysqli_query(
                        $db,
                        "SELECT * FROM product where brand = '$b'"
                    );
                }
                $tot_records = mysqli_num_rows($result);
                pagination($tot_records);
             }
               
             function pagination($tot_records){

                if (isset($_GET['page']) && $_GET['page']!="") {
                    $page = $_GET['page'];
                } else {
                        $page = 1;
                }
   
                    
                $per_pages = 4;
   
                $lim = ($page-1) * $per_pages;
                $previous_page = $page - 1;
                $next_page = $page + 1;
                
                    $tot_pages = ceil($tot_records / $per_pages);
                 $second_last = $tot_pages - 1;
               
                if ($tot_pages <= 7){   
                    for ($count = 1; $count <= $tot_pages; $count++){
                        if ($count == $page) {
                            echo '<li class="page-item active"><a class="page-link">Page '.$count.'</a></li>'; 
                        }else{
                            if(isset($_GET['filter'])){
                                $b = $_GET['filter'];
                                if($b == "" || $b == "ALL"){
                                    echo "<li><a class='page-link' href='?filter&page=$count'>Page $count</a></li>";
                                } else {
                                    echo "<li><a class='page-link' href='?filter=$b&page=$count'>Page $count</a></li>";
                                }
                            }
                            
                        }
                    }
                } elseif ($tot_pages > 7){
                    if($page <= 3) { 
                        for ($count = 1; $count < 4; $count++){ 
                        if ($count == $page) {
                            echo '<li class="page-item active"><a class="page-link">Page '.$count.'</a></li>';
                        }else{
                            if(isset($_GET['filter'])){
                                $b = $_GET['filter'];
                                if($b == "" || $b == "ALL"){
                                    echo "<li><a class='page-link' href='?filter&page=$count'>Page $count</a></li>";
                                } else {
                                    echo "<li><a class='page-link' href='?filter=$b&page=$count'>Page $count</a></li>";
                                }
                            }
                       }
                       echo "<li class='page-item'><a class='page-link'>...</a></li>";
                       echo "<li class='page-item'><a class='page-link' href='?filter&page=$second_last'>Page $second_last</a></li>";
                       echo "<li class='page-item'><a class='page-link' href='?filter&page=$tot_pages'>Page $tot_pages</a></li>";
                       }
                 }
                }
            } 
                 
                ?>
            </ul>
        </div>
    </div>
</nav>

<?php
if(isset($_GET['notify'])){
    notify();
}
if(isset($_GET['booking'])){
    booking();
}
if(isset($_GET['filter_booking'])){
    filter_booking();
}
if(isset($_GET['bookMessage'])){
    
    bookMessage();
    
}

if(isset($_GET['delMessage'])){
    echo '<div style="text-align:center;">';
    delMessage();
    echo '</div>';
}
if(isset($_GET['failMessage'])){
    echo '<div style="text-align:center;">';
    failMessage();
    echo '</div>';
}
if(isset($_GET['outMessage'])){
    echo '<div style="text-align:center;">';
    outMessage();
    echo '<div>';
}
if(isset($_GET['filter']) && !isset($_GET['search']))
{
    $b = $_GET['filter'];
    filter($b);
} else if(isset($_GET['search'])) {
    search();
}

if(isset($_GET['filter_by_id'])){
    $id = $_GET['filter_by_id'];
    filter_by_id($id);
}

if(isset($_GET['del_booking'])){
    $pid = $_GET['del_booking'];
    del_booking($pid);
}
?>

</div>
</div>

<?php
            function filter($b){
                    $db = mysqli_connect(dbhost,dbuser,dbpass,database);

                    if (isset($_GET['page']) && $_GET['page']!="") {
                        $page = $_GET['page'];
                    } else {
                            $page = 1;
                    }

                    	
                    $per_pages = 4;

                    $lim = ($page-1) * $per_pages;
                    $previous_page = $page - 1;
                    $next_page = $page + 1;
                    

                    
        
                    if($b=="" || $b=="ALL"){

                        $result = mysqli_query(
                            $db,
                            "SELECT * FROM product"
                            );
                       
                            $tot_records = mysqli_num_rows($result);
                            $tot_pages = ceil($tot_records / $per_pages);
                            $second_last = $tot_pages - 1;

                        $sql = "SELECT * FROM product 
                        ORDER BY sale_count desc, book_count desc, storage desc, brand, price desc 
                        LIMIT $lim, $per_pages";            
                    } else {

                        $result = mysqli_query(
                            $db,
                            "SELECT * FROM product where brand = '$b'"
                            );
                       
                            $tot_records = mysqli_num_rows($result);
                            $tot_pages = ceil($tot_records / $per_pages);
                            $second_last = $tot_pages - 1;

                        $sql = "SELECT * FROM product where brand = '$b' 
                        ORDER BY sale_count desc, book_count desc, storage desc, brand, price desc 
                        LIMIT $lim, $per_pages";
                    }
                                
                                
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
                                            $storage = $row['storage'];
                                            $sale = $row['sale_count'];
                                            $book = $row['book_count'];

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
                                            echo    '<p class="card-text">Sorage: ' .$storage.'</p>';
                                            echo    '<p class="card-text">Total Sales: ' .$sale.'</p>';
                                            echo    '<p class="card-text">Total Booking: ' .$book.'</p>';
                                            if ($_SESSION['logged']){
                                                echo '<form method="post" action="products.php?booking='.$pid.'">';
                                            } else {
                                                echo '<form method="post" action="products.php?notify='.$pid.'">';
                                            }
                                            
                                             echo       '<input type="hidden" value="'.$pid.'" name="pid">';
                                            echo   '<button class="btn btn-info float-right stretched-link">
                                                    Book Now</button>';
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

                        function filter_by_id($id){
                            $db = mysqli_connect(dbhost,dbuser,dbpass,database);
        
                        
                            $sql = "SELECT * FROM product where product_id = $id";
                                
                                        
                                        
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
                                                    $storage = $row['storage'];
                                                    $sale = $row['sale_count'];
                                                    $book = $row['book_count'];
        
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
                                                    echo    '<p class="card-text">Storage: ' .$storage.'</p>';
                                                    echo    '<p class="card-text">Total Sales: ' .$sale.'</p>';
                                                    echo    '<p class="card-text">Total Booking: ' .$book.'</p>';
                                                    if ($_SESSION['logged']){
                                                        echo '<form method="post" action="products.php?booking='.$pid.'">';
                                                    } else {
                                                        echo '<form method="post" action="products.php?notify='.$pid.'">';
                                                    }
                                                    
                                                     echo       '<input type="hidden" value="'.$pid.'" name="pid">';
                                                    echo   '<button class="btn btn-info float-right stretched-link">
                                                            Book Now</button>';
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

                        function booking(){
                            $db = mysqli_connect(dbhost,dbuser,dbpass,database);
                            
                            $user = $_SESSION['username'];
                            $sql_t = "SELECT user_id FROM users WHERE user_name = '$user'";
                            $result_t = mysqli_query($db, $sql_t);
                            $row = mysqli_fetch_array($result_t);
                            $uid = $row['user_id'];
                            if ($_SERVER["REQUEST_METHOD"] == "POST"){
                                $pid = $_POST['pid'];
                                $sql_p = "SELECT storage FROM product WHERE product_id = $pid";
                                $result_p = mysqli_query($db, $sql_p);
                                $row_p = mysqli_fetch_array($result_p);
                                $st = $row_p['storage'];
                                if($st == NULL || $st == 0){
                                    outMessage();
                                } else {

                                   $sql = "INSERT INTO booking(product_id,user_id) VALUES (?,?)";
                                   
                                   $stmt = $db->prepare($sql);
                                    
                                    $stmt->bind_param("ii",$pid,$uid);
                                    if($stmt->execute()){
                                       
                                        $sql2 = "SELECT book_count from product where product_id = $pid";
                                        $result2 = mysqli_query($db, $sql2);
                                        $row2 = mysqli_fetch_array($result2);
                                        $bcnt = $row2['book_count'];
                                        if ($bcnt == NULL){
                                            $bcnt = 1;
                                        } else {
                                            $bcnt = $bcnt + 1;
                                        }
                                        $sql3 = "UPDATE product SET book_count = $bcnt WHERE product_id = $pid";
                                        if (mysqli_query($db,$sql3)){
                                            echo '<div style="text-align:center;">';
                                            bookMessage();
                                            echo '</div>';
                                            _count();
                                        } else {
                                            bookMessage();
                                            echo '<div style="text-align:center;">';
                                            failMessage();
                                            echo '</div>';
                                            echo mysqli_error($db);
                                        }
                                        
                                    } else {
                                        failMessage();
                                        echo mysqli_error($db);
                                    }
                                }
                            }
                            mysqli_close($db);
                        }

                        function del_booking($pid){
                            if($_SESSION['logged']){
                            $db = mysqli_connect(dbhost,dbuser,dbpass,database);
                            $user = $_SESSION['username'];
                            $sql_t = "SELECT user_id FROM users WHERE user_name = '$user'";
                            $result_t = mysqli_query($db, $sql_t);
                            $row = mysqli_fetch_array($result_t);
                            $uid = $row['user_id'];
                            
                                $sql_p = "SELECT storage FROM product WHERE product_id = $pid";
                                $result_p = mysqli_query($db, $sql_p);
                                $row_p = mysqli_fetch_array($result_p);
                                $st = $row_p['storage'];

                                   $sql = "DELETE FROM booking WHERE user_id=$uid && product_id = $pid";
                                   
                                    if(mysqli_query($db,$sql)){
                                       
                                        $sql2 = "SELECT book_count from product where product_id = $pid";
                                        $result2 = mysqli_query($db, $sql2);
                                        $row2 = mysqli_fetch_array($result2);
                                        $bcnt = $row2['book_count'];
                                        
                                        $bcnt = $bcnt - 1;
                                        
                                        $sql3 = "UPDATE product SET book_count = $bcnt WHERE product_id = $pid";
                                        if (mysqli_query($db,$sql3)){
                                            echo '<div style="text-align:center;">';
                                            delMessage();
                                            echo '</div>';
                                            _count();
                                        } else {
                                            echo '<div style="text-align:center;">';
                                            delMessage();
                                            echo '</div>';
                                            failMessage();
                                            echo mysqli_error($db);
                                        }
                                        
                                    } else {
                                        echo '<div style="text-align:center;">';
                                        failMessage();
                                        echo '</div>';
                                        echo mysqli_error($db);
                                    }
                        
                            mysqli_close($db);
                                } else {
                                    header('location:?filter');
                                }
                        }

                        function filter_booking(){
                            $db = mysqli_connect(dbhost,dbuser,dbpass,database);

                            if($_SESSION['logged']){
                            $user = $_SESSION['username'];
                            $sql_t = "SELECT user_id FROM users WHERE user_name = '$user'";
                            $result_t = mysqli_query($db, $sql_t);
                            $row = mysqli_fetch_array($result_t);
                            $uid = $row['user_id'];
                                  
                            $sql = "SELECT * FROM product natural join booking WHERE user_id = $uid";
                                
                                
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
                                            $storage = $row['storage'];
                                            $bdate = $row['booking_date'];
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
                                            echo    '<p class="card-text">Storage: ' .$storage.'</p>';
                                            echo    '<p class="card-text">Booking Date: ' .$bdate.'</p>';
                                            echo '<a class="btn btn-danger float-right" href="?del_booking='.$pid.'">
                                                    Cancel Booking</a>';
                                            echo    '</div>';
                                            echo '</div>';
                                            echo '</div>';
                                    }
                                    mysqli_free_result($result);
                                } else{
                                    echo '<div class="container-fluid" style="text-align:center;">';
                                    echo '<div class="alert alert-info">';
                                    echo "<strong>No Booking Available</strong>";
                                    echo '</div>';
                                    echo '</div>';
                                }
                            } else{
                                echo "ERROR: Could not able to execute $sql. " . mysqli_error($db);
                            }
                            mysqli_close($db);
                            echo '</div>';
                            echo '</div>';
                        } else {
                            header('location:products.php?filter');
                        }
                        }

                        function notify(){
                            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                                echo '<div style="text-align:center; font-size:25px;">';
                                    echo '<div class="alert alert-warning">';
                                    echo '<strong>You need to Login first!</strong><br>';
                                    echo   '<a class="btn btn-primary float-center" href="login_form.php">
                                    Login</a>';
                                    echo   '<a class="btn btn-secondary float-center" href="customer_form.php?register">
                                    Register</a>';
                                   
                                    echo '</div>';
                                    echo '</div>';        
                            }
                        }

                        function failMessage(){
                            echo '<div class="alert alert-danger">';
                            echo '<strong>Operation Failed!!</strong>';
                            echo '</div>';
                        }

                        function outMessage(){
                            echo '<div class="alert alert-danger">';
                            echo "<strong>You cannot book this product! It's not in stock!</strong>";
                            echo '</div>';
                        }

                        function delMessage(){
                            echo '<div class="alert alert-info">';
                            echo '<strong>Booking Canceled.</strong>';
                            echo '</div>';
                        }

                        function bookMessage(){
                            if ($_SERVER["REQUEST_METHOD"] == "POST"){
                                $pid = $_POST['pid'];
                                $db = mysqli_connect(dbhost,dbuser,dbpass,database);
                                $sql_t = "SELECT product_name FROM product WHERE product_id = $pid";
                                $result_t = mysqli_query($db, $sql_t);
                                $row = mysqli_fetch_array($result_t);
                                $pname = $row['product_name'];
                            }
                            echo '<div class="alert alert-success">';
                            echo '<strong>You have successfully booked "'.$pname.'"</strong>';
                            echo '</div>';
                        }
?>

    <script src="js/jquery.slim.min.js"></script>
    <script src="js/jquery.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.mCustomScrollbar.concat.min.js"></script>
    <script src="js/fontawesome.min.js"></script>
    <script src="js/all.min.js"></script>

    <script type="text/javascript">
        $(document).ready(function () {
            $('#sidebarCollapse').on('click', function () {
                $('#sidebar').toggleClass('active');
            });
        });
    </script>
</body>
</html>


              