<?php

ob_start();
session_start();
include("dv_dbConnection.php");

$myusername = mysqli_real_escape_string($con,$_POST['username']);
$mypassword = mysqli_real_escape_string($con,$_POST['password']);

$myusername = strtolower($myusername);

$sql = "SELECT user_ID FROM account WHERE account_name = '".$myusername."' and BINARY account_password = '".$mypassword."'";
$result = mysqli_query($con,$sql);
$row = mysqli_fetch_array($result,MYSQLI_ASSOC);
$active = $row['active'];

$count = mysqli_num_rows($result);

if($count == 1) {
    
    

    $_SESSION['login_user'] = $myusername;
    $_SESSION['logged_on'] = $myusername;
    
    $per = "SELECT admin_permission FROM account
    WHERE account_name = '".$myusername."'
    and account_password = '".$mypassword."'";
    $per_result = mysqli_query($con, $per);
    $user = mysqli_fetch_array($per_result, MYSQLI_ASSOC);
 


    $admin_per = $user['admin_permission'];
    if($user['admin_permission'] == 1){
        $_SESSION['admin_is_logged'] = true;
    }

    echo "Gets here 1";
    header('Location: dv_map.php');
    
    exit();
    echo "Gets here 2";

} else {
    header('Location: index.php');
    exit();
}

?>

