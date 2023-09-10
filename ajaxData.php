<?php
// Include the database config file 
include_once 'bd/conexion1.php';

if (!empty($_POST["codigo"])) {



    if ($_POST["codigo"] === "1") {
        $query = "SELECT codigo as codigo, dimension as descripcion FROM componentes p  WHERE es_insumo = 1";
    
        $result = $db->query($query);
  
        if ($result->num_rows > 0) {
            echo '<option value="">Seleccione los componentes</option>';
            while ($row = $result->fetch_assoc()) {
                echo '<option value="' . $row['codigo'] . '">' . $row['descripcion'] . '</option>';
            }
        } else {
            echo '<option value="">No hay opciones para elegir</option>';
        }
    }else if($_POST["codigo"] === "2"){
        $query = "SELECT codigo ,dimension FROM componentes  WHERE es_insumo = 0";
    
        $result = $db->query($query);
  
        if ($result->num_rows > 0) {
            echo '<option value="">Seleccione los insumos</option>';
            while ($row = $result->fetch_assoc()) {
                echo '<option value="' . $row['codigo'] . '">' . $row['dimension'] . '</option>';
            }
        } else {
            echo '<option value="">No hay opciones para elegir</option>';
        }




    }else{
        $query = "SELECT * FROM maquinas WHERE es_insumo=3 ";
    
        $result = $db->query($query);
  
        if ($result->num_rows > 0) {
            echo '<option value="">Seleccione las maquinas</option>';
            while ($row = $result->fetch_assoc()) {
                echo '<option value="' . $row['codigo'] . '">' . $row['descripcion'] . '</option>';
            }
        } else {
            echo '<option value="">No hay opciones para elegir</option>';
        }
    }
   
}
