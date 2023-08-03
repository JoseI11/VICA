<?php

error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING ^ E_STRICT);

session_start();

if ($_SESSION["usuario"] == "mari") {
    header("Location: inicio.php");
    die();
}

if (!isset($_SESSION["usuario"]) || !isset($_SESSION['password'])) {
    header("Location: login.php");
} else {
    header("Location: inicio.php");
}