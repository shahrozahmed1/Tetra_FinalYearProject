<?php include 'dv_navigation.php'; ?>

  <!DOCTYPE html>
  <html>

  <head>

    <style>
      .filter_nav {
        background-color: DarkSeaGreen;
        position: fixed;
        top: 10%;
        width: 16%;
        min-width: 200px;
        min-height: 595px;
        max-width: 200px;
        border-right: 5px solid #313836;
        border-left: 2px solid #313836;
        border-bottom: 5px solid #313836;
        border-top: 2px solid #313836;
      }
      
      .sidebar {
        float: left;
      }
      
      .errorClass {
        float: right;
        background-color: white;
      }
    </style>

    <title>
      Map Analysis
    </title>

  </head>

  <body>

    <div class="errorClass">
      <span id="update-text" style="color:red"> 
      </div>

      <div class="sidebar">

        <ul class="filter_nav">

          <form action="<?=$_SERVER['PHP_SELF'];?>" method="post">
            <div align="center">
              <input type="text" name="search" maxlength="3" placeholder "Search for animal.."/>
              <input type="submit" value="Search" />
            </div>

            <br>
            <div align="left">
              <input type="checkbox" name="markers" id="markers" onclick="enableMarkeredTraj()" /> Markered Trajectories
              <br>
              <input type="checkbox" name="clusters" id="clusters" onclick="enableClusters()" /> Markers Clustering
              <br>
              <input type="checkbox" name="heatmap" id="heatmap" onclick="disableAllMarkers()" /> Heatmap
            </div>

            <!-- Align it in the middle of the -->
            <br>
            <div align="center">
              <u><b>Refine by</b></u>
            </div>

            <div align="left">
              <br>
              <b> Date/Time </b>
              <br> <i> From: </i>
              <br>
              <input type="date" name="fdate">
              <br>
              <input type="time" name="ftime">
              <br>
              <i> To: </i>
              <br>
              <input type="date" name="tdate">
              <br>
              <input type="time" name="ttime">
              <br>
              <br> <b> Altitude </b>
              <br> <i>Min:</i>
              <input type="number" name="minAlt" id="inputMin" min="0" max="5000" maxlength="4">
              <i> &nbsp; Max:</i>
              <input type="number" name="maxAlt" id="inputMax" min="0" max="5000" maxlength="4">
              <br>
              <br>
            </div>

            <div align="center">
              <u><b>  Animal Details </b></u>
              <br>
              <br>
              <table border=1 width=150 cellpadding=0>
                <tr>
                  <td colspan=2>
                    ID: <span id="initialsId" style="color:blue">  </span>
                  </td>
                </tr>
                <tr>
                  <td colspan=2>
                    Name: <span id="nameId" style="color:blue">  </span>
                  </td>
                </tr>
                <tr>
                  <td colspan=2>
                    Sex:
                    <span id="sexId" style="color:blue">  </span>
                  </td>
                </tr>
                <tr>
                  <td colspan=2>
                    Age Category:
                    <span id="ageCatId" style="color:blue">  </span>
                  </td>
                </tr>
                <tr>
                  <td colspan=2>
                    Mother:
                    <span id="motherId" style="color:blue">  </span>
                  </td>
                </tr>
                <tr>
                  <td colspan=2>
                    Partner:
                    <span id="partnerId" style="color:blue">  </span>
                  </td>
                </tr>
              </table>
              <br>

              <button onclick="myFunction()">Print this page</button>
            </div>

          </form>

        </ul>

      </div>

  </body>

  <script>
    function enableMarkeredTraj() {
      var elem = document.getElementById('markers').checked;
      if (elem == true) {
        document.getElementById("clusters").disabled = true;
        document.getElementById("heatmap").disabled = true;
      } else {
        document.getElementById("clusters").disabled = false;
        document.getElementById("heatmap").disabled = false;
      }
    }

    function enableClusters() {
      var elem = document.getElementById('clusters').checked;
      if (elem == true) {
        document.getElementById("markers").disabled = true;
        document.getElementById("heatmap").disabled = true;
      } else {
        document.getElementById("markers").disabled = false;
        document.getElementById("heatmap").disabled = false;
      }
    }

    function disableAllMarkers() {
      var elem = document.getElementById('heatmap').checked;
      if (elem == true) {
        document.getElementById("markers").disabled = true;
        document.getElementById("clusters").disabled = true;
      } else {
        document.getElementById("markers").disabled = false;
        document.getElementById("clusters").disabled = false;
      }
    }

    function myFunction() {
      window.print();
    }
  </script>

  </html>


  <?php


