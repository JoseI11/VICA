<legend>ORDEN VENTA POR REPARACION</legend>
<form id="guardarDatosOrdenCompra">
    <div class="modal-body">
        <div id="datos_ajax_register"></div>
        
        <div class="form-group" style="display: flex;">
            <label for="label0" class="control-label encabezado-form" style="margin-left:1%; margin-top:10px; width: 10%; text-align: right;">Nro:</label>
            <input type="text" class="form-control" id="codigo" name="codigo" style="margin-left:1%; width: 20%;" maxlength="100" disabled value="<?php echo $orden_venta["codigo"]; ?>">
            <label for="label0" class="control-label encabezado-form" style="margin-left:1%; margin-top:10px; width: 10%; text-align: right;">Cliente:</label>
            <input type="text" class="form-control" id="cliente" name="cliente" style="margin-left:1%; width: 20%;" maxlength="100" disabled value="<?php echo $orden_venta["cliente"]; ?>">
            <label for="label0" class="control-label encabezado-form" style="margin-left:1%; margin-top:10px; width: 10%; text-align: right;">Producto:</label>
            <input type="text" class="form-control" id="producto" name="producto" style="margin-left:1%; width: 20%;" maxlength="100" disabled value="<?php echo $orden_venta["producto"] ? $orden_venta["producto"] : $orden_venta["maquina"]; ?>">
        </div>
        
        <div class="form-group" style="display: flex;">
            <label for="label0" class="control-label encabezado-form" style="margin-left:1%; margin-top:10px; width: 10%; text-align: right;">Cantidad:</label>
            <input type="text" class="form-control" id="cantidad" name="cantidad" style="margin-left:1%; width: 20%;" maxlength="100" disabled value="<?php echo $orden_venta["cantidad"]; ?>">
            <label for="label0" class="control-label encabezado-form" style="margin-left:1%; margin-top:10px; width: 10%; text-align: right;">Precio:</label>
            <input type="text" class="form-control" id="precio_maquina" name="precio_maquina" style="margin-left:1%; width: 20%;" disabled maxlength="100" value="<?php echo $orden_venta["precio_maquina"]; ?>">
            <label for="label0" class="control-label encabezado-form" style="margin-left:1%; margin-top:10px; width: 10%; text-align: right;">Fecha:</label>
            <input type="date" class="form-control" id="fecha" name="fecha" style="margin-left:1%; width: 20%;" maxlength="100" disabled value="<?php echo $orden_venta["fecha"]; ?>">
        </div>
        
        <div class="form-group" style="display: flex;">
            <label for="label0" class="control-label encabezado-form" style="margin-left:1%; margin-top:10px; width: 10%; text-align: right;">Factura:</label>
            <input type="text" class="form-control" id="nombre_facturacion" name="nombre_facturacion" style="margin-left:1%; width: 20%;" maxlength="100" value="<?php echo $orden_venta["nombre_facturacion"]; ?>">
            <label for="label0" class="control-label encabezado-form" style="margin-left:1%; margin-top:10px; width: 10%; text-align: right;">Flete:</label>
            <input type="text" class="form-control" id="flete" name="flete" style="margin-left:1%; width: 20%;" maxlength="100" value="<?php echo $orden_venta["flete"]; ?>">
            <label for="label0" class="control-label encabezado-form" style="margin-left:1%; margin-top:10px; width: 10%; text-align: right;">Destino:</label>
            <input type="text" class="form-control" id="destino" name="destino" style="margin-left:1%; width: 20%;" maxlength="100" value="<?php echo $orden_venta["destino"]; ?>">
        </div>
        
        <div class="form-group" style="display: flex;">
            <label for="label0" class="control-label encabezado-form" style="margin-left:1%; margin-top:10px; width: 10%; text-align: right;">Estimado:</label>
            <input type="date" class="form-control" id="fecha_entrega_maquina" name="fecha_entrega_maquina" style="margin-left:1%; width: 20%;" maxlength="100" value="<?php echo $orden_venta["fecha_entrega_maquina"]; ?>">
            <label for="label0" class="control-label encabezado-form" style="margin-left:1%; margin-top:10px; width: 10%; text-align: right;">Vendedor:</label>
            <select id="cod_vendedor" style="margin-left:1%; width: 20%;" class="form-control" name="cod_vendedor">
                <?php foreach ($vendedores as $reg) {?>
                    <option type="text" value="<?php echo $reg["codigo"]; ?>" <?php echo ($orden_venta["cod_vendedor"]==$reg["codigo"]) ? "selected" : ''; ?>><?php echo $reg["descripcion"]; ?></option>
                <?php } ?>
            </select>
            <label for="label0" class="control-label encabezado-form" style="margin-left:1%; margin-top:10px; width: 10%; text-align: right;">Comision:</label>
            <input type="text" class="form-control" id="comision_vendedor" name="comision_vendedor" style="margin-left:1%; width: 20%;" maxlength="100" value="<?php echo $orden_venta["comision_vendedor"]; ?>">
        </div>

        <div class="form-group" style="display: flex;">
            <label for="nombre0" class="control-label encabezado-form" style="margin-left:1%; margin-top:10px; width: 10%; text-align: right;">Obs.:</label>
            <input type="text" class="form-control" id="descripcion" name="descripcion" required maxlength="100"  style="margin-left:1%; width: 84%;" value="<?php echo $orden_venta["observaciones"]; ?>">
        </div>

        <div class="form-group" style="display: flex;">
            <label for="label0" class="control-label encabezado-form" style="margin-left:1%; margin-top:10px; width: 10%; text-align: right;">Categoria:</label>
            <input type="text" class="form-control" id="producto" name="producto" style="margin-left:1%; width: 20%;" maxlength="100" disabled value="<?php echo $orden_venta["producto"] ? $orden_venta["producto_cat"] : $orden_venta["maquina_cat"]; ?>">
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" id="btn_volver" class="btn btn-default" data-dismiss="modal">Volver</button>
    </div>
