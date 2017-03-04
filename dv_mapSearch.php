<?php
ob_start();
if(!isset($_SESSION['login_user']))
{
    // not logged in
    header('Location: index.php');
    exit();
}

?>

  <!DOCTYPE html>
  <html>

  <head>
    <link rel="stylesheet" type="text/css" href="styles/styles.css">
    <title>
      Map Analysis
    </title>

  </head>

  <body>

    <div class="errorClass">
      <span id="update-text" style="color:red">
</div>

<div class="sidebar">
<!--<ul class="filter_nav">-->

<form class="map-search" action="<?=$_SERVER['PHP_SELF'];?>" method="post">
<div class="top">
<input type="text" name="search" maxlength="3" placeholder="Enter animal initials.."/>
<input type="submit" value="Search" />
</div>

<ul class="map-type">
<li><label class="control control--checkbox">Marked Trajectories
<input type="checkbox" name="markers" id="markersid" onclick="enableMarkeredTraj()" />
<div class="control__indicator"></div></label></li>

<li><label class="control control--checkbox">Marker Clustering
<input type="checkbox" name="clusters" id="clustersid" onclick="enableClusters()" />
<div class="control__indicator"></div></label></li>

<li><label class="control control--checkbox">Heatmap
<input type="checkbox" name="heatmap" id="heatmapid" onclick="disableAllMarkers()" />
<div class="control__indicator"></div></label></li>
</ul>

<!-- Align it in the middle of the -->

<div class="refine-by">
<h1 class="subtitle">Refine by</h1>

<div align="left">
<h2> Date/Time </h2>
<p> From: </p>
<input type="date" name="fdate">
<input type="time" name="ftime">
<p> To: </p>

<input type="date" name="tdate">

<input type="time" name="ttime">
<h2> Altitude </h2>
<div class="input-wrapper">
<p>Min:</p>
<input type="number" name="minAlt" id="inputMin" min="0" max="5000" maxlength="4">
<p>&nbsp; &nbsp; Max:</p>
<input type="number" name="maxAlt" id="inputMax" min="0" max="5000" maxlength="4">
</div>
</div>
</div>
<div class="animal-details">
<h1 class="subtitle">Animal Details</h1>
<table border=1 width=160 cellpadding=0>
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
      <input type="button" onclick="myFunction()" value="Print this page" />
    </div>

    </form>

    </div>

  </body>

  <script>
    function enableMarkeredTraj() {
      var elem = document.getElementById('markersid').checked;
      if (elem == true) {
        document.getElementById("clustersid").disabled = true;
        document.getElementById("heatmapid").disabled = true;
      } else {
        document.getElementById("clustersid").disabled = false;
        document.getElementById("heatmapid").disabled = false;
      }
    }

    function enableClusters() {
      var elem = document.getElementById('clustersid').checked;
      if (elem == true) {
        document.getElementById("markersid").disabled = true;
        document.getElementById("heatmapid").disabled = true;
      } else {
        document.getElementById("markersid").disabled = false;
        document.getElementById("heatmapid").disabled = false;
      }
    }

    function disableAllMarkers() {
      var elem = document.getElementById('heatmapid').checked;
      if (elem == true) {
        document.getElementById("markersid").disabled = true;
        document.getElementById("clustersid").disabled = true;
      } else {
        document.getElementById("markersid").disabled = false;
        document.getElementById("clustersid").disabled = false;
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
        $output = "Error: Could not find any results for <b>".$searchq."</b> with the refined settings, please try again!";
            
        echo "
        <script>
        document.getElementById('update-text').innerHTML = 'Error: Could not find any results for <b>".$searchq."</b> with the refined settings, please try again!';
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