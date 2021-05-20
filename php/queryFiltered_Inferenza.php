        
<?php
include_once ("dbconnection.php");
$label = isset($_POST['label']) ? $_POST['label'] : "%";
//$sql = "select istante, count(*) as conteggio from mask_cam.mask where label like '" . $label . "' group by istante";
//$sql = " select label , istante, COUNT(*) AS conteggio FROM (SELECT DISTINCT ObjectId, label, istante FROM tablenew  ) AS A  WHERE label LIKE " . $label . " GROUP BY label, Istante;";
$istante = isset($_POST['istante']) ? $_POST['istante'] : "%";
//$sql = "select label , COUNT(*) AS conteggio FROM (SELECT DISTINCT ObjectId, label, istante FROM mask_cam.tablenew WHERE istante = '" . $istante ."') AS A WHERE label LIKE '" . $label . "' GROUP BY label;";
//$sql= "select label, count(label) as conteggio, istante from tablenew WHERE label LIKE '"  . $label . "' group by istante";
//$sql= "select label, count(label) as conteggio, istante from tablenew WHERE label LIKE '"  . $label . "' group by istante;";
$sql= "select count(*) as conteggio from mask_cam.inferenza where label like '%"  . $label . "%' and secondi = '"  . $istante . "';";
   //echo $sql;
 //$sql = "select label, count(*) as conteggio, secondi from mask_cam.tablenew where label like '%"  . $label . "%' group by secondi;";
$conteggio = -1;
$result=mysqli_query($GLOBALS["link"], $sql);
while($row = $result->fetch_assoc()) {
    $conteggio = $row["conteggio"];
}
echo $conteggio;

?>

