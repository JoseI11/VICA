
<?php 
session_start();

include 'bd/conexion1.php';
    // Include the database config file 
    
     
    // Fetch all the country data 
    $query = "SELECT codigo,descripcion FROM personas"; 
    $result = $db->query($query); 
?>

<!-- Country dropdown -->
<select id="country">
    <option value="">Select Country</option>
    <?php 
    if($result->num_rows > 0){ 
        while($row = $result->fetch_assoc()){  
            echo '<option value="'.$row['codigo'].'">'.$row['descripcion'].'</option>'; 
        } 
    }else{ 
        echo '<option value="">Country not available</option>'; 
    } 
    ?>
</select>


<select id="state">
    <option value="">Select country first</option>
</select>


<select id="city">
    <option value="">Select state first</option>
</select>