var requestSent = false;
var codigo;

$(document).ready(function () {
    $("#busqueda-icono").click();
    //$(".navbar-minimalize").click();
    getRegistrosAsociados();
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
            funcion: "getRegistrosFiltroSinglePagos",
            codigo: codigo,
            ver: ver
        }
        $.ajax({
            type: "POST",
            url: 'controller/orden_ventas.controller.php',
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

function getRegistrosAsociados() {
    var codigo = $("#loading").attr("codigo");
    var parametros = {
        funcion: "getRegistrosFiltroAsociados",
        codigo: codigo
    }
    $.ajax({
        type: "POST",
        url: 'controller/orden_ventas.controller.php',
        data: parametros,
        success: function (datos) {
            $("#tabla_asociada").html(datos);
        },
        error: function () {
            alert("Error");
        },
        complete: function () {
            requestSent = false;
        }
    });
}

$("#actualidarDatosOrdenCompra").submit(function (event) {
    if (!requestSent) {
        requestSent = true;
        var cod_ov = $("#loading").attr("codigo");
        var ver = $("#loading").attr("ver");
        var parametros = {
            funcion: "updateOrdenVentaPago",
            codigo: codigo,
            orden_venta: cod_ov,
            fecha: $("#fechaUpdate").val(),
            forma: $("#formaUpdate").val(),
            importe: $("#importeUpdate").val(),
            observaciones: $("#observacionesUpdate").val()
        }
        console.log(parametros);
        $.ajax({
            type: "POST",
            url: 'controller/orden_ventas.controller.php',
            data: parametros,
            success: function (datos) {
                if (parseInt(datos) == 0) {
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

$("#guardarDatosOrdenCompra").submit(function (event) {
    if (!requestSent) {
        requestSent = true;
        var cod_ov = $("#loading").attr("codigo");
        var parametros = {
            funcion: "addOrdenVentaPago",
            orden_venta: cod_ov,
            fecha: $("#fechaAdd").val(),
            forma: $("#formaAdd").val(),
            importe: $("#importeAdd").val(),
            observaciones: $("#observacionesAdd").val()
        }
        $.ajax({
            type: "POST",
            url: 'controller/orden_ventas.controller.php',
            data: parametros,
            success: function (datos) {
                if (parseInt(datos) == 0) {
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

