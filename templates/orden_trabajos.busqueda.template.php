<table id="tabla" namefile="OrdenTrabajos" totales="<?php echo $_SESSION["totales"]; ?>" registros="<?php echo $_SESSION['cant_reg']; ?>" pagina="<?php $_SESSION['pagina']; ?>" class="table table-striped table-hover" mes="<?php echo $mes; ?>" anio="<?php echo $anio; ?>" dia="<?php echo $dia; ?>" opcion="<?php echo $opcion; ?>"> 
    <thead>
        <tr class="row " style="background-color: transparent;">
            <th class="text-center ordena" orderby="cliente" sentido="asc">Nro.</th>
            <th class="text-left ordena" orderby="fecha_programada_entrega" sentido="asc">Fecha</th>
            <th class="text-left ordena" orderby="cod_maquina" sentido="asc">Producto</th>
            <th class="text-left ordena" orderby="observaciones" sentido="asc">Observaciones</th>
            <th class="col-lg-1 col-md-1 col-sm-1 col-xs-1 text-center ordena" orderby="estado" sentido="asc">Reparacion Caja Quebrados</th>
            <th class="col-lg-1 col-md-1 col-sm-1 col-xs-1 text-center ordena" orderby="estado" sentido="asc">Estado</th>
            <th class="col-lg-1 col-md-1 col-sm-1 col-xs-1 text-center noExl">Acciones</th>
        </tr>
    </thead>
    <tbody id="body">
        <?php foreach ($registros as $usu) { ?>
            <tr class="row" codigo="<?php echo $usu["codigo"]; ?>" cod_orden_venta="<?php echo $usu["cod_orden_venta"]; ?>">
                <td class="text-center" style="vertical-align: middle;">
                    <?php echo $usu["codigo"]; ?>
                    <?php echo $usu["version"] > 0 ? "/".$usu["version"] : ""; ?>
                </td>
                <td class="text-left" style="vertical-align: middle;"><?php echo $usu["fecha_programada_entrega"]; ?></td>
                <td class="text-left" style="vertical-align: middle;">
                        <?php 
                            echo "OV#".$usu["cod_orden_venta"] . " - ";
                            echo $usu["maquina"] ? " MAQ: " : " COMP: ";
                            echo $usu["maquina"] ? $usu["maquina"] : $usu["producto"];
                        ?>
                    </td>
                <td class="text-left" style="vertical-align: middle;"><?php echo $usu["observaciones"]; ?></td>
                <td class="text-center" style="vertical-align: middle;"><?php echo $usu["caja_quebrados"] == 1 ? "SI" : "NO"; ?></td>
                <td class="text-center" style="vertical-align: middle;"><?php echo $usu["estado"]; ?></td>
                <td class="col-lg-1 col-md-1 col-sm-1 col-xs-1 text-center noExl" style="vertical-align: middle;">
                    <div class="dropdown">
                        <button class="btn btn-sm btn-primary dropdown-toggle nuevo" id="menu" type="button" data-toggle="dropdown" style="font-size: 10px;height: 15px;" aria-expanded="true">
                            <div class="opciones" style="margin-top: -6px">Opciones <span class="caret"></span></div>
                        </button>
                        <ul class="dropdown-menu" role="menu" aria-labelledby="menu">
                            <li role="presentation" class="personasOrdenTrabajo"><a role="menuitem" tabindex="-1" href="#">Personal</a></li>
                            <li role="presentation" class="tareasOrdenTrabajo"><a role="menuitem" tabindex="-1" href="#">Tareas</a></li>
                            <?php if ($usu["cod_orden_venta"] > 0){ ?>
                                <li role="presentation" class="viewOrdenVenta"><a role="menuitem" tabindex="-1" href="#">Detalle OV</a></li>
                            <?php } ?>
                            <?php if ($usu["cod_orden_trabajo_estado"] == 1){ ?>
                                <li role="presentation" class="confirmarOrdenTrabajo"><a role="menuitem" tabindex="-1" href="#">Comenzar</a></li>
                                <li role="presentation" class="editOrdenTrabajo"><a role="menuitem" tabindex="-1" href="#">Editar</a></li>
                                <li role="presentation" class="deleteOrdenTrabajo"><a role="menuitem" tabindex="-1" href="#">Eliminar</a></li>
                            <?php } ?>
                            <?php if ($usu["cod_orden_trabajo_estado"] == 2){ ?>
                                <li role="presentation" class="viewOrdenTrabajo"><a role="menuitem" tabindex="-1" href="#">Ver</a></li>
                                <li role="presentation" class="editOrdenTrabajo"><a role="menuitem" tabindex="-1" href="#">Editar</a></li>
                                <li role="presentation" class="finalizarOrdenTrabajo"><a role="menuitem" tabindex="-1" href="#">Finalizar</a></li>
                                <li role="presentation" class="anularOrdenTrabajo"><a role="menuitem" tabindex="-1" href="#">Anular</a></li>
                            <?php } ?>
                            <?php if ($usu["cod_orden_trabajo_estado"] == 3){ ?>
                                <li role="presentation" class="viewOrdenTrabajo"><a role="menuitem" tabindex="-1" href="#">Ver</a></li>
                                <li role="presentation" class="verOrdenTrabajo"><a role="menuitem" tabindex="-1" href="#">Reabrir</a></li>
                            <?php } ?>
                            <?php if ($usu["cod_orden_trabajo_estado"] == 4){ ?>
                                <li role="presentation" class="viewOrdenTrabajo"><a role="menuitem" tabindex="-1" href="#">Ver</a></li>
                                <li role="presentation" class="verOrdenTrabajo"><a role="menuitem" tabindex="-1" href="#">Reabrir</a></li>
                            <?php } ?>
                            <?php if ($usu["caja_quebrados"] == 1){ ?>
                                <li role="presentation" class="verOrdenTrabajoPDF"><a role="menuitem" tabindex="-1" target="_blank" href="PDF/ot_rep.php?codigo=<?php echo $usu["codigo"]; ?>">PDF</a></li>
                            <?php } else { ?>
                                <li role="presentation" class="verOrdenTrabajoPDF"><a role="menuitem" tabindex="-1" target="_blank" href="PDF/ot.php?codigo=<?php echo $usu["codigo"]; ?>">PDF</a></li>
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

    $("#btn-eliminar-rol").click(function () {
        if (!requestSent) {
            requestSent = true;
            var parametros = {
                funcion: "deleteOrdenTrabajo",
                codigo: codigo
            }
            $.ajax({
                type: "POST",
                url: 'controller/orden_trabajos.controller.php',
                data: parametros,
                success: function (datos) {
                    if (parseInt(datos) == 0) {
                        location.reload();
                    } else {
                        alert("Error: " + datos);
                    }
                },
                error: function () {
                    alert("Error");
                },
                complete: function () {
                    //me.data('requestRunning', false);
                    requestSent = false;
                }
            });
            event.preventDefault();
        }
    });

    $(".confirmarOrdenTrabajo").click(function () {
        codigo = $(this).closest('tr').attr("codigo");
        var parametros = {
            funcion: "cambiarEstadoOrdenTrabajo",
            codigo: codigo,
            estado: 2
        }
        $.ajax({
            type: "POST",
            url: 'controller/orden_trabajos.controller.php',
            data: parametros,
            success: function (data) {
                location.reload();
            },
            error: function () {
                alert("Error");
            }
        });
    });

    $(".finalizarOrdenTrabajo").click(function () {
        codigo = $(this).closest('tr').attr("codigo");
        var parametros = {
            funcion: "cambiarEstadoOrdenTrabajo",
            codigo: codigo,
            estado: 3
        }
        $.ajax({
            type: "POST",
            url: 'controller/orden_trabajos.controller.php',
            data: parametros,
            success: function (data) {
                location.reload();
            },
            error: function () {
                alert("Error");
            }
        });
    });

    $(".anularOrdenTrabajo").click(function () {
        codigo = $(this).closest('tr').attr("codigo");
        var parametros = {
            funcion: "cambiarEstadoOrdenTrabajo",
            codigo: codigo,
            estado: 4
        }
        $.ajax({
            type: "POST",
            url: 'controller/orden_trabajos.controller.php',
            data: parametros,
            success: function (data) {
                location.reload();
            },
            error: function () {
                alert("Error");
            }
        });
    });

    $(".recepcionarOrdenTrabajo").click(function () {
        codigo = $(this).closest('tr').attr("codigo");
        window.location.href = "recepcion_orden_trabajo.php?codigo="+codigo;
    });

    $(".verOrdenTrabajo").click(function () {
        //codigo = $(this).closest('tr').attr("codigo");
        //window.location.href = "recepcion_orden_trabajo.php?ver=1&codigo="+codigo;
        codigo = $(this).closest('tr').attr("codigo");
        var parametros = {
            funcion: "cambiarEstadoOrdenTrabajo",
            codigo: codigo,
            estado: 1
        }
        $.ajax({
            type: "POST",
            url: 'controller/orden_trabajos.controller.php',
            data: parametros,
            success: function (data) {
                location.reload();
            },
            error: function () {
                alert("Error");
            }
        });
    });

    $(".viewOrdenTrabajo").click(function () {
        codigo = $(this).closest('tr').attr("codigo");
        window.location.href = "orden_trabajo.php?ver=1&codigo="+codigo;
    });

    $(".tareasOrdenTrabajo").click(function () {
        codigo = $(this).closest('tr').attr("codigo");
        window.location.href = "orden_trabajo_tareas.php?&codigo="+codigo;
    });

    $(".editOrdenTrabajo").click(function () {
        codigo = $(this).closest('tr').attr("codigo");
        window.location.href = "orden_trabajo.php?codigo="+codigo;
        /*$("#text-header-body").html("¿Desea eliminar el registro?");
        $("#btn-eliminar-rol").css("display", "inline-block");
        $("#btn-cancelar").text("Cancelar");
        var parametros = {
            funcion: "getOrdenTrabajo",
            codigo: codigo
        }
        $.ajax({
            type: "POST",
            url: 'controller/orden_trabajos.controller.php',
            data: parametros,
            success: function (data) {
                var datos = JSON.parse(data);
                $('#observacionesUpdate').val(datos.observaciones);
                $('#clienteUpdate').val(datos.cliente);
                $('#productoUpdate').val(datos.cod_componente);
                $('#productoUpdate').val(datos.cod_componente);
                $('#fechaUpdate').val(datos.fecha_programada_entrega);
            },
            error: function () {
                alert("Error");
            }
        });
        //event.preventDefault();
        $('#dataUpdate').modal('show');*/
    });

    $(".deleteOrdenTrabajo").click(function () {
        codigo = $(this).closest('tr').attr("codigo");
        $("#name-header-modal").html("<b>Eliminar</b>");
        $("#text-header-body").html("¿Desea eliminar el registro ?");
        $("#btn-eliminar").css("display", "inline-block");
        $("#btn-cancelar").text("Cancelar");
        $('#myModal').modal('show');
    });

    $(".viewOrdenVenta").click(function () {
        cod_orden_venta = $(this).closest('tr').attr("cod_orden_venta");
        window.location.href = "orden_venta.php?codigo="+cod_orden_venta;
    });

    $(".personasOrdenTrabajo").click(function () {
        codigo = $(this).closest('tr').attr("codigo");
        window.location.href = "orden_trabajo_personas.php?codigo="+codigo;
    });

    $(".ordena").click(function () {

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
    
    $("tbody > tr").click(function () {
        $("tbody > tr").css("background-color", "");
        $(this).css("background-color", "#FFFFB8");
    });
</script>