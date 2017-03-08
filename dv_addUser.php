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
        width: 360px;
        border: 1px solid black;
        border-radius: 5px;
        box-shadow: 10px 10px 5px #888888;
      }
      
      th,
      td {
        padding: 8px;
        text-align: left;
        border-bottom: 1px solid #ddd;
        background-color: #f2f2f2;
      }
      
      input[type=text],
      select {
        display: inline-block;
        border: solid 1px #999;
        border-radius: 2px 2px 5px 5px;
        box-sizing: border-box;
      }
      
      input[type=password],
      select {
        display: inline-block;
        border: solid 1px #999;
        border-radius: 2px 2px 5px 5px;
        box-sizing: border-box;
      }
      
      .error-msg {
        margin-top: 5;
      }
    </style>

    <title>Insert New User</title>
  </head>

  <body>

    <div class="error-msg" align="center">
      <span id="update-text" style="color:black;">  </span>
      <span id="update-text2" style="color:red;">  </span>
    </div>

    <div class="body-table" align="center">
      <h3>Insert New User</h3>
      <form name="insert-animal-frm" action="<?= $_SERVER['PHP_SELF']; ?>" method="post">
        <table border=5 width=150 cellpadding=10>

          <tr>
            <td colspan=2>
              <b>Account Username</b>
            </td>
            <td colspan=2>
              <input class="text-length" type="text" maxlength="20" name="account_username" placeholder="Username">
            </td>
          </tr>

          <tr>
            <td colspan=2>
              <b>Account Password</b>
            </td>
            <td colspan=2>
              <input class="text-length" type="password" maxlength="15" name="account_password" placeholder="Password">
            </td>
          </tr>

          <tr>
            <td colspan=2>
              <b>Administrative Rights</b>
            </td>
            <td colspan=2>
              <label class="control control--checkbox">Enable
                <input type="checkbox" name="permissions" id="perm_id" value="yes"/>
                <div class="control__indicator"></div>
              </label>

              <br>
            </td>
          </tr>

          <td colspan=2>
          </td>
          <td colspan=2>
          <input class="button" type="submit" name="addBtn" value="Create">
            <input class="button" type="submit" name="deleteBtn" value="Delete">
            
          </td>
          </tr>
        </table>
      </form>

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
    if ($permission == "yes") {
        $permission_bool = true;
    }
    
    if( $name == "" || $password == "" ) {
        $print_it;
        if(empty($name)){
            $print_it =  "Warning: <b> Account Username </b> cannot be empty and must be unique";
        }
        else if(empty($password)){
            $print_it = "Warning: <b> Account Password </b> cannot be empty";
        }
        
        echo "
        <script>
        document.getElementById('update-text2').innerHTML = '".$print_it.", please try again!';
        </script>
        ";
        
    } else {
        
        $lower_username = strtolower($name);
        
        $sql = "INSERT INTO account(account_name, account_password, admin_permission) VALUES('" . $lower_username . "',
        '" . $password . "','" . $permission_bool . "')";
        
        if (mysqli_query($con, $sql)){
            
            echo "
            <script>
            document.getElementById('update-text').innerHTML = '<b>".$lower_username."</b> has been added successfully!';
            </script>
            ";
            
        } else {
            
            $error = mysqli_error($con);
            
            echo "
            <script>
            document.getElementById('update-text2').innerHTML = 'Error: <b>".$error."</b>, Please try again!';
            </script>
            ";
            
        }
        
    }
    
    mysqli_close($con);
}
else if (isset($_POST['deleteBtn'])) {
    
    $name = $_POST['account_username'];
    
    if(empty($name)){
        die("
        <script>
        document.getElementById('update-text2').innerHTML = 'Warning: <b> Account Username </b> must be provided in order to delete a user record!';
        </script>
        ");
    }
    
    
    $lower_username = strtolower($name);
    
    $sql = 'DELETE FROM account
    WHERE account_name = "'.$lower_username.'"';
    
    $result = $con->query('SELECT account_name FROM account WHERE account_name = "'.$lower_username.'"');
    
    $row_cnt = $result->num_rows;
    
    //    printf("Result set has %d rows.\n", $row_cnt);
    
    if($row_cnt > 0)
    {
      $retval = mysqli_query($con, $sql);
        echo "
        <script>
        document.getElementById('update-text').innerHTML = '<b>".$lower_username."</b> has been deleted successfully!';
        </script>
        ";
    }
    else
    {
        
        echo "
        <script>
        document.getElementById('update-text2').innerHTML = 'Error: <b>".$lower_username."</b> could not be found, please try again!';
        </script>
        ";
        
    }
    
    
}



?>