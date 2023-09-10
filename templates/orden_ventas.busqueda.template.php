<table id="tabla" namefile="OrdenVentas" totales="<?php echo $_SESSION["totales"]; ?>" registros="<?php echo $_SESSION['cant_reg']; ?>" pagina="<?php $_SESSION['pagina']; ?>" class="table table-striped table-hover" mes="<?php echo $mes; ?>" anio="<?php echo $anio; ?>" dia="<?php echo $dia; ?>" opcion="<?php echo $opcion; ?>">
    <thead>
        <tr class="row " style="background-color: transparent; ">
            <th class="text-center ordena" orderby="codigo" sentido="asc">Nro.</th>
            <th class="text-left ordena" orderby="cliente" sentido="asc">Cliente</th>
            <th class="text-left ordena" orderby="fecha_programada_entrega" sentido="asc">Fecha</th>
            <th class="text-left ordena" orderby="cod_maquina" sentido="asc">Producto</th>
            <th class="text-left ordena" orderby="cantidad" sentido="asc">Cantidad</th>
            <th class="text-left ordena" orderby="precio" sentido="asc">Precio</th>
            <th class="text-left ordena" orderby="observaciones" sentido="asc">Observaciones</th>
            <th class="col-lg-1 col-md-1 col-sm-1 col-xs-1 text-center ordena" orderby="estado" sentido="asc">Estado General</th>
            <th class="col-lg-1 col-md-1 col-sm-1 col-xs-1 text-center " orderby="estado" sentido="asc">Tipo</th>
            <th class="col-lg-1 col-md-1 col-sm-1 col-xs-1 text-center " orderby="estado" sentido="asc">Cobrado Parcial</th>
            <th class="col-lg-1 col-md-1 col-sm-1 col-xs-1 text-center " orderby="estado" sentido="asc">Importe Total</th>
            <th class="col-lg-1 col-md-1 col-sm-1 col-xs-1 text-center noExl">Acciones</th>
          
        </tr>
    </thead>
    <tbody id="body">
        <?php foreach ($registros as $usu) { ?>
            <tr class="row" codigo="<?php echo $usu["codigo"]; ?>" id="val">

                <td class="text-center" style="vertical-align: middle;"><?php echo $usu["codigo"]; ?></td>
                <td class="text-left" style="vertical-align: middle;"><?php echo $usu["cliente"]; ?></td>
                <td class="text-left" style="vertical-align: middle;"><?php echo $usu["fecha"]; ?></td>
                <td class="text-left" style="vertical-align: middle;"><?php echo $usu["producto"] ? $usu["producto"] : $usu["maquina"]; ?></td>
                <td class="text-left" style="vertical-align: middle;"><?php echo $usu["cantidad"]; ?></td>
                <td class="text-left" style="vertical-align: middle;"><?php echo $usu["precio_maquina"]; ?></td>
                <td class="text-left" style="vertical-align: middle;"><?php echo $usu["observaciones"]; ?></td>
                <td class="text-center" style="vertical-align: middle;"><?php echo $usu["estado_general"]; ?></td>
                <td class="text-center" style="vertical-align: middle;">
                    <?php 
                        foreach($tipos as $tipo){
                            if ($tipo["codigo"] == $usu["cod_orden_venta_tipo"]){
                                echo $tipo["descripcion"]; 
                            }
                        }
                    ?>
                </td>
                <td class="text-center" style="vertical-align: middle;">
                    <?php echo number_format($usu["cobrado_parcial"],2); ?>
                </td>
                <td class="text-center" style="vertical-align: middle;">
                    <?php echo number_format($usu["precio_maquina"] * $usu["cantidad"],2); ?>
                </td>
                <td class="col-lg-1 col-md-1 col-sm-1 col-xs-1 text-center noExl" style="vertical-align: middle;">
                    <div class="dropdown">
                        <button class="btn btn-sm btn-primary dropdown-toggle nuevo" id="menu" type="button" data-toggle="dropdown" style="font-size: 10px;height: 15px;" aria-expanded="true">
                            <div class="opciones" style="margin-top: -6px">Opciones <span class="caret"></span></div>
                        </button>
                        <ul class="dropdown-menu" role="menu" aria-labelledby="menu">
                            <li role="presentation" class="viewOrdenVenta"><a role="menuitem" tabindex="-1" href="#">Detalle</a></li>
                            <li role="presentation" class="pagosOrdenVenta"><a role="menuitem" tabindex="-1" href="#">Pagos</a></li>
                            <li role="presentation" class="editOrdenVenta"><a role="menuitem" tabindex="-1" href="#">Editar</a></li>
                            <li role="presentation" class="deleteOrdenVenta"><a role="menuitem" tabindex="-1" href="#">Eliminar</a></li>
                            <?php if ($usu["cod_orden_venta_tipo"] == 2){ ?>
                                <li role="presentation" class="tareasOrdenTrabajo"><a role="menuitem" tabindex="-1" href="#">Tareas</a></li>
                            <?php } ?>
                        </ul>
                    </div>
                </td>
            
            </tr>

        <?php } ?>
    </tbody>
