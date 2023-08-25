var requestSent = false;
var codigo;

$(document).ready(function () {
    $("#busqueda-icono").click();
    //$(".navbar-minimalize").click();
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
        var parametros = {
            funcion: "getRegistrosFiltro",
            orderby: orderby,
            sentido: sentido,
            registros: registros,
            pagina: pagina,
            busqueda: busqueda
        }
        $.ajax({
            type: "POST",
            url: 'controller/orden_trabajos.controller.php',
            data: parametros,
            success: function (datos) {
                $("#paginacion_paginas").html($("#paginas_aux").html());
                $("#div_tabla").attr("pagina", pagina);
                $("#div_tabla").html(datos);
                $("#leyenda_paginacion").html($("#leyenda_paginacion_aux").html());

                var pag = $("#div_tabla").attr("pagina");

                var first = $("#first");
                var before = $("#before");
                var actual = $("#actual");
                var next = $("#next");
                var last = $("#last");

                var cant_reg = $("#tabla").attr("registros");
                var totales = $("#tabla").attr("totales");

                last.attr("ultimo", Math.ceil(totales / cant_reg));

                if (pag == "<<") {
                    pag = 1;
                }

                if (pag == ">>") {
                    pag = parseInt(last.attr("ultimo"));
                }

                $("#div_tabla").attr("pagina", pag);
                //$("#busqueda-icono").click();

                first.css("display", "inline-block");
                before.css("display", "inline-block");
                if (parseInt(pag) == 1) {
                    first.css("display", "none");
                    before.css("display", "none");
                }
                if (parseInt(pag) == 2) {
                    first.css("display", "none");
                    before.css("display", "inline-block");
                }

                first.text("<<");
                before.text(parseInt(pag) - 1);
                actual.text(pag);
                next.text(parseInt(pag) + 1);
                last.text(">>");

                next.css("display", "inline-block");
                last.css("display", "inline-block");
                if (parseInt(pag) == parseInt(last.attr("ultimo"))) {
                    next.css("display", "none");
                    last.css("display", "none");
                }
                if (parseInt(pag) == parseInt(last.attr("ultimo")) - 1) {
                    next.css("display", "inline-block");
                    last.css("display", "none");
                }

                if (parseInt($("#cant_reg").val()) == -1) {
                    first.css("display", "none");
                    before.css("display", "none");
                    next.css("display", "none");
                    last.css("display", "none");
                }

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


$(document).ready(function() {
  $('#productoAdd').change(function() {
    var option = $(this).val();
    var parametros = {
        funcion: "addOrdenTrabajo2",
        option: option
    }
    $.ajax({
      type: 'POST',
      url: 'controller/orden_trabajos.controller.php',
      data: parametros,
      success: function(response) {
        var datos = JSON.parse(response);
        $('#label1').text(datos.observaciones);
        $('#label2').text(datos.observaciones2);
      }
    });
  });
});


$("#guardarDatosOrdenTrabajo").submit(function (event) {
    if (!requestSent) {
        requestSent = true;
        const MixArray =  $("#PersonalOtAdd").val().toString()
        const string = MixArray.toString()
        const ans_array = string.split(',')
        var parametros = {
            funcion: "addOrdenTrabajo",
            producto: $("#productoAdd").val(),
            observaciones: $("#observacionesAdd").val(),
            fecha: $("#fechaAdd").val(),
            cliente: $("#clienteAdd").val(),
            id_cajaquebrado: $("#cajaquedradoAdd").val(),
            id_cajaquebrado2: $("#cajaquedrado2Add").val(),
            id_sinfin: $("#sinfinAdd").val(),
            id_motor: $("#motorAdd").val(),
            personal_ot: JSON.stringify(ans_array)
        }
        $.ajax({
            type: "POST",
            url: 'controller/orden_trabajos.controller.php',
            data: parametros,
            success: function (datos) {                
                if (parseInt(datos) >= 0) {
                    window.location.href = "orden_trabajo.php?codigo="+datos;
                    //location.reload();                    
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

$("#actualizarDatosOrdenTrabajo").submit(function (event) {
    if (!requestSent) {
        requestSent = true;
        var parametros = {
            funcion: "updateOrdenTrabajo",
            codigo: codigo,
            producto: $("#productoUpdate").val(),
            observaciones: $("#observacionesUpdate").val(),
            fecha: $("#fechaUpdate").val(),
            cliente: $("#clienteUpdate").val()
        }
        $.ajax({
            type: "POST",
            url: 'controller/orden_trabajos.controller.php',
            data: parametros,
            success: function (datos) {                
                if (parseInt(datos) >= 0) {
                    // window.location.href = "orden_trabajo.php?codigo="+datos;
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