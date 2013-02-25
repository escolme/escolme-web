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

//SERVICIOS DE SESION
escolmeWeb.service('sessionService',function(){

    function validarSession(){
        if(angular.equals(sessionStorage.getItem("stUsuario"),null)){
            location.href = "#/";
        }
    }

    // Exponer funciones del servicio
    return {
        validar: function()   { return validarSession();  }
    };
});


