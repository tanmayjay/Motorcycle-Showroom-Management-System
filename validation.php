<?php

include_once('config.php');

$pnameErr = $typeErr = $statusErr = $brandErr = $priceErr = $stockErr = $mileErr = "";
$pname = $type = $status = $brand = $price = $stock = $mile = "";

$emailErr = $passErr = $passErr2 = $roleErr = $unameErr = $srid = "";
$email = $tpassword = $password = $role = $uname = $srErr = "";

$fnameErr = $lnameErr = $sexErr = $dobErr = $phoneErr = $addrErr = "";
$fname = $lname = $sex = $dob = $phone = $addr = "";

$srname = "";
$srnameErr = "";

$imgErr = "";

$pay = $pid = $cid = "";
$pidErr = $cidErr = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

  //for add product

  if (empty($_POST["pname"])) {
    $nameErr = "Name is required";
  } else {
    $name = test_input($_POST["pname"]);
  }

  if (empty($_POST["type"])) {
    $typeErr = "Type is required";
  } else {
    $type = test_input($_POST["type"]);
  }

  if (empty($_POST["brand"])) {
    $brandErr = "Brand is required";
  } else {
    $brand = test_input($_POST["brand"]);
  }

  if (empty($_POST["status"])) {
    $statusErr = "Status is required";
  } elseif ($_POST["status"] == "Status") {
    $statusErr = "Status is required";
  } else {
    $status = test_input($_POST["status"]);
  }

  if (empty($_POST["stock"])) {
    $stockErr = "Stock is required";
  } elseif (!is_numeric($_POST["stock"])) {
    $stockErr = "Should be a number";
  } else {
    $stock = test_input($_POST["stock"]);
  }

  if (empty($_POST["mileage"])) {
    $mileErr = "Speed is required";
  } elseif (!is_numeric($_POST["mileage"])) {
    $mileErr = "Should be a number";
  } else {
    $mile = test_input($_POST["mileage"]);
  }

  if (empty($_POST["price"])){
    $price = "";
  } else {
    $num = $_POST["price"];
    if($num<0){
      $priceErr = "Price must be Non-negative";
      $price = "";
    } else {
      $price = test_input($_POST["price"]);
    }
  }


 //for add user
  
  if (empty($_POST["email"])) {
    $emailErr = "Email is required";
  }  else {
    $db = mysqli_connect(dbhost,dbuser,dbpass,database);
		$em =		$_POST["email"];				            
    $sql = "SELECT * FROM users where email = '$em'";

		if($result = mysqli_query($db, $sql)){
			if(mysqli_num_rows($result) > 0){
        $emailErr = "An account with this email already exists!";
        $email = "";
				mysqli_free_result($result);
			} else{
				$email = test_input($_POST["email"]);
			}
		} else{
			echo "ERROR: Could not able to execute $sql. " . mysqli_error($db);
		}
		mysqli_close($db);
  }

  if (empty($_POST["password"])) {
    $passErr = "Password is required";
  } else {
    if(preg_match("/^.*(?=.{8,})(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z]).*$/", $_POST["password"]) === 0){
      $passErr = "Must contain at least 8 charecter with one number and one uppercase and lowercase letter";
    } else {
      $tpassword = test_input($_POST["password"]);
    }    
  }

  if(empty($_POST["cpassword"])){
    $passErr2 = "Password is required";
  } else {
    $password = test_input($_POST["cpassword"]);
    if($password != $tpassword){
      $passErr2 = "Password not matched";
      $password = "";
    }
  }

  if (empty($_POST["utype"])) {
    $roleErr = "Role is required";
  } elseif ($_POST["utype"] == "Role") {
    $roleErr = "Role is required";
  } else {
    $role = test_input($_POST["utype"]);
  }  

  if (empty($_POST["sr_id"])) {
    $srErr = "Showroom is required";
  } elseif (!is_numeric($_POST["sr_id"])) {
    $srErr = "Showroom is required";
  } else {
    $srid = test_input($_POST["sr_id"]);
  }

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
		mysqli_close($db);
  }


//for create profile
  
  if (empty($_POST["fname"])) {
    $fnameErr = "Name is required";
  } elseif (is_numeric($_POST["fname"])) {
    $fnameErr = "Name cannot contain number";
  } else {
    $fname = test_input($_POST["fname"]);
  }

  if (empty($_POST["lname"])) {
    $lnameErr = "Name is required";
  } elseif (is_numeric($_POST["lname"])) {
    $lnameErr = "Name cannot contain number";
  } else {
    $lname = test_input($_POST["lname"]);
  }

  if (empty($_POST["gender"])) {
    $sexErr = "Gender is required";
  } elseif ($_POST["gender"] == "Gender") {
    $sexErr = "Gender is required";
  } else {
    $sex = test_input($_POST["gender"]);
  }

  if (empty($_POST["phone_no"])) {
    $phoneErr = "Phone number is required";
  } elseif (!is_numeric($_POST["phone_no"])) {
    $phoneErr = "Phone number cannot contain charecter";
  } else {
    $phone = test_input($_POST["phone_no"]);
  }

  if (empty($_POST["dob"])) {
    $dobErr = "DOB is required";
  } else {
    $dob = test_input($_POST["dob"]);
  }

  if (empty($_POST["address"])) {
    $addrErr = "Address is required";
  } else {
    $addr = test_input($_POST["address"]);
  }

  //for add contact

  if (empty($_POST["sr_name"])) {
    $srnameErr = "Outlet Name is required";
  } elseif (is_numeric($_POST["sr_name"])) {
    $unameErr = "Name must contain alphabet";
  } else {
    $db = mysqli_connect(dbhost,dbuser,dbpass,database);
		$sr =		$_POST["sr_name"];				            
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
		mysqli_close($db);
  }


  //for add sale

  if(empty($_POST["pro_id"])) {
    $pidErr = "Product cannot be empty";
  } else {
    if($_POST["pro_id"]=="Select Available Product"){
      $pidErr = "Product cannot be empty";
    } else {
      $pid = $_POST["pro_id"];
      $res = mysqli_query(
        $db,
        "SELECT price from product where product_id = $pid"
      );
      $rw = mysqli_fetch_assoc($res);
      $pay = $rw['price'];
    }
  }

  if(empty($_POST["cust_id"])) {
    $cidErr = "Customer cannot be empty";
  } else {
    if($_POST["pro_id"]=="Select Customer"){
      $cidErr = "Customer cannot be empty";
    } else {
      $cid = $_POST["cust_id"];
    }
  }

}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

?>