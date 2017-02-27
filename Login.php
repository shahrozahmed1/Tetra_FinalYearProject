<?php

  include("dv_dbConnection.php");
  session_start();

  echo "gets here";

  $myusername = mysqli_real_escape_string($con,$_POST['username']);
  $mypassword = mysqli_real_escape_string($con,$_POST['password']); 
      
  $sql = "SELECT user_ID FROM account WHERE account_username = '$myusername' and account_password = '$mypassword'";
  $result = mysqli_query($con,$sql);
  $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
  $active = $row['active'];
      
  $count = mysqli_num_rows($result);
     
  if($count == 1) {

    session_register("myusername");
    $_SESSION['login_user'] = $myusername;

    $permissions = mysqli_query(
      $con,
      "SELECT admin_permission FROM accounts 
      WHERE account_username = '$myusername'
      AND account_password = '$mypassword'");
      $user = mysqli_fetch_array($permissions);
		  if($user['admin_permission'] == 1){	
        $_SESSION['admin_is_logged'] = true;
		  }
      $_SESSION['login_user'] = "myusername";
      header('Location: dv_map.php');
      exit();
  } else {
      header('Location: index.php');
      exit();
  }
?>