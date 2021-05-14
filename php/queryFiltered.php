        
<?php
include_once ("dbconnection.php");
$label = isset($_POST['label']) ? $_POST['label'] : "%";
//$sql = "select istante, count(*) as conteggio from mask_cam.mask where label like '" . $label . "' group by istante";
//$sql = " select label , istante, COUNT(*) AS conteggio FROM (SELECT DISTINCT ObjectId, label, istante FROM tablenew  ) AS A  WHERE label LIKE " . $label . " GROUP BY label, Istante;";
$istante = isset($_POST['istante']) ? $_POST['istante'] : "%";
$sql = "select label , COUNT(*) AS conteggio FROM (SELECT DISTINCT ObjectId, label, istante FROM tablenew WHERE istante = '" . $istante ."') AS A WHERE label LIKE '" . $label . "' GROUP BY label";

$conteggio = 0;
$result=mysqli_query($GLOBALS["link"], $sql);
while($row = $result->fetch_assoc()) {
    $conteggio = $row["conteggio"];
}
echo $conteggio;

?>

