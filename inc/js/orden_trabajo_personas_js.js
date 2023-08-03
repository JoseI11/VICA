var requestSent = false;
var codigo;
var cod_ov;

$(document).ready(function () {
    $("#busqueda-icono").click();
    //$(".navbar-minimalize").click();
    //getRegistrosAsociados();
});

$(document).on({
    ajaxStart: function () {
        $("#loading").css("display", "block");
    },
    ajaxStop: function () {
        $("#loading").css("display", "none");
    }
});

$('#myModal').on('shown.bs.modal', function () {
    $('#btn-eliminar').focus();
})

$('#dataUpdate').on('shown.bs.modal', function () {
    $('#descripcionUpdate').focus();
});

$("#add").click(function () {
    $('#dataRegister').modal('show');
});

$('#dataRegister').on('shown.bs.modal', function () {
    $('#descripcionAdd').focus();
});

function getRegistros(orderby, sentido, registros, pagina, busqueda, objeto) {
    if (!requestSent) {
        requestSent = true;
        var codigo = $("#loading").attr("codigo");
        var ver = $("#loading").attr("ver");
        var parametros = {
            funcion: "getRegistrosFiltroPersonas",
            codigo: codigo,
            ver: ver
        }
        $.ajax({
            type: "POST",
            url: 'controller/orden_trabajos.controller.php',
            data: parametros,
            success: function (datos) {
                $("#div_tabla").html(datos);
            },
            error: function () {
                alert("Error");
            },
            complete: function () {
                requestSent = false;
            }
        });
    }
}

$("#actualizarDatosOrdenTrabajo").submit(function (event) {
    if (!requestSent) {
        requestSent = true;
        var parametros = {
            funcion: "updateOrdenTrabajoPersona",
            codigo: codigo,
            categoria: $("#categoriaUpdate").val(),
            empleado: $("#empleadoUpdate").val()
        }
        $.ajax({
            type: "POST",
            url: 'controller/orden_trabajos.controller.php',
            data: parametros,
            success: function (datos) {                
                if (parseInt(datos) >= 0) {
                    //window.location.href = "orden_trabajo.php?codigo="+datos;
                    location.reload();                    
                } else {
                    alert("Error: " + datos);
                }
            },
            error: function () {
                alert("Error");
            }
        });
        event.preventDefault();
    }
});

$("#guardarDatosOrdenTrabajo").submit(function (event) {
    if (!requestSent) {
        requestSent = true;
        var parametros = {
            funcion: "addOrdenTrabajoPersona",
            codigo: codigo,
            cod_ot: $("#loading").attr("codigo"),
            categoria: $("#categoriaAdd").val(),
            empleado: $("#empleadoAdd").val()
        }
        $.ajax({
            type: "POST",
            url: 'controller/orden_trabajos.controller.php',
            data: parametros,
            success: function (datos) {                
                if (parseInt(datos) >= 0) {
                    //window.location.href = "orden_trabajo.php?codigo="+datos;
                    location.reload();                    
                } else {
                    alert("Error: " + datos);
                }
            },
            error: function () {
                alert("Error");
            }
        });
        event.preventDefault();
    }
});