
  <nav class="navbar navbar-expand-md fixed-top navbar-dark bg-dark" style="font-family: Ubuntu-Regular, sans-serif;">
  <div class="container-fluid">
  <div class="navbar-header">
<a class="navbar-brand" href="index.php">
<img src="images/icon-red.png" class="img-fluid" alt="Stallions Logo" style="width:80px;">
</a>
</div>
<button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#collNavbar">
<span class="navbar-toggler-icon"></span>
</button>
<div class="collapse navbar-collapse" id="collNavbar">
<ul class="nav navbar-nav mr-auto" style="font-size:25px;">
<li class="active nav-item">
<a class="nav-link" href="index.php"><font color=#ff5050><strong>Home</strong></font></a>
</li>
<li class="nav-item">
<a class="nav-link" href="products.php?filter"><font color=#ff5050><strong>Products</strong></font></a>
</li>
<li class="nav-item">
<a class="nav-link" href="contact.php?filter"><font color=#ff5050><strong>Contacts</strong></font></a>
</li>
<?php
$count = counter();
if(isset($_GET['counter'])){
    $count = counter();
}

if($_SESSION['logged']==false){
    echo '<li class="nav-item">
    <a class="nav-link" href="customer_form.php?register"><font color=#ff5050><strong>Register</strong></font></a>
    </li>';
} else {
    if($_SESSION['user_type']!='Visitor'){
        echo '<li class="nav-item">
        <a class="nav-link" href="bookings.php?filter"><font color=#ff5050><strong>Bookings<span class="badge badge-light">'.$count.'</span></strong></font></a>
        </li>';
    }
}
function counter(){
    $count = 0;
    $db = mysqli_connect('localhost','root','','SHOWROOM');
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


?>
<li class="nav-item dropdown">
<a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
<font color=#ff5050><strong>About</strong></font></a>
<div class="dropdown-menu">
<a class="inactive dropdown-item" href="#">
<i class="fas fa-paper-plane"></i>
<font color=#669999><strong>   Documentations</strong></font></a>
<a class="inactive dropdown-item" href="#">
<i class="fas fa-image"></i>
<font color=#669999><strong>   Portfolio</strong></font></a>
<a class="inactive dropdown-item" href="#">
<i class="fas fa-question"></i>
<font color=#669999><strong>   FAQ</strong></font></a>
</li>
</ul>
<form class="form-inline" method="post" action="products.php?search">
<input class="form-control mr-sm-2" type="text" placeholder="Products" name="search">
<button class="btn btn-danger" type="submit">Search</button>
</form>
                        
                <?php
  
                    if($_SESSION['logged']==true){
                        echo '<ul class="nav navbar-nav navbar-nav-right" style="font-size:25px">';
                        echo '<li class="nav-item dropdown active" style="float:right;">';
                        echo '<a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" id="navbardrop">';
                        echo '<span style="color:#00cc99"><i class="fas fa-user-shield"></i></span>';
                        echo '<font color=#ff5050><strong>' .htmlentities($_SESSION['username'], ENT_QUOTES, 'UTF-8') .' ('.htmlentities($_SESSION['user_type'], ENT_QUOTES, 'UTF-8'). ')</strong></font><span class="caret"></span></a>';
                        echo '<div class="dropdown-menu">';
                        echo '<a class="inactive dropdown-item" href="profile.php?filter='.$_SESSION['username'].'">';
                        echo '<span style="color:#669999;"><i class="fas fa-id-badge"></i></i></span>';
                        echo '<font color=#669999><strong>    Profile</strong></font></a>';
                        if($_SESSION['user_type']=='Admin'){
                            echo '<a class="inactive dropdown-item" href="users.php?filter">';
                            echo '<span style="color:#669999"><i class="fas fa-user-friends"></i></i></span>';
                            echo '<font color=#669999><strong>  Manage Users</strong></font></a>';
                            echo '<a class="inactive dropdown-item" href="logout.php">';
                            echo '<span style="color:#669999"><i class="fas fa-sign-out-alt"></i></span>';
                            echo '<font color=#669999><strong>   Log Out</strong></font></a>';
                        } else {
                            echo '<a class="inactive dropdown-item" href="logout.php">';
                            echo '<span style="color:#669999"><i class="fas fa-sign-out-alt"></i></span>';
                            echo '<font color=#669999><strong>   Log Out</strong></font></a>';
                        }
                        echo '</div>';
                        echo '</li>';
                        echo '</ul>';
                    } else {
                        echo '<ul class="nav navbar-nav navbar-nav-right" style="font-size:25px;">';
                        echo '<li class="nav-item dropdown">';
                        echo '<a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">';
                        echo '<span style="color:#00cc99;"><i class="fas fa-users-cog"></i></span>';
                        echo '<font color=#ff5050><strong>  User</strong></font>';
                        echo '</a>';
                        echo '<div class="dropdown-menu">';
                        echo '<a class="dropdown-item" href="login_form.php">';
                        echo  '<span style="color:#00cc99;"><i class="fas fa-sign-in-alt"></i></span>';
                        echo  '<font color=#00cc99><strong>  Log In</strong></font>';
                        echo '</a>';
                        echo '</div>';
                        echo '</li>';
                        echo '</ul>';
                    }

                    function search(){
                        //include_once('config.php');
                        $db = mysqli_connect(dbhost,dbuser,dbpass,database);
                            if(isset($_POST['search'])){
                                $b = $_POST['search'];
                            } else {
                                $b = "";
                               
                            }
                            if($b==""){
                                echo 'No Keyword Given!';
                                $sql = "SELECT * FROM product where product_name like '%$b%' ORDER BY sale_count desc,status,brand,price desc";
                            } else {
                                $sql = "SELECT * FROM product where product_name like '%$b%' ORDER BY sale_count desc,status,brand,price desc";
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
                                        echo   '<a href="#" class="btn btn-primary float-right stretched-link">Book Now</a>';
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
                ?>
                            
            </div>
        </nav>