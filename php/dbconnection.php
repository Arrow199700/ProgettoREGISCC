<?php
$host = "localhost";
$database = "mask_cam";
$user = "root";
$password = "";

$conn = new mysqli($host, $user, $password, $database);
$link = mysqli_connect($host, $user, $password, $database);

//Conn new mysqli
if ($conn->connect_errno) {
    echo "Connessione fallita: ". $conn->connect_error . ".";
    exit();
}
else{
    //echo "Connessione riuscita <br>";
}

//Conn (link) mysqli_connect
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

$conn->close();
?>

