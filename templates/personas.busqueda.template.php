<table id="tabla" namefile="Personas" totales="<?php echo $_SESSION["totales"]; ?>" registros="<?php echo $_SESSION['cant_reg']; ?>" pagina="<?php $_SESSION['pagina']; ?>" class="table table-striped table-hover" mes="<?php echo $mes; ?>" anio="<?php echo $anio; ?>" dia="<?php echo $dia; ?>" opcion="<?php echo $opcion; ?>"> 
    <thead>
        <tr class="row " style="background-color: transparent;">
            <th class="text-left ordena" orderby="descripcion" sentido="asc">Nombre</th>
            <th class="text-left ordena" orderby="mail" sentido="asc">Mail</th>
            <th class="text-left ordena" orderby="telefono" sentido="asc">Telefono</th>
            <th class="text-left ordena" orderby="localidad" sentido="asc">Localidad</th>
            <th class="text-left ordena" orderby="cuit" sentido="asc">CUIT</th>
            <th class="text-center ordena" orderby="cliente" sentido="asc">Cliente</th>
            <th class="text-center ordena" orderby="proveedor" sentido="asc">Proveedor</th>
            <th class="text-center ordena" orderby="transportista" sentido="asc">Transportista</th>
            <th class="text-center ordena" orderby="vendedor" sentido="asc">Vendedor</th>
            <th class="text-center ordena" orderby="empleado" sentido="asc">Empleado</th>
            <th class="text-center noExl">Acciones</th>
        </tr>
    </thead>
    <tbody id="body">
        <?php foreach ($registros as $usu) { ?>
            <tr class="row" codigo="<?php echo $usu["codigo"]; ?>">
                <td class="text-left" style="vertical-align: middle;"><?php echo $usu["descripcion"]; ?></td>
                <td class="text-left" style="vertical-align: middle;"><?php echo $usu["mail"]; ?></td>
                <td class="text-left" style="vertical-align: middle;"><?php echo $usu["telefono"]; ?></td>
                <td class="text-left" style="vertical-align: middle;"><?php echo $usu["localidad"]; ?></td>
                <td class="text-left" style="vertical-align: middle;"><?php echo $usu["cuit"]; ?></td>
                <td class="text-center" style="vertical-align: middle;">
                    <?php echo ($usu["cliente"] == 1) ? '<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>' : '<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>'; ?> 
                </td>
                <td class="text-center" style="vertical-align: middle;">
                    <?php echo ($usu["proveedor"] == 1) ? '<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>' : '<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>'; ?> 
                </td>
                <td class="text-center" style="vertical-align: middle;">
                    <?php echo ($usu["transportista"] == 1) ? '<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>' : '<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>'; ?> 
                </td>
                <td class="text-center" style="vertical-align: middle;">
                    <?php echo ($usu["vendedor"] == 1) ? '<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>' : '<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>'; ?> 
                </td>
                <td class="text-center" style="vertical-align: middle;">
                    <?php echo ($usu["empleado"] == 1) ? '<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>' : '<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>'; ?> 
                </td>
                <td class="text-center noExl" style="vertical-align: middle;">
                    <div class="editPersona" style="float: left; margin-left: 10px;"><a href="#"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a></div>
                    <div class="deletePersona" style="float: right;margin-right: 10px;"><a href="#"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a></div>
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
                funcion: "deletePersona",
                codigo: codigo
            }
            $.ajax({
                type: "POST",
                url: 'controller/personas.controller.php',
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

    $(".editPersona").click(function () {
        codigo = $(this).closest('tr').attr("codigo");
        $("#text-header-body").html("¿Desea eliminar el registro?");
        $("#btn-eliminar-rol").css("display", "inline-block");
        $("#btn-cancelar").text("Cancelar");

        var parametros = {
            funcion: "getPersona",
            codigo: codigo
        }
        $.ajax({
            type: "POST",
            url: 'controller/personas.controller.php',
            data: parametros,
            success: function (data) {
                var datos = JSON.parse(data);
                $('#descripcionUpdate').val(datos.descripcion);
                $('#telefonoUpdate').val(datos.telefono);
                $('#mailUpdate').val(datos.mail);
                $('#localidadUpdate').val(datos.localidad);
                $('#provinciaUpdate').val(datos.cod_provincia);
                $('#paisUpdate').val(datos.cod_pais);
                $('#cuitUpdate').val(datos.cuit);
                $('#clienteUpdate').val(datos.cliente);
                $('#proveedorUpdate').val(datos.proveedor);
                $('#transportistaUpdate').val(datos.transportista);
                $('#vendedorUpdate').val(datos.vendedor);
                $('#empleadoUpdate').val(datos.empleado);
            },
            error: function () {
                alert("Error");
            }
        });
        //event.preventDefault();
        $('#dataUpdate').modal('show');
    });

    $(".deletePersona").click(function () {
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