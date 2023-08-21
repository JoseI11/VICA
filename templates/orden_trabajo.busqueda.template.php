<div class="tabs-container">
    <ul class="nav nav-tabs" role="tablist">
        <li class="active"><a class="nav-link" data-toggle="tab" href="#tab-1">Insumos asociados</a></li>
        <li><a class="nav-link" data-toggle="tab" href="#tab-2">Detalles</a></li>
        <li><a class="nav-link" data-toggle="tab" href="#tab-3">Poleas/Correas</a></li>
        <li><a class="nav-link" data-toggle="tab" href="#tab-4">Transmisión/Electricidad</a></li>
    </ul>
    <div class="tab-content">
        <div role="tabpanel" id="tab-1" class="tab-pane active">
            <div class="panel-body" id="tabla_asociada"></div>
        </div>
        <div role="tabpanel" id="tab-2" class="tab-pane">
            <div class="panel-body" id="tabla_detalle"></div>

        </div>
        <div role="tabpanel" id="tab-3" class="tab-pane">
            
            <div class="panel-body" id="tabla_correas"></div>
            
        </div>
        <div role="tabpanel" id="tab-4" class="tab-pane">
            
        <div class="panel-body" id="tabla_transmision"></div>
            
        </div>
    </div>
</div>


<form id="guardarDatosOrdenCompra">
    <div class="form-group">
        <div id="datos_ajax_register"></div>
        <?php if ($orden_venta["codigo"] != 0) { ?>
            <div class="ibox">
                <div class="ibox-title">
                    <h5>Orden de Venta</h5>
                </div>
                <div class="ibox-content">

                    <div class="form-group" style="display: flex;">
                    <label for="label0" class="control-label encabezado-form" style="margin-left:1%; margin-top:10px; width: 10%; text-align: right;">Producto:</label>
                    <input type="text" class="form-control" id="producto" name="producto" style="margin-left:1%; width: 86%;" maxlength="100" value="<?php echo $orden_venta["producto"] ? $orden_venta["producto"] . ' (' . $orden_venta["producto_codigo_mp"] . ')' : $orden_venta["maquina"] . ' (' . $orden_venta["maquina_descrip_abrev"] . ')' ; ?>">
                    </div>

                    <div class="form-group" style="display: flex;">
                    <label for="label0" class="control-label encabezado-form" style="margin-left:1%; margin-top:10px; width: 10%; text-align: right;">Nro:</label>
                    <input type="text" class="form-control" id="codigo" name="codigo" style="margin-left:1%; width: 20%;" maxlength="100" value="<?php echo $orden_venta["codigo"]; ?>">
                    <label for="label0" class="control-label encabezado-form" style="margin-left:1%; margin-top:10px; width: 10%; text-align: right;">Cliente:</label>
                    <input type="text" class="form-control" id="cliente" name="cliente" style="margin-left:1%; width: 20%;" maxlength="100" value="<?php echo $orden_venta["cliente"]; ?>">
                    </div>
                    
                    <div class="form-group" style="display: flex;">
                        <label for="label0" class="control-label encabezado-form" style="margin-left:1%; margin-top:10px; width: 10%; text-align: right;">Cantidad:</label>
                        <input type="text" class="form-control" id="cantidad" name="cantidad" style="margin-left:1%; width: 20%;" maxlength="100" value="<?php echo $orden_venta["cantidad"]; ?>">
                        <label for="label0" class="control-label encabezado-form" style="margin-left:1%; margin-top:10px; width: 10%; text-align: right;">Precio:</label>
                        <input type="text" class="form-control" id="precio_maquina" name="precio_maquina" style="margin-left:1%; width: 20%;" maxlength="100" value="<?php echo $orden_venta["precio_maquina"]; ?>">
                        <label for="label0" class="control-label encabezado-form" style="margin-left:1%; margin-top:10px; width: 10%; text-align: right;">Fecha:</label>
                        <input type="date" class="form-control" id="fecha" name="fecha" style="margin-left:1%; width: 20%;" maxlength="100"  value="<?php echo $orden_venta["fecha"]; ?>">
                    </div>
                </div>
            </div>
        <?php } ?>
     
        <?php if ($orden_trabajo["codigo_sinfin"] != "") { ?>
            <div class="ibox">
                <div class="ibox-title">
                    <h5>Sin Fin</h5>
                </div>
                <div class="ibox-content">
                    <div class="form-group" style="display: flex;">
                        <label for="nombre0" class="control-label encabezado-form" style="margin-left:1%; margin-top:10px; width: 20%; text-align: right;">Código:</label>
                        <input type="text" class="form-control" id="descripcion" name="descripcion" required maxlength="100" style="margin-left:1%; width: 74%;" value="<?php echo $orden_trabajo["codigo_sinfin"]; ?>">
                    </div>
                    <div class="form-group" style="display: flex;">
                        <label for="nombre0" class="control-label encabezado-form" style="margin-left:1%; margin-top:10px; width: 20%; text-align: right;">Descripción:</label>
                        <input type="text" class="form-control" id="descripcion" name="descripcion" required maxlength="100" style="margin-left:1%; width: 74%;" value="<?php echo $orden_trabajo["dimension_sinfin"]; ?>">
                    </div>
                    <div class="form-group" style="display: flex;">
                        <label for="nombre0" class="control-label encabezado-form" style="margin-left:1%; margin-top:10px; width: 20%; text-align: right;">Detalle:</label>
                        <input type="text" class="form-control" id="sinfinDetalle" name="sinfinDetalle" style="margin-left:1%; width: 74%;" value="<?php echo $orden_trabajo["sinfin_detalle"]; ?>">
                    </div>
                    <div class="form-group" style="display: flex;">
                        <label for="label0" class="control-label encabezado-form" style="margin-left:1%; margin-top:10px; width: 20%; text-align: right;">Personal:</label>
                        <select id="sinfinpersonaAdd" class="form-control" name="sinfinpersonaAdd" style="margin-left:1%; width: 74%;" >
                            <?php foreach ($personas as $reg) {?> 
                                <option type="text" value="<?php echo $reg["codigo"]; ?>" <?php if ($reg['codigo'] == $orden_trabajo["sinfin_empleado"]): ?> selected="selected"<?php endif; ?>>
                                    <?php echo $reg["descripcion"]; ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group" style="display: flex;">
                        <label for="nombre0" class="control-label encabezado-form" style="margin-left:1%; margin-top:10px; width: 20%; text-align: right;">Numero Seguimiento:</label>
                        <input type="text" class="form-control" id="sinfinSeguimiento" name="sinfinSeguimiento" required maxlength="100"  style="margin-left:1%; width: 74%;" value="<?php echo $orden_trabajo["sinfin_seguimiento"]; ?>">
                    </div>


                </div>
            </div>
        <?php } ?>

        <?php if ($orden_trabajo["codigo_cajaquebrado"] != "") { ?>
            <div class="ibox">
                <div class="ibox-title">
                    <h5>Caja de Quebrado 1</h5>
                </div>
                <div class="ibox-content">
                    <div class="form-group" style="display: flex;">
                        <label for="nombre0" class="control-label encabezado-form" style="margin-left:1%; margin-top:10px; width: 20%; text-align: right;">Código:</label>
                        <input type="text" class="form-control" id="descripcion" name="descripcion" required maxlength="100" style="margin-left:1%; width: 74%;" value="<?php echo $orden_trabajo["codigo_cajaquebrado"]; ?>">
                    </div>
                    <div class="form-group" style="display: flex;">
                        <label for="nombre0" class="control-label encabezado-form" style="margin-left:1%; margin-top:10px; width: 20%; text-align: right;">Descripción:</label>
                        <input type="text" class="form-control" id="descripcion" name="descripcion" required maxlength="100" style="margin-left:1%; width: 74%;" value="<?php echo $orden_trabajo["dimension_cajaquebrado"]; ?>">
                    </div>
                    <div class="form-group" style="display: flex;">
                        <label for="nombre0" class="control-label encabezado-form" style="margin-left:1%; margin-top:10px; width: 20%; text-align: right;">Detalle:</label>
                        <input type="text" class="form-control" id="cajaquebradoDetalle" name="cajaquebradoDetalle" style="margin-left:1%; width: 74%;" value="<?php echo $orden_trabajo["cajaquebrado_detalle"]; ?>">
                    </div>
                    <div class="form-group" style="display: flex;">
                        <label for="label0" class="control-label encabezado-form" style="margin-left:1%; margin-top:10px; width: 20%; text-align: right;">Personal:</label>
                        <select id="cajaquebradopersonaAdd" class="form-control" name="cajaquebradopersonaAdd" style="margin-left:1%; width: 74%;" >
                            <?php foreach ($personas as $reg) {?> 
                                <option type="text" value="<?php echo $reg["codigo"]; ?>" <?php if ($reg['codigo'] == $orden_trabajo["cajaquebrado_empleado"]): ?> selected="selected"<?php endif; ?>>
                                    <?php echo $reg["descripcion"]; ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group" style="display: flex;">
                        <label for="nombre0" class="control-label encabezado-form" style="margin-left:1%; margin-top:10px; width: 20%; text-align: right;">Numero Seguimiento:</label>
                        <input type="text" class="form-control" id="cajaquebradoSeguimiento" name="cajaquebradoSeguimiento" required maxlength="100"  style="margin-left:1%; width: 74%;" value="<?php echo $orden_trabajo["cajaquebrado_seguimiento"]; ?>">
                    </div>


                </div>
            </div>
        <?php } ?>


        <?php if ($orden_trabajo["codigo_cajaquebrado2"] != "") { ?>
            <div class="ibox">
                <div class="ibox-title">
                    <h5>Caja de Quebrado 2</h5>
                </div>
                <div class="ibox-content">
                    <div class="form-group" style="display: flex;">
                        <label for="nombre0" class="control-label encabezado-form" style="margin-left:1%; margin-top:10px; width: 20%; text-align: right;">Código:</label>
                        <input type="text" class="form-control" id="descripcion" name="descripcion" required maxlength="100" style="margin-left:1%; width: 74%;" value="<?php echo $orden_trabajo["codigo_cajaquebrado2"]; ?>">
                    </div>
                    <div class="form-group" style="display: flex;">
                        <label for="nombre0" class="control-label encabezado-form" style="margin-left:1%; margin-top:10px; width: 20%; text-align: right;">Descripción:</label>
                        <input type="text" class="form-control" id="descripcion" name="descripcion" required maxlength="100" style="margin-left:1%; width: 74%;" value="<?php echo $orden_trabajo["dimension_cajaquebrado2"]; ?>">
                    </div>
                    <div class="form-group" style="display: flex;">
                        <label for="nombre0" class="control-label encabezado-form" style="margin-left:1%; margin-top:10px; width: 20%; text-align: right;">Detalle:</label>
                        <input type="text" class="form-control" id="cajaquebradoDetalle2" name="cajaquebradoDetalle2" style="margin-left:1%; width: 74%;" value="<?php echo $orden_trabajo["cajaquebrado_detalle2"]; ?>">
                    </div>
                    <div class="form-group" style="display: flex;">
                        <label for="label0" class="control-label encabezado-form" style="margin-left:1%; margin-top:10px; width: 20%; text-align: right;">Personal:</label>
                        <select id="cajaquebradopersona2Add" class="form-control" name="cajaquebradopersona2Add" style="margin-left:1%; width: 74%;" >
                            <?php foreach ($personas as $reg) {?> 
                                <option type="text" value="<?php echo $reg["codigo"]; ?>" <?php if ($reg['codigo'] == $orden_trabajo["cajaquebrado_empleado2"]): ?> selected="selected"<?php endif; ?>>
                                    <?php echo $reg["descripcion"]; ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group" style="display: flex;">
                        <label for="nombre0" class="control-label encabezado-form" style="margin-left:1%; margin-top:10px; width: 20%; text-align: right;">Numero Seguimiento:</label>
                        <input type="text" class="form-control" id="cajaquebradoSeguimiento2" name="cajaquebradoSeguimiento2" required maxlength="100"  style="margin-left:1%; width: 74%;" value="<?php echo $orden_trabajo["cajaquebrado_seguimiento2"]; ?>">
                    </div>


                </div>
            </div>
        <?php } ?>

       
        <?php if ($orden_trabajo["codigo_motor"] != "") { ?>
            <div class="ibox">
                <div class="ibox-title">
                    <h5>Motor</h5>
                </div>
                <div class="ibox-content">
                    <div class="form-group" style="display: flex;">
                        <label for="nombre0" class="control-label encabezado-form" style="margin-left:1%; margin-top:10px; width: 20%; text-align: right;">Código:</label>
                        <input type="text" class="form-control" id="descripcion" name="descripcion" required maxlength="100" style="margin-left:1%; width: 74%;" value="<?php echo $orden_trabajo["codigo_motor"]; ?>">
                    </div>
                    <div class="form-group" style="display: flex;">
                        <label for="nombre0" class="control-label encabezado-form" style="margin-left:1%; margin-top:10px; width: 20%; text-align: right;">Descripción:</label>
                        <input type="text" class="form-control" id="descripcion" name="descripcion" required maxlength="100" style="margin-left:1%; width: 74%;" value="<?php echo $orden_trabajo["dimension_motor"]; ?>">
                    </div>
                    <div class="form-group" style="display: flex;">
                        <label for="nombre0" class="control-label encabezado-form" style="margin-left:1%; margin-top:10px; width: 20%; text-align: right;">Detalle:</label>
                        <input type="text" class="form-control" id="motorDetalle" name="motorDetalle" required maxlength="100"  style="margin-left:1%; width: 74%;" value="<?php echo $orden_trabajo["motor_detalle"]; ?>">
                    </div>
                    
                    <div class="form-group" style="display: flex;">
                        <label for="nombre0" class="control-label encabezado-form" style="margin-left:1%; margin-top:10px; width: 20%; text-align: right;">Numero Seguimiento:</label>
                        <input type="text" class="form-control" id="motorSeguimiento" name="motorSeguimiento" required maxlength="100"  style="margin-left:1%; width: 74%;" value="<?php echo $orden_trabajo["motor_seguimiento"]; ?>">
                    </div>


                </div>
            </div>
        <?php } ?>

        <div class="ibox">
                <div class="ibox-title">
                    <h5>Orden de Trabajo</h5>
                </div>
                <div class="ibox-content">
                    <div class="form-group" style="display: flex;">
                    <label for="label0" class="control-label encabezado-form" style="margin-left:1%; margin-top:10px; width: 20%; text-align: right;">Fecha:</label>
                    <input type="date" class="form-control" id="fecha_programada_entrega" name="fecha_programada_entrega" style="margin-left:1%; width: 20%;" maxlength="100" value="<?php echo $orden_trabajo["fecha_programada_entrega"]; ?>">
                    
                    </div>
                    <div class="form-group" style="display: flex;">
                        <label for="nombre0" class="control-label encabezado-form" style="margin-left:1%; margin-top:10px; width: 20%; text-align: right;">Obs.:</label>
                        <input type="text" class="form-control" id="descripcion" name="descripcion" required maxlength="100"  style="margin-left:1%; width: 74%;" value="<?php echo $orden_trabajo["observaciones"]; ?>">
                    </div>

                    <div class="form-group" style="display: flex;">
                        <label for="label0" class="control-label encabezado-form" style="margin-left:1%; margin-top:10px; width: 20%; text-align: right;">Personal Encargado:</label>
                        <select id="PersonalOtAdd" style="margin-left:1%; width: 74%; height:70px;" class="form-control" name="PersonalOtAdd" multiple>
                            <?php foreach ($personas as $reg) {?>
                                <option type="text" value="<?php echo $reg["codigo"]; ?>" <?php echo (strpos($orden_trabajo["personal_ot"], '"'.$reg["codigo"].'"') !== false) ? "selected" : ''; ?>><?php echo $reg["descripcion"]; ?></option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="form-group" style="display: flex;">
                        <label for="label0" class="control-label encabezado-form" style="margin-left:1%; margin-top:10px; width: 20%; text-align: right;">Fecha Pintura:</label>
                        <input type="date" class="form-control" id="fecha_pintura" name="fecha_pintura" style="margin-left:1%; width: 20%;" maxlength="100" value="<?php echo $orden_trabajo["fecha_pintura"]; ?>">            
                    </div>
                    <div class="form-group" style="display: flex;">
                        <label for="label0" class="control-label encabezado-form" style="margin-left:1%; margin-top:10px; width: 20%; text-align: right;">Observaciones Pintura:</label>
                        <input type="text" class="form-control" id="observaciones_pintura" name="observaciones_pintura" required maxlength="100"  style="margin-left:1%; width: 74%;" value="<?php echo $orden_trabajo["observaciones_pintura"]; ?>">  
                    </div>
                    <div class="form-group" style="display: flex;">
                        <label for="label0" class="control-label encabezado-form" style="margin-left:1%; margin-top:10px; width: 20%; text-align: right;">Personal Pintura:</label>
                        <select id="personal_pintura" style="margin-left:1%; width: 74%;; height:70px;" class="form-control" name="personal_pintura" multiple>
                            <?php foreach ($personas as $reg) {?>
                                <option type="text" value="<?php echo $reg["codigo"]; ?>" <?php echo (strpos($orden_trabajo["personal_pintura"], '"'.$reg["codigo"].'"') !== false) ? "selected" : ''; ?>><?php echo $reg["descripcion"]; ?></option>
                            <?php } ?>
                        </select>
                    </div>


                </div>
            </div>


       
    </div>
    <div class="modal-footer">
        <?php if ($_SESSION["ver"] == 0) { ?>
            <button type="button" id="btn_guardar" class="btn btn-danger boton_marron_carni" >Guardar datos</button>
        <?php } ?> 
        <button type="button" id="btn_volver" class="btn btn-default" data-dismiss="modal">Volver</button>
    </div>
</form>









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
        indexed_array["personal_pintura"] = JSON.stringify($("#personal_pintura").val());
        indexed_array["personal_ot"] = JSON.stringify($("#PersonalOtAdd").val());
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
                funcion: "editOrdenTrabajo",
                codigo: codigo,
                data: myJsonString
            }
            $.ajax({
                type: "POST",
                url: 'controller/orden_trabajos.controller.php',
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
                funcion: "getRegistrosFiltroAsociados",
                codigo: codigo
            }
            $.ajax({
                type: "POST",
                url: 'controller/orden_trabajos.controller.php',
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

    function getRegistrosAsociados2() {
        if (!requestSent) {
            requestSent = true;
            var codigo = $("#loading").attr("codigo");
            var parametros = {
                funcion: "getRegistrosFiltroAsociados2",
                codigo: codigo
            }
            $.ajax({
                type: "POST",
                url: 'controller/orden_trabajos.controller.php',
                data: parametros,
                success: function (datos) {
                    $("#tabla_detalle").html(datos);
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

    getRegistrosAsociados2();

    function getRegistrosAsociados3() {
        if (!requestSent) {
            requestSent = true;
            var codigo = $("#loading").attr("codigo");
            var parametros = {
                funcion: "getRegistrosFiltroAsociados3",
                codigo: codigo
            }
            $.ajax({
                type: "POST",
                url: 'controller/orden_trabajos.controller.php',
                data: parametros,
                success: function (datos) {
                    $("#tabla_correas").html(datos);
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

    getRegistrosAsociados3();

    function getRegistrosAsociados4() {
        if (!requestSent) {
            requestSent = true;
            var codigo = $("#loading").attr("codigo");
            var parametros = {
                funcion: "getRegistrosFiltroAsociados4",
                codigo: codigo
            }
            $.ajax({
                type: "POST",
                url: 'controller/orden_trabajos.controller.php',
                data: parametros,
                success: function (datos) {
                    $("#tabla_transmision").html(datos);
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

    getRegistrosAsociados4();


    $("#actualidarDatosOrdenCompra").submit(function (event) {
        if (!requestSent) {
            requestSent = true;
            var cot_ot = $("#loading").attr("codigo");
            var parametros = {
                funcion: "updateOrdenTrabajoInsumo",
                codigo: codigo,
                orden_trabajo: cod_ot,
                insumo: $("#insumoUpdate").val(),
                cantidad: $("#cantidadUpdate").val()
            }
            $.ajax({
                type: "POST",
                url: 'controller/orden_trabajos.controller.php',
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
                funcion: "addOrdenTrabajoInsumo",
                orden_trabajo: cod_ot,
                insumo: $("#cantidadAdd").val(),
                cantidad: $("#cantidadAdd").val()
            }
            $.ajax({
                type: "POST",
                url: 'controller/orden_trabajos.controller.php',
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