</table>

<div class="col-lg-2" style="float: left;text-align: left;margin-top: 8px; display: none;" id='leyenda_paginacion_aux'>
    <label>Mostrando <?php echo ($_SESSION["pagina"] - 1) * $_SESSION["cant_reg"] + 1; ?> a <?php
                                                                                            if ($_SESSION["totales"] <= $_SESSION["pagina"] * $_SESSION["cant_reg"])
                                                                                                echo $_SESSION["totales"];
                                                                                            else
        if ($_SESSION["cant_reg"] == -1) {
                                                                                                echo $_SESSION["totales"];
                                                                                            } else {
                                                                                                echo $_SESSION["pagina"] * $_SESSION["cant_reg"];
                                                                                            }
                                                                                            ?> de <?php echo $_SESSION["totales"]; ?></label>
</div>

<script>
    var requestSent = false;

    $("#btn-eliminar-rol").click(function() {
        if (!requestSent) {
            requestSent = true;
            var parametros = {
                funcion: "deleteOrdenVenta",
                codigo: codigo
            }
            $.ajax({
                type: "POST",
                url: 'controller/orden_ventas.controller.php',
                data: parametros,
                success: function(datos) {
                    if (parseInt(datos) == 0) {
                        location.reload();
                    } else {
                        alert("Error: " + datos);
                    }
                },
                error: function() {
                    alert("Error");
                },
                complete: function() {
                    //me.data('requestRunning', false);
                    requestSent = false;
                }
            });
            event.preventDefault();
        }
    });

    $(".confirmarOrdenVenta").click(function() {
        codigo = $(this).closest('tr').attr("codigo");
        var parametros = {
            funcion: "cambiarEstadoOrdenVenta",
            codigo: codigo,
            estado: 2
        }
        $.ajax({
            type: "POST",
            url: 'controller/orden_ventas.controller.php',
            data: parametros,
            success: function(data) {
                location.reload();
            },
            error: function() {
                alert("Error");
            }
        });
    });

    $(".finalizarOrdenVenta").click(function() {
        codigo = $(this).closest('tr').attr("codigo");
        var parametros = {
            funcion: "cambiarEstadoOrdenVenta",
            codigo: codigo,
            estado: 3
        }
        $.ajax({
            type: "POST",
            url: 'controller/orden_ventas.controller.php',
            data: parametros,
            success: function(data) {
                location.reload();
            },
            error: function() {
                alert("Error");
            }
        });
    });

    $(".anularOrdenVenta").click(function() {
        codigo = $(this).closest('tr').attr("codigo");
        var parametros = {
            funcion: "cambiarEstadoOrdenVenta",
            codigo: codigo,
            estado: 4
        }
        $.ajax({
            type: "POST",
            url: 'controller/orden_ventas.controller.php',
            data: parametros,
            success: function(data) {
                location.reload();
            },
            error: function() {
                alert("Error");
            }
        });
    });

    $(".recepcionarOrdenVenta").click(function() {
        codigo = $(this).closest('tr').attr("codigo");
        window.location.href = "recepcion_orden_venta.php?codigo=" + codigo;
    });

    $(".verOrdenVenta").click(function() {
        //codigo = $(this).closest('tr').attr("codigo");
        //window.location.href = "recepcion_orden_venta.php?ver=1&codigo="+codigo;
        codigo = $(this).closest('tr').attr("codigo");
        var parametros = {
            funcion: "cambiarEstadoOrdenVenta",
            codigo: codigo,
            estado: 1
        }
        $.ajax({
            type: "POST",
            url: 'controller/orden_ventas.controller.php',
            data: parametros,
            success: function(data) {
                location.reload();
            },
            error: function() {
                alert("Error");
            }
        });
    });

    $(".viewOrdenVenta").click(function () {
        codigo = $(this).closest('tr').attr("codigo");
        window.location.href = "orden_venta.php?ver=1&codigo="+codigo;
    });

    $(".pagosOrdenVenta").click(function () {
        codigo = $(this).closest('tr').attr("codigo");
        window.location.href = "orden_venta_pagos.php?codigo="+codigo;
    });

    $(".editOrdenVenta").click(function() {
       
        codigo = $(this).closest('tr').attr("codigo");
       
        //window.location.href = "orden_venta.php?codigo="+codigo;
        $("#text-header-body").html("¿Desea eliminar el registro?");
        $("#btn-eliminar-rol").css("display", "inline-block");
        $("#btn-cancelar").text("Cancelar");
        var parametros = {
            funcion: "getOrdenVenta",
            codigo: codigo
        }

        $.ajax({
            type: "POST",
            url: 'controller/orden_ventas.controller.php',
            data: parametros,

            success: function(data) {

                var datos = JSON.parse(data);

                $('#observacionesUpdate').val(datos.observaciones);
                $('#clienteUpdate').val(datos.cod_cliente);
                $('#paisUpdate').val(datos.pais);
                $('#provinciaUpdate').val(datos.provincia);
                $('#cuitUpdate').val(datos.cuit)
                $('#tipousoVentaUpdate').val(datos.es_usado);
                $('#tipousoVentaUpdate').change();
                $('#tipoproductoVentaUpdate').val(datos.es_insumo);
                $('#tipoproductoVentaUpdate').change();

                $('#fechaUpdate').val(datos.fecha);
                $('#fechaentregaUpdate').val(datos.fecha_estimada_entrega);
                $('#precioUpdate').val(datos.precio_maquina);
                $('#generalUpdate').val(datos.cod_orden_venta_estado_general);
                $('#entregaUpdate').val(datos.cod_orden_venta_estado_entrega);
                $('#cobranzaUpdate').val(datos.cod_orden_venta_estado_cobranza);
                
                $('#tipoUpdate').val(datos.cod_orden_venta_tipo);

                $('#productoUpdate').val(0);
                //$('.tipo_de_insumo').removeAttr('selected');

  
                $('.tipo_de_insumo[tipo='+datos.es_insumo+']').each(function () {
                    if ($(this).val() == datos.cod){
                        $(this).attr("selected", "selected");
                    }
                });
                            

                //   $('#productoUpdate').val(datos.cod_componente);








            },
            error: function() {
                alert("Error");
            }
        });
        //event.preventDefault();
        $('#dataUpdate').modal('show');
    });

    $(".deleteOrdenVenta").click(function() {
        codigo = $(this).closest('tr').attr("codigo");
        $("#name-header-modal").html("<b>Eliminar</b>");
        $("#text-header-body").html("¿Desea eliminar el registro ?");
        $("#btn-eliminar").css("display", "inline-block");
        $("#btn-cancelar").text("Cancelar");
        $('#myModal').modal('show');
    });

    $(".ordena").click(function() {

        var orderby = $(this).attr("orderby");
        var sentido = $("#div_tabla").attr("sentido");

        if (sentido == "asc") {
            sentido = "desc";
        } else {
            sentido = "asc";
        }

        $("#div_tabla").attr("orderby", orderby);
        $("#div_tabla").attr("sentido", sentido);

        var registros = $("#cant_reg").val();
        var pagina = 1;
        var busqueda = $("#busqueda").val();
        getRegistros(orderby, sentido, registros, pagina, busqueda, null);
        //callGetRegistros(orderby, sentido, registros, pagina, busqueda, this);
        //return false;
    });

    $("tbody > tr").click(function() {
        $("tbody > tr").css("background-color", "");
        $(this).css("background-color", "#FFFFB8");
    });

    $(".tareasOrdenTrabajo").click(function () {
        codigo = $(this).closest('tr').attr("codigo");
        window.location.href = "orden_trabajo_tareas.php?&codigo="+codigo;
    });
</script>