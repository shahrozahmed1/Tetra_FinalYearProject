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
include 'dv_graphSearch.php';
?>

  <!DOCTYPE html>
  <html>

  <head>
    <link rel="stylesheet" type="text/css" href="styles/styles.css">
    <title>
      Graph Analysis
    </title>

    <!--
<style>
#chart-container {
    height: auto;
    width: 80%;
    float: right;
    top: 10%;
}
</style>
-->

  </head>

  <body>
      <div id="chart-container">
        <canvas id="mycanvas"> </canvas>
      </div>

    <!-- javascript -->
    <script type="text/javascript" src="js/jquery.min.js"></script>
    <script type="text/javascript" src="js/Chart.min.js"></script>
    <script type="text/javascript" src="js/charts.js"></script>

  </body>

  </html>