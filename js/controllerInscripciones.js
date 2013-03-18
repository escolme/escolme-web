function InscripcionCtrl(sessionService,$scope,$http){

    $scope.modalidades = [];

    $scope.Limpiar = function(){
        $scope.inscripcion = {
            METO_ID:null,PROG_ID:null,PROG_ID2:null
        };
        $scope.ListarModalidades();
    }

    $scope.ListarModalidades = function(){
        $http.get('api/metodologias/listar').then(function(response){
            $scope.modalidades = response.data.datos;
        });
    }

    $scope.ListarProgramas = function(){
        var meto_id = $scope.inscripcion.METO_ID;
        $http.get('api/programas/listar/' + meto_id).then(function(response){
            console.dir(response.data);
            $scope.programas = response.data.datos;
        });
    }

    $scope.Limpiar();

}
