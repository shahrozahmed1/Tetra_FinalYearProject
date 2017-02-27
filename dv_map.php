<?php 
ob_start();
session_start();
if(!isset($_SESSION['login_user']))
{
    // not logged in
    header('Location: index.php');
    exit();
}

?>

<!DOCTYPE html>
<html>

<?php
include 'dv_mapSearch.php';
?>

  <head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <title>Tetra</title>
    <style>
      /* Always set the map height explicitly to define the size of the div
* element that contains the map. */
      
      #map {
        height: 80%;
        min-height: 590px;
        width: 80%;
        float: right;
        top: 3%;
      }
    </style>
  </head>

  <body>

    <script>
      var jsArray = <?php echo json_encode($database_array); ?>;
      window.localStorage.setItem("jsArray", JSON.stringify(jsArray));

      // set display marker checkbox
      var jsMarkers = <?php echo json_encode($displayMarkers); ?>;
      window.localStorage.setItem("markers", JSON.stringify(jsMarkers));

      // set display marker cluster checkbox
      var jsClusters = <?php echo json_encode($displayCluster); ?>;
      window.localStorage.setItem("clusters", JSON.stringify(jsClusters));

      // set  display heatmap checkbox

      var jsHeatmap = <?php echo json_encode($displayHeatmap); ?>;
      window.localStorage.setItem("heatmap", JSON.stringify(jsHeatmap));
    </script>

      <div id="map"></div>

      <!-- javascript -->
      <script type="text/javascript" src="js/plot.js">
      </script>

      <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyATUGW7_9hN-yhFDWCGXK0i2dOdPe_DTsA&libraries=visualization&callback=initMap">
      </script>

  </body>

</html>

<?php

// Closes the connection with the database
mysqli_close($con);

?>
