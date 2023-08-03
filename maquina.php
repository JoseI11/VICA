<?php

session_start();

/*if ($_SESSION["cargo"] != "Administrador") {
    header("Location: login.php");
}*/

include $_SERVER['DOCUMENT_ROOT'] . "/VICA/controller/maquinas.controller.php";
$controlador = MaquinasController::singleton_maquinas();
$componentes = $controlador->getComponentes();

$_SESSION["totales"] = $controlador->getCountMaquinas();

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

$_SESSION['menu'] = "maquinas.php";

$_SESSION['breadcrumb'] = "Maquinas";

$titlepage = "Maquinas";

include 'inc/html/encabezado.php';

include 'inc/html/menu.php';

include 'inc/html/breadcrumb.php';

?>


<div class="container">

    <div id="loading" class="loading" codigo="<?php echo intval($_GET["codigo"]); ?>"></div>
    
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
    
    <div class="modal fade" id="myModal" maquina="dialog">
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

    <form id="guardarDatosMaquina">
        <div class="modal fade" id="dataRegister" tabindex="-1" maquina="dialog" aria-labelledby="exampleModalLabel">
            <div class="modal-dialog" maquina="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="exampleModalLabel">Nuevo</h4>
                    </div>
                    <div class="modal-body">
                        <div id="datos_ajax_register"></div>
                        <div class="form-group" style="display: flex;">
                            <label for="label0" class="control-label encabezado-form" style="margin-left:1%; margin-top:10px; width: 15%; text-align: right;">Elemento:</label>
                            <select id="componenteAdd" style="margin-left:1%; width: 77%;" class="form-control" name="componenteAdd">
                                <?php foreach ($componentes as $reg) {?>
                                    <option type="text" value="<?php echo $reg["codigo"]; ?>"><?php $usado = $reg["es_usado"] == 1 ? "Usado" : "Nuevo"; echo $reg["descripcion"] . " (" . $usado .")"; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group" style="display: flex;">
                            <label for="label0" class="control-label encabezado-form" style="margin-left:1%; margin-top:10px; width: 15%; text-align: right;">Cantidad:</label>
                            <input type="text" class="form-control" id="cantidadAdd" name="cantidadAdd"  style="margin-left:1%; width: 30%;" maxlength="100">
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

    <form id="actualidarDatosMaquina">
        <div class="modal fade" id="dataUpdate" tabindex="-1" maquina="dialog" aria-labelledby="exampleModalLabel">
            <div class="modal-dialog" maquina="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="exampleModalLabel">Modificar</h4>
                    </div>
                    <div class="modal-body">
                        <div id="datos_ajax_register"></div>
                        <div class="form-group" style="display: flex;">
                            <label for="label0" class="control-label encabezado-form" style="margin-left:1%; margin-top:10px; width: 15%; text-align: right;">Elemento:</label>
                            <select id="componenteUpdate" style="margin-left:1%; width: 77%;" class="form-control" name="componenteUpdate">
                                <?php foreach ($componentes as $reg) {?>
                                    <option type="text" value="<?php echo $reg["codigo"]; ?>"><?php $usado = $reg["es_usado"] == 1 ? "Usado" : "Nuevo"; echo $reg["descripcion"] . " (" . $usado .")"; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group" style="display: flex;">
                            <label for="label0" class="control-label encabezado-form" style="margin-left:1%; margin-top:10px; width: 15%; text-align: right;">Cantidad:</label>
                            <input type="text" class="form-control" id="cantidadUpdate" name="cantidadUpdate"  style="margin-left:1%; width: 30%;" maxlength="100">
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

<div style="bottom: 50px; right: 40px; position: fixed;">
    <button id="add" name="add" type="button" class="btn btn-danger btn-lg boton_marron_carni" style="width: 50px;border-radius: 50%; text-align: center; background-color: transparent;"><i style="margin-bottom: 5px;" class="glyphicon glyphicon-plus"></i></button>
</div>

<?php

include 'inc/html/footer.php';

?>

<script type="text/javascript" src="inc/js/maquina_js.js?version=<?php echo date("Y-m-d H:i:s"); ?>"></script>
<script type="text/javascript" src="inc/js/utils.js"></script>
<script type="text/javascript" src="inc/js/jquery.table2excel.js"></script>