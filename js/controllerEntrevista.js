function ImprimirEntrevistaCtrl (comunService, sessionService,$scope,$http){
    sessionService.validar();

    $scope.LimpiarImprimirEntrevista = function(){
        $scope.ListarEntrevistas();
    }

    $scope.ListarEntrevistas = function(){
        $http.get('api/entrevistados/imprimir').then(function(response){
            $scope.entrevistados= response.data.datos;
            //console.dir(response.data.datos);
        });

    }

    $scope.AbrirImprimirEntrevista = function(dato3){
        //console.dir(dato3);
        $('#imprimirEntrevista').modal('show');
            var formu =dato3.FOIN_ID;
            $http.get('api/entrevista/imprimir/' + formu).then(function(response){
                $scope.imprimirentrevista2 = response.data.datos[0];
                //console.dir($scope.imprimirentrevista2);
                if ($scope.imprimirentrevista2.ENTRE_HOMOLOGACION == 1){
                    $scope.imprimirentrevista2.HOMOLO = 'SI';
                }
                else{
                    $scope.imprimirentrevista2.HOMOLO = 'NO';
                }
            });
            //console.dir(formu);
            $scope.LimpiarImprimirEntrevista();

    }


    $scope.ImprimirEntrevista2 = function(){
        $("#divVistaPreviaEntrevista2").printElement();
    }

    $scope.LimpiarImprimirEntrevista();
}

/*---------------------------------------------------*/
/* Controlador de la pagina /#/entrevista/gestion */
/*---------------------------------------------------*/

function EntrevistaCtrl (comunService, sessionService,$scope,$http){
    sessionService.validar();

    $scope.LimpiarEntrevista = function(){
        $scope.ListarInscritos();
    }

    $scope.ListarInscritos = function(){
        $http.get('api/inscritos/listar').then(function(response){
            $scope.inscritosentrevista= response.data.datos;
            //console.dir(response.data.datos);
        });

    }

    $scope.AbrirGestionarEntrevista = function(dato2){
        //console.dir(dato2);
        $('#ventanaEntrevista').modal('show');
        $scope.entrevista = {
            NOMBRE:dato2.NOMBRE,
            ASPI_NUMERODOCUMENTO : dato2.ASPI_NUMERODOCUMENTO,
            PROGRAMA:dato2.PROG_NOMBRE,
            PROG_ID:dato2.PROG_ID,
            PERIODO:dato2.PEUN_ANO + "-" + dato2.PEUN_PERIODO,
            FOIN_ID:dato2.FOIN_ID,
            USUA_ID:null,
            FECHAENTREVISTA:null,
            FECHAENTREVISTA_:null,
            HOMOLOGACION:null,
            OBSERVACIONES:null,
            PREGUNTA1:null,
            PREGUNTA2:null,
            PREGUNTA3:null,
            PREGUNTA4:null,
            PREGUNTA5:null,
            LLAM_ID:null
        };
    }

    $scope.BuscarLlamado = function(){
            $http.get('api/formulario/buscarllamado/' + $scope.entrevista.PROG_ID).then(function(response){
                $scope.llamado = response.data.datos[0];
                if ($scope.llamado!= null)
                {
                    $scope.entrevista.LLAM_ID=$scope.llamado.LLAM_ID;
                    $scope.GuardarEntrevista();
                }
            });
    }

    $scope.GuardarEntrevista = function(){
        $scope.entrevista.USUA_ID=sessionStorage.getItem("usua_id");
        $scope.entrevista.FECHAENTREVISTA_ = comunService.fechaFormato('dd/mm/yyyy', $scope.entrevista.FECHAENTREVISTA);

        $http.post('api/actualizar/formularioxentrevista/'+ $scope.entrevista.LLAM_ID +'/'+$scope.entrevista.FOIN_ID).then(function(response){
            console.dir(response);
        });

        var json_clasificacion = JSON.stringify($scope.entrevista);
        $.ajax({
            type: 'POST',
            contentType: 'application/json',
            url: 'api/insertar/entrevistanew',
            dataType: "json",
            data: json_clasificacion,
            async:false,
            success: function(data, textStatus, jqXHR){
                console.dir(data);
                $scope.VistaEntrevista();
            },
            error: function(jqXHR, textStatus, errorThrown){
                alert('error: ' + textStatus);
            }
        })


        //$scope.LimpiarEntrevista();
    }


    $scope.VistaEntrevista = function(){
        $('#imprimirEntrevista').modal('show');
        var formu =$scope.entrevista.FOIN_ID;
        $http.get('api/entrevista/imprimir/' + formu).then(function(response){
            $scope.imprimirentrevista = response.data.datos[0];
            console.dir($scope.imprimirentrevista);
            if ($scope.imprimirentrevista.ENTRE_HOMOLOGACION == 1){
                $scope.imprimirentrevista.HOMOLO = 'SI';
            }
            else{
                $scope.imprimirentrevista.HOMOLO = 'NO';
            }
        });
        //console.dir(formu);
        $scope.LimpiarEntrevista();
    }

    $scope.ImprimirEntrevista = function(){
        $("#divVistaPreviaEntrevista").printElement();
    }

    $scope.LimpiarEntrevista();
}