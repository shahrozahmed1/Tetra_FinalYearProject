<?php
ob_start();
// session_start();
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

    <!--
.filter_nav {
    background-color: DarkSeaGreen;
    position: fixed;
    top: 10%;
    width: 16%;
    min-width: 200px;
    max-height: 595px;
    border-right: 5px solid #313836;
    border-left: 2px solid #313836;
    border-bottom: 5px solid #313836;
    border-top: 2px solid #313836;
}

.sidebar {
    float: left;
}
-->

    <style>
      input[type=text],
      select {
        width: 40%;
        margin: 8px 0;
        display: inline-block;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
      }
      

    </style>

    <title>Tetra</title>
  </head>

  <body>

    <div class="errorClass" align="center">
      <span id="update-text" style="color:red">
</span>
    </div>

    <div class="sidebar">
      <form class="map-search" action="<?= $_SERVER['PHP_SELF']; ?>" method="post" autocomplete="on">
        <div class="top">
          <b> Select Graph Type: </b>
          <br>
          <select name="graph">
            <option value="activity">Activity Budgets</option>
            <option value="altitude">Altitude Usage</option>
            <option value="tree">Tree Usage</option>
          </select>

          <input type="submit" name="btnDisplay" value="Display">
        </div>

        <div class="refine-by">
          <h1 class="subtitle">Refine by</h1>

          <ul class="map-type">
            <li>
              <label class="control control--checkbox">Male
                <input type="checkbox" name="male" id="maleid" />
                <div class="control__indicator"></div>
              </label>
            </li>

            <li>
              <label class="control control--checkbox">Female
                <input type="checkbox" name="female" id="femaleid" />
                <div class="control__indicator"></div>
              </label>
            </li>

          </ul>

          <div align="left">
            <h2> Date </h2>
            <p> From: </p>
            <input type="date" name="fdate">
            <p> To: </p>
            <input type="date" name="tdate">
          </div>
          <br>
          <input type="button" onclick="myFunction()" value="Print this page" />
          <br>

      </form>
      </div>
    </div>

  </body>

  </html>

  <script>
    function myFunction() {
      window.print();
    }
  </script>


  <?php

ob_start();
include("dv_dbConnection.php");

$behaviourDB_array = array();


