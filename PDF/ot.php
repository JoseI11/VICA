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
        $registros = $controlador->getDetallesAsociados($codigo);
        $personas_inv = $controlador->getPersonasOt($codigo);
        $ot_detalles = $controlador->getDetalleTrabajoPdf($codigo);
        $ot_poleas = $controlador->getPoleaTrabajoPdf($codigo);
        $ot_transmision = $controlador->getTransmisionTrabajoPdf($codigo);

	}
?>
<html lang="en">
    <head>
       
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

    table.page_footer {
        width: 100%; 
        border: none; 
        background-color: white; 
        padding: 2mm;
        border-collapse:collapse; border: none;
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
        
                <div style="text-align: right;" >
                   
                        <?php $imagen = "../imagenes/loguito_pdf.png"; ?>
                        <img width="9%" src="<?php echo $imagen; ?>" >
                    
                </div>

            <legend style="text-align: center;">Orden de Trabajo</legend>
            
            <br />
        
            <table cellspacing="0" style="width: 100%; text-align: left; font-size: 10pt;">
                <tr>
                    <th style="width: 20%;text-align:right;" class='midnight-blue'>OT#: <?php echo $codigo; ?></th>
                    <th style="width: 80%;text-align:left;" class='midnight-blue'>
                        <?php 
                            foreach($maquinas as $m){
                                if ($m["codigo"] == $orden_trabajo["cod_maquina"]){
                                    echo $m["descripcion"] . ' (' . $m["descrip_abrev"] . ')'; 
                                }
                            }
                            foreach($insumos as $m){
                                if ($m["codigo"] == $orden_trabajo["cod_componente"]){
                                    echo $m["dimension"] . ' (' . $m["codigo_mp"] . ')'; 
                                }
                            }
                        ?>
                    </th>
                    <?php if (!$orden_venta["codigo"]) { ?>
                        <tr>
                        <th style="width: 20%;text-align:right;" class='midnight-blue'>Descripcion:</th>
                        <th style="width: 80%;text-align:left;" class='midnight-blue'><?php echo $orden_trabajo["observaciones"]; ?></th>
                        </tr>
                    <?php } ?>

                </tr>
            </table>

            <?php if ($orden_venta["codigo"]) { ?>
                <br />

                <table cellspacing="0" style="width: 100%; text-align: left; font-size: 10pt;">
                    <tr>
                        <th style="width: 20%;text-align:right;" class='midnight-blue'>OV#: <?php echo $orden_venta["codigo"]; ?></th>
                        <th style="width: 80%;text-align:left;" class='midnight-blue'>Cliente: <?php 
                                foreach($clientes as $m){
                                    if ($m["codigo"] == $orden_venta["cod_cliente"]){
                                        echo $m["descripcion"]; 
                                    }
                                }
                            ?></th>
                    </tr>
                    <tr>
                        <th style="width: 20%;text-align:right;" class='midnight-blue'>Descripcion:</th>
                        <th style="width: 80%;text-align:left;" class='midnight-blue'><?php echo $orden_trabajo["observaciones"]; ?></th>
                    </tr>
                    <tr>
                    <th style="width: 20%;text-align:right;" class='midnight-blue'>Personal Encargado:</th>
                    <th style="width: 80%;text-align:left;" class='midnight-blue'>
                        <?php 
                            $personal = "";
                            foreach ($personas as $reg) {
                                if (strpos($orden_trabajo["personal_ot"], '"'.$reg["codigo"].'"') !== false) {
                                    $personal = $personal .$reg["descripcion"] . ", ";
                                }
                            }
                            echo substr($personal, 0, -2);
                        ?>
                    </th>
                </tr>
                </table>
            <?php } ?>

            <?php if ($orden_trabajo["codigo_cajaquebrado"]) { ?>
                <br />
                <legend>Caja de Quebrado 1</legend>
                <table cellspacing="0" style="width: 100%; text-align: left; font-size: 10pt;">
                    <tr>
                        <th style="width: 20%;text-align:right;" class='midnight-blue'>Codigo: </th>
                        <th style="width: 50%;text-align:left;" class='midnight-blue'><?php echo $orden_trabajo["codigo_cajaquebrado"]; ?></th>
                        <th style="width: 15%;text-align:right;" class='midnight-blue'>N° Seguimiento: </th>
                        <th style="width: 15%;text-align:left;" class='midnight-blue'><?php echo $orden_trabajo["cajaquebrado_seguimiento"]; ?></th>
                    </tr>
                    <tr>
                        <th style="width: 20%;text-align:right;" class='midnight-blue'>Descripción: </th>
                        <th style="width: 50%;text-align:left;" class='midnight-blue'><?php echo $orden_trabajo["dimension_cajaquebrado"]; ?></th>
                        <th style="width: 15%;text-align:right;" class='midnight-blue'>Personal: </th>
                        <th style="width: 15%;text-align:left;" class='midnight-blue'><?php echo $orden_trabajo["empleado_cajaquebrado"]; ?></th>
                    </tr>
                    <tr>
                        <th style="width: 20%;text-align:right;" class='midnight-blue'>Observaciones: </th>
                        <th colspan="3" style="width: 50%;text-align:left;" class='midnight-blue'><?php echo $orden_trabajo["cajaquebrado_detalle"]; ?></th>
                    </tr>
         
                </table>

            <?php } ?>

            <?php if ($orden_trabajo["codigo_cajaquebrado2"]) { ?>
                <br />
                <legend>Caja de Quebrado 2</legend>
                <table cellspacing="0" style="width: 100%; text-align: left; font-size: 10pt;">
                    <tr>
                        <th style="width: 20%;text-align:right;" class='midnight-blue'>Codigo: </th>
                        <th style="width: 50%;text-align:left;" class='midnight-blue'><?php echo $orden_trabajo["codigo_cajaquebrado2"]; ?></th>
                        <th style="width: 15%;text-align:right;" class='midnight-blue'>N° Seguimiento: </th>
                        <th style="width: 15%;text-align:left;" class='midnight-blue'><?php echo $orden_trabajo["cajaquebrado_seguimiento2"]; ?></th>
                    </tr>
                    <tr>
                        <th style="width: 20%;text-align:right;" class='midnight-blue'>Descripción: </th>
                        <th style="width: 50%;text-align:left;" class='midnight-blue'><?php echo $orden_trabajo["dimension_cajaquebrado2"]; ?></th>
                        <th style="width: 15%;text-align:right;" class='midnight-blue'>Personal: </th>
                        <th style="width: 15%;text-align:left;" class='midnight-blue'><?php echo $orden_trabajo["empleado_cajaquebrado2"]; ?></th>
                    </tr>
                    <tr>
                        <th style="width: 20%;text-align:right;" class='midnight-blue'>Observaciones: </th>
                        <th colspan="3" style="width: 50%;text-align:left;" class='midnight-blue'><?php echo $orden_trabajo["cajaquebrado_detalle2"]; ?></th>
                    </tr>
         
                </table>

            <?php } ?>

            <?php if ($orden_trabajo["codigo_sinfin"]) { ?>
                <br />
                <legend>Sin Fin</legend>
                <table cellspacing="0" style="width: 100%; text-align: left; font-size: 10pt;">
                    <tr>
                        <th style="width: 20%;text-align:right;" class='midnight-blue'>Codigo: </th>
                        <th style="width: 50%;text-align:left;" class='midnight-blue'><?php echo $orden_trabajo["codigo_sinfin"]; ?></th>
                        <th style="width: 15%;text-align:right;" class='midnight-blue'>N° Seguimiento: </th>
                        <th style="width: 15%;text-align:left;" class='midnight-blue'><?php echo $orden_trabajo["sinfin_seguimiento"]; ?></th>
                    </tr>
                    <tr>
                        <th style="width: 20%;text-align:right;" class='midnight-blue'>Descripción: </th>
                        <th style="width: 50%;text-align:left;" class='midnight-blue'><?php echo $orden_trabajo["dimension_sinfin"]; ?></th>
                        <th style="width: 15%;text-align:right;" class='midnight-blue'>Personal: </th>
                        <th style="width: 15%;text-align:left;" class='midnight-blue'><?php echo $orden_trabajo["empleado_sinfin"]; ?></th>
                    </tr>
                    <tr>
                        <th style="width: 20%;text-align:right;" class='midnight-blue'>Observaciones: </th>
                        <th colspan="3" style="width: 50%;text-align:left;" class='midnight-blue'><?php echo $orden_trabajo["sinfin_detalle"]; ?></th>
                    </tr>
         
                </table>

            <?php } ?>

          
            <?php if (count($ot_detalles)) { ?>
                <br />
                <legend>Detalles:</legend>
                <table cellspacing="0" style="width: 100%; text-align: left; font-size: 10pt;"> 
                    <thead>
                        <tr >
                        <th style="width: 80%;text-align:left;" class='midnight-blue'>Detalle: </th>
                        <th style="width: 20%;text-align:right;" class='midnight-blue'>Personal: </th>
                        </tr>
                    </thead>
                    <tbody id="body">
                        <?php foreach ($ot_detalles as $usu) { ?>
                            <tr>
                                <th style="width: 80%;text-align:left;" class='midnight-blue'><?php echo $usu["detalle"]; ?></th>
                                <th style="width: 20%;text-align:right;" class='midnight-blue'><?php echo $usu["empleado"]; ?></th>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            <?php } ?>

            <?php if (count($ot_poleas)) { ?>
                <br />
                <legend>Poleas/ Correas:</legend>
                <table cellspacing="0" style="width: 100%; text-align: left; font-size: 10pt;"> 
                    <thead>
                        <tr >
                        <th style="width: 75%;text-align:left;" class='midnight-blue'>Detalle: </th>
                        <th style="width: 25%;text-align:right;" class='midnight-blue'>Personal: </th>
                        </tr>
                    </thead>
                    <tbody id="body">
                        <?php foreach ($ot_poleas as $usu) { ?>
                            <tr>
                                <th style="width: 75%;text-align:left;" class='midnight-blue'><?php echo $usu["detalle"]; ?></th>
                                <th style="width: 25%;text-align:right;" class='midnight-blue'><?php echo $usu["empleado"]; ?></th>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            <?php } ?>

            <?php if (count($ot_transmision)) { ?>
                <br />
                <legend>Transmisión/ Electricidad:</legend>
                <table cellspacing="0" style="width: 100%; text-align: left; font-size: 10pt;"> 
                    <thead>
                        <tr >
                        <th style="width: 75%;text-align:left;" class='midnight-blue'>Detalle: </th>
                        <th style="width: 25%;text-align:right;" class='midnight-blue'>Personal: </th>
                        </tr>
                    </thead>
                    <tbody id="body">
                        <?php foreach ($ot_transmision as $usu) { ?>
                            <tr>
                                <th style="width: 75%;text-align:left;" class='midnight-blue'><?php echo $usu["detalle"]; ?></th>
                                <th style="width: 25%;text-align:right;" class='midnight-blue'><?php echo $usu["empleado"]; ?></th>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            <?php } ?>

           
            
       
           
            
            <br />

            <table cellspacing="0" style="width: 100%; text-align: left; font-size: 10pt;">
                <tr>
                    <th style="width: 25%;text-align:right;" class='midnight-blue'>Fecha Pintura y Armado:</th>
                    <th style="width: 75%;text-align:left;" class='midnight-blue'><?php echo date_format(date_create($orden_trabajo["fecha_pintura"]),"d-m-Y"); ?></th>
                </tr>
                <tr>
                    <th style="width: 25%;text-align:right;" class='midnight-blue'>Obs. Pintura y Armado:</th>
                    <th style="width: 75%;text-align:left;" class='midnight-blue'><?php echo $orden_trabajo["observaciones_pintura"]; ?></th>
                </tr>
                <tr>
                    <th style="width: 25%;text-align:right;" class='midnight-blue'>Personal Pintura y Armado:</th>
                    <th style="width: 75%;text-align:left;" class='midnight-blue'>
                        <?php 
                            $personal = "";
                            foreach ($personas as $reg) {
                                if (strpos($orden_trabajo["personal_pintura"], '"'.$reg["codigo"].'"') !== false) {
                                    $personal = $personal .$reg["descripcion"] . ", ";
                                }
                            }
                            echo substr($personal, 0, -2);
                        ?>
                    </th>
                </tr>
                <tr>
                    <th style="width: 25%;text-align:right;" class='midnight-blue'>Fecha Entrega Cliente:</th>
                    <th style="width: 75%;text-align:left;" class='midnight-blue'><?php echo date_format(date_create($orden_venta["fecha_estimada_entrega"]),"d-m-Y"); ?></th>
                </tr>
            </table>

            <br />

            <legend style="text-align: center; font-size: 12px;">USO EXCLUSIVO POR VICA - PROHIBIDA SU REPRODUCCION SIN AUTORIZACION</legend>
            
        </page>

        <script type="text/javascript"> window.print(); </script>

    </body>
</html>