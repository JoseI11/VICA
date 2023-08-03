<?php

session_start();

/*if ($_SESSION["cargo"] != "Administrador") {
    header("Location: login.php");
}*/

include $_SERVER['DOCUMENT_ROOT'] . "/VICA/controller/personas.controller.php";
$controlador = PersonasController::singleton_personas();
$provincias = $controlador->getProvincias();
$paises = $controlador->getPaises();

$_SESSION["totales"] = $controlador->getCountPersonas();

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

$_SESSION['menu'] = "personas.php";

$_SESSION['breadcrumb'] = "Personas";

$titlepage = "Personas";

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

    <div class="modal fade" id="myModal" persona="dialog">
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

    <form id="guardarDatosPersona">
        <div class="modal fade" id="dataRegister" tabindex="-1" persona="dialog" aria-labelledby="exampleModalLabel">
            <div class="modal-dialog" persona="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="exampleModalLabel">Nuevo</h4>
                    </div>
                    <div class="modal-body">
                        <div id="datos_ajax_register"></div>
                        <div class="form-group">
                            <label for="nombre0" class="control-label">Nombre:</label>
                            <input type="text" class="form-control" id="descripcionAdd" name="descripcionAdd" required maxlength="100">
                        </div>
                        <div class="form-group">
                            <label for="nombre0" class="control-label">Teléfono:</label>
                            <input type="text" class="form-control" id="telefonoAdd" name="telefonoAdd" required maxlength="100">
                        </div>
                        <div class="form-group">
                            <label for="nombre0" class="control-label">Localidad:</label>
                            <input type="text" class="form-control" id="localidadAdd" name="localidadAdd" required maxlength="100">
                        </div>
                        <div class="form-group">
                            <label for="nombre0" class="control-label">CUIT:</label>
                            <input type="text" class="form-control" id="cuitAdd" name="cuitAdd" required maxlength="100">
                        </div>
                        <div class="form-group">
                            <label for="nombre0" class="control-label">Mail:</label>
                            <input type="text" class="form-control" id="mailAdd" name="mailAdd" required maxlength="100">
                        </div>
                        <div class="form-group">
                            <label for="nombre0" class="control-label">Pais:</label>
                            <select id="paisAdd" class="form-control" name="paisAdd">
                                <?php foreach ($paises as $reg) {?>
                                    <option type="text" value="<?php echo $reg["codigo"]; ?>"><?php echo $reg["descripcion"]; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="nombre0" class="control-label">Provincia:</label>
                            <select id="provinciaAdd" class="form-control" name="provinciaAdd">
                                <?php foreach ($provincias as $reg) {?>
                                    <option type="text" value="<?php echo $reg["codigo"]; ?>"><?php echo $reg["descripcion"]; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="nombre0" class="control-label">Es Cliente:</label>
                            <select id="clienteAdd" class="form-control" name="clienteAdd">
                                <option type="text" value="0">NO</option>
                                <option type="text" value="1">SI</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="nombre0" class="control-label">Es Proveedor:</label>
                            <select id="proveedorAdd" class="form-control" name="proveedorAdd">
                                <option type="text" value="0">NO</option>
                                <option type="text" value="1">SI</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="nombre0" class="control-label">Es Transportista:</label>
                            <select id="transportistaAdd" class="form-control" name="transportistaAdd">
                                <option type="text" value="0">NO</option>
                                <option type="text" value="1">SI</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="nombre0" class="control-label">Es Vendedor:</label>
                            <select id="vendedorAdd" class="form-control" name="vendedorAdd">
                                <option type="text" value="0">NO</option>
                                <option type="text" value="1">SI</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="nombre0" class="control-label">Es Empleado:</label>
                            <select id="empleadoAdd" class="form-control" name="empleadoAdd">
                                <option type="text" value="0">NO</option>
                                <option type="text" value="1">SI</option>
                            </select>
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

    <form id="actualidarDatosPersona">
        <div class="modal fade" id="dataUpdate" tabindex="-1" persona="dialog" aria-labelledby="exampleModalLabel">
            <div class="modal-dialog" persona="document">
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
                        <div class="form-group">
                            <label for="nombre0" class="control-label">Teléfono:</label>
                            <input type="text" class="form-control" id="telefonoUpdate" name="telefonoUpdate" required maxlength="100">
                        </div>
                        <div class="form-group">
                            <label for="nombre0" class="control-label">Localidad:</label>
                            <input type="text" class="form-control" id="localidadUpdate" name="localidadUpdate" required maxlength="100">
                        </div>
                        <div class="form-group">
                            <label for="nombre0" class="control-label">CUIT:</label>
                            <input type="text" class="form-control" id="cuitUpdate" name="cuitUpdate" required maxlength="100">
                        </div>
                        <div class="form-group">
                            <label for="nombre0" class="control-label">Mail:</label>
                            <input type="text" class="form-control" id="mailUpdate" name="mailUpdate" required maxlength="100">
                        </div>
                        <div class="form-group">
                            <label for="nombre0" class="control-label">Pais:</label>
                            <select id="paisUpdate" class="form-control" name="paisUpdate">
                                <?php foreach ($paises as $reg) {?>
                                    <option type="text" value="<?php echo $reg["codigo"]; ?>"><?php echo $reg["descripcion"]; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="nombre0" class="control-label">Provincia:</label>
                            <select id="provinciaUpdate" class="form-control" name="provinciaUpdate">
                                <?php foreach ($provincias as $reg) {?>
                                    <option type="text" value="<?php echo $reg["codigo"]; ?>"><?php echo $reg["descripcion"]; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="nombre0" class="control-label">Es Cliente:</label>
                            <select id="clienteUpdate" class="form-control" name="clienteUpdate">
                                <option type="text" value="0">NO</option>
                                <option type="text" value="1">SI</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="nombre0" class="control-label">Es Proveedor:</label>
                            <select id="proveedorUpdate" class="form-control" name="proveedorUpdate">
                                <option type="text" value="0">NO</option>
                                <option type="text" value="1">SI</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="nombre0" class="control-label">Es Transportista:</label>
                            <select id="transportistaUpdate" class="form-control" name="transportistaUpdate">
                                <option type="text" value="0">NO</option>
                                <option type="text" value="1">SI</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="nombre0" class="control-label">Es Vendedor:</label>
                            <select id="vendedorUpdate" class="form-control" name="vendedorUpdate">
                                <option type="text" value="0">NO</option>
                                <option type="text" value="1">SI</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="nombre0" class="control-label">Es Empleado:</label>
                            <select id="empleadoUpdate" class="form-control" name="empleadoUpdate">
                                <option type="text" value="0">NO</option>
                                <option type="text" value="1">SI</option>
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

<script type="text/javascript" src="inc/js/personas_js.js?version=<?php echo date("Y-m-d H:i:s"); ?>"></script>
<script type="text/javascript" src="inc/js/utils.js"></script>
<script type="text/javascript" src="inc/js/jquery.table2excel.js"></script>