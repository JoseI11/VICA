<?php

session_start();

/*if ($_SESSION["cargo"] != "Administrador") {
    header("Location: login.php");
}*/

include $_SERVER['DOCUMENT_ROOT'] . "/VICA/controller/orden_ventas.controller.php";
$controlador = OrdenVentasController::singleton_orden_ventas();
$formas = $controlador->getFormas();

$_SESSION["totales"] = $controlador->getCountOrdenVentas();

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
        $orderby = "codigo";
    }
}
$_SESSION["orderby"] = $orderby;

if (isset($_GET['sentido'])) {
    $sentido = $_GET['sentido'];
} else {
    if (isset($_POST['sentido'])) {
        $sentido = $_POST['sentido'];
    } else {
        $sentido = "asc";
    }
}
$_SESSION["sentido"] = $sentido;

// Fin Recepcion parametros PAGINACION /***************************************/

$_SESSION['menu'] = "orden_ventas.php";

$_SESSION['breadcrumb'] = "OrdenVentas";

$titlepage = "OrdenVentas";

include 'inc/html/encabezado.php';

include 'inc/html/menu.php';

include 'inc/html/breadcrumb.php';

$ov = $controlador->getVenta(intval($_GET["codigo"]))[0];

?>


<div class="container">

    <div id="loading" class="loading" codigo="<?php echo intval($_GET["codigo"]); ?>" ver="<?php echo intval($_GET["ver"]); ?>"></div>
    
    <div id="modulo_paginacion" style="display: none;">
        <?php include 'inc/html/paginacion.php'; ?>
    </div>

    <div    id="div_tabla" 
            class="row col-lg-12" 
            style="float: none"
            registros="<?php echo $_SESSION['cant_reg']; ?>" 
            pagina="<?php echo $_SESSION['pagina']; ?>"
            orderby="<?php echo $_SESSION['orderby']; ?>"
            sentido="<?php echo $_SESSION['sentido']; ?>"
    >
        <!-- Devolución Ajax -->
    </div>
    
    <div class="modal fade" id="myModal" orden_compra="dialog">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 id="name-header-modal" class="modal-title">Eliminar!</h4>
                </div>
                <div class="modal-body text-center"  id="text-header-body">

                </div>
                <div class="modal-footer">
                    <button type="button" id="btn-eliminar-rol" name="btn-eliminar-rol" class="btn btn-danger boton_marron_carni" data-dismiss="modal" >Eliminar</button>
                    <button type="button" id="btn-cancelar" name="btn-cancelar" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </div>
    </div>

    <form id="guardarDatosOrdenCompra">
        <div class="modal fade" id="dataRegister" tabindex="-1" orden_compra="dialog" aria-labelledby="exampleModalLabel">
            <div class="modal-dialog" orden_compra="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="exampleModalLabel">Nuevo</h4>
                    </div>
                    <div class="modal-body">
                        <div id="datos_ajax_register"></div>
                        <div class="form-group">
                            <label for="nombre0" class="control-label">Fecha:</label>
                            <input type="date" class="form-control" id="fechaAdd" name="fechaAdd" required maxlength="10" value="<?php echo date("Y-m-d"); ?>">
                        </div>
                        <div class="form-group">
                            <label for="label0" class="control-label ">Forma de Pago:</label>
                            <select id="formaAdd" class="form-control" name="formaAdd">
                                <?php foreach ($formas as $reg) {?>
                                    <option type="text" value="<?php echo $reg["codigo"]; ?>">
                                        <?php echo $reg["descripcion"]; ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="label0" class="control-label encabezado-form" >Importe:</label>
                            <input type="text" class="form-control" id="importeAdd" name="importeAdd"  maxlength="100">
                        </div>
                        <div class="form-group">
                            <label for="label0" class="control-label encabezado-form" >Observaciones:</label>
                            <input type="text" class="form-control" id="observacionesAdd" name="observacionesAdd"  maxlength="100">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-danger boton_marron_carni" >Guardar datos</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <form id="actualidarDatosOrdenCompra">
        <div class="modal fade" id="dataUpdate" tabindex="-1" orden_compra="dialog" aria-labelledby="exampleModalLabel">
            <div class="modal-dialog" orden_compra="document">
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
                            <label for="label0" class="control-label ">Forma de Pago:</label>
                            <select id="formaUpdate" class="form-control" name="formaUpdate">
                                <?php foreach ($formas as $reg) {?>
                                    <option type="text" value="<?php echo $reg["codigo"]; ?>">
                                        <?php echo $reg["descripcion"]; ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="label0" class="control-label encabezado-form" >Importe:</label>
                            <input type="text" class="form-control" id="importeUpdate" name="importeUpdate"  maxlength="100">
                        </div>
                        <div class="form-group">
                            <label for="label0" class="control-label encabezado-form" >Observaciones:</label>
                            <input type="text" class="form-control" id="observacionesUpdate" name="observacionesUpdate"  maxlength="100">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-danger boton_marron_carni" >Actualizar datos</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

</div>
<?php //if ($ov["cod_orden_venta_tipo"] != 1) { ?>
    <div style="bottom: 50px; right: 40px; position: fixed;">
        <button id="add" name="add" type="button" class="btn btn-danger btn-lg boton_marron_carni" style="width: 50px;border-radius: 50%; text-align: center; background-color: transparent;"><i style="margin-bottom: 5px;" class="glyphicon glyphicon-plus"></i></button>
    </div>
<?php //} ?>
<?php

include 'inc/html/footer.php';

?>

<script type="text/javascript" src="inc/js/orden_venta_pagos_js.js?version=<?php echo date("Y-m-d H:i:s"); ?>"></script>
<script type="text/javascript" src="inc/js/utils.js"></script>
<script type="text/javascript" src="inc/js/jquery.table2excel.js"></script>