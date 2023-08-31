<?php

include_once 'bd/conexion1.php';

if(!empty($_POST["codigoVal"])){
    $sql = "SELECT ps.descripcion AS descPais,pv.descripcion AS descProv FROM personas prs INNER JOIN paises ps ON prs.cod_pais=ps.codigo INNER JOIN provincias pv ON prs.cod_provincia=pv.codigo WHERE prs.codigo='".$_POST["codigoVal"]."'";
    $result = $db->query($sql); 
    $fila = mysqli_fetch_row($result);
   
        echo$fila[0].'-'.$fila[1];
   
    // echo"<h1>$fila[0]</h1>";
    // echo"$fila[1]";
}else{
    echo $_POST["codigoVal"];
    echo "hoal";
}

?>