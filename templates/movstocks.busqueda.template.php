<?php
$registros = array_reverse($registros);
$saldo = 0;
foreach ($registros as $registro) {
    foreach ($registro as $usu) {
        $saldo += ($usu["impacto"] * $usu["cantidad"]);
    }
}
?>
<?php if ($saldo > 0) { ?>
    <legend style="color: #0A0;"><?php echo "Sobrante: " . number_format(abs($saldo), 2, ",", "."); ?></legend>
<?php } ?>
<?php if ($saldo < 0) { ?>
    <legend style="color: #A00;"><?php echo "Faltante: " . number_format(abs($saldo), 2, ",", "."); ?></legend>
<?php } ?>
<table id="tabla" namefile="Mov-Stock" totales="<?php echo $_SESSION["totales"]; ?>" registros="<?php echo $_SESSION['cant_reg']; ?>" pagina="<?php $_SESSION['pagina']; ?>" class="table table-striped table-hover" mes="<?php echo $mes; ?>" anio="<?php echo $anio; ?>" dia="<?php echo $dia; ?>" opcion="<?php echo $opcion; ?>">
    <thead>
        <tr class="row alert-danger " style="background-color: transparent; color: #5A3E2B;">
            <th class="col-lg-1 col-md-1 col-sm-1 col-xs-1 text-center">Fecha</th>

            <th class="col-lg-8 col-md-8 col-sm-8 col-xs-8 text-left">Descripcion</th>
            <th class="col-lg-1 col-md-1 col-sm-1 col-xs-1 text-center">Incremento</th>
            <th class="col-lg-1 col-md-1 col-sm-1 col-xs-1 text-center">Baja</th>
            <th class="col-lg-1 col-md-1 col-sm-1 col-xs-1 text-center">Saldo</th>
        </tr>
    </thead>
    <tbody id="body">
        <?php
        //$saldo = 0;
        foreach ($registros as $registro) {
            foreach ($registro as $usu) {
        ?>
                <tr class="row fila" impacto="<?php echo $usu["impacto"]; ?>" codigo="<?php echo $usu["codigo"]; ?>">
                    <td class="col-lg-1 col-md-1 col-sm-1 col-xs-1 text-center" style="vertical-align: middle;"><?php echo $usu["fecha"]; ?></td>


                    <td class="col-lg-8 col-md-8 col-sm-8 col-xs-8 text-left" style="vertical-align: middle;"><?php echo $usu["descripcion"]; ?></td>
                    <?php if ($usu["impacto"] < 0) { ?>
                        <td class="col-lg-1 col-md-1 col-sm-1 col-xs-1 text-center" style="vertical-align: middle;"></td>
                        <td class="col-lg-1 col-md-1 col-sm-1 col-xs-1 text-right" style="vertical-align: middle; color: #A00;"><?php echo number_format($usu["cantidad"], 2, ",", "."); ?></td>
                    <?php } else { ?>
                        <td class="col-lg-1 col-md-1 col-sm-1 col-xs-1 text-right" style="vertical-align: middle; color: #0A0;"><?php echo number_format($usu["cantidad"], 2, ",", "."); ?></td>
                        <td class="col-lg-1 col-md-1 col-sm-1 col-xs-1 text-center" style="vertical-align: middle;"></td>
                    <?php } ?>
                    <td class="col-lg-1 col-md-1 col-sm-1 col-xs-1 text-center" style="vertical-align: middle; font-weight: bolder;"><?php echo number_format($saldo, 2, ",", "."); ?></td>
                </tr>
            <?php
                $saldo -= ($usu["impacto"] * $usu["cantidad"]);
            } ?>
        <?php } ?>
    </tbody>
</table>

<script>
    $("tbody > tr").click(function() {
        $("tbody > tr").css("background-color", "");
        $(this).css("background-color", "#FFFFB8");
    });
    /*
    $(".fila").dblclick(function () {
        impacto = $(this).attr("impacto");
        codigo = $(this).attr("codigo");
        var parametros = {
            funcion: "getRegistro",
            impacto: impacto,
            codigo: codigo
        }
        $.ajax({
            type: "POST",
            url: 'controller/movstocks.controller.php',
            data: parametros,
            success: function (data) {
                var datos = JSON.parse(data);
                //$(".venta_update").css("display", "block");
                $('.venta_update').removeAttr("disabled");
                $('#tipoUpdate').val(impacto);
                $('#fechaUpdate').val(datos.fecha);
                $('#personaUpdate').val(datos.cod_persona);
                $('#subtotalUpdate').val(datos.subtotal);
                if (impacto == -1){
                    $('#cantidadUpdate').val(datos.cantidad);
                    $('#productoUpdate').val(datos.cod_producto);
                } else {
                    $('.venta_update').attr("disabled", "disabled");
                    $('.venta_update').val("");
                    //$(".venta_update").css("display", "none");
                }
            },
            error: function () {
                alert("Error");
            }
        });
        $('#dataUpdate').modal('show');
    });*/
</script>