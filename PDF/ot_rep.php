<!DOCTYPE html>
<?php
	if (isset($_GET["codigo"])){
        $codigo = $_GET["codigo"];            
        include $_SERVER['DOCUMENT_ROOT'] . "/VICA/controller/orden_trabajos.controller.php";
        $controlador = OrdenTrabajosController::singleton_orden_trabajos();
        $maquinas = $controlador->getMaquinas();
        $insumos = $controlador->getInsumos();
        $categorias = $controlador->getCategoriasComponentes();
        $personas = $controlador->getPersonas();
        $unidades = $controlador->getUnidades();
        $proveedores = $controlador->getProveedores();
        $clientes = $controlador->getClientes();
        $orden_trabajo = $controlador->getOrdenTrabajoArray($codigo)[0];
        $orden_venta = $controlador->getOrdenVentaArray($orden_trabajo["cod_orden_venta"])[0];
        $tareas = $controlador->getTareas();
        $tareas_realizadas = $controlador->getTareasRealizadas($codigo);
        $registros = $controlador->getDetallesAsociados($codigo);
        $personas_inv = $controlador->getPersonasOt($codigo);
	}
?>
<html lang="en">
    <head>
        <link href="css/styles.css" rel="stylesheet" />
    </head>

    <style type="text/css">

    table { vertical-align: top; }
    tr    { vertical-align: top; }
    td    { vertical-align: top; }

    .midnight-blue{
        padding: 4px 4px 4px;
        color:black;
        font-weight:bold;
        font-size:12px;
  -webkit-appearance: none;
     -moz-appearance: none;
          appearance: none;
  -webkit-print-color-adjust: exact;
          color-adjust: exact;
          border-color: gray;
  border-width: 1px;
  border-style: solid;
    }

    .silver{
        background:white;
        padding: 3px 4px 3px;
        border: solid 1px #000000;
  -webkit-appearance: none;
     -moz-appearance: none;
          appearance: none;
  -webkit-print-color-adjust: exact;
          color-adjust: exact;
    }

    .clouds{
        background:#ecf0f1;
        padding: 3px 4px 3px;
        border: solid 1px #000000;
  -webkit-appearance: none;
     -moz-appearance: none;
          appearance: none;
  -webkit-print-color-adjust: exact;
          color-adjust: exact;
    }

    .border-top{
        border-top: solid 1px #bdc3c7;
        
    }

    .border-left{
        border-left: solid 1px #bdc3c7;
    }

    .border-right{
        border-right: solid 1px #bdc3c7;
    }

    .border-bottom{
        border-bottom: solid 1px #bdc3c7;
    }

    .recuadro{
        padding: 3px 4px 3px;
        border: solid 1px #000000;
    }

    .izquierda{
        border-right: solid 1px #ffffff;
    }

    .derecho{
        border-right: solid 1px #ffffff;
    }

    .derecho1{
        border-right: solid 2px #000000;
    }

    table.page_footer {width: 100%; border: none; background-color: white; padding: 2mm;border-collapse:collapse; border: none;}
    }

    #tabla3{
    border: 1px solid #80A93E;
    width: 200px;
    }

    .mostaza{
    background-color: #fdd83f;
    font-weight: bold;
    font-size: 8pt;
    padding: 2 2 2 20px;
    height: 20px;
  -webkit-appearance: none;
     -moz-appearance: none;
          appearance: none;
  -webkit-print-color-adjust: exact;
          color-adjust: exact;
    }

    .griso{
    background-color: #606060;
    font-weight: bold;
    font-size: 8pt;
    padding: 2 2 2 20px;
    height: 20px;
    width: 65%;
  -webkit-appearance: none;
     -moz-appearance: none;
          appearance: none;
  -webkit-print-color-adjust: exact;
          color-adjust: exact;
    }

    .grisclaro{
    background-color: #DCDCDC;
    font-weight: bold;
    font-size: 8pt;
    padding: 2 2 2 20px;
  -webkit-appearance: none;
     -moz-appearance: none;
          appearance: none;
  -webkit-print-color-adjust: exact;
          color-adjust: exact;
    }

    .grispie{
    background-color: #EEEEEE;
    font-weight: bold;
    font-size: 8pt;
    padding: 2 2 2 20px;
  -webkit-appearance: none;
     -moz-appearance: none;
          appearance: none;
  -webkit-print-color-adjust: exact;
          color-adjust: exact;
    }

    .musgo{
    background-color: #006F73;
    font-weight: bold;
    font-size: 8pt;
    padding: 0 0 0 0px;
    height: 20px;
  -webkit-appearance: none;
     -moz-appearance: none;
          appearance: none;
  -webkit-print-color-adjust: exact;
          color-adjust: exact;
    }

    .blanco{
    background-color: #FFFFFF;
    font-weight: bold;
    font-size: 8pt;
    padding: 2 2 2 20px;
    height: 20px;
  -webkit-appearance: none;
     -moz-appearance: none;
          appearance: none;
  -webkit-print-color-adjust: exact;
          color-adjust: exact;
    }

    p.round3 {
    border: 10px solid #006F73;
    border-radius: 0 0 0 32px;
    background-color: #006F73;
    padding: 0 0 0 0px;
  -webkit-appearance: none;
     -moz-appearance: none;
          appearance: none;
  -webkit-print-color-adjust: exact;
          color-adjust: exact;
    }

    p.recto {
    border: 5px solid #006F73;
    background-color: #006F73;
    padding: 0 0 0 0px;
  -webkit-appearance: none;
     -moz-appearance: none;
          appearance: none;
  -webkit-print-color-adjust: exact;
          color-adjust: exact;
    }

    </style>
    <body id="page-top">
        <page backtop="15mm" backbottom="15mm" backleft="15mm" backright="15mm" style="font-size: 12pt; font-family: arial" >
        
            <div style="text-align: center; margin-top: -100px; margin-bottom: -100px;">
                <h1 class="logo-name">
                    <?php $imagen = "../imagenes/loguito.png"; ?>
                    <img width="300px" src="<?php echo $imagen; ?>" >
                </h1>
            </div>

            <legend style="text-align: center;">Orden de Trabajo Reparacion</legend>
            
            <table cellspacing="0" style="width: 100%; text-align: left; font-size: 10pt;">
                <tr>
                    <th style="width: 10%;text-align:right;" class='midnight-blue'>#</th>
                    <th style="width: 10%;text-align:left;" class='midnight-blue'><?php echo $codigo; ?></th>
                    <th style="width: 80%;text-align:left;" class='midnight-blue'>
                        <?php 
                            foreach($maquinas as $m){
                                if ($m["codigo"] == $orden_trabajo["cod_maquina"]){
                                    echo $m["descripcion"]; 
                                }
                            }
                            foreach($insumos as $m){
                                if ($m["codigo"] == $orden_trabajo["cod_componente"]){
                                    echo $m["descripcion"]; 
                                }
                            }
                        ?>
                    </th>
                </tr>
            </table>

            <br />

            <table cellspacing="0" style="width: 100%; text-align: left; font-size: 10pt;">
                <tr>
                    <th style="width: 20%;text-align:right;" class='midnight-blue'>OV#:</th>
                    <th style="width: 80%;text-align:left;" class='midnight-blue'><?php echo $orden_venta["codigo"]; ?></th>
                </tr>
                <tr>
                    <th style="width: 20%;text-align:right;" class='midnight-blue'>Descripcion:</th>
                    <th style="width: 80%;text-align:left;" class='midnight-blue'><?php echo $orden_venta["observaciones"]; ?></th>
                </tr>
                <tr>
                    <th style="width: 20%;text-align:right;" class='midnight-blue'>Cliente:</th>
                    <th style="width: 80%;text-align:left;" class='midnight-blue'>
                        <?php 
                            foreach($clientes as $m){
                                if ($m["codigo"] == $orden_venta["cod_cliente"]){
                                    echo $m["descripcion"]; 
                                }
                            }
                        ?>
                    </th>
                </tr>
                <tr>
                    <th style="width: 20%;text-align:right;" class='midnight-blue'>Fecha Recepcion:</th>
                    <th style="width: 80%;text-align:left;" class='midnight-blue'><?php echo $orden_trabajo["fecha_recepcion"]; ?></th>
                </tr>
                <tr>
                    <th style="width: 20%;text-align:right;" class='midnight-blue'>Fecha Entrega Cliente:</th>
                    <th style="width: 80%;text-align:left;" class='midnight-blue'><?php echo $orden_venta["fecha_entrega_maquina"]; ?></th>
                </tr>
            </table>

            <br />
        
            <table cellspacing="0" style="width: 100%; text-align: left; font-size: 10pt;">
                <tr>
                    <th style="width: 50%;text-align:left;" class='midnight-blue'>Tarea</th>
                    <th style="width: 40%;text-align:center;" class='midnight-blue'>Comentario</th>
                    <th style="width: 10%;text-align:center;" class='midnight-blue'></th>
                </tr>
                <?php foreach ($tareas as $usu) { ?>
                    <tr class="row" codigo="<?php echo $usu["codigo"]; ?>">
                        <td class="text-left" style="vertical-align: middle;">
                            <?php echo $usu["nombre"]; ?>
                        </td>
                        <?php
                            $observaciones = "";
                            $valor = "";
                            foreach($tareas_realizadas as $tr){
                                if ($tr["cod_orden_trabajo_categoria"] == $usu["codigo"]){
                                    $observaciones = $tr["observaciones"];
                                    $valor = $tr["valor"];
                                }
                            }
                        ?>
                        <td class="text-left" style="vertical-align: middle;"><?php echo $observaciones; ?></td>
                        <td class="text-center" style="vertical-align: middle;"><?php echo $valor; ?></td>
                    </tr>
                <?php } ?>            
            </table>
            
            <table cellspacing="0" style="width: 100%; text-align: left; font-size: 10pt;">
                <tr>
                    <th style="width: 20%;text-align:right;" class='midnight-blue'>Comentarios:</th>
                    <th style="width: 80%;text-align:left;" class='midnight-blue'><?php echo $orden_trabajo["observaciones"]; ?></th>
                </tr>          
            </table>

            <br />
            
            <div style="width: 90%; margin-left: 5%; border: 3px solid #A00; text-align: center; padding: 10px;">
                CUALQUIER OTRO CAMBIO, QUE A CRITERIO DEL MECANICO CORRESPONDIESE REALIZAR, CONSULTAR CON GERENCIA
            </div>

        </page>

        <script type="text/javascript"> window.print(); </script>

    </body>
</html>