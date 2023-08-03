function callGetRegistros(orderby, sentido, registros, pagina, busqueda, objeto) {
    getRegistros(orderby, sentido, registros, pagina, busqueda, objeto);
    return false;
}

$("#export").click(function () {
    $("#tabla").table2excel({
        exclude: ".noExl",
        name: $("#tabla").attr("namefile"),
        filename: $("#tabla").attr("namefile"),
        fileext: ".xls",
    });
});

$("#busqueda-erase").click(function () {
    $("#busqueda").val("");
    $("#busqueda-icono").click();
    $("#busqueda").focus();
});


$("#filtrar").click(function () {
    $("#busqueda-icono").click();
    $("#busqueda").focus();
});

$(".paginas").click(function () {
    var pag = $(this).text();
        
    var first = $("#first");
    var before = $("#before");
    var actual = $("#actual");
    var next = $("#next");
    var last = $("#last");
    
    var cant_reg = $("#tabla").attr("registros");
    var totales = $("#tabla").attr("totales");
    
    last.attr("ultimo", Math.ceil(totales/cant_reg));
        
    if (pag == "<<"){
        pag = 1;
    }
    
    if (pag == ">>"){
        pag = parseInt(last.attr("ultimo"));
    }
    
    $("#div_tabla").attr("pagina", pag);
    busquedaIconoPagina();
            
    first.css("display","inline-block");
    before.css("display","inline-block");
    if (parseInt(pag) == 1){
        first.css("display","none");
        before.css("display","none");
    }
    if (parseInt(pag) == 2){
        first.css("display","none");
        before.css("display","inline-block");
    }
    
    first.text("<<");
    before.text(parseInt(pag) - 1);
    actual.text(pag);
    next.text(parseInt(pag) + 1);
    last.text(">>");
    
    next.css("display","inline-block");
    last.css("display","inline-block");
    if (parseInt(pag) == parseInt(last.attr("ultimo"))){
        next.css("display","none");
        last.css("display","none");
    }
    if (parseInt(pag) == parseInt(last.attr("ultimo")) - 1){
        next.css("display","inline-block");
        last.css("display","none");
    }
    
});

function busquedaIconoPagina() {
    var orderby = $("#div_tabla").attr("orderby");
    var sentido = $("#div_tabla").attr("sentido");
    var registros = $("#cant_reg").val();
    var pagina = $("#div_tabla").attr("pagina");
    var busqueda = $("#busqueda").val();
    getRegistros(orderby, sentido, registros, pagina, busqueda, null);
}

$("#busqueda-icono").click(function () {
    var orderby = $("#div_tabla").attr("orderby");
    var sentido = $("#div_tabla").attr("sentido");
    var registros = $("#cant_reg").val();
    var pagina = 1;
    var busqueda = $("#busqueda").val();
    getRegistros(orderby, sentido, registros, pagina, busqueda, null);
});

$("#busqueda").keypress(function (e) {
    if (e.which == 13) {
        $("#busqueda-icono").click();
    }
});

$("#cant_reg").change(function (e) {
    $("#busqueda-icono").click();
});

$("tbody > tr").click(function () {
	$("tbody > tr").css("background-color", "");
	$(this).css("background-color", "#FFFFB8");
});

$("#logo").click(function () {
    $('#helpModal').modal('show');
});