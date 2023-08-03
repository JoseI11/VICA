<?php
include 'bd/conexion1.php';

$tipo = 1;
$sql = "SELECT p.* FROM componentes p  WHERE p.es_insumo = 1";
$result = mysqli_query($conn, $sql);
while ($row = mysqli_fetch_array($result)) {
    echo '<option class="tipo_de_insumo" tipo="' . $tipo . '" estado="' . $row["es_usado"] . '" value="' . $row['codigo'] . '">' . $row['dimension'] . ' (' .$row['codigo_mp'] .')</option>';
}
$tipo = 2;
//$sql = "SELECT p.* FROM componentes p  WHERE p.es_insumo = 0";
$sql="SELECT * FROM maquinas where cod_maquina_modelo in (8,9)";
$result = mysqli_query($conn, $sql);
while ($row = mysqli_fetch_array($result)) {
    echo '<option class="tipo_de_insumo" tipo="' . $tipo . '" estado="' . $row["es_usado"] . '" value="' . $row['codigo'] . '">' . $row['descripcion'] . ' (' .$row['descrip_abrev'] .')</option>';
}
$tipo = 3;
$sql = "SELECT * FROM maquinas ";
$result = mysqli_query($conn, $sql);
while ($row = mysqli_fetch_array($result)) {
    echo '<option class="tipo_de_insumo" tipo="' . $tipo . '" estado="' . $row["es_usado"] . '"  value="' . $row['codigo'] . '">' . $row['descripcion'] . ' (' .$row['descrip_abrev'] .')</option>';
}
?>