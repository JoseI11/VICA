<table id="tabla" namefile="Componentes" totales="<?php echo $_SESSION["totales"]; ?>" registros="<?php echo $_SESSION['cant_reg']; ?>" pagina="<?php $_SESSION['pagina']; ?>" class="table table-striped table-hover" mes="<?php echo $mes; ?>" anio="<?php echo $anio; ?>" dia="<?php echo $dia; ?>" opcion="<?php echo $opcion; ?>"> 
    <thead>
        <tr class="row " style="background-color: transparent;">
            <th class="text-left ordena" orderby="codigo_mp" sentido="asc">Código</th>
            <th class="text-left ordena" orderby="dimension" sentido="asc">Descripción/ dimensión</th>
            <th class="text-left ordena" orderby="cod_componente_categoria" sentido="asc">Categoria</th>
            <th class="text-left ordena" orderby="precio_unitario" sentido="asc">Precio Unitario</th>
            <th class="text-left ordena" orderby="cod_unidad" sentido="asc">Unidad</th>
            <th class="col-lg-1 col-md-1 col-sm-1 col-xs-1 text-center ordena" orderby="es_insumo" sentido="asc">Insumo</th>
            <!-- <th class="col-lg-1 col-md-1 col-sm-1 col-xs-1 text-center ordena" orderby="es_usado" sentido="asc">Usado</th> -->
            <th class="col-lg-1 col-md-1 col-sm-1 col-xs-1 text-center noExl">Acciones</th>
        </tr>
    </thead>
    <tbody id="body">
        <?php foreach ($registros as $usu) { ?>
            <tr class="row" codigo="<?php echo $usu["codigo"]; ?>">
                <td class="text-left" style="vertical-align: middle;"><?php echo $usu["codigo_mp"]; ?></td>
                <td class="text-left" style="vertical-align: middle;"><?php echo $usu["dimension"]; ?></td>
                <td class="text-left" style="vertical-align: middle;"><?php echo $usu["categoria"]; ?></td>
                <td class="text-left" style="vertical-align: middle;"><?php echo $usu["precio_unitario"]; ?></td>
                <td class="text-left" style="vertical-align: middle;"><?php echo $usu["unidad"]; ?></td>
                <td class="col-lg-1 col-md-1 col-sm-1 col-xs-1 text-center noExl" style="vertical-align: middle;">
                    <?php
                    if ($usu["es_insumo"] == 1) {
                        echo '<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>';
                    } else {
                        echo '<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>';
                    }
                    ?> 
                </td>
                <!-- <td class="col-lg-1 col-md-1 col-sm-1 col-xs-1 text-center noExl" style="vertical-align: middle;">
                    <?php
                    if ($usu["es_usado"] == 1) {
                        echo '<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>';
                    } else {
                        echo '<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>';
                    }
                    ?> 
                </td> -->
                <td class="col-lg-1 col-md-1 col-sm-1 col-xs-1 text-center noExl" style="vertical-align: middle;">
                    <div class="editComponente" style="float: left; margin-left: 10px;"><a href="#"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a></div>
                    <div class="deleteComponente" style="float: right;margin-right: 10px;"><a href="#"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a></div>
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
                funcion: "deleteComponente",
                codigo: codigo
            }
            $.ajax({
                type: "POST",
                url: 'controller/componentes.controller.php',
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

    $(".editComponente").click(function () {
        codigo = $(this).closest('tr').attr("codigo");
        window.location.href = "componente.php?codigo="+codigo;
        /*
        $("#text-header-body").html("¿Desea eliminar el registro?");
        $("#btn-eliminar-rol").css("display", "inline-block");
        $("#btn-cancelar").text("Cancelar");

        var parametros = {
            funcion: "getComponente",
            codigo: codigo
        }
        $.ajax({
            type: "POST",
            url: 'controller/componentes.controller.php',
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

    $(".deleteComponente").click(function () {
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