<form id="guardarDatosMaquina">
    <div class="modal-body">
        <div id="datos_ajax_register"></div>
        <div class="form-group">
            <label for="nombre0" class="control-label">Nombre:</label>
            <input type="text" class="form-control" id="descripcion" name="descripcion" required maxlength="100" value="<?php echo $maquina["descripcion"]; ?>">
        </div>
        <div class="form-group">
            <label for="nombre0" class="control-label">Codigo:</label>
            <input type="text" class="form-control" id="descrip_abrev" name="descrip_abrev" required maxlength="100" value="<?php echo $maquina["descrip_abrev"]; ?>">
        </div>
        <div class="form-group">
            <label for="nombre0" class="control-label">Observaciones:</label>
            <input type="text" class="form-control" id="observaciones" name="observaciones" value="<?php echo $maquina["observaciones"]; ?>">
        </div>
        <div class="form-group">
            <label for="nombre0" class="control-label">Precio unitario:</label>
            <input type="text" class="form-control" id="preciounitario" name="preciounitario" value="<?php echo $maquina["precio_unitario"]; ?>">
        </div>
        <div class="form-group">
            <label for="nombre0" class="control-label">Costo unitario:</label>
            <input type="text" class="form-control" id="costounitario" name="costounitario" value="<?php echo $maquina["costo_unitario"]; ?>">
        </div>
        <div class="form-group">
            <label for="label0" class="control-label encabezado-form">Modelo:</label>
            <select id="modelo" class="form-control" name="modelo">
                <?php foreach ($categorias as $reg) { ?>
                    <option type="text" value="<?php echo $reg["codigo"]; ?>" <?php echo ($maquina["cod_maquina_modelo"] == $reg["codigo"]) ? "selected" : ''; ?>><?php echo $reg["descripcion"]; ?></option>
                <?php } ?>
            </select>
        </div>
        <div class="form-group">
            <label for="label0" class="control-label encabezado-form">Uso:</label>
            <select id="tipouso" class="form-control" name="tipouso">
                <option type="text" value="1" <?php echo ($maquina["es_usado"] == 1) ? "selected" : ''; ?>>Usado</option>
                <option type="text" value="0" <?php echo ($maquina["es_usado"] == 0) ? "selected" : ''; ?>>Nuevo</option>
            </select>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" id="btn_guardar" class="btn btn-danger boton_marron_carni">Guardar datos</button>
        <button type="button" id="btn_volver" class="btn btn-default" data-dismiss="modal">Volver</button>
    </div>
</form>

<?php if ($maquina["es_componente"] == 0) { ?>
    <legend>Componentes asociados</legend>
    <div id="tabla_asociada">

    </div>
<?php } ?>

<script>
    var requestSent = false;

    $("tbody > tr").click(function() {
        $("tbody > tr").css("background-color", "");
        $(this).css("background-color", "#FFFFB8");
    });

    $("#btn_volver").click(function() {
        window.location.href = "maquinas.php";
    });

    function getFormData($form) {
        var unindexed_array = $form.serializeArray();
        var indexed_array = {};
        $.map(unindexed_array, function(n, i) {
            indexed_array[n['name']] = n['value'];
        });
        return indexed_array;
    }

    $("#btn_guardar").click(function(event) {
        //var formData = $("#guardarDatosMaquina").serializeArray();
        var $form = $("#guardarDatosMaquina");
        var formData = getFormData($form);
        var myJsonString = JSON.stringify(formData);
        if (!requestSent) {
            requestSent = true;
            var codigo = $("#loading").attr("codigo");
            var parametros = {
                funcion: "editMaquina",
                codigo: codigo,
                data: myJsonString
            }
            $.ajax({
                type: "POST",
                url: 'controller/maquinas.controller.php',
                data: parametros,
                success: function(datos) {
                    console.log(datos);
                    if (parseInt(datos) == 0) {
                        //location.reload();
                        window.location.href = "maquinas.php";
                    } else {
                        alert("Error: " + datos);
                    }
                },
                error: function() {
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
                url: 'controller/maquinas.controller.php',
                data: parametros,
                success: function(datos) {
                    $("#tabla_asociada").html(datos);
                },
                error: function() {
                    alert("Error");
                },
                complete: function() {
                    requestSent = false;
                }
            });
        }
    }

    getRegistrosAsociados();

    $("#actualidarDatosMaquina").submit(function(event) {
        if (!requestSent) {
            requestSent = true;
            var codigo = $("#loading").attr("codigo");
            var parametros = {
                funcion: "updateMaquinaComponente",
                codigo: codigo,
                componente: $("#componenteUpdate").val(),
                cantidad: $("#cantidadUpdate").val()

            }
            $.ajax({
                type: "POST",
                url: 'controller/maquinas.controller.php',
                data: parametros,
                success: function(datos) {
                    if (parseInt(datos) == 0) {
                        getRegistrosAsociados();
                    } else {
                        alert("Error: " + datos);
                    }
                },
                error: function() {
                    alert("Error");
                }
            });
            event.preventDefault();
        }
    });

    $("#guardarDatosMaquina").submit(function(event) {
        if (!requestSent) {
            requestSent = true;
            var parametros = {
                funcion: "addMaquinaComponente",
                componente: $("#cantidadAdd").val(),
                cantidad: $("#cantidadAdd").val()
            }
            $.ajax({
                type: "POST",
                url: 'controller/maquinas.controller.php',
                data: parametros,
                success: function(datos) {
                    if (parseInt(datos) == 0) {
                        getRegistrosAsociados();
                    } else {
                        alert("Error: " + datos);
                    }
                },
                error: function() {
                    alert("Error");
                }
            });
            event.preventDefault();
        }
    });
</script>