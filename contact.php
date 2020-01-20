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
    <title>Contacts</title>
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
               
            <h3>Contacts</h3>
            <strong>C</strong>
                
            </div>

            <ul class="list-unstyled components">
            <li class="active">
                    <a href="contact.php?filter">
                        <i class="fas fa-image"></i>
                        Outlets
                    </a>
                </li>

                <?php
                if($_SESSION['logged']){
                    if($_SESSION['user_type']=='Admin'){
                            show();
                    } 
                }
               
                function show(){
                    echo '<li>';
                    echo    '<a href="#homeSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                        <i class="fas fa-braille"></i>
                            Update Outlets
                        </a>
                        <ul class="collapse list-unstyled" id="homeSubmenu">
                        <li>
                        <a href="update_contact.php?changeName">Change Name</a>
                        </li>
                        <li>
                        <a href="update_contact.php?changeAddr">Change Address</a>
                        </li>
                        <li>
                        <a href="update_contact.php?changeEmail">Change Email</a>
                        </li>
                        <li>
                        <a href="update_contact.php?changeContact">Change Contact No</a>
                        </li>
                        </ul>';
                    echo '</li>';
                    echo '<li>
                        <a href="add_contact.php">
                            <i class="fas fa-image"></i>
                            Add Outlet
                        </a>
                    </li>';
                    echo '<li>
                        <a href="remove_contact.php">
                            <i class="fas fa-image"></i>
                            Remove Outlet
                        </a>
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

if(isset($_GET['upMessage'])){
    echo '<div style="text-align:center;">';
	upMessage();
	echo '</div>';
}

if(isset($_GET['remMessage'])){
    echo '<div style="text-align:center;">';
	remMessage();
	echo '</div>';
}

if(isset($_GET['filter'])){
    filter();
}

?>

</div>
</div>


<?php
function filter(){
    $db = mysqli_connect(dbhost,dbuser,dbpass,database);
    $sql = "SELECT * FROM showroom";
    if($result = mysqli_query($db, $sql)){
        if(mysqli_num_rows($result) > 0){
            echo '<div class="container-fluid center" style="text-align:center;">';
            echo '<div class="table-responsive">';
            echo '<table class="table">';
            echo '<thead>';
                echo "<tr>";
                    echo "<th>Id</th>";
                    echo "<th>Name</th>";
                    echo "<th>Address</th>";
                    echo "<th>Email</th>";
                    echo "<th>Contact No</th>";
                echo "</tr>";
            echo '</thead>';
            echo '<tbody>';
            while($row = mysqli_fetch_array($result)){
                echo "<tr>";
                    echo "<td>" . $row['sr_id'] . "</td>";
                    echo "<td>" . $row['sr_name'] . "</td>";
                    echo "<td>" . $row['address'] . "</td>";
                    echo "<td>" . $row['email'] . "</td>";
                    echo "<td>" . $row['contact_no'] . "</td>";
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
    echo '<strong>Outlet Added Successfully.</strong>';
    echo '</div>';
}

function upMessage(){
    echo '<div class="alert alert-success">';
    echo '<strong>Outlet Updated Successfully.</strong>';
    echo '</div>';
}

function remMessage(){
    echo '<div class="alert alert-success">';
    echo '<strong>Outlet Removed Successfully.</strong>';
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


              