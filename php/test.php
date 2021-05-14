<?php
include ("dbconnection.php");

$path = '../json/uno.json';
$jsondata = file_get_contents($path);
$data = json_decode($jsondata /*, true*/);
print_r($data);
//$properties = array_keys($data);
$propertyName = key( get_object_vars($data)) ;


/*
$timestamp = $data['time_stamp'];
$masked = $data['masked']['probability'];
$nonmasked = $data['nonmasked']['probability'];
*/

#for label = mask -> probability
#count
//$items = $data['predictions'];

//for($n = 1; $n < count($data); $n++){
        #echo $data['predictions'][0]['label'];
        /*
        foreach($data as $name => $value){
            if (count($data["$name"]) < 0 ){
                for($n = 0; $n < count($data[$name]); $n++){
                echo "IF OGGETTO MULTIPLO = ";
                echo $data["$name"][$n]["label"] + "<br>";
                }
            } else {
                echo "IF OGGETTO SINGOLO = ";
                echo $data["$name"];
                echo "<br> $name <br>";
            }
        }
        */
//}

foreach($data as $name => $value){
    if (count($data["$name"]) >= 0 ){
        echo "IF OGGETTO SINGOLO = ";
        echo $data["$name"];
        echo "<br> $name <br>";
    } else {
        for($n = 0; $n < count($data[$name]); $n++){
            echo "IF OGGETTO MULTIPLO = ";
            foreach($data as $name2 => $value){
                echo $data["$name"][$n]["$name2"] + "<br>";
            }
        }
    }
}





//$prova = $data['predictions'][0]['probability'];

/*
$directory = "../json/";
$filecount = 0;
$files = glob($directory . "*");
if ($files){
 $filecount = count($files);
}
echo "There were $filecount files <br>";
*/

$sql = "INSERT INTO maskstory (`id_object`,`timestamp`) VALUES ('1', '$timestamp')";

if(mysqli_query($link, $sql)){
    echo "Records inserted successfully.";
} else{
    echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
}

?>
