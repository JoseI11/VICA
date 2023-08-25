var requestSent = false;
var codigo;

$(document).ready(function () {
    $("#busqueda-icono").click();
    //$(".navbar-minimalize").click();
    getRegistrosAsociados();
    getRegistrosAsociados2();
    getRegistrosAsociados3();
    getRegistrosAsociados4();
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

$('#deldetalleOt').on('shown.bs.modal', function () {
    $('#btn-eliminar-detalle').focus();
})

$('#delcorreasOt').on('shown.bs.modal', function () {
    $('#btn-eliminar-correas').focus();
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
            funcion: "getRegistrosFiltroSingle",
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

function getRegistrosAsociados() {
    var codigo = $("#loading").attr("codigo");
    var parametros = {
        funcion: "getRegistrosFiltroAsociados",
        codigo: codigo
    }
    $.ajax({
        type: "POST",
        url: 'controller/orden_trabajos.controller.php',
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

function getRegistrosAsociados2() {
    var codigo = $("#loading").attr("codigo");
    var parametros = {
        funcion: "getRegistrosFiltroAsociados2",
        codigo: codigo
    }
    $.ajax({
        type: "POST",
        url: 'controller/orden_trabajos.controller.php',
        data: parametros,
        success: function (datos) {
            $("#tabla_detalle").html(datos);
        },
        error: function () {
            alert("Error");
        },
        complete: function () {
            requestSent = false;
        }
    });
}

function getRegistrosAsociados3() {
    var codigo = $("#loading").attr("codigo");
    var parametros = {
        funcion: "getRegistrosFiltroAsociados3",
        codigo: codigo
    }
    $.ajax({
        type: "POST",
        url: 'controller/orden_trabajos.controller.php',
        data: parametros,
        success: function (datos) {
            $("#tabla_correas").html(datos);
        },
        error: function () {
            alert("Error");
        },
        complete: function () {
            requestSent = false;
        }
    });
}

function getRegistrosAsociados4() {
    var codigo = $("#loading").attr("codigo");
    var parametros = {
        funcion: "getRegistrosFiltroAsociados4",
        codigo: codigo
    }
    $.ajax({
        type: "POST",
        url: 'controller/orden_trabajos.controller.php',
        data: parametros,
        success: function (datos) {
            $("#tabla_transmision").html(datos);
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
        var cot_ot = $("#loading").attr("codigo");
        var ver = $("#loading").attr("ver");
        var parametros = {
            funcion: "updateOrdenTrabajoInsumo",
            codigo: codigo,
            orden_trabajo: cot_ot,
            insumo: $("#insumoUpdate").val(),
            cantidad: $("#cantidadUpdate").val()
        }
        console.log(parametros);
        $.ajax({
            type: "POST",
            url: 'controller/orden_trabajos.controller.php',
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
        var cot_ot = $("#loading").attr("codigo");
        var parametros = {
            funcion: "addOrdenTrabajoInsumo",
            orden_trabajo: cot_ot,
            insumo: $("#insumoAdd").val(),
            cantidad: $("#cantidadAdd").val()
        }
        $.ajax({
            type: "POST",
            url: 'controller/orden_trabajos.controller.php',
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

$("#guardarDetallesOrdenCompra").submit(function (event) {
    if (!requestSent) {
        requestSent = true;
        var cot_ot = $("#loading").attr("codigo");
        var parametros = {
            funcion: "addDetalleOt",
            orden_trabajo: cot_ot,
            empleado: $("#personaAdd").val(),
            detalle: $("#detalleAdd").val()
        }
        $.ajax({
            type: "POST",
            url: 'controller/orden_trabajos.controller.php',
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

$("#guardarCorreasOrdenCompra").submit(function (event) {
    if (!requestSent) {
        requestSent = true;
        var cot_ot = $("#loading").attr("codigo");
        var parametros = {
            funcion: "addCorreasOt",
            orden_trabajo: cot_ot,
            empleado: $("#personacorreaAdd").val(),
            detalle: $("#correasAdd").val()
        }
        $.ajax({
            type: "POST",
            url: 'controller/orden_trabajos.controller.php',
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

$("#guardarTransmisionOrdenCompra").submit(function (event) {
    if (!requestSent) {
        requestSent = true;
        var cot_ot = $("#loading").attr("codigo");
        var parametros = {
            funcion: "addTransmisionOt",
            orden_trabajo: cot_ot,
            empleado: $("#personatransmisionAdd").val(),
            detalle: $("#transmisionAdd").val()
        }
        $.ajax({
            type: "POST",
            url: 'controller/orden_trabajos.controller.php',
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

$("#actualidarDetallesOrdenCompra").submit(function (event) {
    if (!requestSent) {
        requestSent = true;
        var parametros = {
            funcion: "updateDetalleTrabajoInsumo",
            codigo: codigo,
            id_empleado: $("#id_empleado").val(),
            detalle: $("#detalledetalle").val()
        }
       
       // console.log(parametros);
        $.ajax({
            type: "POST",
            url: 'controller/orden_trabajos.controller.php',
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

$("#actualidarCorreasOrdenCompra").submit(function (event) {
    
    if (!requestSent) {
        requestSent = true;
        var parametros = {
            funcion: "updateCorreasTrabajoInsumo",
            codigo: codigo,
            id_empleado: $("#id_empleadocorreas").val(),
            detalle: $("#detallecorreas").val()
        }
        console.log(parametros);
        $.ajax({
            type: "POST",
            url: 'controller/orden_trabajos.controller.php',
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

$("#actualidarTransmisionOrdenCompra").submit(function (event) {
    if (!requestSent) {
        requestSent = true;
        var parametros = {
            funcion: "updateTransmisionTrabajoInsumo",
            codigo: codigo,
            id_empleado: $("#id_empleadotansmision").val(),
            detalle: $("#detalletransmision").val()
        }
        console.log(parametros);
        $.ajax({
            type: "POST",
            url: 'controller/orden_trabajos.controller.php',
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
