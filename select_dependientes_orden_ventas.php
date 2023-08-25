<!-- <?php

session_start();

include 'bd/conexion1.php';

$query = "SELECT codigo,descripcion FROM personas";
$sqlo = mysqli_query($conn, $query);

echo"<select name=student class='form-control' >";

while ($row = mysqli_fetch_assoc($sqlo)) {
echo "<option id=s1 onchange='reload()' value=$row[codigo]>$row[descripcion]</option>";

}
echo "</select>";
echo "</div><div class='col-3'>";
$query1 = "SELECT codigo,descripcion FROM provincias WHERE codigo=";
$sqlo = mysqli_query($conn, $query1);

echo"<select name=student class='form-control' >";

while ($row = mysqli_fetch_assoc($sqlo)) {
echo "<option id=s1 onchange='reload()' value=$row[codigo]>$row[descripcion]</option>";

}
?>

</div>
<script>
    function reload(){
        let val = document.getElementById("s1").value;
       document.write(val)
    }
</script>
</body>
</html> -->
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

<!-- State dropdown -->
<select id="state">
    <option value="">Select country first</option>
</select>

<!-- City dropdown
<select id="city">
    <option value="">Select state first</option>
</select> -->