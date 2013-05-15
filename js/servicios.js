//SERVICIOS DE INTERFAZ DE USUARIO
escolmeWeb.service('uiService',function(){

    function mostrarMenuSuperior(mostrar){
        if(mostrar)
            $('#divMenuSuperior').show();
        else
            $('#divMenuSuperior').hide();
    }

    // Exponer funciones del servicio
    return {
        mostrarMenuSuperior: function(mostrar)   { return mostrarMenuSuperior(mostrar);  }
    };

});

escolmeWeb.service('comunService',function(){

    function fechaFormato(formato,fecha){
        var month = fecha.getMonth() + 1;
        month = month < 10 ? "0"+month:month;
        var day = fecha.getDate() < 10 ? "0"+fecha.getDate():fecha.getDate();
        var year = fecha.getFullYear();
        switch (formato){
            case "dd/mm/yyyy":
                return  day + "/" + month + "/" + year;
            case "dd-mm-yyyy":
                return  day + "-" + month + "-" + year;
        }
    }

    // Exponer funciones del servicio
    return {
        fechaFormato: function(formato,fecha)   { return fechaFormato(formato,fecha);  }
    };

});

//SERVICIOS DE SESION
escolmeWeb.service('sessionService',function(){

    function validarSession(){
        if(angular.equals(sessionStorage.getItem("usua_usuario"),null)){
            location.href = "#/login";
        }
        else{
            $('#divBarraUsuario').show();
            $('#divMenu').show();
            $('#linkUsuario').html('<i class="icon-user"></i> ' + sessionStorage.getItem("usua_nombre") + ' <span class="caret"></span>');
        }
    }



    // Exponer funciones del servicio
    return {
        validar: function()   { return validarSession();  }
    };
});