if (isset($_POST['btnDisplay'])) {
    
    // get combo-box value
    $graphType = $_POST['graph'];
    
    $sql;
    $output = '';
    
    // get date
    $fDate = $_POST['fdate'];
    $tDate = $_POST['tdate'];
    
    if ($graphType == "activity") {
        
        // search query of all
        // if male female set
        if (isset($_POST['male']) and !isset($_POST['female'])) {
            
            $sql = "SELECT observations.observation_Behaviour, COUNT(*), behaviour.behaviour_Details,
            animal.animal_Sex FROM observations JOIN behaviour ON
            behaviour.behaviour_ID=observations.observation_Behaviour
            JOIN animal ON animal.animal_Initials=observations.observation_Animal
            WHERE animal.animal_Sex = 'm'
            GROUP BY observations.observation_Behaviour";
            
        } else if (isset($_POST['female']) and !isset($_POST['male'])) {
            
            
            $sql = "SELECT observations.observation_Behaviour, COUNT(*), behaviour.behaviour_Details,
            animal.animal_Sex FROM observations JOIN behaviour ON
            behaviour.behaviour_ID=observations.observation_Behaviour
            JOIN animal ON animal.animal_Initials=observations.observation_Animal
            WHERE animal.animal_Sex = 'f'
            GROUP BY observations.observation_Behaviour";
        } else {
            
            $sql = "SELECT observations.observation_Behaviour, COUNT(*), behaviour.behaviour_Details,
            animal.animal_Sex FROM observations JOIN behaviour ON
            behaviour.behaviour_ID=observations.observation_Behaviour
            JOIN animal ON animal.animal_Initials=observations.observation_Animal
            GROUP BY observations.observation_Behaviour";
            
        }
        
        
        // change command if date is selected
        if (!empty($fDate) and !empty($tDate)) {
            
            if (isset($_POST['male']) and !isset($_POST['female'])) {
                
                $sql = "SELECT observations.observation_Behaviour, COUNT(*), behaviour.behaviour_Details,
                animal.animal_Sex FROM observations JOIN behaviour ON
                behaviour.behaviour_ID=observations.observation_Behaviour
                JOIN animal ON animal.animal_Initials=observations.observation_Animal
                WHERE observations.observation_Date >= '$fDate' AND observations.observation_Date <= '$tDate'
                AND animal.animal_Sex = 'm'
                GROUP BY observations.observation_Behaviour";
                
            } else if (isset($_POST['female']) and !isset($_POST['male'])) {
                
                
                $sql = "SELECT observations.observation_Behaviour, COUNT(*), behaviour.behaviour_Details,
                animal.animal_Sex FROM observations JOIN behaviour ON
                behaviour.behaviour_ID=observations.observation_Behaviour
                JOIN animal ON animal.animal_Initials=observations.observation_Animal
                WHERE observations.observation_Date >= '$fDate' AND observations.observation_Date <= '$tDate'
                AND animal.animal_Sex = 'f'
                GROUP BY observations.observation_Behaviour";
            } else {
                
                $sql = "SELECT observations.observation_Behaviour, COUNT(*), behaviour.behaviour_Details,
                animal.animal_Sex FROM observations JOIN behaviour ON
                behaviour.behaviour_ID=observations.observation_Behaviour
                JOIN animal ON animal.animal_Initials=observations.observation_Animal
                WHERE observations.observation_Date >= '$fDate' AND observations.observation_Date <= '$tDate'
                GROUP BY observations.observation_Behaviour";
                
            }
            
            
        } else if (empty($fDate) and !empty($tDate)) {
            
            if (isset($_POST['male']) and !isset($_POST['female'])) {
                
                $sql = "SELECT observations.observation_Behaviour, COUNT(*), behaviour.behaviour_Details,
                animal.animal_Sex FROM observations JOIN behaviour ON
                behaviour.behaviour_ID=observations.observation_Behaviour
                JOIN animal ON animal.animal_Initials=observations.observation_Animal
                WHERE observations.observation_Date <= '$tDate' AND animal.animal_Sex = 'm'
                GROUP BY observations.observation_Behaviour";
                
            } else if (isset($_POST['female']) and !isset($_POST['male'])) {
                
                
                $sql = "SELECT observations.observation_Behaviour, COUNT(*), behaviour.behaviour_Details,
                animal.animal_Sex FROM observations JOIN behaviour ON
                behaviour.behaviour_ID=observations.observation_Behaviour
                JOIN animal ON animal.animal_Initials=observations.observation_Animal
                WHERE observations.observation_Date <= '$tDate' AND animal.animal_Sex = 'f'
                GROUP BY observations.observation_Behaviour";
            } else {
                
                $sql = "SELECT observations.observation_Behaviour, COUNT(*), behaviour.behaviour_Details,
                animal.animal_Sex FROM observations JOIN behaviour ON
                behaviour.behaviour_ID=observations.observation_Behaviour
                JOIN animal ON animal.animal_Initials=observations.observation_Animal
                WHERE observations.observation_Date <= '$tDate'
                GROUP BY observations.observation_Behaviour";
                
            }
            
            
        } else if (!empty($fDate) and empty($tDate)) {
            
            if (isset($_POST['male']) and !isset($_POST['female'])) {
                
                $sql = "SELECT observations.observation_Behaviour, COUNT(*), behaviour.behaviour_Details,
                animal.animal_Sex FROM observations JOIN behaviour ON
                behaviour.behaviour_ID=observations.observation_Behaviour
                JOIN animal ON animal.animal_Initials=observations.observation_Animal
                WHERE observations.observation_Date >= '$fDate' AND animal.animal_Sex = 'm'
                GROUP BY observations.observation_Behaviour";
                
            } else if (isset($_POST['female']) and !isset($_POST['male'])) {
                
                $sql = "SELECT observations.observation_Behaviour, COUNT(*), behaviour.behaviour_Details,
                animal.animal_Sex FROM observations JOIN behaviour ON
                behaviour.behaviour_ID=observations.observation_Behaviour
                JOIN animal ON animal.animal_Initials=observations.observation_Animal
                WHERE observations.observation_Date >= '$fDate' AND animal.animal_Sex = 'f'
                GROUP BY observations.observation_Behaviour";
            } else {
                
                $sql = "SELECT observations.observation_Behaviour, COUNT(*), behaviour.behaviour_Details,
                animal.animal_Sex FROM observations JOIN behaviour ON
                behaviour.behaviour_ID=observations.observation_Behaviour
                JOIN animal ON animal.animal_Initials=observations.observation_Animal
                WHERE observations.observation_Date >= '$fDate'
                GROUP BY observations.observation_Behaviour";
                
            }
            
        }
        
        $filter = mysqli_query($con, $sql);
        $count = mysqli_num_rows($filter);
        
        // total occurrence
        $details = array();
        $details[0] = 0;
        
        if ($count == 0) {
            $output = 'Error: No results could be found, please try again!';
        } else {
            
            $behaviour_id_array = array();
            $behaviour_occurrence_array = array();
            $behaviour_details_array = array();
            $animal_sex_array = array();
            
            while ($row = mysqli_fetch_array($filter, MYSQLI_ASSOC)) {
                
                $behaviour = $row['observation_Behaviour'];
                $occurrence = $row['COUNT(*)'];
                $b_details = $row['behaviour_Details'];
                $sex = $row['animal_Sex'];
                
                array_push($behaviour_id_array, $behaviour);
                array_push($behaviour_occurrence_array, $occurrence);
                array_push($behaviour_details_array, $b_details);
                $details[0] += $occurrence;
                array_push($animal_sex_array, $sex);
                
            }
            
            // pass graph type used
            $details[1] = $graphType;
            // push behaviour ID, occurrence, behaviour details, total results
            array_push($behaviourDB_array, $behaviour_details_array, $behaviour_occurrence_array, $details,
            $behaviour_id_array);
            
        }
        
    }
    
    if ($graphType == "tree") {
        
        // search query of all
        // if male female set
        if (isset($_POST['male']) and !isset($_POST['female'])) {
            
            $sql = "SELECT observations.observation_Tree, COUNT(*), animal.animal_Sex FROM observations
            JOIN animal ON animal.animal_Initials=observations.observation_Animal
            WHERE animal.animal_Sex = 'm' and observations.observation_Tree != ''
            GROUP BY observations.observation_Tree";
            
        } else if (isset($_POST['female']) and !isset($_POST['male'])) {
            
            
            $sql = "SELECT observations.observation_Tree, COUNT(*), animal.animal_Sex FROM observations
            JOIN animal ON animal.animal_Initials=observations.observation_Animal
            WHERE animal.animal_Sex = 'f' and observations.observation_Tree != ''
            GROUP BY observations.observation_Tree";
        } else {
            
            $sql = "SELECT observations.observation_Tree, COUNT(*), animal.animal_Sex FROM observations
            JOIN animal ON animal.animal_Initials=observations.observation_Animal
            WHERE observations.observation_Tree != ''
            GROUP BY observations.observation_Tree";
            
        }
        
        
        // change command if date is selected
        if (!empty($fDate) and !empty($tDate)) {
            
            if (isset($_POST['male']) and !isset($_POST['female'])) {
                
                $sql = "SELECT observations.observation_Tree, COUNT(*), animal.animal_Sex FROM observations
                JOIN animal ON animal.animal_Initials=observations.observation_Animal
                WHERE observations.observation_Date >= '$fDate' AND observations.observation_Date <= '$tDate'
                AND animal.animal_Sex = 'm' AND observations.observation_Tree != ''
                GROUP BY observations.observation_Tree";
                
            } else if (isset($_POST['female']) and !isset($_POST['male'])) {
                
                $sql = "SELECT observations.observation_Tree, COUNT(*), animal.animal_Sex FROM observations
                JOIN animal ON animal.animal_Initials=observations.observation_Animal
                WHERE observations.observation_Date >= '$fDate' AND observations.observation_Date <= '$tDate'
                AND animal.animal_Sex = 'f' AND observations.observation_Tree != ''
                GROUP BY observations.observation_Tree";
                
            } else {
                
                $sql = "SELECT observations.observation_Tree, COUNT(*), animal.animal_Sex FROM observations
                JOIN animal ON animal.animal_Initials=observations.observation_Animal
                WHERE observations.observation_Date >= '$fDate' AND observations.observation_Date <= '$tDate'
                AND observations.observation_Tree != ''
                GROUP BY observations.observation_Tree";
                
            }
            
            
        } else if (empty($fDate) and !empty($tDate)) {
            
            if (isset($_POST['male']) and !isset($_POST['female'])) {
                
                $sql = "SELECT observations.observation_Tree, COUNT(*), animal.animal_Sex FROM observations
                JOIN animal ON animal.animal_Initials=observations.observation_Animal
                WHERE observations.observation_Date <= '$tDate' AND animal.animal_Sex = 'm'
                AND observations.observation_Tree != ''
                GROUP BY observations.observation_Tree";
                
            } else if (isset($_POST['female']) and !isset($_POST['male'])) {
                
                $sql = "SELECT observations.observation_Tree, COUNT(*), animal.animal_Sex FROM observations
                JOIN animal ON animal.animal_Initials=observations.observation_Animal
                WHERE observations.observation_Date <= '$tDate' AND animal.animal_Sex = 'f'
                AND observations.observation_Tree != ''
                GROUP BY observations.observation_Tree";
            } else {
                
                $sql = "SELECT observations.observation_Tree, COUNT(*), animal.animal_Sex FROM observations
                JOIN animal ON animal.animal_Initials=observations.observation_Animal
                WHERE observations.observation_Date <= '$tDate' AND observations.observation_Tree != ''
                GROUP BY observations.observation_Tree";
            }
            
            
        } else if (!empty($fDate) and empty($tDate)) {
            
            if (isset($_POST['male']) and !isset($_POST['female'])) {
                
                $sql = "SELECT observations.observation_Tree, COUNT(*), animal.animal_Sex FROM observations
                JOIN animal ON animal.animal_Initials=observations.observation_Animal
                WHERE observations.observation_Date >= '$fDate' AND animal.animal_Sex = 'm'
                AND observations.observation_Tree != ''
                GROUP BY observations.observation_Tree";
                
            } else if (isset($_POST['female']) and !isset($_POST['male'])) {
                
                $sql = "SELECT observations.observation_Tree, COUNT(*), animal.animal_Sex FROM observations
                JOIN animal ON animal.animal_Initials=observations.observation_Animal
                WHERE observations.observation_Date >= '$fDate' AND animal.animal_Sex = 'f'
                AND observations.observation_Tree != ''
                GROUP BY observations.observation_Tree";
            } else {
                
                $sql = "SELECT observations.observation_Tree, COUNT(*), animal.animal_Sex FROM observations
                JOIN animal ON animal.animal_Initials=observations.observation_Animal
                WHERE observations.observation_Date >= '$fDate' AND observations.observation_Tree != ''
                GROUP BY observations.observation_Tree";
                
            }
            
            
        }
        
        $filter = mysqli_query($con, $sql);
        $count = mysqli_num_rows($filter);
        
        // total occurrence
        $details = array();
        $details[0] = 0;
        
        if ($count == 0) {
            $output = 'Error: No results could be found, please try again!';
        } else {
            
            $behaviour_tree_array = array();
            $behaviour_occurrence_array = array();
            $behaviour_details_array = array();
            $animal_sex_array = array();
            
            while ($row = mysqli_fetch_array($filter, MYSQLI_ASSOC)) {
                
                $behaviour_tree = $row['observation_Tree'];
                $occurrence = $row['COUNT(*)'];
                $sex = $row['animal_Sex'];
                
                // remove underscore from the tree name in the data
                $removeUndScr = str_replace('_', ' ', $behaviour_tree);
                array_push($behaviour_tree_array, $removeUndScr);
                array_push($behaviour_occurrence_array, $occurrence);
                $details[0] += $occurrence;
                array_push($animal_sex_array, $sex);
                
            }
            
            // pass graph type used
            $details[1] = $graphType;
            // push behaviour ID, occurrence, behaviour details, total results
            array_push($behaviourDB_array, $behaviour_tree_array, $behaviour_occurrence_array,
            $details);
            
        }
        
        
    }
    
    if ($graphType == "altitude") {
        
        if (isset($_POST['male']) and !isset($_POST['female'])) {
            
            $sql = "SELECT animal.animal_Name, MAX(location.location_Altitude),
            MIN(location.location_Altitude), AVG(location.location_Altitude)
            FROM location JOIN animal ON animal.animal_Initials=location.location_Animal
            WHERE animal.animal_Sex = 'm' GROUP BY animal.animal_Initials";
            
        } else if (isset($_POST['female']) and !isset($_POST['male'])) {
            
            $sql = "SELECT animal.animal_Name, MAX(location.location_Altitude),
            MIN(location.location_Altitude), AVG(location.location_Altitude)
            FROM location JOIN animal ON animal.animal_Initials=location.location_Animal
            WHERE animal.animal_Sex = 'f' GROUP BY animal.animal_Initials";
            
        } else {
            
            $sql = "SELECT animal.animal_Name, MAX(location.location_Altitude),
            MIN(location.location_Altitude), AVG(location.location_Altitude)
            FROM location JOIN animal ON animal.animal_Initials=location.location_Animal
            GROUP BY animal.animal_Initials";
            
        }
        
        
        // change command if date is selected
        if (!empty($fDate) and !empty($tDate)) {
            
            if (isset($_POST['male']) and !isset($_POST['female'])) {
                
                $sql = "SELECT animal.animal_Name, MAX(location.location_Altitude),
                MIN(location.location_Altitude), AVG(location.location_Altitude)
                FROM location JOIN animal ON animal.animal_Initials=location.location_Animal
                WHERE location.location_Date >= '$fDate'
                AND location.location_Date <= '$tDate'
                AND animal.animal_Sex = 'm' GROUP BY animal.animal_Initials";
                
            } else if (isset($_POST['female']) and !isset($_POST['male'])) {
                
                $sql = "SELECT animal.animal_Name, MAX(location.location_Altitude),
                MIN(location.location_Altitude), AVG(location.location_Altitude)
                FROM location JOIN animal ON animal.animal_Initials=location.location_Animal
                WHERE location.location_Date >= '$fDate'
                AND location.location_Date <= '$tDate'
                AND animal.animal_Sex = 'f' GROUP BY animal.animal_Initials";
                
            } else {
                
                $sql = "SELECT animal.animal_Name, MAX(location.location_Altitude),
                MIN(location.location_Altitude), AVG(location.location_Altitude)
                FROM location JOIN animal ON animal.animal_Initials=location.location_Animal
                WHERE location.location_Date >= '$fDate'
                AND location.location_Date <= '$tDate'
                GROUP BY animal.animal_Initials";
                
            }
            
        } else if (empty($fDate) and !empty($tDate)) {
            
            if (isset($_POST['male']) and !isset($_POST['female'])) {
                
                $sql = "SELECT animal.animal_Name, MAX(location.location_Altitude),
                MIN(location.location_Altitude), AVG(location.location_Altitude)
                FROM location JOIN animal ON animal.animal_Initials=location.location_Animal
                WHERE location.location_Date <= '$tDate'
                AND animal.animal_Sex = 'm' GROUP BY animal.animal_Initials";
                
            } else if (isset($_POST['female']) and !isset($_POST['male'])) {
                
                $sql = "SELECT animal.animal_Name, MAX(location.location_Altitude),
                MIN(location.location_Altitude), AVG(location.location_Altitude)
                FROM location JOIN animal ON animal.animal_Initials=location.location_Animal
                WHERE location.location_Date <= '$tDate'
                AND animal.animal_Sex = 'f' GROUP BY animal.animal_Initials";
                
            } else {
                
                $sql = "SELECT animal.animal_Name, MAX(location.location_Altitude),
                MIN(location.location_Altitude), AVG(location.location_Altitude)
                FROM location JOIN animal ON animal.animal_Initials=location.location_Animal
                WHERE location.location_Date <= '$tDate'
                GROUP BY animal.animal_Initials";
                
            }
            
            
        } else if (!empty($fDate) and empty($tDate)) {
            
            if (isset($_POST['male']) and !isset($_POST['female'])) {
                
                $sql = "SELECT animal.animal_Name, MAX(location.location_Altitude),
                MIN(location.location_Altitude), AVG(location.location_Altitude)
                FROM location JOIN animal ON animal.animal_Initials=location.location_Animal
                WHERE location.location_Date >= '$tDate'
                AND animal.animal_Sex = 'm' GROUP BY animal.animal_Initials";
                
            } else if (isset($_POST['female']) and !isset($_POST['male'])) {
                
                $sql = "SELECT animal.animal_Name, MAX(location.location_Altitude),
                MIN(location.location_Altitude), AVG(location.location_Altitude)
                FROM location JOIN animal ON animal.animal_Initials=location.location_Animal
                WHERE location.location_Date >= '$tDate'
                AND animal.animal_Sex = 'f' GROUP BY animal.animal_Initials";
                
            } else {
                
                $sql = "SELECT animal.animal_Name, MAX(location.location_Altitude),
                MIN(location.location_Altitude), AVG(location.location_Altitude)
                FROM location JOIN animal ON animal.animal_Initials=location.location_Animal
                WHERE location.location_Date >= '$tDate'
                GROUP BY animal.animal_Initials";
                
            }
            
            
        }
        
        
        $filter = mysqli_query($con, $sql);
        $count = mysqli_num_rows($filter);
        
        // total occurrence
        $details = array();
        
        if ($count == 0) {
            $output = 'Error: No results could be found, please try again!';
        } else {
            
            $animal_name_array = array();
            $avg_array = array();
            $max_array = array();
            $min_array = array();
            
            
            while ($row = mysqli_fetch_array($filter, MYSQLI_ASSOC)) {
                
                $name = $row['animal_Name'];
                $avg = $row['AVG(location.location_Altitude)'];
                $max = $row['MAX(location.location_Altitude)'];
                $min = $row['MIN(location.location_Altitude)'];
                
                
                // remove underscore from the tree name in the data
                $removeUndScrName = str_replace('_', ' ', $name);
                
                array_push($animal_name_array, ucfirst($removeUndScrName));
                array_push($avg_array, $avg);
                array_push($min_array, $min);
                array_push($max_array, $max);
                
            }
            
            $details[0] = 1;
            // pass graph type used
            $details[1] = $graphType;
            // push behaviour ID, occurrence, behaviour details, total results
            array_push($behaviourDB_array, $animal_name_array, $avg_array,
            $details, $min_array, $max_array);
            
        }
        
    }
    
    // echo if no result found
    //echo $output;
    
    echo "
    <script>
    document.getElementById('update-text').innerHTML = '".$output."';
    </script>
    ";
    
}

// Closes the connection with the database

/*
produces table with occurance:

SELECT observations.observation_Behaviour, behaviour.behaviour_Details, animal.animal_Sex, COUNT(*) FROM observations JOIN behaviour ON behaviour.behaviour_ID=observations.observation_Behaviour JOIN animal ON animal.animal_Initials=observations.observation_Animal GROUP BY observations.observation_Behaviour

*/


// SELECT animal.*, observations.observation_Behaviour FROM animal JOIN observations ON animal.animal_Initials=observations.observation_Animal

// creates table of behaviour id/behaviour details / animal sex
// SELECT observations.observation_Behaviour, behaviour.behaviour_Details, animal.animal_Sex FROM observations JOIN behaviour ON behaviour.behaviour_ID=observations.observation_Behaviour JOIN animal ON animal.animal_Initials=observations.observation_Animal


//SELECT observations.observation_Behaviour, COUNT(*) from observations GROUP BY observations.observation_Behaviour


// COUNT(*) FROM observations
?>

    <script>
      var jsBehArray = <?php echo json_encode($behaviourDB_array); ?>;
      window.localStorage.setItem("jsBehArray", JSON.stringify(jsBehArray));
    </script>