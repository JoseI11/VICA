<div class="row">
    <div class="col-lg-2">
        <label for="busqueda">Factor:</label>
        <input type="text" id="factor" name="factor" data-mask="9.99" value="<?php echo number_format(1, 2); ?>" disabled />
    </div>
    <div class="col-lg-2">
        <label for="busqueda">Costo/Precio:</label>
        <select id="select_valor" class="form-control asistencia afecta_factor" style="width: 70%;display: inline-block;vertical-align: middle; font-size: 11px; height: auto; margin-top: -5px;">
            <option value="1" <?php if ($valor == 1) {
                                    echo "selected";
                                } ?>>Precio</option>
            <option value="-1" <?php if ($valor == -1) {
                                    echo "selected";
                                } ?>>Costo</option>
        </select>
    </div>
    <div class="col-lg-2">
        <label for="busqueda">Subir/Bajar:</label>
        <select id="select_subir" class="form-control asistencia afecta_factor" style="width: 70%;display: inline-block;vertical-align: middle; font-size: 11px; height: auto; margin-top: -5px;">
            <option value="1" selected>Subir</option>
            <option value="-1">Bajar</option>
        </select>
    </div>
    <div class="col-lg-2">
        <label for="busqueda">Tipo-Producto</label>
        <select id="tipo" class="form-control asistencia" onchange="" style="width: 70%;display: inline-block;vertical-align: middle; font-size: 11px; height: auto; margin-top: -5px;">
            <option value="1" <?php echo $tipo==1 ?"selected" :"";?>>Insumo</option>
            <option value="2" <?php echo $tipo==2 ?"selected" :"";?>>Componente</option>
            <option value="3" <?php echo $tipo==3 ?"selected" :"";?>>Maquina</option>
        </select>
    </div>
    
    <div class="col-lg-2">
        <label for="busqueda">Porcentaje:</label>
        <input type="text" id="porcentaje" name="porcentaje" data-mask="99.99" class="afecta_factor" value="<?php echo number_format(0, 2); ?>" />
    </div>
    <div class="col-lg-12" style="margin-top: 10px;">
        <div class="ibox">
            <div class="ibox-title">
                <h5>Ajuste de Precios</h5>
            </div>
            <div class="ibox-content">
                <p>
                    Elija los elementos de la lista, para ajustar el precio de venta por el factor correspondiente.
                </p>
                <form id="form" action="#" class="wizard-big">
                    <select class="form-control dual_select" multiple id="lista">
                        <?php foreach ($insumos as $p) { ?>
                            <?php if ($valor == 1) { ?>
                                <option value="<?php echo $p["codigo"]; ?>"><?php echo $p["descripcion"] /*. " (" . $p["marca"] */ . " - $ " . number_format($p["precio_unitario"], 2); ?></option>
                            <?php } else { ?>
                                <option value="<?php echo $p["codigo"]; ?>"><?php echo $p["descripcion"] /*. " (" . $p["marca"] */ . " - $ " . number_format($p["costo_unitario"], 2); ?></option>
                            <?php } ?>
                        <?php } ?>
                    </select>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-1 col-md-1 col-sm-12 col-xs-12 right">
        <input type="button" id="afectar" name="afectar" class="btn-danger btn-sm boton_marron_carni" style="border-radius: 10px; margin-left: 10px;" value="Confirmar" />
    </div>
</div>


<script>
    function filtrar(){
        var valor
    }
    var requestSent = false;
    $("#porcentaje").change();

    $("tr").click(function() {
        scroll = $(window).scrollTop();
    });

    $(document).ready(function() {
        $('.dual_select').bootstrapDualListbox({
            selectorMinimalHeight: 160
        });
    });
   /*$("#tipo").click(function(){
        var tipo=$("#tipo").val();
       
        var parametros={
            funcion="filtrar_tipos_de_stock",
            tipo:tipo,
            alert(tipo);
        }

        $.ajax({
            type: "POST",
            url: 'controller/ajustes.controller.php',
            data: parametros,
            success: function (datos) {
                if (parseInt(datos) == 0) {
                    $("#lista").html();
                } else {
                    alert("Error: " + datos);
                }
            },
            error: function () {
                alert("Error");
            }
        });
    });*/
    $("#afectar").click(function() {
        var tipo=$("#tipo").val();
        var valor = $("#loading").attr("valor");
        var factor = parseFloat($("#factor").val()) || 0;
        var selected = $(".dual_select").val();
        if (selected.length == 0) {
            return false;
        }
        if (factor == 0) {
            return false;
        }
        var parametros = {
            funcion: "afectarPrecios",
            selected: selected,
            factor: factor,
            valor: valor,
            tipo: tipo
        }
        $.ajax({
            type: "POST",
            url: 'controller/ajustes.controller.php',
            data: parametros,
            success: function(datos) {
                if (parseInt(datos) == 0) {
                    location.reload();
                } else {
                    alert("Error");
                }
            },
            error: function() {
                alert("Error");
            },
            complete: function() {
                requestSent = false;
                $(window).scrollTop(scroll);
            }
        });
    });

    $(".afecta_factor").change(function() {
        var select_subir = $("#select_subir").val();
        var porcentaje = $("#porcentaje").val();
        var factor = $("#factor").val();
        var diferencia = porcentaje / 100;
        if (select_subir > 0) {
            factor = 1 + diferencia;
        }
        if (select_subir < 0) {
            factor = 1 - diferencia;
        }
        $("#factor").val(factor.toFixed(2));
    })
    $("#tipo").change(function(){
        var valor=$("#select_valor").val();
        var tipo_valor=$(this).val();
        window.location.href="ajustes.php?valor="+valor+"&tipo="+tipo_valor;
        window.location.href="ajustes.php?valor="+valor+"&tipo="+tipo_valor;
    });
    $("#select_valor").change(function() {
        var tipo=$("#tipo").val();
        var select_valor = $(this).val();
        window.location.href = "ajustes.php?tipo="+tipo+"&valor=" + select_valor;
    });
</script>