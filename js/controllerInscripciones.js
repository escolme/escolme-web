function InscripcionCtrl(sessionService,$scope,$http){


    $scope.Limpiar = function(){
        $scope.inscripcion = {
            METO_ID:null,PROG_ID:null,PROG_ID2:null,TIDG_ID:null
        };
        $scope.ListarModalidades();
        $scope.ListarTipoDocumento();
    }

    $scope.ListarModalidades = function(){
        $http.get('api/metodologias/listar').then(function(response){
            $scope.modalidades = response.data.datos;
        });
    }

    $scope.ListarProgramas = function(){
        var meto_id = $scope.inscripcion.METO_ID;
        if(meto_id!=null){
            $http.get('api/programas/listar/' + meto_id).then(function(response){
                $scope.programas = response.data.datos;
            });            
        }else{
            $scope.programas = [];
        }

    }

    $scope.ListarTipoDocumento = function(){
        $http.get('api/tipodocumento/listar').then(function(response){
            $scope.tipodocumento= response.data.datos;
        });
    }


    $scope.Limpiar();

}
