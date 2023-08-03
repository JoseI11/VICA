<?php

session_start();

/*if ($_SESSION["cargo"] != "Administrador") {
    header("Location: login.php");
}*/

include $_SERVER['DOCUMENT_ROOT'] . "/VICA/controller/stocks.controller.php";
$controlador = StocksController::singleton_stocks();
$productos      = $controlador->getProductos();
$motivos        = $controlador->getMotivos();
$operaciones    = array();
foreach ($motivos as $m) {
    $operaciones[$m["codigo"]] = $m["descripcion"];
}

$_SESSION["totales"] = $controlador->getCountStocks();

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

$_SESSION['menu'] = "stocks.php";

$_SESSION['breadcrumb'] = "Stocks";

$titlepage = "Stocks";

include 'inc/html/encabezado.php';

include 'inc/html/menu.php';

include 'inc/html/breadcrumb.php';
$valor1 = $_POST['tipouso'];

?>

<head>

    <meta charset="utf-8">

    <title>Obtener valor de un select en jQuery</title>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

    <script>

    </script>
</head>

<div class="container">
    <div id="loading" class="loading" tipo="<?php echo $_GET["valor"];?>"></div>
    <!--<div id="loading" class="loading"></div>-->

    <div id="modulo_paginacion">
        <?php include 'inc/html/paginacion_stockscombo.php'; ?>
    </div>

    <div id="div_tabla" class="row col-lg-12" style="float: none" registros="<?php echo $_SESSION['cant_reg']; ?>" pagina="<?php echo $_SESSION['pagina']; ?>" orderby="<?php echo $_SESSION['orderby']; ?>" sentido="<?php echo $_SESSION['sentido']; ?>">
        <!-- Devolución Ajax -->
    </div>

    <form id="guardarDatosStock">
        <?php
        $cal = $_POST['tipouso'];
        echo $cal;
        ?>
        <div class="modal fade" id="dataRegister" tabindex="-1" stock="dialog" aria-labelledby="exampleModalLabel">
            <div class="modal-dialog" stock="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="exampleModalLabel">Nuevo Registro</h4>
                    </div>
                    <div class="modal-body">
                        <div id="datos_ajax_register"></div>

                        <div class="form-group" style="display: flex;">
                            <label for="label0" class="control-label encabezado-form" style="margin-left:1%; margin-top:10px; width: 15%; text-align: right;">Motivo:</label>
                            <select id="tipoAdd" style="margin-left:1%; width: 30%;" class="form-control" name="tipoAdd">
                                <?php foreach ($operaciones as $pos => $reg) { ?>
                                    <option type="text" value="<?php echo $pos; ?>"><?php echo $reg; ?></option>
                                <?php } ?>
                            </select>
                            <label for="label0" class="control-label encabezado-form" style="margin-left:1%; margin-top:10px; width: 15%; text-align: right;">Fecha:</label>
                            <input type="date" style="margin-left:1%;width: 30%; " class="form-control" id="fechaAdd" name="fechaAdd" required value="<?php echo date("Y-m-d"); ?>">
                        </div>

                        <div class="form-group" style="display: flex;">
                            <!--<label for="label0" class="venta control-label encabezado-form" style="margin-left:1%; margin-top:10px; width: 15%; text-align: right;">Producto:</label>
                            <select disabled id="productoAdd" style="margin-left:1%; width: 30%;" class="venta form-control" name="productoAdd">
                                <?php foreach ($productos as $pos => $reg) { ?>
                                    <option type="text" value="<?php echo $reg["codigo"]; ?>"><?php echo $reg["descripcion"]; ?></option>
                                <?php } ?>
                            </select>-->
                            <label for="label0" class="venta control-label encabezado-form" style="margin-left:1%; margin-top:10px; width: 15%; text-align: right;">Cantidad:</label>
                            <input type="text" style="margin-left:1%;width: 77%; " class="venta form-control" id="cantidadAdd" name="cantidadAdd" required>
                        </div>

                        <div class="form-group" style="display: flex;">
                            <label for="label0" class="venta control-label encabezado-form" style="margin-left:1%; margin-top:10px; width: 15%; text-align: right;">Motivo:</label>
                            <input type="text" style="margin-left:1%;width: 77%; " class="form-control" id="motivoAdd" name="motivoAdd" value=" " required>
                        </div>
                        <!--<div class="form-group" style="display: flex;">
                            <label for="label0" class="venta control-label encabezado-form" style="margin-left:1%; margin-top:10px; width: 15%; text-align: right;">Uso:</label>
                            <select disabled id="tipousoAdd"  style="margin-left:1%; width: 30%;" class="venta form-control" name="tipousoAdd">
                                <option type="text" value="0" <?php echo ($maquina["es_usado"] == 0) ? "selected" : ''; ?>>Usado</option>
                                <option type="text" value="1" <?php echo ($maquina["es_usado"] == 1) ? "selected" : ''; ?>>Nuevo</option>
                            </select>
                            <label for="label0" class="venta control-label encabezado-form" style="margin-left:1%; margin-top:10px; width: 15%; text-align: right;">Tipo:</label>
                            <select disabled id="tipoproductoAdd" style="margin-left:1%; width: 30%;" class="venta form-control" name="tipoproductoAdd">
                                <option value="1" <?php echo $tipo == 1 ? "selected" : ""; ?>>Insumo</option>
                                <option value="2" <?php echo $tipo == 2 ? "selected" : ""; ?>>Componente</option>
                                <option value="3" <?php echo $tipo == 3 ? "selected" : ""; ?>>Maquina</option>
                            </select>
                        </div> -->
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

<script type="text/javascript" src="inc/js/stocks_js.js?version=<?php echo date("Y-m-d H:i:s"); ?>"></script>
<script type="text/javascript" src="inc/js/utils.js"></script>
<script type="text/javascript" src="inc/js/jquery.table2excel.js"></script>