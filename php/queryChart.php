<?php
include ("dbconnection.php");


function queryChart($sql,$field){
    //$sql = "SELECT label FROM mask_cam.mask group by label";

    if ($result = $GLOBALS["link"] -> query($sql)) {
        //echo "Returned rows are: " . $result -> num_rows . "<br>";

        //create array
        $Array = array();

        // output data of each row
        while($row = $result->fetch_assoc()) {
          //echo "label: ". $row["label"] . "<br>";
          $Array[] = $row[$field];
        }

        echo json_encode($Array);
        $result -> free_result();
      }
      
}
$sql = isset($_POST['sql']) ? $_POST['sql'] : "";
$field = isset($_POST['field']) ? $_POST['field'] : "";
if ($sql != "" && $field != "")
{
  queryChart($sql, $field);
}
?>




