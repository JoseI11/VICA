<?php

include_once 'bd/conexion1.php';

if(!empty($_POST["codigoVal"])){
    $sql = "SELECT ps.descripcion AS descPais,pv.descripcion AS descProv,prs.cuit as cuit FROM personas prs INNER JOIN paises ps ON prs.cod_pais=ps.codigo INNER JOIN provincias pv ON prs.cod_provincia=pv.codigo WHERE prs.codigo='".$_POST["codigoVal"]."'";
    $result = $db->query($sql); 
    $fila = mysqli_fetch_row($result);
   
        echo $fila[0].'*'.$fila[1].'*'.$fila[2];
   
    
}else{
    echo $_POST["codigoVal"];
   
}

?>