<table id="tabla" namefile="OrdenCompras" totales="<?php echo $_SESSION["totales"]; ?>" registros="<?php echo $_SESSION['cant_reg']; ?>" pagina="<?php $_SESSION['pagina']; ?>" class="table table-striped table-hover" mes="<?php echo $mes; ?>" anio="<?php echo $anio; ?>" dia="<?php echo $dia; ?>" opcion="<?php echo $opcion; ?>"> 
    <thead>
        <tr class="row " style="background-color: transparent;">
            <th class="text-center ordena" orderby="codigo" sentido="asc">Nro.</th>
            <th class="text-left ordena" orderby="proveedor" sentido="asc">Proveedor</th>
            <th class="text-left ordena" orderby="fecha" sentido="asc">Fecha</th>
            <th class="text-left ordena" orderby="observaciones" sentido="asc">Descripción</th>
            <th class="col-lg-1 col-md-1 col-sm-1 col-xs-1 text-center ordena" orderby="estado" sentido="asc">Estado</th>
            <th class="col-lg-1 col-md-1 col-sm-1 col-xs-1 text-center noExl">Acciones</th>
        </tr>
    </thead>
    <tbody id="body">
        <?php foreach ($registros as $usu) { ?>
            <tr class="row" codigo="<?php echo $usu["codigo"]; ?>">
                <td class="text-center" style="vertical-align: middle;"><?php echo $usu["codigo"]; ?></td>
                <td class="text-left" style="vertical-align: middle;"><?php echo $usu["proveedor"]; ?></td>
                <td class="text-left" style="vertical-align: middle;"><?php echo $usu["fecha"]; ?></td>
                <td class="text-left" style="vertical-align: middle;"><?php echo $usu["observaciones"]; ?></td>
                <td class="text-center" style="vertical-align: middle;"><?php echo $usu["estado"]; ?></td>
                <td class="col-lg-1 col-md-1 col-sm-1 col-xs-1 text-center noExl" style="vertical-align: middle;">
                    <div class="dropdown">
                        <button class="btn btn-sm btn-primary dropdown-toggle nuevo" id="menu" type="button" data-toggle="dropdown" style="font-size: 10px;height: 15px;" aria-expanded="true">
                            <div class="opciones" style="margin-top: -6px">Opciones <span class="caret"></span></div>
                        </button>
                        <ul class="dropdown-menu" role="menu" aria-labelledby="menu">
                            <?php if ($usu["cod_orden_compra_estado"] == 1){ ?>
                                <li role="presentation" class="confirmarOrdenCompra"><a role="menuitem" tabindex="-1" href="#">Confirmar</a></li>
                                <li role="presentation" class="editOrdenCompra"><a role="menuitem" tabindex="-1" href="#">Editar</a></li>
                                <li role="presentation" class="deleteOrdenCompra"><a role="menuitem" tabindex="-1" href="#">Eliminar</a></li>
                            <?php } ?>
                            <?php if ($usu["cod_orden_compra_estado"] == 2){ ?>
                                <li role="presentation" class="recepcionarOrdenCompra"><a role="menuitem" tabindex="-1" href="#">Recepcionar</a></li>
                                <li role="presentation" class="finalizarOrdenCompra"><a role="menuitem" tabindex="-1" href="#">Finalizar</a></li>
                                <li role="presentation" class="anularOrdenCompra"><a role="menuitem" tabindex="-1" href="#">Anular</a></li>
                            <?php } ?>
                            <?php if ($usu["cod_orden_compra_estado"] == 3){ ?>
                                <li role="presentation" class="verOrdenCompra"><a role="menuitem" tabindex="-1" href="#">Ver</a></li>
                            <?php } ?>
                            <?php if ($usu["cod_orden_compra_estado"] == 4){ ?>
                                <li role="presentation" class="verOrdenCompra"><a role="menuitem" tabindex="-1" href="#">Ver</a></li>
                            <?php } ?>
                            <li role="presentation" class="verOrdenCompraPDF"><a role="menuitem" tabindex="-1" target="_blank" href="PDF/oc.php?codigo=<?php echo $usu["codigo"]; ?>">PDF</a></li>
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
                funcion: "deleteOrdenCompra",
                codigo: codigo
            }
            $.ajax({
                type: "POST",
                url: 'controller/orden_compras.controller.php',
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

    $(".confirmarOrdenCompra").click(function () {
        codigo = $(this).closest('tr').attr("codigo");
        var parametros = {
            funcion: "cambiarEstadoOrdenCompra",
            codigo: codigo,
            estado: 2
        }
        $.ajax({
            type: "POST",
            url: 'controller/orden_compras.controller.php',
            data: parametros,
            success: function (data) {
                location.reload();
            },
            error: function () {
                alert("Error");
            }
        });
    });

    $(".finalizarOrdenCompra").click(function () {
        codigo = $(this).closest('tr').attr("codigo");
        var parametros = {
            funcion: "cambiarEstadoOrdenCompra",
            codigo: codigo,
            estado: 3
        }
        $.ajax({
            type: "POST",
            url: 'controller/orden_compras.controller.php',
            data: parametros,
            success: function (data) {
                location.reload();
            },
            error: function () {
                alert("Error");
            }
        });
    });

    $(".anularOrdenCompra").click(function () {
        codigo = $(this).closest('tr').attr("codigo");
        var parametros = {
            funcion: "cambiarEstadoOrdenCompra",
            codigo: codigo,
            estado: 4
        }
        $.ajax({
            type: "POST",
            url: 'controller/orden_compras.controller.php',
            data: parametros,
            success: function (data) {
                location.reload();
            },
            error: function () {
                alert("Error");
            }
        });
    });

    $(".recepcionarOrdenCompra").click(function () {
        codigo = $(this).closest('tr').attr("codigo");
        window.location.href = "recepcion_orden_compra.php?codigo="+codigo;
    });

    $(".verOrdenCompra").click(function () {
        codigo = $(this).closest('tr').attr("codigo");
        window.location.href = "recepcion_orden_compra.php?ver=1&codigo="+codigo;
    });

    $(".editOrdenCompra").click(function () {
        codigo = $(this).closest('tr').attr("codigo");
        window.location.href = "orden_compra.php?codigo="+codigo;
        /*
        $("#text-header-body").html("¿Desea eliminar el registro?");
        $("#btn-eliminar-rol").css("display", "inline-block");
        $("#btn-cancelar").text("Cancelar");

        var parametros = {
            funcion: "getOrdenCompra",
            codigo: codigo
        }
        $.ajax({
            type: "POST",
            url: 'controller/orden_compras.controller.php',
            data: parametros,
            success: function (data) {
                var datos = JSON.parse(data);
                $('#descripcionUpdate').val(datos.descripcion);
                $('#insumoUpdate').val(datos.es_insumo);
                $('#unidadUpdate').val(datos.cod_unidad);
            },
            error: function () {
                alert("Error");
            }
        });
        //event.preventDefault();
        $('#dataUpdate').modal('show');*/
    });

    $(".deleteOrdenCompra").click(function () {
        codigo = $(this).closest('tr').attr("codigo");
        $("#name-header-modal").html("<b>Eliminar</b>");
        $("#text-header-body").html("¿Desea eliminar el registro ?");
        $("#btn-eliminar").css("display", "inline-block");
        $("#btn-cancelar").text("Cancelar");
        $('#myModal').modal('show');
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