</form>

<?php if ($orden_compra["es_insumo"]==0) { ?>
    <legend>Tareas asociadas</legend>
    <div id="tabla_asociada">
        <?php foreach ($tareas as $tarea) { ?>
            
        <?php } ?>

        <table id="tabla" namefile="OrdenCompras" totales="<?php echo $_SESSION["totales"]; ?>" registros="<?php echo $_SESSION['cant_reg']; ?>" pagina="<?php $_SESSION['pagina']; ?>" class="table table-striped table-hover" mes="<?php echo $mes; ?>" anio="<?php echo $anio; ?>" dia="<?php echo $dia; ?>" opcion="<?php echo $opcion; ?>"> 
            <thead>
                <tr class="row " style="background-color: transparent;">
                    <th class="text-left " orderby="descripcion" sentido="asc">Tarea</th>
                    <th class="text-left " orderby="descripcion" sentido="asc">Comentarios</th>
                    <th class="col-lg-1 col-md-1 col-sm-1 col-xs-1 text-center noExl"></th>
                    <th class="col-lg-1 col-md-1 col-sm-1 col-xs-1 text-center noExl"></th>
                </tr>
            </thead>
            <tbody id="body">
                <?php foreach ($tareas as $usu) { ?>
                    <tr class="row" codigo="<?php echo $usu["codigo"]; ?>">
                        <td class="text-left" style="vertical-align: middle;">
                            <?php echo $usu["nombre"]; ?>
                        </td>
                        <?php
                            $observaciones = "";
                            $valor = "";
                            foreach($tareas_realizadas as $tr){
                                if ($tr["cod_orden_trabajo_categoria"] == $usu["codigo"]){
                                    $observaciones = $tr["observaciones"];
                                    $valor = $tr["valor"];
                                }
                            }
                        ?>
                        <td class="text-left" style="vertical-align: middle;"><?php echo $observaciones; ?></td>
                        <td class="col-lg-1 col-md-1 col-sm-1 col-xs-1 text-center" style="vertical-align: middle;"><?php echo $valor; ?></td>
                        <td class="col-lg-1 col-md-1 col-sm-1 col-xs-1 text-center noExl" style="vertical-align: middle;">
                            <div class="saveChange" style="text-align: center;"><a href="#"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a></div>
                        </td>
                    </tr>
        <?php } ?>
            </tbody>
        </table>

    </div>
<?php } ?>
<br />
<legend>IMPORTANTE</legend>
<div style="width: 50%; margin-left: 25%; border: 3px solid #A00; text-align: center; padding: 10px;">
    CUALQUIER OTRO CAMBIO, QUE A CRITERIO DEL MECANICO CORRESPONDIESE REALIZAR, CONSULTAR CON GERENCIA
</div>

<script>
    var requestSent = false;

    $("tbody > tr").click(function () {
        $("tbody > tr").css("background-color", "");
        $(this).css("background-color", "#FFFFB8");
    });

    $("#btn_volver").click(function () {
        window.location.href = "orden_ventas.php";
    });

    $(".saveChange").click(function (){
        cod_ov = $("#loading").attr("codigo");
        codigo = $(this).closest('tr').attr("codigo");
        var parametros = {
            funcion: "getTarea",
            cod_ov: cod_ov,
            codigo: codigo
        }
        $.ajax({
            type: "POST",
            url: 'controller/orden_trabajos.controller.php',
            data: parametros,
            success: function (data) {
                $('#tareaUpdate').val(codigo);
                $('#cantidadUpdate').val("");
                $('#observacionesUpdate').val("");
                var datos = JSON.parse(data);
                if (datos) {
                    $('#cantidadUpdate').val(datos.valor);
                    $('#observacionesUpdate').val(datos.observaciones);
                }
            },
            error: function () {
                alert("Error");
            }
        });
        //event.preventDefault();
        $('#dataUpdate').modal('show');
    });
    
    function getFormData($form){
        var unindexed_array = $form.serializeArray();
        var indexed_array = {};
        $.map(unindexed_array, function(n, i){
            indexed_array[n['name']] = n['value'];
        });
        return indexed_array;
    }
</script>