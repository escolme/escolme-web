function InscripcionCtrl(sessionService,$scope,$http){


    $scope.Limpiar = function(){
        $scope.inscripcion = {
            METO_ID:null,PROG_ID:null,PROG_ID2:null,TIDG_ID:null,PAGE_ID:null, DEGE_ID:null, CIGE_ID:null,ESCG_ID:null,ESTR_ID:null,OMED_ID:null
        };
        $scope.ListarModalidades();
        $scope.ListarTipoDocumento();
        $scope.ListarPais();
        $scope.ListarEstadoCivil();
        $scope.ListarEstrato();
        $scope.ListarMedio();
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

    $scope.ListarPais = function(){
        $http.get('api/pais/listar').then(function(response){
            $scope.pais= response.data.datos;
        });
    }

    $scope.ListarDepartamento = function(){
        var page_id = $scope.inscripcion.PAGE_ID;
        if(page_id!=null){
        $http.get('api/departamento/listar/' + page_id).then(function(response){
            $scope.departamento= response.data.datos;
        });
        }else{
            $scope.departamento = [];
        }
    }

    $scope.ListarCiudad = function(){
        var dege_id = $scope.inscripcion.DEGE_ID;
        if(dege_id!=null){
            $http.get('api/ciudad/listar/' + dege_id).then(function(response){
                $scope.ciudad= response.data.datos;
            });
        }else{
            $scope.ciudad = [];
        }
    }

    $scope.ListarEstadoCivil = function(){
        $http.get('api/estadocivil/listar').then(function(response){
            $scope.estadocivil= response.data.datos;
        });
    }

    $scope.ListarEstrato = function(){
        $http.get('api/estrato/listar').then(function(response){
            $scope.estrato= response.data.datos;
        });
    }

    $scope.ListarMedio = function(){
        $http.get('api/medio/listar').then(function(response){
            $scope.medio= response.data.datos;
        });
    }

    $scope.Limpiar();

}
