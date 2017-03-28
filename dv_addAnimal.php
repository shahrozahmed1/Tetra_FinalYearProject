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
        width: 300px;
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
      
      .error-msg {
        margin-top: 5;
      }
    </style>

    <title>Insert Animal Data</title>
  </head>

  <body>

    <div class="error-msg" align="center">
      <span id="update-text" style="color:black;">  </span>
      <span id="update-text2" style="color:red;">  </span>
    </div>

    <div class="body-table" align="center">
      <h3> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Insert New Animal</h3>

      <form class="insert-animal-frm" name="animal_form" action="<?= $_SERVER['PHP_SELF']; ?>" method="post">
        <table border=5 width=150 cellpadding=10>
          <tr>
            <td colspan=2>
              <b>Initials</b>
            </td>
            <td colspan=2>
              <input class="text-length" type="text" maxlength="3" name="animal_initials_id" placeholder="Animal ID">
            </td>
          </tr>

          <tr>
            <td colspan=2>
              <b>Name</b>
            </td>
            <td colspan=2>
              <input class="text-length" type="text" maxlength="15" name="animal_name_id" placeholder="Animal Name">
            </td>
          </tr>

          <tr>
            <td colspan=2>
              <b>Sex</b>
            </td>
            <td colspan=2>

              <label class="control control--radio">Male
                <input type="radio" name="sex_id" id="m_id" value="m">
                <div class="control__indicator"></div>
              </label>


              <label class="control control--radio">Female
                <input type="radio" name="sex_id" id="f_id" value="f">
                <div class="control__indicator"></div>
              </label>


              <label class="control control--radio">Unknown
                <input type="radio" name="sex_id" value="u" id="un_id">
                <div class="control__indicator"></div>
              </label>

            </td>
          </tr>

          <tr>
            <td colspan=2>
              <b>Age Category</b>
            </td>
            <td colspan=2>
              <select name="age_id">
                <option value="adult">Adult</option>
                <option value="juvenile">Juvenile</option>
                <option value="infant">Infant</option>
                <option value="unknown">Unknown</option>
              </select>
            </td>
          </tr>

          <tr>
            <td colspan=2>
              <b>Status</b>
            </td>
            <td colspan=2>
              <select name="status_id">
                <option value="Collared">Collared</option>
                <option value="Uncollared">Uncollared</option>
                <option value="Deceased">Deceased</option>
              </select>
            </td>
          </tr>

          <tr>
            <td colspan=2>
              <b>Mother</b>
            </td>
            <td colspan=2>
              <input class="text-length" type="text" maxlength="15" name="animal_mother_id" placeholder="Mother Name">
            </td>
          </tr>

          <tr>
            <td colspan=2>
              <b>Social Partner</b>
            </td>
            <td colspan=2>
              <input class="text-length" type="text" maxlength="15" name="animal_partner_id" placeholder="Partner Name">
            </td>
          </tr>
          <tr>
            <td colspan=2>
            </td>
            <td colspan=2>
              <input class="button" type="submit" name="addBtn" value="Add">
              <input class="button" type="submit" name="deleteBtn" value="Delete">
            </td>
          </tr>
        </table>
      </form>

    </div>

    </div>

  </body>

  </html>

  <?php
//load the database configuration file
include 'dv_dbConnection.php';

$initials;

if (isset($_POST['animal_initials_id'])) {
    
    $initials = $_POST['animal_initials_id'];
    
}

if (isset($_POST['addBtn'])) {
    
    $name = $_POST['animal_name_id'];
    $sex = $_POST['sex_id'];
    $age = $_POST['age_id'];
    $status = $_POST['status_id'];
    $mother = $_POST['animal_mother_id'];
    $partner = $_POST['animal_partner_id'];
    
    $name = str_replace(' ', '_', $name);
    $mother = str_replace(' ', '_', $mother);
    $partner = str_replace(' ', '_', $partner);
    
    
    if( $initials == "" || $name == "" || $sex == "" ) {
        $print;
        if(empty($initials)){
            $print = "Warning: <b> Animal Initials </b> cannot be empty and must be unique!";
        }
        else if(empty($name)) {
            $print = "Warning: <b> Animal Name </b> cannot be empty!";
        }
        else if(empty($sex)) {
            $print = "Warning: <b> Animal Sex </b> must be selected!";
            
        }
        
        echo "
        <script>
        document.getElementById('update-text2').innerHTML = '".sprintf($print)."';
        </script>
        ";
        
        
    } else {
        
        $lower_initials = strtolower($initials);
        
        $lower_name = strtolower($name);
        $name = str_replace(' ', '_', $lower_name);
        
        $lower_mother = strtolower($mother);
        $mother = str_replace(' ', '_', $lower_mother);
        
        $lower_partner = strtolower($partner);
        $partner = str_replace(' ', '_', $lower_partner);
        
        $sql = "INSERT INTO animal(animal_initials, animal_Name, animal_Sex, animal_Category,
        animal_Status, animal_Mother, animal_Partner) VALUES('" . $lower_initials . "',
        '" . $name . "','" . $sex . "', '" . $age . "','" . $status . "','" . $mother . "',
        '" . $partner . "')";
        
        // CHECK IF ITS UNIQUE BEFORE INSERTION
        $result = $con->query('SELECT animal_Initials FROM animal WHERE animal_Initials
        = "'.$lower_initials.'"');
        $row_cnt = $result->num_rows;
        if($row_cnt == 0)
        {
            
            if (mysqli_query($con, $sql)){
                
                echo "
                <script>
                document.getElementById('update-text').innerHTML = '<b>".$lower_name."</b> has been added successfully!';
                </script>
                ";
                
            } else {
                
                $error = mysqli_error($con);
                echo "
                <script>
                document.getElementById('update-text2').innerHTML = 'Error: ".sprintf($error)." Please try again!';
                </script>
                ";
                
            }
        }
        else
        {
            echo "
            <script>
            document.getElementById('update-text2').innerHTML = 'Error: Animal with that ID already exist in the system, please try again!';
            </script>
            ";
        }
        
        
    }
    
    mysqli_close($con);
}
else if (isset($_POST['deleteBtn'])) {
    
    if(empty($initials)){
        die("
        <script>
        document.getElementById('update-text2').innerHTML = 'Warning: <b> Animal initials </b> must be provided in order to delete a record!';
        </script>
        ");
    }
    
    $lower_initials = strtolower($initials);
    
    $sql = 'DELETE FROM animal
    WHERE animal_Initials = "'.$lower_initials.'"';
    
    $result = $con->query('SELECT animal_Initials FROM animal WHERE animal_Initials
    = "'.$lower_initials.'"');
    $row_cnt = $result->num_rows;
    
    if($row_cnt > 0)
    {
        $retval = mysqli_query($con, $sql);
        echo "
        <script>
        document.getElementById('update-text').innerHTML = '<b>".$lower_initials."</b> has been deleted successfully!';
        </script>
        ";
    }
    else
    {
        echo "
        <script>
        document.getElementById('update-text2').innerHTML = 'Error: <b>".$lower_initials."</b> could not be found, please try again!';
        </script>
        ";
        
    }
    
}



?>