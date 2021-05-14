<?php
include ("dbconnection.php");
$ini = parse_ini_file('app.ini');

function query($label) {
    $sql = "SELECT * FROM mask $label";

    if($result=mysqli_query($GLOBALS["link"], $sql)){
        //echo "Query ok <br>". mysqli_num_rows($result);
        echo mysqli_num_rows($result);
    } else{
        echo "ERROR: Could not able to execute $sql. " . mysqli_error($GLOBALS["link"]);
    }
  }
 
?>


