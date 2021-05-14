<?php
include ("dbconnection.php");


$label = isset($_POST['label']) ? $_POST['label'] : "%";
  $sql = 'select *
  from (select count(*) as conteggio,
      label,
      DATE_FORMAT(Istante, "%H:%i:%s") as `ora_minuto`
  from mask_cam.mask
  where label="' . $label . '"
  group by label, ora_minuto
  order by ora_minuto desc
  limit 30) as x
  order by ora_minuto;';

  $sql=  "select label , istante, COUNT(*) AS conteggio FROM (SELECT DISTINCT ObjectId, label, istante FROM tablenew  ) AS A  WHERE label LIKE '%" . $label . "%' GROUP BY label, Istante;";



  if ($result = $GLOBALS["link"] -> query($sql)) {
    $Array = array();

    while($row = $result->fetch_assoc()) {
      $Array[] = $row["conteggio"];
    }

    echo json_encode($Array);
    $result -> free_result();
  }
  ?>