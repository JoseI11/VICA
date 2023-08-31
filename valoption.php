<?php
session_start();
include_once 'bd/conexion1.php';
if(!empty($_POST["codigo"])){
    $_SESSION["ejemplo"]=$_POST["codigo"];
    echo  $_SESSION["ejemplo"];
}
?>