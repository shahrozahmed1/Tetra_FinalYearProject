<?php

ob_start();
session_start();
if(!isset($_SESSION['login_user']))
{
    // not logged in
    header('Location: index.php');
    exit();
}

include 'dv_navigation.php'; 

?>

  <!DOCTYPE html>

  <html>

  <head>
    <title>Upload</title>
  </head>

  <body>

    <div class="right-panel">
      <br>
      <h2>Upload Behaviour Data</h2>
      <form id="GPSfileUpload" action="<?=$_SERVER['PHP_SELF'];?>" method="post" enctype="multipart/form-data">
        <br>
        <h3>Select <b> Behaviour </b> file to upload</h3>
        <br>
        <input type="file" name="bcsv" id="csv_id">
        <button type="sumbit" name="submit2">Upload</button>
      </form>

      <div id="text-update"></div>

    </div>
  </body>

  </html>


  <?php


//load the database configuration file
include 'dv_dbConnection.php';


function format_Date($date){
    $date = str_replace('/', '-', $date);
    $event_date = date('Y-m-d', strtotime($date));
    return $event_date;
}

function format_null($data) {
    if($data == "NA") {
        $data = NULL;
    }
    return $data;
}

if(isset($_POST['submit2'])) {
    
    $fname = $_FILES['bcsv']['name'];
    
    // echo 'upload file name: '.$fname.' .. ';
    
    $check_ext = explode(".", $fname);
    // check it is a csv file
    if(strtolower(end($check_ext)) == "csv") {
        // uploaded file handling
        $filename = $_FILES['bcsv']['tmp_name'];
        if(($handle = fopen($filename, "r")) !== FALSE){
            
            // write errors for data that was unsuccessful in uploading
            $fileErrors = fopen("unsuccessful_behaviour_data.txt", "w") or die("Unable to open error file!");
            
            fgetcsv($filename);
            
            while (($data = fgetcsv($handle, 1000, ",")) != FALSE)
            {
                
                $num = count($data);
                
                // start from 1 as 0 line is description
                for ($c = 0; $c < $num; $c++) {
                    $col[$c] = $data[$c];
                }
                
                $id = $col[0];
                $animalID = $col[11];
                $date = $col[2];
                $time = $col[7];
                $behvaiour = $col[18];
                $social_beaviour = $col[33];
                $tree = $col[28];
                $tree_height = $col[27];
                $animal_height = $col[26];
                $posture = $col[20];
                
                // formatting
                $fSocialBehaviour = format_null($social_beaviour);
                $fTree = format_null($tree);
                $fTreeHeight = format_null($tree_height);
                $fAnimalHeight = format_null($animal_height);
                $fPosture = format_null($posture);
                
                $formated_date = format_Date($date);
                
                // ignore first line
                if($id !== 'Observation No') {
                    $behaviourData = "INSERT INTO observations(
                    observation_ID, observation_Animal, observation_Date,
                    observation_Time, observation_Behaviour, observation_Social_Behaviour,
                    observation_Tree, observation_Tree_Height, observation_Animal_Height,
                    observation_Posture) values(
                    '".$id."','".$animalID."','".$formated_date."',
                    '".$time."','".$behvaiour."','".$fSocialBehaviour."',
                    '".$fTree."','".$fTreeHeight."','".$fAnimalHeight."',
                    '".$fPosture."')";
                    
                    $location_AI;
                    if (mysqli_query($con, $behaviourData)){
                    } else {
                        $error = " Error: " . $gpsData . "<br>" . mysqli_error($con);
                        fwrite($fileErrors, $error);
                    }
                }
                
            }
            
            fclose($handle);
            fclose($fileErrors);
            
            //$textMsg += "Successfully Imported!";
            echo '<script type="text/javascript">
            document.getElementById("text-update").innerHTML = "Successfully Imported!";
            </script>';
            
        }
    }
    else {
        echo "Invalid File";
    }
    unlink($filename);
    mysqli_close($con);
    
}




?>