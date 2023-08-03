<?php

session_start();

if (!isset($_SESSION["usuario"])) {
    header("Location: login.php");
}

include $_SERVER['DOCUMENT_ROOT'] . "/VICA/controller/ajustes.controller.php";
$controlador    = AjustesController::singleton_ajustes();

$empresas       = $controlador->getEmpresas();

$_SESSION['menu'] = "ajustes.php";

$_SESSION['breadcrumb'] = "Ajuste de Precios";

$titlepage = "Ajuste de Precios";

include 'inc/html/encabezado.php';

include 'inc/html/menu.php';

include 'inc/html/breadcrumb.php';
?>

<style>
    label {
        font-size: 11px;
    }
</style>

<div class="container" style="width: 96%; margin-left: 2%;">

    <div id="loading" class="loading" tipo="<?php echo $_GET["tipo"]; ?>" valor="<?php echo $_GET["valor"]; ?>"></div>

    <div id="modulo_paginacion" style="display: none;">
        <?php include 'inc/html/paginacion.php'; ?>
    </div>

    <div id="div_tabla" class="row col-lg-12" style="float: none" registros="<?php echo $_SESSION['cant_reg']; ?>" pagina="<?php echo $_SESSION['pagina']; ?>" orderby="<?php echo $_SESSION['orderby']; ?>" sentido="<?php echo $_SESSION['sentido']; ?>">
        <!-- Devolución Ajax -->
    </div>

</div>

<?php

include 'inc/html/footer.php';

?>

<script type="text/javascript" src="inc/js/ajustes_js.js?version=<?php echo date("Y-m-d H:i:s"); ?>"></script>
<script type="text/javascript" src="inc/js/utils.js"></script>
<script type="text/javascript" src="inc/js/jquery.table2excel.js"></script>