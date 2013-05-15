function IndexCtrl($scope){
    if(!angular.equals(sessionStorage.getItem("usua_usuario"),null)){
        $('#divBarraUsuario').show();
        $('#divMenu').show();
        $('#linkUsuario').html('<i class="icon-user"></i> ' + sessionStorage.getItem("usua_nombre") + ' <span class="caret"></span>');

    }
}

function IndexAdminCtrl($scope,sessionService){
    sessionService.validar();
}

function LoginCtrl(comunService, sessionService,$scope,$http,$location){
    $scope.maestro = {};
    $scope.Limpiar = function () {
        $scope.form_autenticar = angular.copy($scope.maestro);
        //$scope.form_autenticar.usuario = "p70566989";
        //$scope.form_autenticar.password = "p70566989";
    };
    $scope.Autenticar = function(form_autenticar){
        $scope.maestro = angular.copy(form_autenticar);
        $.ajax({
            type: 'GET',
            url: 'api/usuario/buscar/' + $scope.maestro.usuario + "/" + $scope.maestro.password,
            dataType: "json",
            success: function(data){
                usuario = data.datos[0];
                if(usuario != null){
                    sessionStorage.setItem("usua_usuario",usuario.usua_usuario);
                    sessionStorage.setItem("usua_id",usuario.usua_id);
                    sessionStorage.setItem("pege_id",usuario.pege_id);
                    sessionStorage.setItem("usua_nombre",usuario.usua_nombre);
                    sessionStorage.setItem("usua_documento",usuario.usua_documento);
                    location.href = "#/principal";
                }
                else{
                    alert("Datos de usuario no son validos");
                }
            }
        });
    }
    $scope.Limpiar();
}

function PrincipalCtrl(comunService, sessionService,$scope,$http){
    sessionService.validar();

}




