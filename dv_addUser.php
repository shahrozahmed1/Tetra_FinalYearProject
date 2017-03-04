<?php

ob_start();
session_start();
if(!isset($_SESSION['login_user']) || !isset($_SESSION['admin_is_logged']))
{
    // not logged in
    header('Location: index.php');
    exit();
}

include('dv_navigation.php');
?>

  <!DOCTYPE html>

  <head>

    <link rel="stylesheet" type="text/css" href="styles/styles.css">

    <style>
      table {
        border-collapse: collapse;
        width: 20%;
      }
      
      th,
      td {
        padding: 8px;
        text-align: left;
        border-bottom: 1px solid #ddd;
      }
      
      tr:hover {
        background-color: #f5f5f5
      }
    </style>

    <title>Insert New User</title>
  </head>

  <body>
    <h3>Insert New User</h3>
    <form name="insert-animal-frm" action="<?= $_SERVER['PHP_SELF']; ?>" method="post">
      <table border=5 width=150 cellpadding=10>

        <tr>
          <td colspan=2>
            <b>Account Username</b>
          </td>
          <td colspan=2>
            <input class="text-length" type="text" maxlength="11" name="account_username">
          </td>
        </tr>

        <tr>
          <td colspan=2>
            <b>Account Password</b>
          </td>
          <td colspan=2>
            <input class="text-length" type="password" maxlength="11" name="account_password">
          </td>
        </tr>

        <tr>
          <td colspan=2>
            <b>Administrative Rights</b>
          </td>
          <td colspan=2>
            <label class="control control--checkbox">Enable
              <input type="checkbox" name="permissions" id="perm_id" />
              <div class="control__indicator"></div>
            </label>

            <br>
          </td>
        </tr>

        <td colspan=2>
        </td>
        <td colspan=2>
          <input class="button" type="submit" name="deleteBtn" value="Delete">
          <input class="button" type="submit" name="addBtn" value="Create">
        </td>
        </tr>
      </table>
    </form>

    <br>
    <div>
      <span id="update-text" style="color:green">  </span>
      <span id="update-text2" style="color:red">  </span>
      <i>
<div id="text-update3"></div>
</i>

    </div>

  </body>

  </html>

  <?php
//load the database configuration file
include 'dv_dbConnection.php';

$name;

if (isset($_POST['account_username'])) {
    
    $name = $_POST['account_username'];
    
}

if (isset($_POST['addBtn'])) {
    
    $password = $_POST['account_password'];
    $permission = $_POST['permissions'];
    $perm = false;
    if ($permission == on) {
        $permission_bool = true;
    }
    
    if( $name == "" || $password == "" ) {
        
        if(empty($name)){
            echo "<span style='color:red; background-color: white;'>  Warning: 'Account Username' cannot be empty and must be unique!</span>";
        }
        else if(empty($password)){
            echo "<span style='color:red; background-color: white;'>  Warning: 'Account Password' cannot be empty!</span>";
        }
        
    } else {
        
        $sql = "INSERT INTO account(account_name, account_password, admin_permission) VALUES('" . $name . "',
        '" . $password . "','" . $permission_bool . "')";
        
        if (mysqli_query($con, $sql)){
            
            echo "
            <script>
            document.getElementById('update-text').innerHTML = '<b>".$name."</b> has been successfully added!';
            </script>
            ";
            
        } else {
            
            $error = mysqli_error($con);
            echo "<font color='red'>Error: " .$error.". Please try again! </font>";
            
        }
        
    }
    
    mysqli_close($con);
}
else if (isset($_POST['deleteBtn'])) {
    
    if(empty($name)){
        die("<font color='red'>Warning:  'Account Username' must be provided in order to delete a user record! </font>");
    }
    
    $sql = 'DELETE FROM account
    WHERE account_name = "'.$name.'"';
    
    $result = $con->query('SELECT account_name FROM account WHERE account_name = "'.$name.'"');
    
    $row_cnt = $result->num_rows;
    
    //    printf("Result set has %d rows.\n", $row_cnt);
    
    if($row_cnt > 0)
    {
        $retval = mysqli_query($con, $sql);
        echo "<span style='color:green; background-color: white;'>  '<b>".$name."</b>' has been deleted successfull!</span>";
    }
    else
    {
        
        echo "<span style='color:red; background-color: white;'>  Error: '<b>".$name."</b>' could not be found, please try again!</span>";
        
    }
    
}



?>