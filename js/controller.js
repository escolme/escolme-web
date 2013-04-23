function IndexCtrl($scope){

}

function LoginCtrl(comunService, sessionService,$scope,$http,$location){
    $scope.maestro = {};
    $scope.Limpiar = function () {
        $scope.form_autenticar = angular.copy($scope.maestro);
        $scope.form_autenticar.usuario = "p70566989";
        $scope.form_autenticar.password = "p70566989";
    };
    $scope.Autenticar = function(form_autenticar){
        $scope.maestro = angular.copy(form_autenticar);
        $.ajax({
            type: 'GET',
            url: url_servicios + '/UsuariosVO/AutenticarUsuario/' + $scope.maestro.usuario + "/" + $scope.maestro.password,
            dataType: "json",
            success: function(data){
                if(data != null){
                    sessionStorage.setItem("usua_usuario",data.usua_usuario);
                    sessionStorage.setItem("usua_id",data.usua_id);
                    sessionStorage.setItem("pege_id",data.pege_id);
                    sessionStorage.setItem("usua_nombre",data.usua_nombre);
                    sessionStorage.setItem("usua_documento",data.usua_documento);
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



