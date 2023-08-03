    <table id="tabla_detalle" namefile="OrdenCompras" totales="<?php echo $_SESSION["totales"]; ?>" registros="<?php echo $_SESSION['cant_reg']; ?>" pagina="<?php $_SESSION['pagina']; ?>" class="table table-striped table-hover" mes="<?php echo $mes; ?>" anio="<?php echo $anio; ?>" dia="<?php echo $dia; ?>" opcion="<?php echo $opcion; ?>"> 
        <thead>
            <tr class="row " style="background-color: transparent;">
                <th class="text-left ordena" orderby="detalle" sentido="asc">Detalle</th>
                <th class="col-lg-1 col-md-1 col-sm-1 col-xs-1 text-center ordena" orderby="descripcion" sentido="asc">Empleado</th>
                <th class="col-lg-1 col-md-1 col-sm-1 col-xs-1 text-center noExl">Acciones</th>
                <th class="col-lg-1 col-md-1 col-sm-1 col-xs-1 text-center noExl" style="vertical-align: middle;">
                        <?php if ($_SESSION["ver"] == 0) { ?>
                            <div class="addDetalleOt" style="float: left; margin-left: 10px;"><a href="#"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span></a></div>
                         <?php } ?>
                </th>
            </tr>
        </thead>
        <tbody id="body">
            <?php foreach ($registros as $usu) { ?>
                <tr class="row" codigo="<?php echo $usu["id"]; ?>">
                    <td class="text-left" style="vertical-align: middle;"><?php echo $usu["detalle"]; ?></td>
                    <td class="col-lg-1 col-md-1 col-sm-1 col-xs-1 text-center noExl" style="vertical-align: middle;"><?php echo $usu["descripcion"]; ?></td>
                    <td class="col-lg-1 col-md-1 col-sm-1 col-xs-1 text-center noExl" style="vertical-align: middle;">
                        <?php if ($_SESSION["ver"] == 0) { ?>
                            <div class="editDetalleOt" style="float: left; margin-left: 10px;"><a href="#"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a></div>
                            <div class="deleteDetalleOt" style="float: right;margin-right: 10px;"><a href="#"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a></div>
                        <?php } ?>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>


<script>
    var requestSent = false;

    $("#btn-eliminar-detalle").click(function () {
        if (!requestSent) {
            requestSent = true;
            var parametros = {
                funcion: "deleteDetalleTrabajoInsumo",
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
                    requestSent = false;
                }
            });
            event.preventDefault();
        }
    });

    $(".editDetalleOt").click(function () {
        codigo = $(this).closest('tr').attr("codigo");
        $("#text-header-body").html("¿Desea eliminar el registro?");
        $("#btn-eliminar-rol").css("display", "inline-block");
        $("#btn-cancelar").text("Cancelar");

        var parametros = {
            funcion: "getDetalleTrabajoInsumo",
            codigo: codigo
        }
        $.ajax({
            type: "POST",
            url: 'controller/orden_trabajos.controller.php',
            data: parametros,
            success: function (data) {
                var datos = JSON.parse(data);
                $('#id_empleado').val(datos.id_empleado);
                $('#detalledetalle').val(datos.detalle);
            },
            error: function () {
                alert("Error");
            }
        });
        //event.preventDefault();
        $('#detalleUpdate').modal('show');
    });

    $(".addDetalleOt").click(function () {
        $('#detalleRegister').modal('show');
    });

    $(".deleteDetalleOt").click(function () {
        codigo = $(this).closest('tr').attr("codigo");
        $("#name-header-modal").html("<b>Eliminar</b>");
        $("#text-header-body").html("¿Desea eliminar el registro ?");
        $("#btn-eliminar").css("display", "inline-block");
        $("#btn-cancelar").text("Cancelar");
        $('#deldetalleOt').modal('show');
    });
    
    $("tbody > tr").click(function () {
        $("tbody > tr").css("background-color", "");
        $(this).css("background-color", "#FFFFB8");
    });
</script>