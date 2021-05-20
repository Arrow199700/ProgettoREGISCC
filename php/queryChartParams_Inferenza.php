<?php
include ("dbconnection.php");


$label = isset($_POST['label']) ? $_POST['label'] : "%";
$secondi = isset($_POST['istante']) ? $_POST['istante'] : "%";
 

  $sql=  "select label, secondi , count(*) as conteggio from inferenza where label like '%". $label . "%' and secondi <= " . $secondi . " GROUP BY label, secondi order by secondi;";



  if ($result = $GLOBALS["link"] -> query($sql)) {
    $Array = array();

    while($row = $result->fetch_assoc()) {
      $Array[] = $row["conteggio"];
    }

    echo json_encode($Array);
    $result -> free_result();
  }
  ?>