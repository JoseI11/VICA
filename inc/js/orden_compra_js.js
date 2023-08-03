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
        var parametros = {
            funcion: "getRegistrosFiltroSingle",
            codigo: codigo
        }
        $.ajax({
            type: "POST",
            url: 'controller/orden_compras.controller.php',
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
        url: 'controller/orden_compras.controller.php',
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
        var orden_compra = $("#loading").attr("codigo");
        var parametros = {
            funcion: "updateOrdenCompraInsumo",
            codigo: codigo,
            orden_compra: orden_compra,
            insumo: $("#insumoUpdate").val(),
            cantidad: $("#cantidadUpdate").val(),
            precio: $("#precioUpdate").val()
        }
        $.ajax({
            type: "POST",
            url: 'controller/orden_compras.controller.php',
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
        var orden_compra = $("#loading").attr("codigo");
        var parametros = {
            funcion: "addOrdenCompraInsumo",
            orden_compra: orden_compra,
            insumo: $("#insumoAdd").val(),
            cantidad: $("#cantidadAdd").val(),
            precio: $("#precioAdd").val()
        }
        $.ajax({
            type: "POST",
            url: 'controller/orden_compras.controller.php',
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

