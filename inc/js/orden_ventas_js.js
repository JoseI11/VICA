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

$('#dataUpdate').on('hidden.bs.modal', function () {
    location.reload();
});

$("#add").click(function () {
    $("#tipoproductoVenta").val(-1);
    $("#tipousoVenta").val(-1);
    $("#productoAdd").val(0);
    $('#dataRegister').modal('show');
});

$('#dataRegister').on('shown.bs.modal', function () {
    $('#descripcionAdd').focus();
});
$("#productoAdd").change(function () {
    $("#busqueda-icono").click();
    /*var producto=$(this).val();
    $("#productoAdd").val(producto);*/
    // $("#busqueda-icono").click();

   /* var producto=$(this).val();
    var texto = $(this).find('option:selected').text(); // Capturamos el texto del option 
    alert(texto);
    $("#productoAdd").val(producto);*/
});
$("#tipousoVenta").change(function(){
    $(".tipo_de_insumo").css("display","none");
    var estado= $(this).val();
    var tipo=$("#tipoproductoVenta").val();
    $("#tipousoVenta").val(estado);
    $(".tipo_de_insumo[tipo="+tipo+"][estado="+estado+"]").css("display","block");
    $("#productoAdd").val(0);
   // $("#busqueda-icono").click();

});
$("#tipousoVentaUpdate").change(function(){
    $(".tipo_de_insumo").css("display","none");
    var estado= $(this).val();
    var tipo=$("#tipoproductoVentaUpdate").val();
    $("#tipousoVentaUpdate").val(estado);
    $(".tipo_de_insumo[tipo="+tipo+"][estado="+estado+"]").css("display","block");
    $("#productoUpdate").val(0);
   // $("#busqueda-icono").click();

});

$("#tipoAdd").change(function () {
    var tipo= $(this).val();
    $(".tipo_prod_v").css("display","none");
    if (tipo == 3){
        $(".tipo_prod_v[tipo_prod_v=1]").css("display","block");
    } else {
        $(".tipo_prod_v").css("display","block");
    }
    $("#tipoproductoVenta").val(-1);
    $("#tipousoVenta").val(-1);
    $("#productoAdd").val(0);
});

$("#tipoproductoVenta").change(function(){

    $(".tipo_de_insumo").css("display","none");
    var tipo= $(this).val();
    var estado=$("#tipousoVenta").val();
    $("#tipoproductoVenta").val(tipo);
    $(".tipo_de_insumo[tipo="+tipo+"][estado="+estado+"]").css("display","block");
    $("#tipousoVenta").val(-1);
    $("#productoAdd").val(0);
    //$("#busqueda-icono").click();   

});
$("#tipoproductoVentaUpdate").change(function(){
    $(".tipo_de_insumo").css("display","none");
    var tipo= $(this).val();
    var estado=$("#tipousoVenta").val();
    $("#tipoproductoVentaUpdate").val(tipo);
    $(".tipo_de_insumo[tipo="+tipo+"][estado="+estado+"]").css("display","block");
    $("#productoUpdate").val(0);
    //$("#busqueda-icono").click();   
});

$("#productoUpdate").change(function () {
    /*   var producto=$(this).val();
    $("#productoUpdate").val(producto);*/
    $("#busqueda-icono").click();
    
 
  
});
$("#tipousoVentaUpdate").change(function(){
    $(".tipo_de_insumo").css("display","none");
    var estado= $(this).val();
    var tipo=$("#tipoproductoVentaUpdate").val();
    $("#tipousoVentaUpdate").val(estado);
    $(".tipo_de_insumo[tipo="+tipo+"][estado="+estado+"]").css("display","block");
    $("#productoUpdate").val(0);
   // $("#busqueda-icono").click();

});
$("#tipoproductoVenta").change(function(){

    $(".tipo_de_insumo").css("display","none");
    var tipo= $(this).val();
    var estado=$("#tipousoVentaUpdate").val();
    $("#tipoproductoVentaUpdate").val(tipo);
    $(".tipo_de_insumo[tipo="+tipo+"][estado="+estado+"]").css("display","block");
    $("#productoUpdate").val(0);
    //$("#busqueda-icono").click();   
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
            url: 'controller/orden_ventas.controller.php',
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

$("#guardarDatosOrdenVenta").submit(function (event) {
    if (!requestSent) {
        requestSent = true;
        var parametros = {
            funcion: "addOrdenVenta",
            tipo: $("#tipoAdd").val(),            
            producto: $("#productoAdd").val(),            
            tipoprod:  $("#tipoproductoVenta").val(),
            tipouso:  $("#tipousoVenta").val(),
            observaciones: $("#observacionesAdd").val(),
            fecha: $("#fechaAdd").val(),
            cliente: $("#clienteAdd").val(),
            pais: $("#paisAdd").val(),
            provincia: $("#provinciaAdd").val(),
            cuit: $("#cuitAdd").val(),
            general: $("#generalAdd").val(),
            entrega: $("#entregaAdd").val(),
            cobranza: $("#cobranzaAdd").val(),
            precio: $("#precioAdd").val(),
            cantidad: $("#cantidadAdd").val()
        }
        $.ajax({
            type: "POST",
            url: 'controller/orden_ventas.controller.php',
            data: parametros,
            success: function (datos) {                
                if (parseInt(datos) >= 0) {
                    //window.location.href = "orden_venta.php?codigo="+datos;
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

$("#actualizarDatosOrdenVenta").submit(function (event) {
    if (!requestSent) {
        requestSent = true;
        var parametros = {
            funcion: "updateOrdenVenta",
            codigo: codigo,
            producto: $("#productoUpdate").val(),
            tipoprod:  $("#tipoproductoVentaUpdate").val(),
            observaciones: $("#observacionesUpdate").val(),
            fecha: $("#fechaUpdate").val(),
            fechaentrega: $("#fechaentregaUpdate").val(),
            cliente: $("#clienteUpdate").val(),
            pais: $("#paisUpdate").val(),
            provincia: $("#provinciaUpdate").val(),
            cuit: $("#cuitUpdate").val(),
            general: $("#generalUpdate").val(),
            entrega: $("#entregaUpdate").val(),
            cobranza: $("#cobranzaUpdate").val(),
            precio: $("#precioUpdate").val()
        }
        $.ajax({
            type: "POST",
            url: 'controller/orden_ventas.controller.php',
            data: parametros,
            success: function (datos) {    
                if (parseInt(datos) >= 0) {
                    //window.location.href = "orden_venta.php?codigo="+datos;
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