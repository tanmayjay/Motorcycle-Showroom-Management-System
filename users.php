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
    <title>Manage Users</title>
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
               
            <h3>Users</h3>
            <strong>U</strong>
                
            </div>

            <ul class="list-unstyled components">
            <li class="active">
                    <a href="users.php?filter">
                        <i class="fas fa-image"></i>
                        View Users
                    </a>
                </li>
            <li>
                    <a href="#homeSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                    <i class="fas fa-braille"></i>
                        Update User
                    </a>
                    <ul class="collapse list-unstyled" id="homeSubmenu">
                    <li>
                    <a href="update_user.php?changeUName">Change Username</a>
                    </li>
                    <li>
                    <a href="update_user.php?changeRole">Change User Role</a>
                    </li>
                    <li>
                    <a href="update_user.php?changeSR">Change Showroom</a>
                    </li>
                    </ul>
                </li>
                <li>
                    <a href="add_user.php">
                        <i class="fas fa-image"></i>
                        Add User
                    </a>
                </li>
                <li>
                    <a href="remove_user.php?currentPass">
                        <i class="fas fa-image"></i>
                        Remove User
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
    if($_SESSION['user_type']=='Admin'){
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
    $sql = "SELECT user_id, user_name, email, user_type FROM users";
    if($result = mysqli_query($db, $sql)){
        if(mysqli_num_rows($result) > 0){
            echo '<div class="container-fluid center" style="text-align:center;">';
            echo '<div class="table-responsive">';
            echo '<table class="table">';
            echo '<thead>';
                echo "<tr>";
                    echo "<th>Id</th>";
                    echo "<th>Username</th>";
                    echo "<th>Email</th>";
                    echo "<th>Role</th>";
                    echo "<th>Showroom</th>";
                    echo "<th>Details</th>";
                echo "</tr>";
            echo '</thead>';
            echo '<tbody>';
            while($row = mysqli_fetch_array($result)){
                $id=$row['user_id'];
                $sql_t = "SELECT sr_id FROM user_info where user_id=$id";
                $result_t = mysqli_query($db, $sql_t);
                if(mysqli_num_rows($result_t) > 0){
                    $row_t = mysqli_fetch_array($result_t);
                    $sri = $row_t['sr_id'];
                    $sql_t2 = "SELECT sr_name FROM showroom where sr_id = $sri";
                    $result_t2 = mysqli_query($db, $sql_t2);
                    if(!is_bool($result_t2)){
                        if(mysqli_num_rows($result_t2) > 0){
                            $row_t2 = mysqli_fetch_array($result_t2);
                            $sr = $row_t2['sr_name'];
                        } else {
                            $sr = 'NULL';
                        }
                    } else{
                        $sr = 'NULL';
                    }
                } else {
                    $sr = 'NULL';
                }
                echo "<tr>";
                    echo "<td>" . $row['user_id'] . "</td>";
                    echo "<td>" . $row['user_name'] . "</td>";
                    echo "<td>" . $row['email'] . "</td>";
                    echo "<td>" . $row['user_type'] . "</td>";
                    echo "<td>" . $sr . "</td>";
                    echo '<td><a href="profile.php?filter='. $row['user_name'] .'">View</a></td>';
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
    echo '<strong>User Added  Successfully</strong>';
    echo '</div>';
}

function upMessage(){
    echo '<div class="alert alert-success">';
    echo '<strong>User Updated Successfully</strong>';
    echo '</div>';
}

function remMessage(){
    echo '<div class="alert alert-success">';
    echo '<strong>User Removed  Successfully</strong>';
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


              