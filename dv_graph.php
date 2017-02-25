<?php
include 'dv_navigation.php';
include 'dv_graphSearch.php';
?>

  <!DOCTYPE html>
  <html>

  <head>

    <title>
      Graph Analysis
    </title>

    <style>
      #chart-container {
        height: auto;
        width: 80%;
        float: right;
        top: 10%;
      }
    </style>

  </head>

  <body>

    <div id="chart-container">
      <br>
      <br>
      <canvas id="mycanvas"> </canvas>
    </div>

    <!-- javascript -->
    <script type="text/javascript" src="js/jquery.min.js"></script>
    <script type="text/javascript" src="js/Chart.min.js"></script>
    <script type="text/javascript" src="js/charts.js"></script>

    <script> /*
      var jsBehArray = JSON.parse(window.localStorage.getItem("jsBehArray"));

      console.log(jsBehArray);

      console.log("new update here");

      var size_arr = jsBehArray[0].length;

      var column1 = [];
      var occurrence = [];

      var chartType = jsBehArray[2][1];

      topLabel = "";
      bottomLabel = "";
      leftLabel = "";

      if (chartType == "activity") {
        topLabel = "Activity Budget";
        bottomLabel = "Behaviour Type";
        leftLabel = "Percentage (%)";

      } else if (chartType == "tree") {
        topLabel = "Tree Species Usage";
        bottomLabel = "Tree Specie";
        leftLabel = "Percentage (%)";

      } else if (chartType == "altitude") {
        topLabel = "Altitude Usage";
        bottomLabel = "Animal Name";
        leftLabel = "Meters";

      }

      if (chartType !== "altitude") {
        for (var i = 0; i < size_arr; i++) {
          column1.push(jsBehArray[0][i]);
          occurrence.push(((jsBehArray[1][i] / jsBehArray[2][0]) * 100.00));
        }
      } else {
        for (var i = 0; i < size_arr; i++) {
          column1.push(jsBehArray[0][i]);
          occurrence.push(jsBehArray[1][i]);
        }
      }

      var chartdata = {
        labels: column1,
        datasets: [{
          label: topLabel,
          backgroundColor: 'rgba(200, 200, 200, 0.75)',
          borderColor: 'rgba(200, 200, 200, 0.75)',
          hoverBackgroundColor: 'rgba(200, 200, 200, 1)',
          hoverBorderColor: 'rgba(200, 200, 200, 1)',

          data: occurrence
        }]
      };

      var ctx = $("#mycanvas");

      var barGraph = new Chart(ctx, {
        type: 'bar',
        data: chartdata,
        options: {
          legend: {
            labels: {
              fontColor: "black",
              fontSize: 18
            }
          },
          scales: {
            yAxes: [{
              scaleLabel: {
                fontColor: "black",
                display: true,
                labelString: leftLabel
              }
            }],
            xAxes: [{
              scaleLabel: {
                fontColor: "black",
                display: true,
                labelString: bottomLabel
              }
            }]
          }
        }
      }); */
    </script>


  </body>

  </html>