<?php
session_start();

include 'bd/conexion1.php';
?>

<head>

	<meta charset="utf-8">

	<title>Obtener valor de un select en jQuery</title>

	<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

	<script>
		$("select.tipouso").change(function(){
			//var tipo_valor=$(this).val();
			var seleccion = $(this).children("option:selected").val();
			window.location.href='stocks.php?valor=' + seleccion;
		});
		/*function enviouso(valor){
		


window.location.href='stocks.php?valor=' + valor;
//alert("Has seleccionado - " + seleccion);


	//Pasa los parámetros a la pagina buscar
  
}*/
		/*$(document).ready(function() {

			$("select.tipouso").change(function() {

				var seleccion = $(this).children("option:selected").val();

				//alert("Has seleccionado - " + seleccion);

			});
			$("select.tipoinsumo").change(function() {

				var seleccion1 = $(this).children("option:selected").val();

				//alert("Has seleccionado - " + seleccion1);

			});
			$("select.productos").change(function() {

				var seleccion2 = $(this).children("option:selected").val();

				alert("Has seleccionado - " + seleccion2);

			});

		});*/
	</script>

</head>

	<div id="div_paginacion" class="row" style="margin-top: -10px; font-size: 11px;" orderby="<?php $_SESSION["orderby"]; ?>" sentido="<?php $_SESSION["sentido"]; ?>">
		<div class="col-lg-2 col-md-3 col-sm-3  hidden-xs" style="float: left;text-align: left;margin-top: 5px; display: none;">
			<label for="busqueda">Buscar:</label>
			<input type="text" id="busqueda" name="busqueda" value="<?php echo $_SESSION["busqueda"]; ?>" style="width: 75px;" />
			<a href="#" style="margin-left: 5px;" id="busqueda-erase" name="busqueda-erase"><span class="glyphicon glyphicon-erase" aria-hidden="true"></span></a>
			<a href="#" style="margin-left: 5px;" id="busqueda-icono" name="busqueda-icono"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></a>
			<a href="#" style="margin-left: 5px;" id="busqueda-tipouso" name="busqueda-tipouso"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></a>
			<a href="#" style="margin-left: 5px;" id="busqueda-tipoinsumo" name="busqueda-tipoinsumo"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></a>
		</div>
		<div id="select2lista"></div>
		<div class="col-lg-4 col-md-4 col-sm-5 col-xs-12" style="float: left;text-align: left;margin-top: 0px;">
			<label style="margin-left: 5px;">Seleccione <br>una opción:</label>
			<select id="tipoinsumo" name="tipoinsumo" class="tipoinsumo" class="form-control" style="width: 50%;display: inline-block;vertical-align: middle; font-size: 11px; height: auto; margin-top: -18px;">
				<option value="1" <?php echo $tipo == 1 ? "selected" : ""; ?>>Insumo</option>
				<option value="2" <?php echo $tipo == 2 ? "selected" : ""; ?>>Componente</option>
				<option value="3" <?php echo $tipo == 3 ? "selected" : ""; ?>>Maquina</option>
			</select>
		</div>
		<div class="col-lg-4 col-md-4 col-sm-5 col-xs-12" style="float: left;text-align: left;margin-top: 0px;">
			<label style="margin-left: 5px;">Seleccione <br>una opción:</label>
			<select id="tipouso" name="tipouso" class="tipouso" class="form-control" style="width: 75%;display: inline-block;vertical-align: middle; font-size: 11px; height: auto; margin-top: -18px;">
				<option type="text" value="0" <?php echo ($maquina["es_usado"] == 0) ? "selected" : ''; ?>>Nuevo</option>
				<option type="text" value="1" <?php echo ($maquina["es_usado"] == 1) ? "selected" : ''; ?>>Usado</option>
			</select>
		</div>
		<div id="valor" class="col-lg-4 col-md-4 col-sm-5 col-xs-12" style="float: left;text-align: left;margin-top: 0px;">
			<label style="margin-left: 5px;">Seleccione <br>una opción:</label>
			<select id="productos" class="productos" class="form-control" style="width: 75%;display: inline-block;vertical-align: middle; font-size: 11px; height: auto; margin-top: -18px;">
				<?php
				include 'bd/conexion1.php';

				echo $tipo;
				$tipo = 1;
				$sql = "SELECT p.* FROM componentes p  WHERE p.es_insumo = 1";
				$result = mysqli_query($conn, $sql);
				while ($row = mysqli_fetch_array($result)) {
					echo '<option class="tipo_de_insumo" tipo="' . $tipo . '" estado="' . $row["es_usado"] . '" value="' . $row['codigo'] . '">' . $row['dimension'] . ' (' .$row['codigo_mp'] .')</option>';
				}
				$tipo = 2;
				//$sql = "SELECT p.* FROM componentes p  WHERE p.es_insumo = 0";
				$sql="SELECT * FROM maquinas where cod_maquina_modelo in (8,9,10)";
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
			
			</select>
		</div>
	</div>
