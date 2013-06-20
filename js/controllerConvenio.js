function ConvenioCtrl (comunService,uiService, sessionService,$scope,$http){

    //sessionService.validar();
    $scope.IniciarConvenio = function(){
        $scope.ListarProgramas();
        $scope.ListarMetodologia();
        $scope.ListarPeriodo();
        $scope.ListarConvenios();
        $scope.convenio = {
            CONV_NOMBRE:null,
            PROG_ID:null,
            METO_ID:null,
            CONV_REGION:null,
            CONV_CANTIDAD:null,
            CATE_ID:null,
            PEUN_ID:null

        };
    }

    $scope.ListarProgramas=function(){
        $http.get('api/convenio/programa/listar').then(function(response){
            $scope.listarprograma = response.data.datos;

        });
    }

    $scope.ListarMetodologia=function(){
        $http.get('api/metodologias/listar').then(function(response){
            $scope.listarmetodologia = response.data.datos;

        });
    }

    $scope.ListarPeriodo=function(){
        $http.get('api/convenio/periodo/listar').then(function(response){
            $scope.listarperiodo = response.data.datos;

        });
    }

    $scope.ListarConvenios=function(){
        $http.get('api/convenio/listar').then(function(response){
            $scope.listarconvenios = response.data.datos;

        });
    }

    $scope.GuardarConvenio = function(){
        var json_inscripcion = JSON.stringify($scope.convenio);
        //console.dir($scope.convenio);
        $.ajax({
            type: 'POST',
            contentType: 'application/json',
            url: 'api/insertar/convenio',
            dataType: "json",
            data: json_inscripcion,
            async:false,
            success: function(data, textStatus, jqXHR){
                console.dir(data);
                $scope.ListarConvenios();
                $scope.IniciarConvenio()

            },
            error: function(jqXHR, textStatus, errorThrown){
                alert('error: ' + textStatus);
            }
        })
    }

    $scope.AbrirModificarConvenio=function(c){
        $scope.CANTIDADNEW=null;
        //console.dir(c);
        $scope.conveniomodi=c;
        //console.dir($scope.conveniomodi);
        $('#ventanamodiconvenio').modal('show');

    }

    $scope.GuardarModificar=function(){
        console.dir($scope.conveniomodi);
        console.dir($scope.CANTIDADNEW);
    }

$scope.IniciarConvenio();
}