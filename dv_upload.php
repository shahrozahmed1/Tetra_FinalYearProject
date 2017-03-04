<?php

ob_start();
session_start();
if(!isset($_SESSION['login_user']) || !isset($_SESSION['admin_is_logged']))
{
    // not logged in
    header('Location: index.php');
    exit();
}

?>

  <!DOCTYPE html>

  <?php
include 'dv_navigation.php';
?>

    <html>

    <script>
      function locationDelete() {
        if (confirm("You are about to delete all location records!") == true) {
          document.getElementById("deleteGPSId").value = "Deleted";
        }

      }


      function behaviourDelete() {
        if (confirm("You are about to delete all behaviour records!") == true) {
          document.getElementById("bDeleteId").value = "Deleted";
        }

      }
    </script>


    <head>


      <style>
        input {
          -webkit-appearance: none;
          -moz-appearance: none;
          padding: 3px;
          margin: 5px 0;
          border: solid 1px #999;
        }
        
        .leftpanel {
          float: left;
          margin-left: 50px;
        }
        
        .rightpanel {
          float: left;
          margin-left: 50px;
        }
        
        table {
          border-collapse: collapse;
        }
        
        table,
        th,
        td {
          border: 1px solid black;
        }
        
        input[type=submit] {
          padding: 3px 15px;
          background-color: #d8d8d8;
        }
        
        input[type=file] {}
        
        ::-ms-browse {
          background: black;
          color: red;
          padding: 1em;
        }
        
        input[type=button] {
          padding: 3px 15px;
          background-color: #d8d8d8;
        }
        
        .text-update1 {
          color: red;
        }
        
        .text-update2 {
          color: red;
        }
        
        .fileUpload {
          position: relative;
          overflow: hidden;
          width: 40px;
          border: 1px solid #ccc;
          background-color: #d8d8d8;
          box-shadow: inset 0 1px 3px rgba(0, 0, 0, .1);
          float: right;
          font-size: 13px;
          text-align: center;
          height: 15px;
          padding: 2px 12px 2px 12px;
          margin: 5px;
          background-color: #d8d8d8;
          border: 1px solid #999999 !important;
          border-radius: 1px!important;
        }
        
        .fileUpload input[type=file] {
          position: absolute;
          top: 0;
          right: 0;
          cursor: pointer;
          opacity: 0;
          filter: alpha(opacity=0);
        }
        
        .placeholder {
          display: inline-block;
          margin-right: 5px;
          width: 200px;
          float: left;
        }
        
        .choose {
          display: inline-block;
          width: 220px;
        }
        
        .heading-file {
          text-align: center;
          height: 30px;
        }
      </style>

      <title>Upload</title>
    </head>

    <body>

      <div class="leftpanel">
        <br>
        <h3> Animal GPS Location Data File </h3>
        <form id="GPSfileUpload" action="<?=$_SERVER['PHP_SELF'];?>" method="post" enctype="multipart/form-data">
          <table border=5 width=150 cellpadding=10>
            <tr>
              <td colspan=2>
                <div class="heading-file">
                  <h6>Select CSV GPS location file to upload</h6> </div>
              </td>
            </tr>
            <tr>
              <td colspan=2>
                <div class="choose">
                  <input id="uploadFile" placeholder="Choose file.." disabled="disabled" />

                  <div class="fileUpload btn btn-primary">
                    <span>Select</span>
                    <input id="uploadBtn" type="file" name="csv" />
                  </div>
                </div>
              </td>
              <td colspan=1>
                <input type="submit" name="submit" value="Upload" />
              </td>

              <td colspan=1>
                <input type="submit" name="deleteGPS" id="deleteGPSId" value="Delete All" onclick="locationDelete()" />
              </td>
            </tr>
          </table>
        </form>
        <br>
        <div class="text-update1" id="text-update1"></div>
      </div>

      <div class="rightpanel">
        <br>
        <h3> Animal Behaviour Data File </h3>
        <form id="BehfileUpload" action="<?=$_SERVER['PHP_SELF'];?>" method="post" enctype="multipart/form-data">
          <table border=5 width=150 cellpadding=10>
            <td colspan=2>
              <div class="heading-file">
                <h6>Select CSV behaviour file to upload</h6> </div>
            </td>
            </tr>
            <tr>
              <td colspan=2>
                <div class="choose">
                  <input id="uploadFile" placeholder="Choose file.." disabled="disabled" />

                  <div class="fileUpload btn btn-primary">
                    <span>Select</span>
                    <input type="file" name="bcsv" id="csv_id" />
                  </div>
                </div>
              </td>
              <td colspan=2>
                <input type="submit" name="submit2" value="Upload" />
              </td>
              <td colspan=2>
                <input type="submit" name="deleteBeh" id="bDeleteId" value="Delete All" onclick="behaviourDelete()" />
              </td>
            </tr>
          </table>
        </form>
        <br>
        <div class="text-update2" id="text-update2"></div>
      </div>
    </body>

    </html>

    <script>
      document.getElementById("uploadBtn").onchange = function() {
        document.getElementById("uploadFile").value = this.value;
      };
    </script>


    <?php

//load the database configuration file
include 'dv_dbConnection.php';

function format_Date($date){
    $date = str_replace('/', '-', $date);
    $event_date = date('Y-m-d', strtotime($date));
    return $event_date;
}

// format null values
function format_null($data) {
    if($data == "NA") {
        $data = NULL;
    }
    return $data;
}

