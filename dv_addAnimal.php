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

    <title>Insert Animal Data</title>
  </head>

  <body>
    <h3>Insert New Animal</h3>
    <form name="animal_form" action="<?= $_SERVER['PHP_SELF']; ?>" method="post">
      <table border=5 width=150 cellpadding=10>
        <tr>
          <td colspan=2>
            <b>Initials</b>
          </td>
          <td colspan=2>
            <input class="text-length" type="text" maxlength="3" name="animal_initials_id">
          </td>
        </tr>

        <tr>
          <td colspan=2>
            <b>Name</b>
          </td>
          <td colspan=2>
            <input class="text-length" type="text" maxlength="11" name="animal_name_id">
          </td>
        </tr>

        <tr>
          <td colspan=2>
            <b>Sex</b>
          </td>
          <td colspan=2>
            <input type="radio" name="sex_id" value="m">Male
            <br>
            <input type="radio" name="sex_id" value="f">Female
            <br>
            <input type="radio" name="sex_id" value="u">Unknown
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
            <input class="text-length" type="text" maxlength="11" name="animal_mother_id">
          </td>
        </tr>

        <tr>
          <td colspan=2>
            <b>Social Partner</b>
          </td>
          <td colspan=2>
            <input class="text-length" type="text" maxlength="11" name="animal_partner_id">
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
        
        if(empty($initials)){
            echo "<span style='color:red; background-color: white;'>  Warning: 'Animal Initials' cannot be empty and must be unique!</span>";
        }
        else if(empty($name)) {
            echo "<span style='color:red; background-color: white;'>  Warning: 'Animal Name' cannot be empty!</span>";
        }
        else if(empty($sex)) {
            echo "<span style='color:red; background-color: white;'>  Warning: 'Animal Sex' must be selected!</span>";
            
        }
        
    } else {
        
        $sql = "INSERT INTO animal(animal_initials, animal_Name, animal_Sex, animal_Category,
        animal_Status, animal_Mother, animal_Partner) VALUES('" . $initials . "',
        '" . $name . "','" . $sex . "', '" . $age . "','" . $status . "','" . $mother . "',
        '" . $partner . "')";
        
        if (mysqli_query($con, $sql)){
            
            echo "
            <script>
            document.getElementById('update-text').innerHTML = '<b>".$initials."</b> has been successfully added!';
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
    
    echo '<script> alert("hello world") </script>';
    
    if(empty($initials)){
        die("<font color='red'>Warning: Animal initials must be provided in order to delete a record! </font>");
    }
    
    $sql = 'DELETE FROM animal
    WHERE animal_Initials = "'.$initials.'"';
    
    $result = $con->query('SELECT animal_Initials FROM animal WHERE animal_Initials = "'.$initials.'"');
    
    $row_cnt = $result->num_rows;
    
    //    printf("Result set has %d rows.\n", $row_cnt);
    
    if($row_cnt > 0)
    {
        $retval = mysqli_query($con, $sql);
         echo "<span style='color:green; background-color: white;'>  '<b>".$initials."</b>' has been deleted successfull!</span>";
    }
    else
    {

         echo "<span style='color:red; background-color: white;'>  Error: '<b>".$initials."</b>' could not be found, please try again!</span>";

    }
    
}



?>