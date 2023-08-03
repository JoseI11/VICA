<legend>ORDEN TRABAJO #<?php echo $codigo; ?></legend>

<?php if ($orden_compra["es_insumo"]==0) { ?>
    <legend>Personas asociadas</legend>
    <div id="tabla_asociada">
        <table id="tabla" namefile="OrdenCompras" totales="<?php echo $_SESSION["totales"]; ?>" registros="<?php echo $_SESSION['cant_reg']; ?>" pagina="<?php $_SESSION['pagina']; ?>" class="table table-striped table-hover" mes="<?php echo $mes; ?>" anio="<?php echo $anio; ?>" dia="<?php echo $dia; ?>" opcion="<?php echo $opcion; ?>"> 
            <thead>
                <tr class="row " style="background-color: transparent;">
                    <th class="text-left " orderby="descripcion" sentido="asc">Categoria</th>
                    <th class="text-left " orderby="descripcion" sentido="asc">Persona</th>
                    <th class="col-lg-1 col-md-1 col-sm-1 col-xs-1 text-center noExl"></th>
                </tr>
            </thead>
            <tbody id="body">
                <?php foreach ($personas_inv as $usu) { ?>
                    <tr class="row" codigo="<?php echo $usu["codigo"]; ?>">
                        <td class="text-left" style="vertical-align: middle;">
                            <?php 
                                foreach($categorias as $p){
                                    if ($p["codigo"] == $usu["cod_comp_cat"]){
                                        echo $p["descripcion"]; 
                                    }
                                }
                            ?>
                        </td>
                        <td class="text-left" style="vertical-align: middle;">
                            <?php 
                                foreach($personas as $p){
                                    if ($p["codigo"] == $usu["cod_persona"]){
                                        echo $p["descripcion"]; 
                                    }
                                }
                            ?>
                        </td>
                        <td class="col-lg-1 col-md-1 col-sm-1 col-xs-1 text-center noExl" style="vertical-align: middle;">
                            <div class="saveChange" style="float: left; margin-left: 10px;"><a href="#"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a></div>
                            <div class="deleteChange" style="float: right; margin-right: 10px;"><a href="#"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a></div>
                        </td>
                    </tr>
        <?php } ?>
            </tbody>
        </table>

    </div>
<?php } ?>
<br />

<script>
    var requestSent = false;

    $("tbody > tr").click(function () {
        $("tbody > tr").css("background-color", "");
        $(this).css("background-color", "#FFFFB8");
    });

    $("#btn_volver").click(function () {
        window.location.href = "orden_trabajos.php";
    });

    $("#btn-eliminar-rol").click(function () {
        if (!requestSent) {
            requestSent = true;
            var parametros = {
                funcion: "deleteOtPersona",
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

    $(".deleteChange").click(function () {
        codigo = $(this).closest('tr').attr("codigo");
        $("#name-header-modal").html("<b>Eliminar</b>");
        $("#text-header-body").html("¿Desea eliminar el registro ?");
        $("#btn-eliminar").css("display", "inline-block");
        $("#btn-cancelar").text("Cancelar");
        $('#myModal').modal('show');
    });

    $(".saveChange").click(function (){
        cod_ov = $("#loading").attr("codigo");
        codigo = $(this).closest('tr').attr("codigo");
        var parametros = {
            funcion: "getOtPersona",
            cod_ov: cod_ov,
            codigo: codigo
        }
        $.ajax({
            type: "POST",
            url: 'controller/orden_trabajos.controller.php',
            data: parametros,
            success: function (data) {
                var datos = JSON.parse(data);
                $('#empleadoUpdate').val(datos.cod_persona);
                $('#categoriaUpdate').val(datos.cod_comp_cat);
            },
            error: function () {
                alert("Error");
            }
        });
        //event.preventDefault();
        $('#dataUpdate').modal('show');
    });
    
    function getFormData($form){
        var unindexed_array = $form.serializeArray();
        var indexed_array = {};
        $.map(unindexed_array, function(n, i){
            indexed_array[n['name']] = n['value'];
        });
        return indexed_array;
    }
</script>