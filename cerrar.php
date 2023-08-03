<?php

session_start();

if (!isset($_SESSION["usuario"]) || !isset($_SESSION['password'])) {
    header("Location: login.php");
}

session_destroy();

header("Location: login.php");

?>