<?php

session_start();

/*if ($_SESSION["cargo"] != "Administrador") {
    header("Location: login.php");
}*/

include $_SERVER['DOCUMENT_ROOT'] . "/VICA/controller/orden_trabajos.controller.php";
$controlador = OrdenTrabajosController::singleton_orden_trabajos();
$proveedores = $controlador->getProveedores();
$unidades = $controlador->getUnidades();
$productos = $controlador->getProductos();
$ventas = $controlador->getVentas();
$ventas_pendientes = $controlador->getVentasPendientes();
$quebrados = $controlador->getCajaDeQuebrados();
$sinfin = $controlador->getSinFin();
$motor = $controlador->getMotor();
$personas = $controlador->getPersonas();

$_SESSION["totales"] = $controlador->getCountOrdenTrabajos();

// Recepcion parametros PAGINACION /*******************************************/

if (isset($_GET['pagina'])) {
    $pagina = $_GET['pagina'];
} else {
    if (isset($_POST['pagina'])) {
        $pagina = $_POST['pagina'];
    } else {
        $pagina = 1;
    }
}
$_SESSION["pagina"] = $pagina;

if (isset($_GET['cant_reg'])) {
    $cant_reg = $_GET['cant_reg'];
} else {
    if (isset($_POST['cant_reg'])) {
        $cant_reg = $_POST['cant_reg'];
    } else {
        $cant_reg = 25;
    }
}
$_SESSION["cant_reg"] = $cant_reg;

if (isset($_GET['busqueda'])) {
    $busqueda = $_GET['busqueda'];
} else {
    if (isset($_POST['busqueda'])) {
        $busqueda = $_POST['busqueda'];
    } else {
        $busqueda = "";
    }
}
$_SESSION["busqueda"] = $busqueda;

if (isset($_GET['orderby'])) {
    $orderby = $_GET['orderby'];
} else {
    if (isset($_POST['orderby'])) {
        $orderby = $_POST['orderby'];
    } else {
        $orderby = "fecha_programada_entrega";
    }
}
$_SESSION["orderby"] = $orderby;

if (isset($_GET['sentido'])) {
    $sentido = $_GET['sentido'];
} else {
    if (isset($_POST['sentido'])) {
        $sentido = $_POST['sentido'];
    } else {
        $sentido = "desc";
    }
}
$_SESSION["sentido"] = $sentido;

// Fin Recepcion parametros PAGINACION /***************************************/

$_SESSION['menu'] = "orden_trabajos.php";

$_SESSION['breadcrumb'] = "OrdenTrabajos";

$titlepage = "OrdenTrabajos";

include 'inc/html/encabezado.php';

include 'inc/html/menu.php';

include 'inc/html/breadcrumb.php';

?>