include("dv_dbConnection.php");


$database_array = array();

$output = '';
$searchq = '';
$count = 0;
if(isset($_POST['search'])) {
    
    // get search text and put it as lowercase
    $searchq = $_POST['search'];
    $searchq = preg_replace("#[^0-9a-z]#i", "", $searchq);
    
    $sql = "SELECT * FROM location WHERE location_Animal = '$searchq'";
    
    // all min and max altitude
    // set altitude
    $minAlt = $_POST['minAlt'];
    $maxAlt = $_POST['maxAlt'];
    
    $altGiven = False;
    if (!empty($minAlt) || !empty($maxAlt)) {
        $altGiven = True;
        
        if (!empty($minAlt) and !empty($maxAlt)) {
            $sql = "SELECT * FROM location WHERE location_Animal = '$searchq'
            
            AND location_Altitude >= '$minAlt' AND location_Altitude <= '$maxAlt'";
        } else if (!empty($minAlt) and empty($maxAlt)) {
            $sql = "SELECT * FROM location WHERE location_Animal = '$searchq'
            AND location_Altitude >= '$minAlt'";
        } else if (empty($minAlt) and !empty($maxAlt)) {
            $sql = "SELECT * FROM location WHERE location_Animal = '$searchq'
            AND location_Altitude <= '$maxAlt'";
        }
    }
    
    // change command if date is selected
    $fDate = $_POST['fdate'];
    $tDate = $_POST['tdate'];
    if (!empty($fDate) and !empty($tDate)) {
        $sql = "SELECT * FROM location WHERE location_Animal = '$searchq' AND
        location_Date >= '$fDate' AND location_Date <= '$tDate'";
        
        // set time - if time and date given
        $fTime = $_POST['ftime'];
        $tTime = $_POST['ttime'];
        if (!empty($fTime) and !empty($tTime) and ($fDate == $tDate)) {
            $sql = "SELECT * FROM location WHERE location_Animal = '$searchq' AND
            location_Date >= '$fDate' AND location_Time >= '$fTime' AND
            location_Date <= '$tDate' AND location_Time <= '$tTime'";
            
            // altitude with date and time
            if ($altGiven) {
                if (!empty($minAlt) and !empty($maxAlt)) {
                    $sql = "SELECT * FROM location WHERE location_Animal = '$searchq' AND
                    location_Date >= '$fDate' AND location_Time >= '$fTime' AND
                    location_Date <= '$tDate' AND location_Time <= '$tTime'
                    AND location_Altitude >= '$minAlt' AND location_Altitude <= '$maxAlt'";
                } else if (!empty($minAlt) and empty($maxAlt)) {
                    $sql = "SELECT * FROM location WHERE location_Animal = '$searchq' AND
                    location_Date >= '$fDate' AND location_Time >= '$fTime' AND
                    location_Date <= '$tDate' AND location_Time <= '$tTime'
                    AND location_Altitude >= '$minAlt'";
                } else if (empty($minAlt) and !empty($maxAlt)) {
                    $sql = "SELECT * FROM location WHERE location_Animal = '$searchq' AND
                    location_Date >= '$fDate' AND location_Time >= '$fTime' AND
                    location_Date <= '$tDate' AND location_Time <= '$tTime'
                    AND location_Altitude <= '$maxAlt'";
                }
            }
            
            // else if no time given then filter altitude with dates
        } else if ($altGiven) {
            if (!empty($minAlt) and !empty($maxAlt)) {
                $sql = "SELECT * FROM location WHERE location_Animal = '$searchq' AND
                location_Date >= '$fDate' AND location_Date <= '$tDate'
                AND location_Altitude >= '$minAlt' AND location_Altitude <= '$maxAlt'";
            } else if (!empty($minAlt) and empty($maxAlt)) {
                $sql = "SELECT * FROM location WHERE location_Animal = '$searchq' AND
                location_Date >= '$fDate' AND location_Date <= '$tDate'
                AND location_Altitude >= '$minAlt'";
            } else if (empty($minAlt) and !empty($maxAlt)) {
                $sql = "SELECT * FROM location WHERE location_Animal = '$searchq' AND
                location_Date >= '$fDate' AND location_Date <= '$tDate'
                AND location_Altitude <= '$maxAlt'";
            }
        }
    }
    
    $filter = mysqli_query($con, $sql);
    $count = mysqli_num_rows($filter);
    
    if($count == 0) {
        $output = "<b>".$searchq."</b> could not be found, please enter animal initials again!";
        
        echo "
        <script>
        document.getElementById('update-text').innerHTML = 'Error: \'<b>".$searchq."</b>\' could not be found, please try again';
        </script>
        ";
        
        
    }
    else {
        
        $name_array = array();
        $latitude_array = array();
        $longitude_array = array();
        $altitude_array = array();
        $date_array = array();
        $time_array = array();
        $symbol_array = array();
        
        while($row = mysqli_fetch_array($filter, MYSQLI_ASSOC)){
            
            $name = $row['location_Animal'];
            $latitude = $row['location_Latitude'];
            $longitude = $row['location_Longitude'];
            $altitude = $row['location_Altitude'];
            $date = $row['location_Date'];
            $time = $row['location_Time'];
            $symbol = $row['location_Symbol'];
            
            //   $output .= '<div> '.$name.' '.$latitude.' '.$longitude.'</div>';
            
            array_push($name_array, $name);
            array_push($latitude_array, $latitude);
            array_push($longitude_array, $longitude);
            array_push($altitude_array, $altitude);
            array_push($date_array, $date);
            array_push($time_array, $time);
            array_push($symbol_array, $symbol);
        }
        
        array_push($database_array, $name_array, $latitude_array, $longitude_array, $altitude_array,
        $date_array, $time_array, $symbol_array);
        
    }
}

