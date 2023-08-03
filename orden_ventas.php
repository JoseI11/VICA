<?php

session_start();

/*if ($_SESSION["cargo"] != "Administrador") {
    header("Location: login.php");
}*/

include $_SERVER['DOCUMENT_ROOT'] . "/VICA/controller/orden_ventas.controller.php";
$controlador = OrdenVentasController::singleton_orden_ventas();
$paises = $controlador->getPaises();
$provincias = $controlador->getProvincias();
$proveedores = $controlador->getProveedores();
$clientes = $controlador->getClientes();
$unidades = $controlador->getUnidades();
$productos = $controlador->getProductos2();
$insumosprod = $controlador->getProductos3();
$maquinas = $controlador->getMaquinas();
$estados = $controlador->getEstados();
$tipos = $controlador->getTipos();

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
        $orderby = "fecha";
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

$_SESSION['menu'] = "orden_ventas.php";

$_SESSION['breadcrumb'] = "OrdenVentas";

$titlepage = "OrdenVentas";

include 'inc/html/encabezado.php';

include 'inc/html/menu.php';

include 'inc/html/breadcrumb.php';

?>

<head>
    <style>

    </style>

</head>

<div class="container">

    <div id="loading" class="loading"></div>

    <div id="modulo_paginacion">
        <?php include 'inc/html/paginacion.php'; ?>
    </div>

    <div id="div_tabla" class="row col-lg-12" style="float: none" registros="<?php echo $_SESSION['cant_reg']; ?>" pagina="<?php echo $_SESSION['pagina']; ?>" orderby="<?php echo $_SESSION['orderby']; ?>" sentido="<?php echo $_SESSION['sentido']; ?>">
        <!-- Devolución Ajax -->
    </div>

    <div class="modal fade" id="myModal" orden_venta="dialog">
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

    <form id="guardarDatosOrdenVenta">

        <div class="modal fade" id="dataRegister" tabindex="-1" orden_venta="dialog" aria-labelledby="exampleModalLabel">
            <div class="modal-dialog modal-lg" orden_venta="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="exampleModalLabel">Nueva Orden de Venta</h4>
                    </div>
                    <div class="modal-body">
                        <div id="datos_ajax_register"></div>
                        
                            
                            <div class="form-group " style="display: flex;">
                                <label for="nombre0" class="control-label encabezado-form" style="margin-top:10px; width: 15%; text-align: right;">Trabajo:</label>
                                <select id="tipoAdd" class="form-control" style="margin-left:1%; width: 20%;" name="tipoAdd">
                                    <?php foreach ($tipos as $reg) { ?>
                                        <option type="text" value="<?php echo $reg["codigo"]; ?>"><?php echo $reg["descripcion"]; ?></option>
                                    <?php } ?>
                                </select>
                                <label for="label0" class="control-label encabezado-form" style="margin-top:10px; width: 15%; text-align: right;">Tipo:</label>
                                <select id="tipoproductoVenta" class="form-control" style="margin-left:1%; width: 20%;" name="tipoproductoVenta">
                                    <option value="1" tipo_prod_v="1" class="tipo_prod_v" <?php echo $tipo == 1 ? "selected" : ""; ?>>Insumo</option>
                                    <option value="2" tipo_prod_v="2" class="tipo_prod_v" <?php echo $tipo == 2 ? "selected" : ""; ?>>Componente</option>
                                    <option value="3" tipo_prod_v="3" class="tipo_prod_v" <?php echo $tipo == 3 ? "selected" : ""; ?>>Maquina</option>
                                </select>
                                <label for="label0" class="control-label encabezado-form" style="margin-top:10px; width: 15%; text-align: right;">Uso:</label>
                                <select id="tipousoVenta" class="form-control" style="margin-left:1%; width: 20%;" name="tipousoVenta">
                                    <option type="text" value="0" <?php echo ($maquina["es_usado"] == 0) ? "selected" : ''; ?>>Nuevo</option>
                                    <option type="text" value="1" <?php echo ($maquina["es_usado"] == 1) ? "selected" : ''; ?>>Usado</option>
                                </select>
                            </div>

                            <div class="form-group " style="display: flex;">
                                <label for="label0" class="control-label encabezado-form" style="margin-top:10px; width: 14%; text-align: right;">Producto:</label>
                                <select id="productoAdd" class="form-control prod_opt BuscardorD" style="margin-left:1%; width: 86%;" name="productoAdd">

                                    <?php
                                    include "./orden_ventas_refactor.php"
                                    ?>



                                    <!--<?php foreach ($insumosprod as $reg) { ?>
                                    <option class="tipo_de_insumo" tipo="1" estado=<?php echo $reg["es_usado"] ?> value=<?php echo $reg["codigo"] . "INS:" . $reg["descripcion"] ?>></option>
                                    
                                <?php } ?>
                                <?php foreach ($productos as $reg) { ?>
                                    <option type="text" value="<?php echo $reg["codigo"]; ?>">COMP: <?php echo $reg["descripcion"]; ?></option>
                                <?php } ?>
                                <?php foreach ($maquinas as $reg) { ?>
                                    <option type="text" value="-<?php echo $reg["codigo"]; ?>">MAQ: <?php echo $reg["descripcion"]; ?></option>
                                <?php } ?>-->
                                </select>
                            </div>

                            <div class="form-group " id="estadocobguardar" style="display: flex;">
                                <label for="nombre0" class="control-label encabezado-form" style="margin-top:10px; width: 15%; text-align: right;">Estado Cobranza:</label>
                                <select id="cobranzaAdd" class="form-control" style="margin-left:1%; width: 20%;" name="cobranzaAdd">
                                    <?php foreach ($estados as $reg) {
                                        if ($reg["cobranza"] == 0) {
                                            continue;
                                        }
                                    ?>
                                        <option type="text" value="<?php echo $reg["codigo"]; ?>"><?php echo $reg["descripcion"]; ?></option>
                                    <?php } ?>
                                </select>
                                <label for="nombre0" class="control-label encabezado-form" style="margin-top:10px; width: 15%; text-align: right;">Precio:</label>
                                <input type="text" class="form-control" style="margin-left:1%; width: 20%;" id="precioAdd" name="precioAdd">
                                <label for="nombre0" class="control-label encabezado-form" style="margin-top:10px; width: 15%; text-align: right;">Estado General:</label>
                                <select id="generalAdd" class="form-control" style="margin-left:1%; width: 20%;" name="generalAdd" <?php if( in_array($_SESSION["cod_rol"], [2])) { echo "disabled"; } ?> >
                                    <?php foreach ($estados as $reg) {
                                        if ($reg["general"] == 0) {
                                            continue;
                                        }
                                    ?>
                                        <option type="text" value="<?php echo $reg["codigo"]; ?>"><?php echo $reg["descripcion"]; ?></option>
                                    <?php } ?>
                                </select>
                            </div>

                            <div class="form-group " id="estadoentguardar" style="display: flex;">
                                <label for="nombre0" class="control-label encabezado-form" style="margin-top:10px; width: 15%; text-align: right;">Estado Entrega:</label>
                                <select id="entregaAdd" class="form-control" style="margin-left:1%; width: 20%;" name="entregaAdd">
                                    <?php foreach ($estados as $reg) {
                                        if ($reg["entrega"] == 0) {
                                            continue;
                                        }
                                    ?>
                                        <option type="text" value="<?php echo $reg["codigo"]; ?>"><?php echo $reg["descripcion"]; ?></option>
                                    <?php } ?>
                                </select>
                                <label for="nombre0" class="control-label encabezado-form" style="margin-top:10px; width: 15%; text-align: right;">Fecha:</label>
                                <input type="date" class="form-control" style="margin-left:1%; width: 20%;" id="fechaAdd" name="fechaAdd" required maxlength="10" value="<?php echo date("Y-m-d"); ?>">
                                <label for="nombre0" class="control-label encabezado-form" style="margin-top:10px; width: 15%; text-align: right;">Cantidad:</label>
                                <input type="text" class="form-control" style="margin-left:1%; width: 20%;" id="cantidadAdd" name="cantidadAdd">
                            </div>

                            <div class="form-group " style="display: flex;" id="BuscarCliente2">
                                
                                <label for="nombre0" class="control-label encabezado-form" style="margin-top:10px; width: 14%; text-align: right;">Cliente:</label>
                                <select id="clienteAdd" class="form-control BuscardorD" style="margin-left:3%; width: 55%;" name="clienteAdd">
                                    <?php foreach ($clientes as $reg) { ?>
                                        <option type="text" value="<?php echo $reg["codigo"]; ?>"><?php echo $reg["descripcion"]; ?></option>
                                    <?php } ?>
                                </select>

                            </div>

                            <div class="form-group " style="display: flex;" >
                                
                               
                                <label for="nombre0" class="control-label encabezado-form" style="margin-top:10px; width: 14%; text-align: right;">Provincia:</label>
                                <select id="provinciaAdd" class="form-control" style="margin-left:1%; width: 18.5%;" name="provinciaAdd">
                                    <?php foreach ($provincias as $reg) { ?>
                                        <option type="text" value="<?php echo $reg["codigo"]; ?>"><?php echo $reg["descripcion"]; ?></option>
                                    <?php } ?>
                                </select>
                                <label for="nombre0" class="control-label encabezado-form" style="margin-top:10px; width: 15%; text-align: right;">Pais:</label>
                                <select id="paisAdd" class="form-control" style="margin-left:1%; width: 20%;" name="paisAdd">
                                    <?php foreach ($paises as $reg) { ?>
                                        <option type="text" value="<?php echo $reg["codigo"]; ?>"><?php echo $reg["descripcion"]; ?></option>
                                    <?php } ?>
                                </select>
                            </div>

                            <div class="form-group " style="display: flex;">
                                
                                <label for="nombre0" class="control-label encabezado-form" style="margin-top:10px; width: 14%; text-align: right;">Observaciones:</label>
                                <input type="text" class="form-control" style="margin-left:1%; width: 86%;" id="observacionesAdd" name="observacionesAdd">
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

    <form id="actualizarDatosOrdenVenta">
        <div class="modal fade" id="dataUpdate" tabindex="-1" orden_venta="dialog" aria-labelledby="exampleModalLabel">
            <div class="modal-dialog modal-lg" orden_venta="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="exampleModalLabel">Modificar</h4>
                    </div>
                    <div class="modal-body">
                        <div id="datos_ajax_register"></div>
                        <div class="form-row">
                            
                            <div class="form-group col-md-6" >
                                <label for="nombre0" class="control-label">Tipo:</label>
                                <select id="tipoUpdate" class="form-control" style="width : 300px" name="tipoUpdate"> <!--Se produjo un cambio en esta linea-->
                                    <?php foreach ($tipos as $reg) { ?>
                                        <option type="text" value="<?php echo $reg["codigo"]; ?>"><?php echo $reg["descripcion"]; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="nombre0" class="control-label">Fecha:</label>
                                <input type="date" style="width : 300px; heigth : 300px" class="form-control" id="fechaUpdate" name="fechaUpdate" required maxlength="10" value="<?php echo date("Y-m-d"); ?>">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="nombre0" class="control-label">Precio:</label>
                                <input type="text" style="width : 300px; heigth : 300px" class="form-control" id="precioUpdate" name="precioUpdate">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="nombre0" class="control-label">Observaciones:</label>
                                <input type="text" style="width : 300px; heigth : 300px" class="form-control" id="observacionesUpdate" name="observacionesUpdate">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="nombre0" class="control-label">Estado Cobranza:</label>
                                <select id="cobranzaUpdate" style="width : 300px; heigth : 300px" class="form-control" name="cobranzaUpdate">
                                    <?php foreach ($estados as $reg) {
                                        if ($reg["cobranza"] == 0) {
                                            continue;
                                        }
                                    ?>
                                        <option type="text" value="<?php echo $reg["codigo"]; ?>"><?php echo $reg["descripcion"]; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="nombre0" class="control-label">Estado General:</label>
                                <select id="generalUpdate" style="width : 300px; heigth : 300px" class="form-control" name="generalUpdate" <?php if( in_array($_SESSION["cod_rol"], [2])) { echo "disabled"; } ?> >
                                    <?php foreach ($estados as $reg) {
                                        if ($reg["general"] == 0) {
                                            continue;
                                        }
                                    ?>
                                        <option type="text" value="<?php echo $reg["codigo"]; ?>"><?php echo $reg["descripcion"]; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="nombre0" class="control-label">Cliente:</label>
                                <select id="clienteUpdate" style="width : 300px; heigth : 300px" class="form-control" name="clienteUpdate">
                                    <?php foreach ($clientes as $reg) { ?>
                                        <option type="text" value="<?php echo $reg["codigo"]; ?>"><?php echo $reg["descripcion"]; ?></option>
                                    <?php } ?>
                                </select>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="nombre0" class="control-label">Pais:</label>
                                <select id="paisUpdate" class="form-control" style="width : 300px; heigth : 300px" name="paisUpdate">
                                    <?php foreach ($paises as $reg) { ?>
                                        <option type="text" value="<?php echo $reg["codigo"]; ?>"><?php echo $reg["descripcion"]; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="nombre0" class="control-label">Provincia:</label>
                                <select id="provinciaUpdate" class="form-control" style="width : 300px; heigth : 300px" name="provinciaUpdate">
                                    <?php foreach ($provincias as $reg) { ?>
                                        <option type="text" value="<?php echo $reg["codigo"]; ?>"><?php echo $reg["descripcion"]; ?></option>
                                    <?php } ?>
                                </select>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="nombre0" class="control-label">Estado Entrega:</label>
                                <select id="entregaUpdate" style="width : 300px; heigth : 300px" class="form-control" name="entregaUpdate">
                                    <?php foreach ($estados as $reg) {
                                        if ($reg["entrega"] == 0) {
                                            continue;
                                        }
                                    ?>
                                        <option type="text" value="<?php echo $reg["codigo"]; ?>"><?php echo $reg["descripcion"]; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="nombre0" class="control-label">Entrega a Cliente:</label>
                                <input type="date" style="width : 300px; heigth : 300px" class="form-control" id="fechaentregaUpdate" name="fechaentregaUpdate"  maxlength="10" >
                            </div>
                            <div class="form-group col-md-6">
                                <br /><br /><br /><br />
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

<script type="text/javascript" src="inc/js/orden_ventas_js.js?version=<?php echo date("Y-m-d H:i:s"); ?>"></script>
<script type="text/javascript" src="inc/js/utils.js"></script>
<script type="text/javascript" src="inc/js/jquery.table2excel.js"></script>
<script> 
$('.BuscardorD').select2({
        dropdownParent: $('#BuscarCliente2')
    });
</script>