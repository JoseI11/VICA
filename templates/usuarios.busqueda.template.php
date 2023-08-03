<table id="tabla" namefile="Usuarios" totales="<?php echo $_SESSION["totales"]; ?>" registros="<?php echo $_SESSION['cant_reg']; ?>" pagina="<?php $_SESSION['pagina']; ?>" class="table table-striped table-hover" mes="<?php echo $mes; ?>" anio="<?php echo $anio; ?>" dia="<?php echo $dia; ?>" opcion="<?php echo $opcion; ?>"> 
    <thead>
        <tr class="row alert-danger " style="background-color: transparent; color: #479ECA;">
            <th class="col-lg-1 col-md-1 col-sm-1 col-xs-1 text-center ordena" orderby="codigo" sentido="asc">C&oacute;digo</th>
            <th class="col-lg-2 col-md-2 col-sm-2 col-xs-2 text-center ordena" orderby="usuario" sentido="asc">Usuario</th>
            <th class="col-lg-3 col-md-3 col-sm-3 col-xs-3 text-center ordena" orderby="nombre" sentido="asc">Nombre</th>
            <th class="col-lg-3 col-md-3 col-sm-3 col-xs-3 text-center " orderby="mail" sentido="asc">Mail</th>
            <th class="col-lg-2 col-md-2 col-sm-2 col-xs-2 text-center ordena" orderby="rol" sentido="asc">Rol</th>
            <th class="col-lg-1 col-md-1 col-sm-1 col-xs-1 text-center noExl">Acciones</th>
        </tr>
    </thead>
    <tbody id="body">
        <?php foreach ($registros as $usu) { ?>
            <tr class="row" codigo="<?php echo $usu["codigo"]; ?>">
                <td class="col-lg-1 col-md-1 col-sm-1 col-xs-1 text-center" style="vertical-align: middle;"><?php echo $usu["codigo"]; ?></td>
                <td class="col-lg-2 col-md-2 col-sm-2 col-xs-2 text-center" style="vertical-align: middle;"><?php echo $usu["usuario"]; ?></td>
                <td class="col-lg-3 col-md-3 col-sm-3 col-xs-3 text-center" style="vertical-align: middle;"><?php echo $usu["nombre"]; ?></td>
                <td class="col-lg-3 col-md-3 col-sm-3 col-xs-3 text-center" style="vertical-align: middle;"><?php echo $usu["mail"]; ?></td>
                <td class="col-lg-2 col-md-2 col-sm-2 col-xs-2 text-center" style="vertical-align: middle;"><?php echo $usu["rol"]; ?></td>
                <td class="col-lg-1 col-md-1 col-sm-1 col-xs-1 text-center noExl" style="vertical-align: middle;">
                    <?php if ($usu["usuario"] != "pbocchio")  { ?>
                        <div class="editUsuario" style="float: left; margin-left: 10px;"><a href="#"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a></div>
                        <div class="deleteUsuario" style="float: right;margin-right: 10px;"><a href="#"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a></div>
                    <?php  } ?>
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
        ?> de <?php echo $_SESSION["totales"]; ?> reg.</label>
</div>

<script>
    var requestSent = false;

    $("#btn-eliminar-usuario").click(function () {
        if (!requestSent) {
            requestSent = true;
            var parametros = {
                funcion: "deleteUsuario",
                codigo: codigo
            }
            $.ajax({
                type: "POST",
                url: 'controller/usuarios.controller.php',
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

    $(".editUsuario").click(function () {
        codigo = $(this).closest('tr').attr("codigo");
        $("#text-header-body").html("¿Desea eliminar el registro?");
        $("#btn-eliminar-usuario").css("display", "inline-block");
        $("#btn-cancelar").text("Cancelar");

        var parametros = {
            funcion: "getUsuario",
            codigo: codigo
        }
        $.ajax({
            type: "POST",
            url: 'controller/usuarios.controller.php',
            data: parametros,
            success: function (data) {
                var datos = JSON.parse(data);
                $('#usuarioUpdate').val(datos.usuario);
                $('#passwordUpdate').val("");
                $('#nombreUpdate').val(datos.nombre);
                $('#mailUpdate').val(datos.mail);
                $('#rolUpdate').val(datos.cod_rol);
            },
            error: function () {
                alert("Error");
            }
        });
        //event.preventDefault();
        $('#dataUpdate').modal('show');
    });

    $(".deleteUsuario").click(function () {
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
</script>

<script>
    $("tbody > tr").click(function () {
        $("tbody > tr").css("background-color", "");
        $(this).css("background-color", "#FFFFB8");
    });
</script>