<!DOCTYPE html>
<html>

<head>
  <style>
    body {
      margin: 0;
    }
    
    ul {
      list-style-type: none;
      margin: 0;
      padding: 0;
      overflow: hidden;
      background-color: #333;
      position: fixed;
      top: 0;
      width: 100%;
      min-width:700px;
    }
    
    li {
      float: left;
    }
    
    li a {
      display: block;
      color: white;
      text-align: center;
      padding: 14px 16px;
      text-decoration: none;
    }
    
    li a:hover:not(.active) {
      background-color: #111;
    }
    
    .active {
      
      background-color: #4CAF50;
    }
  </style>
</head>

<body>

  <ul>
    <li><a href="http://www.nocturama.org/en/welcome-little-fireface-project/">Home</a></li>
    <li><a href="index.php">Map Analysis</a></li>
    <li><a href="dv_graph.php">Graph Analysis</a></li>
    <li><a href="dv_upload.php">Upload Data</a></li>
    <li><a href="dv_addAnimal.php">Insert Animal</a></li>
    <li><a href="Login.php">Login</a></li>
  </ul>

  <div style="padding:20px;margin-top:45px;background-color:DarkSeaGreen; min-height:700px; height:100%;">
<!--  background-color: F3EEE5; -->

</body>

</html>