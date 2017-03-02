
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

    <title>
      About
    </title>

    <style>

    .Content {
    text-align: center;
   
  }
    </style>

  </head>

  <body>

<div class="Content">

    <h2>About</h2>
    
    <img src="images/loris_burned.png" class="w3-image w3-padding-32" width="150" height="215">
      <p>

      Tetra version 2.0 is a web-based data visualisation prototype system,
      developed in partnership with LFP (Little Fireface Project) in order to help LFP 
      researchers analyse the behaviour of endangered species. 
      Data that can be extracted from Tetra 2.0 could help LFP team produce useful reports, 
      which could later be utilised in order to introduce new protection action and 
      international policies.
      Tetra 2.0 enables the LFP researchers to able to visualise the stored data on
      Tetra in a way, which is most convenient while carrying out animal behaviour analysis. 
      <br> <br>
      For more information, visit the Little Fireface Project <a href="http://www.nocturama.org/en/welcome-little-fireface-project/">website</a>.
  
    <br>

    </div>

  </body>

  </html>