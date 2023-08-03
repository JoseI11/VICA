<?php
session_start();

include $_SERVER['DOCUMENT_ROOT']."/VICA/controller/orden_trabajos.controller.php";
$controlador = OrdenTrabajosController::singleton_orden_trabajos();
$ventas_pendientes = $controlador->getVentasPendientesInicio();

$_SESSION['menu'] = "inicio.php";

$_SESSION['breadcrumb'] = "Inicio";

$titlepage = "VICA - Inicio";

include 'inc/html/encabezado.php';
?>


<link href="inspinia/css/plugins/fullcalendar/fullcalendar.css" rel="stylesheet">
<link href="inspinia/css/plugins/fullcalendar/fullcalendar.print.css" rel='stylesheet' media='print'>

<div class="col-lg-12">
    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <h5>Calendario </h5>
        </div>
        <div class="ibox-content">
            <div id="calendar"></div>
        </div>
    </div>
</div>

<?php
include 'inc/html/footer.php';
?>

<script type="text/javascript" src="inc/js/utils.js"></script>
<script type="text/javascript" src="inc/js/jquery.table2excel.js"></script>

<!-- Mainly scripts -->
<script src="inspinia/js/plugins/fullcalendar/moment.min.js"></script>


<!-- Full Calendar -->
<script src="inspinia/js/plugins/fullcalendar/fullcalendar.min.js"></script>


<script>

    $(document).ready(function() {

        /* initialize the calendar
         -----------------------------------------------------------------*/
        var date = new Date();
        var d = date.getDate();
        var m = date.getMonth();
        var y = date.getFullYear();

        $('#calendar').fullCalendar({
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,agendaWeek,agendaDay'
            },
            editable: true,
            droppable: true, // this allows things to be dropped onto the calendar
            drop: function() {
                // is the "remove after drop" checkbox checked?
                if ($('#drop-remove').is(':checked')) {
                    // if so, remove the element from the "Draggable Events" list
                    $(this).remove();
                }
            },
            events: [
                <?php
                    foreach($ventas_pendientes as $vp){
                        $titulo = "OV #".$vp["codigo"]." \\n ";
                        $titulo .= $vp["componente"] ? $vp["componente"] : $vp["maquina"];
                        echo "{
                            title: '".$titulo."',
                            start: new Date(".intval(date("Y", strtotime($vp["fecha_entrega_maquina"]))).", ".intval(date("m", strtotime($vp["fecha_entrega_maquina"]))-1).", ".intval(date("d", strtotime($vp["fecha_entrega_maquina"])))."),
                            url: 'orden_venta.php?ver=1&codigo=".$vp["codigo"]."'
                        },";
                    }
                ?>
            ]
        });


    });

</script>