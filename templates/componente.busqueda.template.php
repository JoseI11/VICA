
<form id="guardarDatosComponente">
    <div class="modal-body">
        <div id="datos_ajax_register"></div>
        <div class="form-group">
            <label for="nombre0" class="control-label">Nombre:</label>
            <input type="text" class="form-control" id="descripcion" name="descripcion" required maxlength="100" value="<?php echo $componente["descripcion"]; ?>">
        </div>

        <div class="form-group" style="display: flex;">
            <label for="label0" class="control-label encabezado-form" style="margin-left:1%; margin-top:10px; width: 10%; text-align: right;">Codigo:</label>
            <input type="text" class="form-control" id="codigo_mp" name="codigo_mp" style="margin-left:1%; width: 20%;" maxlength="100" value="<?php echo $componente["codigo_mp"]; ?>">
            <label for="label0" class="control-label encabezado-form" style="margin-left:1%; margin-top:10px; width: 10%; text-align: right;">Dimension:</label>
            <input type="text" class="form-control" id="dimension" name="dimension" style="margin-left:1%; width: 20%;" maxlength="100" value="<?php echo $componente["dimension"]; ?>">
            <label for="label0" class="control-label encabezado-form" style="margin-left:1%; margin-top:10px; width: 10%; text-align: right;">Espesor:</label>
            <input type="text" class="form-control" id="espesor" name="espesor" style="margin-left:1%; width: 20%;" maxlength="100" value="<?php echo $componente["espesor"]; ?>">
        </div>

        <div class="form-group" style="display: flex;">
            <label for="label0" class="control-label encabezado-form" style="margin-left:1%; margin-top:10px; width: 10%; text-align: right;">Largo:</label>
            <input type="text" class="form-control" id="largo" name="largo" style="margin-left:1%; width: 20%;" maxlength="100" value="<?php echo $componente["largo"]; ?>">
            <label for="label0" class="control-label encabezado-form" style="margin-left:1%; margin-top:10px; width: 10%; text-align: right;">Largo Total:</label>
            <input type="text" class="form-control" id="largo_total" name="largo_total" style="margin-left:1%; width: 20%;" maxlength="100" value="<?php echo $componente["largo_total"]; ?>">
            <label for="label0" class="control-label encabezado-form" style="margin-left:1%; margin-top:10px; width: 10%; text-align: right;">Peso:</label>
            <input type="text" class="form-control" id="peso" name="peso" style="margin-left:1%; width: 20%;" maxlength="100" value="<?php echo $componente["peso"]; ?>">
        </div>

        <div class="form-group" style="display: flex;">
            <label for="label0" class="control-label encabezado-form" style="margin-left:1%; margin-top:10px; width: 10%; text-align: right;">Peso Total:</label>
            <input type="text" class="form-control" id="peso_total" name="peso_total" style="margin-left:1%; width: 20%;" maxlength="100" value="<?php echo $componente["peso_total"]; ?>">
            <label for="label0" class="control-label encabezado-form" style="margin-left:1%; margin-top:10px; width: 10%; text-align: right;">Unidad:</label>
            <select id="unidad" style="margin-left:1%; width: 20%;" class="form-control" name="unidad">
                <?php foreach ($unidades as $reg) {?>
                    <option type="text" value="<?php echo $reg["codigo"]; ?>" <?php echo ($componente["cod_unidad"]==$reg["codigo"]) ? "selected" : ''; ?>><?php echo $reg["descrip_abrev"]; ?></option>
                <?php } ?>
            </select>
            <label for="label0" class="control-label encabezado-form" style="margin-left:1%; margin-top:10px; width: 10%; text-align: right;">Categoría:</label>
            <select id="categoria" style="margin-left:1%; width: 20%;" class="form-control" name="categoria">
                <?php foreach ($categorias as $reg) {?>
                    <option type="text" value="<?php echo $reg["codigo"]; ?>" <?php echo ($componente["cod_componente_categoria"]==$reg["codigo"]) ? "selected" : ''; ?>><?php echo $reg["descripcion"]; ?></option>
                <?php } ?>
            </select>
        </div>
        <div class="form-group" style="display: flex;">
            <label for="label0" class="control-label encabezado-form" style="margin-left:1%; margin-top:10px; width: 10%; text-align: right;">Costo:</label>
            <input type="text" class="form-control" id="costo" name="costo" style="margin-left:1%; width: 20%;" maxlength="100" value="<?php echo $componente["costo_unitario"]; ?>">
            <label for="label0" class="control-label encabezado-form" style="margin-left:1%; margin-top:10px; width: 10%; text-align: right;">Precio:</label>
            <input type="text" class="form-control" id="precio" name="precio" style="margin-left:1%; width: 20%;" maxlength="100" value="<?php echo $componente["precio_unitario"]; ?>">
            <label for="label0" class="control-label encabezado-form" style="margin-left:1%; margin-top:10px; width: 10%; text-align: right;">IVA:</label>
            <input type="text" class="form-control" id="iva" name="iva" style="margin-left:1%; width: 20%;" maxlength="100" value="<?php echo $componente["iva"]; ?>">
        </div>
        <div class="form-group" style="display: flex;">
            <label for="label0" class="control-label encabezado-form" style="margin-left:1%; margin-top:10px; width: 10%; text-align: right;">Stock Mínimo:</label>
            <input type="text" class="form-control" id="minimo" name="minimo" style="margin-left:1%; width: 20%;" maxlength="100" value="<?php echo $componente["stock_minimo"]; ?>">
            <label for="label0" class="control-label encabezado-form" style="margin-left:1%; margin-top:10px; width: 10%; text-align: right;">Stock Máximo:</label>
            <input type="text" class="form-control" id="maximo" name="maximo" style="margin-left:1%; width: 20%;" maxlength="100" value="<?php echo $componente["stock_maximo"]; ?>">
            <label for="label0" class="control-label encabezado-form" style="margin-left:1%; margin-top:10px; width: 10%; text-align: right;">Es Insumo:</label>
            <select id="insumo" style="margin-left:1%; width: 20%;" class="form-control" name="insumo" disabled>
                <option type="text" value="0" <?php echo ($componente["es_insumo"]==0) ? "selected" : ''; ?> ><?php echo "NO"; ?></option>
                <option type="text" value="1" <?php echo ($componente["es_insumo"]==1) ? "selected" : ''; ?>><?php echo "SI"; ?></option>
            </select>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" id="btn_guardar" class="btn btn-danger boton_marron_carni" >Guardar datos</button>
        <button type="button" id="btn_volver" class="btn btn-default" data-dismiss="modal">Volver</button>
    </div>