// get details of the animal and display on GUI
if($count != 0){
    
    $sql_animal = "SELECT * FROM animal WHERE animal_Initials = '$searchq'";
    
    $animal_details = mysqli_query($con, $sql_animal);
    
    while($row = mysqli_fetch_array($animal_details, MYSQLI_ASSOC)){
        
        $db_initials = $row['animal_Initials'];
        $db_name = $row['animal_Name'];
        $db_sex = $row['animal_Sex'];
        $db_age_cat = $row['animal_Category'];
        $db_mother = $row['animal_Mother'];
        $db_partner = $row['animal_Partner'];
        
        $db_name = str_replace('_', ' ', $db_name);
        $db_mother = str_replace('_', ' ', $db_mother);
        $db_partner = str_replace('_', ' ', $db_partner);
        
        // run the javascript inside php - displays animal information
        echo "
        <script>
        document.getElementById('initialsId').innerHTML = '".strtoupper($db_initials)."';
        document.getElementById('nameId').innerHTML = '".ucfirst($db_name)."';
        document.getElementById('sexId').innerHTML = '".ucfirst($db_sex)."';
        document.getElementById('ageCatId').innerHTML = '".ucfirst($db_age_cat)."';
        document.getElementById('motherId').innerHTML = '".ucfirst($db_mother)."';
        document.getElementById('partnerId').innerHTML = '".ucfirst($db_partner)."';
        </script>
        ";
    }
}


// display markers settings
$displayMarkers = false;
if (isset($_POST['markers'])){
    $displayMarkers = true;
}

// display cluster settings
$displayCluster = false;
if (isset($_POST['clusters'])){
    $displayCluster = true;
}

// display heatmap settings
$displayHeatmap = false;
if (isset($_POST['heatmap'])){
    $displayHeatmap = true;
}

?>