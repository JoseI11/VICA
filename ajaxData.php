<?php 
// Include the database config file 
include_once 'bd/conexion1.php'; 
 
if(!empty($_POST["codigo"])){ 
    // Fetch state data based on the specific country 
    $query="SELECT pr.codigo as codigo, pr.descripcion as descripcion FROM `provincias` pr INNER JOIN `personas` ps ON pr.codigo=ps.cod_provincia WHERE ps.codigo='".$_POST["codigo"]."'";
    // $query = "SELECT  FROM states WHERE country_id = ".$_POST['country_id']." AND status = 1 ORDER BY state_name ASC"; 
    // $result = $db->query($query); 
    $result = $db->query($query); 
    // Generate HTML of state options list 
   // echo $query;
    if($result->num_rows > 0){ 
        echo '<option value="">Select State</option>'; 
        while($row = $result->fetch_assoc()){  
            echo '<option value="'.$row['codigo'].'">'.$row['descripcion'].'</option>'; 
        } 
    }else{ 
        echo '<option value="">State not available</option>'; 
    } 
}
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
?>