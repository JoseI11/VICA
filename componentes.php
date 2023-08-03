<?php

session_start();

/*if ($_SESSION["cargo"] != "Administrador") {
    header("Location: login.php");
}*/

include $_SERVER['DOCUMENT_ROOT'] . "/VICA/controller/componentes.controller.php";
$controlador = ComponentesController::singleton_componentes();
$unidades = $controlador->getUnidades();
$categorias = $controlador->getComponentesCategorias();

$_SESSION["totales"] = $controlador->getCountComponentes();

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

$_SESSION['menu'] = "componentes.php";

$_SESSION['breadcrumb'] = "Componentes";

$titlepage = "Componentes";

include 'inc/html/encabezado.php';

include 'inc/html/menu.php';

include 'inc/html/breadcrumb.php';

?>


<div class="container">

    <div id="loading" class="loading"></div>
    
    <div id="modulo_paginacion">
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

    <div class="modal fade" id="myModal" componente="dialog">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 id="name-header-modal" class="modal-title">Eliminar</h4>
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

    <form id="guardarDatosComponente">
        <div class="modal fade" id="dataRegister" tabindex="-1" componente="dialog" aria-labelledby="exampleModalLabel">
            <div class="modal-dialog modal-lg" componente="document">
                <div class="modal-content" >
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="exampleModalLabel">Nuevo</h4>
                    </div>
                    <div class="modal-body">
                    <div id="datos_ajax_register"></div>
                    <div class="form-group">
                        <label for="nombre0" class="control-label">Descripcion:</label>
                        <input type="text" class="form-control" id="descripcionAdd" name="descripcion" required maxlength="100" >
                    </div>

                    <div class="form-group" style="display: flex;">
                        <label for="label0" class="control-label encabezado-form" style="margin-left:1%; margin-top:10px; width: 12%; text-align: right;">Codigo:</label>
                        <input type="text" class="form-control" id="CodigoAdd" name="codigo_mp" style="margin-left:1%; width: 20%;" maxlength="100" >
                        <label for="label0" class="control-label encabezado-form" style="margin-left:1%; margin-top:10px; width: 12%; text-align: right;">Dimension:</label>
                        <input type="text" class="form-control" id="DimensionAdd" name="dimension" style="margin-left:1%; width: 20%;" maxlength="100" >
                        <label for="label0" class="control-label encabezado-form" style="margin-left:1%; margin-top:10px; width: 10%; text-align: right;">Espesor:</label>
                        <input type="text" class="form-control" id="EspesorAdd" name="espesor" style="margin-left:1%; width: 20%;" maxlength="100" >
                    </div>

                    <div class="form-group" style="display: flex;">
                        <label for="label0" class="control-label encabezado-form" style="margin-left:1%; margin-top:10px; width: 12%; text-align: right;">Largo:</label>
                        <input type="text" class="form-control" id="LargoAdd" name="largo" style="margin-left:1%; width: 20%;" maxlength="100" >
                        <label for="label0" class="control-label encabezado-form" style="margin-left:1%; margin-top:10px; width: 12%; text-align: right;">Largo Total:</label>
                        <input type="text" class="form-control" id="LargoTotalAdd" name="largo_total" style="margin-left:1%; width: 20%;" maxlength="100" >
                        <label for="label0" class="control-label encabezado-form" style="margin-left:1%; margin-top:10px; width: 10%; text-align: right;">Peso:</label>
                        <input type="text" class="form-control" id="PesoAdd" name="peso" style="margin-left:1%; width: 20%;" maxlength="100" >
                    </div>

        <div class="form-group" style="display: flex;">
            <label for="label0" class="control-label encabezado-form" style="margin-left:1%; margin-top:10px; width: 12%; text-align: right;">Peso Total:</label>
            <input type="text" class="form-control" id="PesoTotalAdd" name="peso_total" style="margin-left:1%; width: 20%;" maxlength="100" >
            <label for="label0" class="control-label encabezado-form" style="margin-left:1%; margin-top:10px; width: 12%; text-align: right;">Unidad:</label>
            <select id="unidadAdd" style="margin-left:1%; width: 20%;" class="form-control" name="unidad">
                <?php foreach ($unidades as $reg) {?>
                    <option type="text" value="<?php echo $reg["codigo"]; ?>" <?php echo ($componente["cod_unidad"]==$reg["codigo"]) ? "selected" : ''; ?>><?php echo $reg["descrip_abrev"]; ?></option>
                <?php } ?>
            </select>
            <label for="label0" class="control-label encabezado-form" style="margin-left:1%; margin-top:10px; width: 10%; text-align: right;">Categoría:</label>
            <select id="CategoriaAdd" style="margin-left:1%; width: 20%;" class="form-control" name="categoria">
                <?php foreach ($categorias as $reg) {?>
                    <option type="text" value="<?php echo $reg["codigo"]; ?>" <?php echo ($componente["cod_componente_categoria"]==$reg["codigo"]) ? "selected" : ''; ?>><?php echo $reg["descripcion"]; ?></option>
                <?php } ?>
            </select>
        </div>
        <div class="form-group" style="display: flex;">
            <label for="label0" class="control-label encabezado-form" style="margin-left:1%; margin-top:10px; width: 12%; text-align: right;">Costo:</label>
            <input type="text" class="form-control" id="CostoAdd" name="costo" style="margin-left:1%; width: 20%;" maxlength="100" value="<?php echo $componente["costo_unitario"]; ?>">
            <label for="label0" class="control-label encabezado-form" style="margin-left:1%; margin-top:10px; width: 12%; text-align: right;">Precio:</label>
            <input type="text" class="form-control" id="PrecioAdd" name="precio" style="margin-left:1%; width: 20%;" maxlength="100" value="<?php echo $componente["precio_unitario"]; ?>">
            <label for="label0" class="control-label encabezado-form" style="margin-left:1%; margin-top:10px; width: 10%; text-align: right;">IVA:</label>
            <input type="text" class="form-control" id="IvaAdd" name="iva" style="margin-left:1%; width: 20%;" maxlength="100" value="<?php echo $componente["iva"]; ?>">

        </div>
        <div class="form-group" style="display: flex;">
            <label for="label0" class="control-label encabezado-form" style="margin-left:1%; margin-top:10px; width: 12%; text-align: right;">Stock Mínimo:</label>
            <input type="text" class="form-control" id="StockMinAdd" name="minimo" style="margin-left:1%; width: 20%;" maxlength="100" value="<?php echo $componente["stock_minimo"]; ?>">
            <label for="label0" class="control-label encabezado-form" style="margin-left:1%; margin-top:10px; width: 12%; text-align: right;">Stock Máximo:</label>
            <input type="text" class="form-control" id="StockMaxAdd" name="maximo" style="margin-left:1%; width: 20%;" maxlength="100" value="<?php echo $componente["stock_maximo"]; ?>">
            <label for="label0" class="control-label encabezado-form" style="margin-left:1%; margin-top:10px; width: 10%; text-align: right;">Es Insumo:</label>
            <select id="insumoAdd" style="margin-left:1%; width: 20%;" class="form-control" name="insumo" >
                <option type="text" value="0" <?php echo ($componente["es_insumo"]==0) ? "selected" : ''; ?> ><?php echo "NO"; ?></option>
                <option type="text" value="1" <?php echo ($componente["es_insumo"]==1) ? "selected" : ''; ?>><?php echo "SI"; ?></option>
            </select>
        </div>
    
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-danger boton_marron_carni" >Guardar datos</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <form id="actualidarDatosComponente">
        <div class="modal fade" id="dataUpdate" tabindex="-1" componente="dialog" aria-labelledby="exampleModalLabel">
            <div class="modal-dialog" componente="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="exampleModalLabel">Modificar</h4>
                    </div>
                    <div class="modal-body">
                        <div id="datos_ajax_register"></div>
                        <div class="form-group">
                            <label for="nombre0" class="control-label">Nombre:</label>
                            <input type="text" class="form-control" id="descripcionUpdate" name="descripcionUpdate" required maxlength="100">
                        </div>
                        <div class="form-group" style="display: flex;">
                            <label for="label0" class="control-label encabezado-form" style="margin-left:1%; margin-top:10px; width: 15%; text-align: right;">Es Insumo:</label>
                            <select id="insumoUpdate" style="margin-left:1%; width: 30%;" class="form-control" name="insumoUpdate">
                                <option type="text" value="0"><?php echo "NO"; ?></option>
                                <option type="text" value="1"><?php echo "SI"; ?></option>
                            </select>
                            <label for="label0" class="control-label encabezado-form" style="margin-left:1%; margin-top:10px; width: 15%; text-align: right;">Unidad:</label>
                            <select id="unidadUpdate" style="margin-left:1%; width: 30%;" class="form-control" name="unidadUpdate">
                                <?php foreach ($unidades as $reg) {?>
                                    <option type="text" value="<?php echo $reg["codigo"]; ?>"><?php echo $reg["descrip_abrev"]; ?></option>
                                <?php } ?>
                            </select>
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
    
    
    <div class="col-lg-1 col-md-1 col-sm-12 col-xs-12 right">
        <input type="button" id="export" name="export" class="btn-danger btn-sm boton_marron_carni" style="border-radius: 10px; margin-left: 10px;" value="Exportar"/>
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

<script type="text/javascript" src="inc/js/componentes_js.js?version=<?php echo date("Y-m-d H:i:s"); ?>"></script>
<script type="text/javascript" src="inc/js/utils.js"></script>
<script type="text/javascript" src="inc/js/jquery.table2excel.js"></script>