<div class="container">

    <div id="loading" class="loading"></div>

    <div id="modulo_paginacion">
        <?php include 'inc/html/paginacion.php'; ?>
    </div>

    <div id="div_tabla" class="row col-lg-12" style="float: none" registros="<?php echo $_SESSION['cant_reg']; ?>" pagina="<?php echo $_SESSION['pagina']; ?>" orderby="<?php echo $_SESSION['orderby']; ?>" sentido="<?php echo $_SESSION['sentido']; ?>">
        <!-- Devolución Ajax -->
    </div>

    <div class="modal fade" id="myModal" orden_trabajo="dialog">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 id="name-header-modal" class="modal-title">Eliminar</h4>
                </div>
                <div class="modal-body text-center" id="text-header-body">

                </div>
                <div class="modal-footer">
                    <button type="button" id="btn-eliminar-rol" name="btn-eliminar-rol" class="btn btn-danger boton_marron_carni" data-dismiss="modal">Eliminar</button>
                    <button type="button" id="btn-cancelar" name="btn-cancelar" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </div>
    </div>

    <form id="guardarDatosOrdenTrabajo">
        <div class="modal fade" id="dataRegister" tabindex="-1" orden_trabajo="dialog" aria-labelledby="exampleModalLabel">
            <div class="modal-dialog" style="width:900px;" orden_trabajo="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="exampleModalLabel">Nuevo</h4>
                    </div>
                    <div class="modal-body">
                        <div id="datos_ajax_register"></div>
                        <div class="form-group">
                            <label for="nombre0" class="control-label">Entrega Programada:</label>
                            <input type="date" class="form-control" id="fechaAdd" name="fechaAdd" required maxlength="10" value="<?php echo date("Y-m-d"); ?>">
                        </div>
                        <div class="form-group">

                            <label for="label0" class="control-label ">Tipo:</label>
                            <select id="tipoproductotrabajo" class="form-control" name="tipoproductotrabajo">
                                <option value="1" tipo_prod_v="1">Insumo</option>
                                <option value="2" tipo_prod_v="2">Componente</option>
                                <option value="3" tipo_prod_v="2">Maquina</option>
                            </select>

                        </div>

                        <div class="form-group">
                            <label for="label0" class="control-label ">Orden de Venta:</label>
                            <select id="productoAdd" class="form-control" name="productoAdd">
                                <option type="text" value="0"></option>
                                <?php foreach ($ventas_pendientes as $reg) { ?>
                                    <option type="text" value="<?php echo $reg["codigo"]; ?>">
                                        <?php echo "OV#" . $reg["codigo"] . " - " . $reg["cliente"];
                                        echo $reg["maquina"] ? " MAQ: " : " COMP: ";
                                        echo $reg["maquina"] ? $reg["maquina"] : $reg["componente"]; ?>
                                    </option>
                                <?php } ?>
                            </select>
                            <p><label id="label1" style="color: #a7b1c2;"></label></p>
                            <p><label id="label2" style="color: #a7b1c2;"></label></p>
                        </div>
                        <div class="form-group " ">
                        <label for=" label0" class="control-label ">Productos: </label>
                            <!--<label for="label0" class="control-label" style="margin-top:10px; position:relative;bottom: 30px; width: 14%; text-align: right;">Producto:</label>-->
                            <select id="productoAddtrabajo" class="form-control" style="margin-left:1%; width: 100%;" name="productoAddtrabajo">


                            </select>
                        </div>
                        <div class="form-group hidden">
                            <label for="nombre0" class="control-label">Cliente:</label>
                            <input type="text" class="form-control" id="clienteAdd" name="clienteAdd">
                        </div>
                        <div class="form-group">
                            <label for="nombre0" class="control-label">Observaciones:</label>
                            <input type="text" class="form-control" id="observacionesAdd" name="observacionesAdd">
                        </div>

                        <div class="form-group">
                            <label for="nombre0" class="control-label">Personal Encargado:</label>
                            <select id="PersonalOtAdd" class="form-control" name="PersonalOtAdd" style="height:70px;" multiple>
                                <?php foreach ($personas as $reg) { ?>
                                    <option type="text" value="<?php echo $reg["codigo"]; ?>" <?php echo (strpos($orden_trabajo["personal_ot"], '"' . $reg["codigo"] . '"') !== false) ? "selected" : ''; ?>><?php echo $reg["descripcion"]; ?></option>
                                <?php } ?>
                            </select>

                        </div>

                        <div class="form-group" style="display: flex;">
                            <div class="form-group">
                                <label for="label0" class="control-label ">Caja de quebrados 1:</label>
                                <select id="cajaquedradoAdd" class="form-control" name="cajaquedradoAdd">
                                    <option type="text" value="0"></option>
                                    <?php foreach ($quebrados as $reg) { ?>
                                        <option type="text" value="<?php echo $reg["codigo"]; ?>">
                                            <?php
                                            echo $reg["descrip_abrev"];
                                            ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="form-group" style="margin-left:5%;">

                                <label for="label0" class="control-label ">Caja de quebrados 2:</label>
                                <select id="cajaquedrado2Add" class="form-control" name="cajaquedrado2Add">
                                    <option type="text" value="0"></option>
                                    <?php foreach ($quebrados as $reg) { ?>
                                        <option type="text" value="<?php echo $reg["codigo"]; ?>">
                                            <?php
                                            echo $reg["descrip_abrev"];
                                            ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="form-group" style="margin-left:5%;">

                                <label for="label0" class="control-label ">Sin Fin:</label>
                                <select id="sinfinAdd" class="form-control" name="sinfinAdd">
                                    <option type="text" value="0"></option>
                                    <?php foreach ($sinfin as $reg) { ?>
                                        <option type="text" value="<?php echo $reg["codigo"]; ?>">
                                            <?php
                                            echo $reg["descrip_abrev"];
                                            ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="form-group" style="margin-left:5%;">
                                <label for="label0" class="control-label ">Motor:</label>
                                <select id="motorAdd" class="form-control" name="motorAdd">
                                    <option type="text" value="0"></option>
                                    <?php foreach ($motor as $reg) { ?>
                                        <option type="text" value="<?php echo $reg["codigo"]; ?>">
                                            <?php
                                            echo $reg["descrip_abrev"];
                                            ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-danger boton_marron_carni">Guardar datos</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <form id="actualizarDatosOrdenTrabajo">
        <div class="modal fade" id="dataUpdate" tabindex="-1" orden_trabajo="dialog" aria-labelledby="exampleModalLabel">
            <div class="modal-dialog" orden_trabajo="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="exampleModalLabel">Modificar</h4>
                    </div>
                    <div class="modal-body">
                        <div id="datos_ajax_register"></div>
                        <div class="form-group">
                            <label for="nombre0" class="control-label">Fecha:</label>
                            <input type="date" class="form-control" id="fechaUpdate" name="fechaUpdate" required maxlength="10" value="<?php echo date("Y-m-d"); ?>">
                        </div>
                        <div class="form-group">
                            <label for="label0" class="control-label ">Orden de Venta:</label>
                            <select id="productoUpdate" class="form-control" name="productoUpdate">
                                <?php foreach ($ventas as $reg) { ?>
                                    <option type="text" value="<?php echo $reg["codigo"]; ?>">
                                        <?php
                                        echo "OV#" . $reg["codigo"] . " - " . $reg["cliente"];
                                        echo $reg["maquina"] ? " MAQ: " : " COMP: ";
                                        echo $reg["maquina"] ? $reg["maquina"] : $reg["componente"];
                                        ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group hidden">
                            <label for="nombre0" class="control-label">Cliente:</label>
                            <input type="text" class="form-control" id="clienteUpdate" name="clienteUpdate">
                        </div>
                        <div class="form-group">
                            <label for="nombre0" class="control-label">Observaciones:</label>
                            <input type="text" class="form-control" id="observacionesUpdate" name="observacionesUpdate">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-danger boton_marron_carni">Guardar datos</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <div class="col-lg-1 col-md-1 col-sm-12 col-xs-12 right">
        <input type="button" id="export" name="export" class="btn-danger btn-sm boton_marron_carni" style="border-radius: 10px; margin-left: 10px;" value="Exportar" />
    </div>
    <div class="hidden-lg hidden-md">
        <br /><br />
    </div>

</div>

<div style="bottom: 50px; right: 40px; position: fixed;">
    <button id="add" name="add" type="button" class="btn btn-danger btn-lg boton_marron_carni" style="width: 50px;border-radius: 50%; text-align: center; background-color: transparent;"><i style="margin-bottom: 5px;" class="glyphicon glyphicon-plus"></i></button>
</div>


<?php

include 'inc/html/footer.php';

?>


<script>
    $('#tipoproductotrabajo').on('change', function() {
        var option1 = $(this).val()

        $.ajax({
            type: "POST",
            url: "ajaxData.php",

            data: "codigo=" + option1,

            success: function(html) {

                $("#productoAddtrabajo").html(html)
            }
        })

    })
</script>

<script type="text/javascript" src="inc/js/orden_trabajos_js.js?version=<?php echo date("Y-m-d H:i:s"); ?>"></script>
<script type="text/javascript" src="inc/js/utils.js"></script>
<script type="text/javascript" src="inc/js/jquery.table2excel.js"></script>