</form>

<?php if ($componente["es_insumo"]==0) { ?>
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
        window.location.href = "componentes.php";
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
        //var formData = $("#guardarDatosComponente").serializeArray();
        var $form = $("#guardarDatosComponente");
        var formData = getFormData($form);
        var myJsonString = JSON.stringify(formData);
        if (!requestSent) {
            requestSent = true;
            var codigo = $("#loading").attr("codigo");
            var parametros = {
                funcion: "editComponente",
                codigo: codigo,
                data: myJsonString
            }
            $.ajax({
                type: "POST",
                url: 'controller/componentes.controller.php',
                data: parametros,
                success: function (datos) {
                    console.log(datos);
                    if (parseInt(datos) == 0) {
                        //location.reload();
                        window.location.href = "componentes.php";
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
                funcion: "getRegistrosFiltroAsociados",
                codigo: codigo
            }
            $.ajax({
                type: "POST",
                url: 'controller/componentes.controller.php',
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

    $("#actualidarDatosComponente").submit(function (event) {
        if (!requestSent) {
            requestSent = true;
            var codigo = $("#loading").attr("codigo");
            var parametros = {
                funcion: "updateComponenteInsumo",
                codigo: codigo,
                insumo: $("#insumoUpdate").val(),
                cantidad: $("#cantidadUpdate").val()
            }
            $.ajax({
                type: "POST",
                url: 'controller/componentes.controller.php',
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

    $("#guardarDatosComponente").submit(function (event) {
        if (!requestSent) {
            requestSent = true;
            var parametros = {
                funcion: "addComponenteInsumo",
                insumo: $("#cantidadAdd").val(),
                cantidad: $("#cantidadAdd").val()
            }
            $.ajax({
                type: "POST",
                url: 'controller/componentes.controller.php',
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