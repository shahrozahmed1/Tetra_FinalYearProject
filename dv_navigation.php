<!DOCTYPE html>
<html>

<head>
  <style>
    body {
      margin: 0;
      height: 100vh;
      background: url("images/loris_venom.jpg") 50% fixed;
      background-size: cover;
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
      min-width: 750px;
    }
    
    li {
      float: left;
    }
    
    ri {
      float: right;
    }
    
    ri a {
      display: block;
      color: white;
      text-align: center;
      padding: 14px 16px;
      text-decoration: none;
    }
    
    ri a:hover:not(.active) {
      background-color: #111;
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
    <li><a href="dv_map.php">Map Analysis</a></li>
    <li><a href="dv_graph.php">Graph Analysis</a></li>

    <?php

if(isset($_SESSION['admin_is_logged'])) {?>
      <li><a href="dv_upload.php">Upload Data</a></li>
      <li><a href="dv_addAnimal.php">Insert Animal</a></li>
      <li><a href="dv_addUser.php">Insert User</a></li>
      <?php } ?>

        <li><a href="dv_about.php">About</a></li>
        <ri><a href="dv_logout.php">Log Out</a></ri>
  </ul>

  <div style="padding:30px; margin-top:45px; top: 5%; background-color:rgba(143,188,143, 0.98); height:100%;">

  

</body>

</html>
