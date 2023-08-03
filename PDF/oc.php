<!DOCTYPE html>
<?php
	if (isset($_GET["codigo"])){
        $codigo = $_GET["codigo"];            
        include $_SERVER['DOCUMENT_ROOT'] . "/VICA/controller/orden_compras.controller.php";
        $controlador = OrdenComprasController::singleton_orden_compras();
        $insumos = $controlador->getInsumos();
        $orden_compra = $controlador->getOrdenCompraArray($codigo)[0];
        $unidades = $controlador->getUnidades();
        $proveedores = $controlador->getProveedores();
        foreach($proveedores as $p){
            if ($p["codigo"] == $orden_compra["cod_proveedor"]){
                $proveedor = $p["descripcion"];
            }
        }
        $registros = $controlador->getDetallesAsociados($codigo);
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
        
                <div style="text-align: center;">
                    <h1 class="logo-name">
                        <?php $imagen = "../imagenes/loguito.png"; ?>
                        <img width="300px" src="<?php echo $imagen; ?>" >
                    </h1>
                </div>

            <legend style="text-align: center;">Orden de Compra</legend>
            
            <br />
        
            <table cellspacing="0" style="width: 100%; text-align: left; font-size: 10pt;">
                <tr>
                    <th style="width: 10%;text-align:right;" class='midnight-blue'>#</th>
                    <th style="width: 10%;text-align:left;" class='midnight-blue'><?php echo $codigo; ?></th>
                    <th style="width: 15%;text-align:right;" class='midnight-blue'>Proveedor:</th>
                    <th style="width: 65%;text-align:left;" class='midnight-blue'><?php echo $proveedor; ?></th>
                </tr>
            </table>

            <br />

            <table cellspacing="0" style="width: 100%; text-align: left; font-size: 10pt;">
                <tr>
                    <th style="width: 20%;text-align:right;" class='midnight-blue'>Remito:</th>
                    <th style="width: 80%;text-align:left;" class='midnight-blue'><?php echo $orden_compra["remito"]; ?></th>
                </tr>
                <tr>
                    <th style="width: 20%;text-align:right;" class='midnight-blue'>Descripcion:</th>
                    <th style="width: 80%;text-align:left;" class='midnight-blue'><?php echo $orden_compra["observaciones"]; ?></th>
                </tr>
                <tr>
                    <th style="width: 20%;text-align:right;" class='midnight-blue'>Fecha OC:</th>
                    <th style="width: 80%;text-align:left;" class='midnight-blue'><?php echo $orden_compra["fecha"]; ?></th>
                </tr>
                <tr>
                    <th style="width: 20%;text-align:right;" class='midnight-blue'>Fecha Estimada de Recepcion:</th>
                    <th style="width: 80%;text-align:left;" class='midnight-blue'><?php echo $orden_compra["fecha_estimada_recepcion"]; ?></th>
                </tr>
                <tr>
                    <th style="width: 20%;text-align:right;" class='midnight-blue'>Fecha de Recepcion:</th>
                    <th style="width: 80%;text-align:left;" class='midnight-blue'><?php echo $orden_compra["fecha_recepcion"]; ?></th>
                </tr>
            </table>

            <br />
        
            <table cellspacing="0" style="width: 100%; text-align: left; font-size: 10pt;">
                <tr>
                    <th style="width: 60%;text-align:left;" class='midnight-blue'>Insumo</th>
                    <th style="width: 10%;text-align:center;" class='midnight-blue'>Cantidad</th>
                    <th style="width: 10%;text-align:center;" class='midnight-blue'>Precio</th>
                    <th style="width: 10%;text-align:center;" class='midnight-blue'>Subtotal</th>
                    <th style="width: 10%;text-align:center;" class='midnight-blue'>Recibido</th>
                </tr>
                <?php foreach ($registros as $usu) {    ?>
                    <tr style="height: 27px;">
                        <td style="width: 60%; text-align: left;">
                            <?php echo $usu["insumo"]; ?>
                            <?php echo $usu["es_usado"] == 1 ? " (USADO)" :  " (NUEVO)"; ?>
                        </td>
                        <td style="width: 10%; text-align: right;"><?php echo $usu["cantidad"]; ?></td>
                        <td style="width: 10%; text-align: right;"><?php echo $usu["precio"]; ?></td>
                        <td style="width: 10%; text-align: right;"><?php echo $usu["cantidad"] * $usu["precio"]; ?></td>
                        <td style="width: 10%; text-align: right;"><?php echo $usu["cantidad_recibida"]; ?></td>
                    </tr>
                <?php }?>            
            </table>
            
            <br />

            <legend style="text-align: center; font-size: 12px;">USO EXCLUSIVO POR VICA - PROHIBIDA SU REPRODUCCION SIN AUTORIZACION</legend>
            
        </page>

        <script type="text/javascript"> window.print(); </script>

    </body>
</html>