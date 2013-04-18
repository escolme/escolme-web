function InscripcionCtrl(comunService, sessionService,$scope,$http){

    $scope.Limpiar = function(){
        $scope.inscripcion = {
            METO_ID:null,
            PROG_ID:null,PROG_ID2:null,
            TIDG_ID:null,PAGE_ID:null, DEGE_ID:null, CIGE_ID:null,
            ESCG_ID:null,ESTR_ID:null,OMED_ID:null,PAGE_ID2:null, DEGE_ID2:null,
            CIGE_ID2:null, INST_CODIGOSNP:null,JORN_ID:null, JORN_ID2:null,
            ASPI_NUMERODOCUMENTO:null,ASPI_SEXO:null,ASPI_PRIMERNOMBRE:null,
            ASPI_SEGUNDONOMBRE:null,ASPI_PRIMERAPELLIDO:null, ASPI_SEGUNDOAPELLIDO:null,
            ASPI_FECHANACIMIENTO:null,ASPI_FECHANACIMIENTO_S:'',ASPI_TELEFONORESIDENCIA:null,ASPI_TELEFONOCELULAR:null,
            ASPI_EMAIL:null, ESSE_FECHATERMINACION:null, ESSE_SNP:null,ESSE_FECHAPRESENTOPRUEBAS:null,
            ESSE_PUNTAJEOBTENIDO:null, NIED_ID:null,CIRC_ID:null,SEPE_ID:null,UNPR_ID:null,COIN_ID:null
        };
        $scope.filtros = { institucion:''};
        $scope.ListarModalidades();
        $scope.ListarTipoDocumento();
        $scope.ListarPais();
        $scope.ListarPais2();
        $scope.ListarEstadoCivil();
        $scope.ListarEstrato();
        $scope.ListarMedio();
        $scope.ListarHorario();
        $scope.ListarHorario2();
        
    }

    $scope.Guardar = function(){

        $scope.inscripcion.ASPI_FECHANACIMIENTO_S = comunService.fechaFormato('dd/mm/yyyy', $scope.inscripcion.ASPI_FECHANACIMIENTO);


        var json_inscripcion = JSON.stringify($scope.inscripcion);
        $.ajax({
            type: 'POST',
            contentType: 'application/json',
            url: 'api/insertar/aspirantenew',
            dataType: "json",
            data: json_inscripcion,
            success: function(data, textStatus, jqXHR){
                console.dir(data);
            },
            error: function(jqXHR, textStatus, errorThrown){
                alert('error: ' + textStatus);
            }
        }) 
    }

    $scope.ListarModalidades = function(){
        $http.get('api/metodologias/listar').then(function(response){
            $scope.modalidades = response.data.datos;
        });
    }

    $scope.CamposAdicionales = function(){
        var prog = $scope.inscripcion.PROG_ID;
        if(prog!=null){
            $http.get('api/programas/adicional/' + prog).then(function(response){
                $scope.adicional = response.data.datos[0];
                $scope.inscripcion.SEPE_ID=$scope.adicional.SEPE_ID;
                $scope.inscripcion.UNPR_ID=$scope.adicional.UNPR_ID;
                $scope.inscripcion.COIN_ID=$scope.adicional.COIN_ID;
                $scope.inscripcion.CIRC_ID=$scope.adicional.CIRC_ID;
                $scope.inscripcion.NIED_ID=$scope.adicional.NIED_ID;
                console.dir($scope.inscripcion.PROG_ID);
                //console.dir($scope.inscripcion.SEPE_ID);
                //console.dir($scope.inscripcion.UNPR_ID);
                //console.dir($scope.inscripcion.COIN_ID);
                //console.dir($scope.inscripcion.CIRC_ID);
                //console.dir($scope.inscripcion.NIED_ID);
            });
        }else{
            $scope.adicional = [];
        }
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

    $scope.ListarPais2 = function(){
        $http.get('api/pais/listar').then(function(response){
            $scope.pais2= response.data.datos;
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

    $scope.ListarDepartamento2 = function(){
        var page_id = $scope.inscripcion.PAGE_ID2;
        if(page_id!=null){
            $http.get('api/departamento/listar/' + page_id).then(function(response){
                $scope.departamento2= response.data.datos;
            });
        }else{
            $scope.departamento2 = [];
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

    $scope.ListarCiudad2 = function(){
        var dege_id = $scope.inscripcion.DEGE_ID2;
        if(dege_id!=null){
            $http.get('api/ciudad/listar/' + dege_id).then(function(response){
                $scope.ciudad2= response.data.datos;
            });
        }else{
            $scope.ciudad2 = [];
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

    $scope.ListarInstitucion = function($event){
            $http.get('api/institucion/listarporfiltro/' + $scope.filtros.institucion).then(function(response){
                $scope.instituciones= response.data.datos;
                $('#ventanaListarInstituciones').modal('show');
            });
       
        $event.preventDefault();

    }

    $scope.RetornarInstitucion = function(inst){
         $scope.filtros.institucion=inst.INST_NOMBREINSTITUCION;
         $scope.inscripcion.INST_CODIGOSNP=inst.INST_CODIGOSNP;
         $('#ventanaListarInstituciones').modal('toggle');

    }

    $scope.ListarHorario = function(){
        $http.get('api/horario/listar').then(function(response){
            $scope.horario= response.data.datos;
        });
    }

    $scope.ListarHorario2 = function(){
        $http.get('api/horario/listar').then(function(response){
            $scope.horario2= response.data.datos;
        });
    }

    $scope.InformacionAdicional = function(){
        $('#ventanaInformacionAdicional').modal('show');
    }

    $scope.InformacionAdicional2 = function(){
        $('#ventanaInformacionAdicional2').modal('show');
    }

    $scope.VerPensum =function(){
        if(angular.equals($scope.inscripcion.PROG_ID,undefined))
            $('#aInfoAdicional1').hide('blind');
        else
            $('#aInfoAdicional1').show();    
         $('#frmPensum').attr('src','recursos/pensum/' + $scope.inscripcion.PROG_ID + '.pdf');
    }

    $scope.VerPensum2 =function(){
        if(angular.equals($scope.inscripcion.PROG_ID2,undefined))
            $('#aInfoAdicional2').hide('blind');
        else
            $('#aInfoAdicional2').show();    
        $('#frmPensum2').attr('src','recursos/pensum/' + $scope.inscripcion.PROG_ID2 + '.pdf');
    }

    $scope.ValidarPrograma =function(){
        if ($scope.inscripcion.PROG_ID === $scope.inscripcion.PROG_ID2 && !angular.equals($scope.inscripcion.PROG_ID,'')){
            alert('[ERROR] No puede elegir el mismo programa');
            $scope.inscripcion.PROG_ID2=null ;
        }
    }


    $scope.ValidarPrograma2 =function(){
        if ($scope.inscripcion.PROG_ID === $scope.inscripcion.PROG_ID2 && !angular.equals($scope.inscripcion.PROG_ID2,'')){
            alert('[ERROR] No puede elegir el mismo programa');
            $scope.inscripcion.PROG_ID2=null ;
        }
    }

    $scope.Limpiar();

}
