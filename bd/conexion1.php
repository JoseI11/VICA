<?php

$conn=mysqli_connect(
    "localhost",
    "u175932211_vica_new",
    "Vica_new123",
    "u175932211_vica_new"

);
// Create database connection 
$db = new mysqli("localhost", "u175932211_vica_new","Vica_new123","u175932211_vica_new"); 
 
// Check connection 
if ($db->connect_error) { 
    die("Connection failed: " . $db->connect_error); 
}

//$conn=mysqli_connect(
//   "localhost",
//    "u175932211_vica",
//    "Mari34935",
//    "u175932211_vica"

//);

?>
