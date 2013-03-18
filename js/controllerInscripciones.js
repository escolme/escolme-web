function InscripcionCtrl(sessionService,$scope,$http){

    $scope.Limpiar = function(){
        $scope.inscripcion = {
            METO_ID:null
        };
        $scope.ListarModalidades();
    }

    $scope.ListarModalidades = function(){
        $http.get('api/modalidad/listar').then(function(response){
            $scope.modalidades = response.data.datos;
        });
    }

    $scope.ListarProgramas = function(){
        $http.get('api/programas/listar').then(function(response){
            $scope.programas = response.data.datos;
        });
    }

    $scope.Limpiar();

}
