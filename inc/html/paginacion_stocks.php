<?php
session_start();
?>

<div id="div_paginacion" class="row" style="margin-top: -10px; font-size: 11px;" orderby="<?php $_SESSION["orderby"]; ?>" sentido="<?php $_SESSION["sentido"]; ?>">
    <div class="col-lg-2 col-md-3 col-sm-3  hidden-xs" style="float: left;text-align: left;margin-top: 5px; display: none;">
        <label for="busqueda">Buscar:</label>
        <input type="text" id="busqueda" name="busqueda" value="<?php echo $_SESSION["busqueda"]; ?>" style="width: 75px;" />
        <a href="#" style="margin-left: 5px;" id="busqueda-erase" name="busqueda-erase"><span class="glyphicon glyphicon-erase" aria-hidden="true"></span></a>
        <a href="#" style="margin-left: 5px;" id="busqueda-icono" name="busqueda-icono"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></a>
        <a href="#" style="margin-left: 5px;" id="busqueda-tipouso" name="busqueda-tipouso"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></a>
        <a href="#" style="margin-left: 5px;" id="busqueda-tipoinsumo" name="busqueda-tipoinsumo"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></a>
    </div>
    <div id="valor" class="col-lg-4 col-md-4 col-sm-5 col-xs-12" style="float: left;text-align: left;margin-top: 0px;">
        <label style="margin-left: 5px;">Seleccione <br>una opción:</label>
        <select id="productos" name="productos"  class="form-control"  style="width: 75%;display: inline-block;vertical-align: middle; font-size: 11px; height: auto; margin-top: -18px;">
            <option value="-1" <?php if ($_SESSION['cod_producto'] == -1) echo "selected"; ?> disabled>Elija una opción</option>
            <?php foreach ($productos as $cl) { ?>
                <option class="tipo_de_insumo" tipo="<?php echo $cl["es_insumo"] ? "1" : "2"  ?>" value="<?php echo $cl['codigo']; ?>" <?php if ($_SESSION['cod_producto'] == $cl['codigo']) echo "selected"; ?>><?php echo $cl['dimension']; ?></option>
               <!-- <option  value="<?php echo $cl['codigo']; ?>" <?php if ($_SESSION['cod_producto'] == $cl['codigo']) echo "selected"; ?>><?php echo $cl['dimension']; ?></option>-->
            <?php  } ?>
        </select>
   
    </div>
    <div class="col-lg-4 col-md-4 col-sm-5 col-xs-12" style="float: left;text-align: left;margin-top: 0px;">
        <label style="margin-left: 5px;">Seleccione <br>una opción:</label>
        <select id="tipouso" class="form-control" style="width: 75%;display: inline-block;vertical-align: middle; font-size: 11px; height: auto; margin-top: -18px;">
            <option type="text" value="0" <?php echo ($maquina["es_usado"] == 0) ? "selected" : ''; ?>>Usado</option>
            <option type="text" value="1" <?php echo ($maquina["es_usado"] == 1) ? "selected" : ''; ?>>Nuevo</option>
        </select>
    </div>
    <div id="select2lista"></div>
    <div class="col-lg-4 col-md-4 col-sm-5 col-xs-12" style="float: left;text-align: left;margin-top: 0px;">
        <label style="margin-left: 5px;">Seleccione <br>una opción:</label>
        <select id="tipoinsumo" name="tipoinsumo" class="form-control" style="width: 50%;display: inline-block;vertical-align: middle; font-size: 11px; height: auto; margin-top: -18px;">
            <option value="1" <?php echo $tipo == 1 ? "selected" : ""; ?>>Insumo</option>
            <option value="2" <?php echo $tipo == 2 ? "selected" : ""; ?>>Componente</option>
            <option value="3" <?php echo $tipo == 3 ? "selected" : ""; ?>>Maquina</option>
        </select>
        <!--<?php
            $miSelect = $_GET['tipoinsumo'];
            $_SESSION['val']=$miSelect;
        ?>-->
    </div>
    
</div>