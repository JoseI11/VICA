
<form id="guardarDatosOrdenCompra" ver="<?php echo $ver; ?>">
    <div class="modal-body">
        <div id="datos_ajax_register"></div>
        <div class="form-group">
            <label for="nombre0" class="control-label">Descripcion:</label>
            <input type="text" class="form-control" id="descripcion" name="descripcion" required maxlength="100" value="<?php echo $orden_compra["observaciones"]; ?>" disabled>
        </div>
        <div class="form-group" style="display: flex;">
            <label for="label0" class="control-label encabezado-form" style="margin-left:1%; margin-top:10px; width: 10%; text-align: right;">Fecha:</label>
            <input type="date" class="form-control" id="fecha" name="fecha" style="margin-left:1%; width: 20%;" maxlength="100" value="<?php echo $orden_compra["fecha"]; ?>" disabled>
            <label for="label0" class="control-label encabezado-form" style="margin-left:1%; margin-top:10px; width: 10%; text-align: right;">Proveedor:</label>
            <select id="proveedor" style="margin-left:1%; width: 61%;" class="form-control" name="proveedor" disabled>
                <?php foreach ($proveedores as $reg) {?>
                    <option type="text" value="<?php echo $reg["codigo"]; ?>" <?php echo ($orden_compra["cod_proveedor"]==$reg["codigo"]) ? "selected" : ''; ?>><?php echo $reg["descripcion"]; ?></option>
                <?php } ?>
            </select>
        </div>
        <div class="form-group" style="display: flex;">
            <label for="label0" class="control-label encabezado-form" style="margin-left:1%; margin-top:10px; width: 10%; text-align: right;">Estimado:</label>
            <input type="date" class="form-control" id="estimado" name="estimado" style="margin-left:1%; width: 20%;" maxlength="100" value="<?php echo $orden_compra["fecha_estimada_recepcion"]; ?>" <?php echo $ver == 1 ? 'disabled' : ''; ?>>
            <label for="label0" class="control-label encabezado-form" style="margin-left:1%; margin-top:10px; width: 10%; text-align: right;">Recepcion:</label>
            <input type="date" class="form-control" id="recepcion" name="recepcion" style="margin-left:1%; width: 20%;" maxlength="100" value="<?php echo $orden_compra["fecha_recepcion"]; ?>" <?php echo $ver == 1 ? 'disabled' : ''; ?>>
            <label for="label0" class="control-label encabezado-form" style="margin-left:1%; margin-top:10px; width: 10%; text-align: right;">Remito:</label>
            <input type="text" class="form-control" id="remito" name="remito" style="margin-left:1%; width: 20%;" maxlength="100" value="<?php echo $orden_compra["remito"]; ?>" <?php echo $ver == 1 ? 'disabled' : ''; ?>>
        </div>
    </div>
    <?php if ($ver == 0) { ?>
        <div class="modal-footer">
            <button type="button" id="btn_guardar" class="btn btn-danger boton_marron_carni" >Guardar datos</button>
            <button type="button" id="btn_volver" class="btn btn-default" data-dismiss="modal">Volver</button>
        </div>
    <?php } ?>
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
        window.location.href = "orden_compras.php";
    });
    
    function getFormData($form){
        var unindexed_array = $form.serializeArray();
        var indexed_array = {};
        $.map(unindexed_array, function(n, i){
            indexed_array[n['name']] = n['value'];
        });
        return indexed_array;
    }
    
    $("#btn_guardar").click(function (event) {
        //var formData = $("#guardarDatosOrdenCompra").serializeArray();
        var $form = $("#guardarDatosOrdenCompra");
        var formData = getFormData($form);
        var myJsonString = JSON.stringify(formData);
        if (!requestSent) {
            requestSent = true;
            var codigo = $("#loading").attr("codigo");
            var parametros = {
                funcion: "editOrdenCompraRec",
                codigo: codigo,
                data: myJsonString
            }
            $.ajax({
                type: "POST",
                url: 'controller/orden_compras.controller.php',
                data: parametros,
                success: function (datos) {
                    console.log(datos);
                    if (parseInt(datos) == 0) {
                        location.reload();
                        //window.location.href = "orden_compras.php";
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

    function getRegistrosAsociados() {
        if (!requestSent) {
            requestSent = true;
            var codigo = $("#loading").attr("codigo");
            var parametros = {
                funcion: "getRegistrosFiltroAsociadosRecepcion",
                codigo: codigo
            }
            $.ajax({
                type: "POST",
                url: 'controller/orden_compras.controller.php',
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

    getRegistrosAsociados();

    $("#actualidarDatosOrdenCompra").submit(function (event) {
        if (!requestSent) {
            requestSent = true;
            var codigo = $("#loading").attr("codigo");
            var parametros = {
                funcion: "updateOrdenCompraInsumo",
                codigo: codigo,
                insumo: $("#insumoUpdate").val(),
                cantidad: $("#cantidadUpdate").val()
            }
            $.ajax({
                type: "POST",
                url: 'controller/orden_compras.controller.php',
                data: parametros,
                success: function (datos) {
                    if (parseInt(datos) == 0) {
                        getRegistrosAsociados();
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

    $("#guardarDatosOrdenCompra").submit(function (event) {
        if (!requestSent) {
            requestSent = true;
            var parametros = {
                funcion: "addOrdenCompraInsumo",
                insumo: $("#cantidadAdd").val(),
                cantidad: $("#cantidadAdd").val()
            }
            $.ajax({
                type: "POST",
                url: 'controller/orden_compras.controller.php',
                data: parametros,
                success: function (datos) {
                    if (parseInt(datos) == 0) {
                        getRegistrosAsociados();
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
</script>