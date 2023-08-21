
<form id="guardarDatosOrdenCompra">
    <div class="modal-body">
        <div id="datos_ajax_register"></div>

        <div class="form-group" style="display: flex;">
            <label for="label0" class="control-label encabezado-form" style="margin-left:1%; margin-top:10px; width: 10%; text-align: right;">Producto:</label>
            <input type="text" class="form-control" id="producto" name="producto" style="margin-left:1%; width: 84%;" maxlength="100" value="<?php echo $orden_venta["producto"] ? $orden_venta["producto"] . ' (' . $orden_venta["producto_codigo_mp"] . ')' : $orden_venta["maquina"] . ' (' . $orden_venta["maquina_descrip_abrev"] . ')'  ; ?>">
        </div>
        
        <div class="form-group" style="display: flex;">
            <label for="label0" class="control-label encabezado-form" style="margin-left:1%; margin-top:10px; width: 10%; text-align: right;">Nro:</label>
            <input type="text" class="form-control" id="codigo" name="codigo" style="margin-left:1%; width: 20%;" maxlength="100" disabled value="<?php echo $orden_venta["codigo"]; ?>">
            <label for="label0" class="control-label encabezado-form" style="margin-left:1%; margin-top:10px; width: 10%; text-align: right;">Cliente:</label>
            <input type="text" class="form-control" id="cliente" name="cliente" style="margin-left:1%; width: 20%;" maxlength="100"  value="<?php echo $orden_venta["cliente"]; ?>">
        </div>
        
        <div class="form-group" style="display: flex;">
            <label for="label0" class="control-label encabezado-form" style="margin-left:1%; margin-top:10px; width: 10%; text-align: right;">Cantidad:</label>
            <input type="text" class="form-control" id="cantidad" name="cantidad" style="margin-left:1%; width: 20%;" maxlength="100" value="<?php echo $orden_venta["cantidad"]; ?>">
            <label for="label0" class="control-label encabezado-form" style="margin-left:1%; margin-top:10px; width: 10%; text-align: right;">Precio:</label>
            <input type="text" class="form-control" id="precio_maquina" name="precio_maquina" style="margin-left:1%; width: 20%;" maxlength="100" value="<?php echo $orden_venta["precio_maquina"]; ?>">
            <label for="label0" class="control-label encabezado-form" style="margin-left:1%; margin-top:10px; width: 10%; text-align: right;">Fecha:</label>
            <input type="date" class="form-control" id="fecha" name="fecha" style="margin-left:1%; width: 20%;" maxlength="100" value="<?php echo $orden_venta["fecha"]; ?>">
        </div>

        <div class="form-group" style="display: flex;">
            <label for="nombre0" class="control-label encabezado-form" style="margin-left:1%; margin-top:10px; width: 10%; text-align: right;">Obs.:</label>
            <input type="text" class="form-control" id="descripcion" name="descripcion" required maxlength="100"  style="margin-left:1%; width: 84%;" value="<?php echo $orden_venta["observaciones"]; ?>">
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

    </div>
    <div class="modal-footer">
        <?php //if ($_SESSION["ver"] == 0) { ?>
            <button type="button" id="btn_guardar" class="btn btn-danger boton_marron_carni" >Guardar datos</button>
        <?php //} ?> 
        <button type="button" id="btn_volver" class="btn btn-default" data-dismiss="modal">Volver</button>
    </div>
</form>

<?php if ($orden_compra["es_insumo"]==0) { ?>
    <legend>Insumos asociados</legend>
    <div id="tabla_asociada">
        
    </div>
<?php } ?>

<script>
    var requestSent = false;

    $("tbody > tr").click(function () {
        $("tbody > tr").css("background-color", "");
        $(this).css("background-color", "#FFFFB8");
    });

    $("#btn_volver").click(function () {
        window.location.href = "orden_trabajos.php";
    });
    
    function getFormData($form){
        var unindexed_array = $form.serializeArray();
        var indexed_array = {};
        $.map(unindexed_array, function(n, i){
            indexed_array[n['name']] = n['value'];
        });
        return indexed_array;
    }

    function getRegistrosAsociados() {
        if (!requestSent) {
            requestSent = true;
            var codigo = $("#loading").attr("codigo");
            var parametros = {
                funcion: "getRegistrosFiltroAsociados",
                codigo: codigo
            }
            $.ajax({
                type: "POST",
                url: 'controller/orden_ventas.controller.php',
                data: parametros,
                success: function (datos) {
                    $("#tabla_asociada").html(datos);
                },
                error: function () {
                    alert("Error");
                },
                complete: function () {
                    requestSent = false;
                }
            });
        }
    }
    
    $("#btn_guardar").click(function (event) {
        //var formData = $("#guardarDatosComponente").serializeArray();
        var $form = $("#guardarDatosOrdenCompra");
      
        var formData = getFormData($form);
        alert(formData)
        var myJsonString = JSON.stringify(formData);
        alert(myJsonString)
        if (!requestSent) {
            requestSent = true;
            var codigo = $("#loading").attr("codigo");
         
            var parametros = {
                funcion: "editOrdenVenta",
                codigo: codigo,
                data: myJsonString
            }
            $.ajax({
                type: "POST",
                url: 'controller/orden_ventas.controller.php',
                data: parametros,
                success: function (datos) {
             
                    if (parseInt(datos) == 0) {
                        //location.reload();
                        window.location.href = "orden_ventas.php";
                    } else {
                        alert("Error: " + datos);
                    }
                },
                error: function () {
                    alert("Error");
                }
            });
            event.preventDefault();
        }
    });

    getRegistrosAsociados();
</script>