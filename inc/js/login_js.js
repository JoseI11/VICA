$(document).on({
    ajaxStart: function() { $("#loading").css("display", "block");    },
     ajaxStop: function() { $("#loading").css("display", "none"); }    
});

// Boton ingresar
$("#ingresar").click(function () {
    var nombre = $("#inputUser").val();
    var password = $("#inputPassword").val();
    var data = {
        funcion: "logueo",
        nombre: nombre,
        password: password,
    }
    alert(data.nombre)
    alert(data.password)
    $.ajax({
    
        type: 'POST',
        url: 'controller/index.controller.php',
        data: data,
        
        success: function (data) {
            if (parseInt(data) == 0){
                window.location.href = "index.php";
            } else {
                if (parseInt(data) == data) { 
                    alert("Verifique usuario y contraseña!");
                } else {
                    alert(data);
                }
            }
        },
        error: function () {
            alert("Error");
        }
    });
    return false;
});

// Enter en el campo de password
$("#inputPassword").keypress(function(e) {
    if(e.which == 13) {
        $("#ingresar").click();
    }
});

// Enter en el campo de usuario
$("#inputUser").keypress(function(e) {
    if(e.which == 13) {
        $("#inputPassword").focus();
    }
});
