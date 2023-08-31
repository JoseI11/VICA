<?php
// Include the database config file 
include_once 'bd/conexion1.php';

if (!empty($_POST["codigo"])) {



    if ($_POST["codigo"] === "1") {
        $query = "SELECT p.codigo as codigo,p.dimension as descripcion FROM componentes p  WHERE p.es_insumo = 1";
    
        $result = $db->query($query);
  
        if ($result->num_rows > 0) {
            echo '<option value="">Seleccione el pais al cual pertenece</option>';
            while ($row = $result->fetch_assoc()) {
                echo '<option value="' . $row['codigo'] . '">' . $row['descripcion'] . '</option>';
            }
        } else {
            echo '<option value="">State not available</option>';
        }
    }else if($_POST["codigo"] === "2"){
        $query = "SELECT p.codigo as codigo,p.dimension as descripcion FROM componentes p  WHERE p.es_insumo = 0";
    
        $result = $db->query($query);
  
        if ($result->num_rows > 0) {
            echo '<option value="">Seleccione el pais al cual pertenece</option>';
            while ($row = $result->fetch_assoc()) {
                echo '<option value="' . $row['codigo'] . '">' . $row['descripcion'] . '</option>';
            }
        } else {
            echo '<option value="">State not available</option>';
        }




    }else{
        $query = "SELECT codigo, descripcion FROM maquinas ";
    
        $result = $db->query($query);
  
        if ($result->num_rows > 0) {
            echo '<option value="">Seleccione el pais al cual pertenece</option>';
            while ($row = $result->fetch_assoc()) {
                echo '<option value="' . $row['codigo'] . '">' . $row['descripcion'] . '</option>';
            }
        } else {
            echo '<option value="">State not available</option>';
        }
    }
    // Fetch state data based on the specific country 
}
// } elseif (!empty($_POST["codigoProvincia"])) {
//     // Fetch city data based on the specific state 
//     $query = "SELECT DISTINCT ps.codigo as codigo, ps.descripcion as descripcion FROM provincias ps INNER JOIN personas pr ON ps.codigo = pr.cod_provincia WHERE  pr.codigo='" . $_POST["codigoProvincia"] . "'";
//     $result = $db->query($query);

//     // Generate HTML of city options list 
//     if ($result->num_rows > 0) {
//         echo '<option value="">Selecciona una provincia</option>';
//         while ($row = $result->fetch_assoc()) {
//             echo '<option value="' . $row['codigo'] . '">' . $row['descripcion'] . '</option>';
//         }
//     } else {
//         echo '<option value="">City not available</option>';
//     }
// } 
// elseif(!empty($_POST["state_id"])){ 
//     // Fetch city data based on the specific state 
//     $query = "SELECT * FROM cities WHERE state_id = ".$_POST['state_id']." AND status = 1 ORDER BY city_name ASC"; 
//     $result = $db->query($query); 
     
//     // Generate HTML of city options list 
//     if($result->num_rows > 0){ 
//         echo '<option value="">Select city</option>'; 
//         while($row = $result->fetch_assoc()){  
//             echo '<option value="'.$row['city_id'].'">'.$row['city_name'].'</option>'; 
//         } 
//     }else{ 
//         echo '<option value="">City not available</option>'; 
//     } 
// } 