// Check format of date
function check_date_format($field){
    if (preg_match("/[0-9]{4}[\-\s.\/][01][0-9][\-\s.\/][0-2][0-9]/",$field) ||
    preg_match("/[0-2][0-9][\-\s.\/][01][0-9][\-\s.\/][0-9]{4}/",$field) ||
    preg_match("/[0-2][0-9][\-\s.\/][\w]{3}[\-\s.\/][0-9]{4}/",$field) ||
    preg_match("/[0-2][0-9][\-\s.\/][\w]{3}[\-\s.\/][0-9]{2}/",$field) ||
    preg_match("/[0-2][0-9][\-\s.\/][0-1]+[0-9][\-\s.\/][0-9]{2}/",$field))
    {
        return true;
    } else {
        return false;
    }
}

// Check time format
function format_Time($time){
    if(preg_match("/(2[0-3]|[01][0-9])[:]?([0-5][0-9])/", $time)){
        return true;
    } else {
        return false;
    }
}



// if submitted location data
if(isset($_POST['submit'])) {
    
    $fname = $_FILES['csv']['name'];
    
    // echo 'upload file name: '.$fname.' .. ';
    
    $check_ext = explode(".", $fname);
    // check it is a csv file
    if(strtolower(end($check_ext)) == "csv") {
        // uploaded file handling
        $filename = $_FILES['csv']['tmp_name'];
        if(($handle = fopen($filename, "r")) !== FALSE){
            
            // write errors for data that was unsuccessful in uploading
            //$fileErrors = fopen("unsuccessful_data.txt", "w") or die("Unable to open error file!");
            
            
            // fgetcsv($filename);
            
            while (($data = fgetcsv($handle, 1000, ",")) != FALSE)
            {
                
                $num = count($data);
                
                // start from 1 as 0 line is description
                for ($c = 0; $c < $num; $c++) {
                    $col[$c] = $data[$c];
                }
                
                $col1 = $col[0];
                $col2 = $col[1];
                $col4 = $col[3];
                $col5 = $col[4];
                $col6 = $col[5];
                $col7 = $col[6];
                $col8 = $col[7];
                
                // temp assign the value current animal id
                $temp_id = substr($col5, 0, 2);
                $lower_case_id = strtolower($temp_id);
                //echo $temp_id;
                
                
                $formated_date = format_Date($col7);
                $formated_time = format_Time($col8);
                
                // if time stamp then extract time
                if(check_date_format($col8)){
                    
                    $get_time = strstr($col8, 'T');
                    $remove_first = substr($get_time, 1);
                    $formated_time = substr($remove_first, 0, -1);
                }
                
                $format_altitude = format_null($col4);
                
                // ignore first line ('de' of description)
                if($lower_case_id !== 'de') {
                    $gpsData = "INSERT INTO location(
                    location_Animal, location_Latitude, location_Longitude,
                    location_Altitude, location_Date, location_Time,
                    location_Symbol, location_Description) values(
                    '".$lower_case_id."','".$col1."','".$col2."',
                    '".$format_altitude."','".$formated_date."','".$formated_time."',
                    '".$col6."','".$col5."')";
                    
                    $location_AI;
                    if (mysqli_query($con, $gpsData)){
                        $location_AI = mysqli_insert_id($con);
                    } else {
                        $error = " Warning: " . $gpsData . "<br>" . mysqli_error($con);
                        // fwrite($fileErrors, $error);
                        // echo $error;
                        
                        // echo "<span style='color:red;'> <i>".$error."</i></span>";
                    }
                }
                
            }
            
            fclose($handle);
            // fclose($fileErrors);
            
            //$textMsg += "Successfully Imported!";
            
            echo '<script type="text/javascript">
            document.getElementById("text-update1").innerHTML = "Successfully imported GPS data! <br>";
            </script>';
            
        }
    }
    else {
        echo '<script type="text/javascript">
        document.getElementById("text-update1").innerHTML = "Error: Invalid GPS file type, please try again! <br>";
        </script>';
    }
    unlink($filename);
    mysqli_close($con);
    
}

// if the subitted the behaviour file
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
            // $fileErrors = fopen("unsuccessful_behaviour_data.txt", "w") or die("Unable to open error file!");
            
            // fgetcsv($filename);
            
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
                    
                    if (mysqli_query($con, $behaviourData)){
                    } else {
                        $error = " Warning: " . $behaviourData . "<br>" . mysqli_error($con). "<br>";
                        // fwrite($fileErrors, $error);
                        // echo $error;
                        
                        // echo "<span style='color:red;'> <i>".$error."</i></span>";
                    }
                }
                
            }
            
            fclose($handle);
            // fclose($fileErrors);
            
            //$textMsg += "Successfully Imported!";
            echo '<script type="text/javascript">
            document.getElementById("text-update2").innerHTML = "Successfully imported behaviour data! <br>";
            </script>';
            
        }
    }
    else {
        echo '<script type="text/javascript">
        document.getElementById("text-update2").innerHTML = "Error: Invalid behaviour file type, please try again! <br>";
        </script>';
    }
    // unlink($filename);
    mysqli_close($con);
    
}


if(isset($_POST['deleteGPS'])) {
    $deleteloc = $_POST['deleteGPS'];
    if($deleteloc == 'Deleted') {
        mysqli_query($con, "TRUNCATE location");
        echo "<span style='color:green; background-color: white;'> Successfully deleted all <b> location </b> records!</span>";
        
    }
}


if(isset($_POST['deleteBeh'])) {
    $deletebeh = $_POST['deleteBeh'];
    if($deletebeh == 'Deleted') {
        mysqli_query($con, "TRUNCATE observations");
        
        echo "<span style='color:green; background-color: white;'> Successfully deleted all <b> observation </b> records!</span>";
        
    }
}



?>