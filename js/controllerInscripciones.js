function InscripcionCtrl(comunService, sessionService,$scope,$http){


    if(!angular.equals(sessionStorage.getItem("usua_usuario"),null)){
        $('#divBarraUsuario').show();
        $('#linkUsuario').html('<i class="icon-user"></i> ' + sessionStorage.getItem("usua_nombre") + ' <span class="caret"></span>');
        $("#divContenidos").css("width"," 74.35897435897436%");
    }
    else{
        $("#divContenidos").css("width","100%");
    }

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
            ASPI_EMAIL:null, ESSE_FECHATERMINACION:null,ESSE_FECHATERMINACION_S:'', ESSE_SNP:null,ESSE_FECHAPRESENTOPRUEBAS:null,
            ESSE_FECHAPRESENTOPRUEBAS_S:'',ESSE_PUNTAJEOBTENIDO:null, NIED_ID:null,CIRC_ID:null,CIRC_ID2:null,SEPE_ID:null,
            SEPE_ID2:null,UNPR_ID:null,UNPR_ID2:null,COIN_ID:null,COIN_ID2:null,ASPI_ID:null,FOIN_ID:null, validacionguardado:null
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

    $scope.ValidacionExiste = function(){
        var documento = $scope.inscripcion.ASPI_NUMERODOCUMENTO;
        var nied_id= $scope.inscripcion.NIED_ID;
        if (documento!= null && nied_id!=null){
            $http.get('api/buscar/inscripcion/' + documento).then(function(response){
                $scope.existe = response.data.datos[0];
                if($scope.existe!= null){
                    $scope.inscripcion.validacionguardado=1;
                    alert("El usuario ya tiene una inscripcion activa para este periodo, no se guardara ninguna información" + $scope.inscripcion.validacionguardado);
                    $scope.inscripcion.ASPI_NUMERODOCUMENTO = null;

                }
                else{
                    $http.get('api/buscar/aspiid/'+documento+'/'+nied_id).then(function(response){
                        $scope.existe2 = response.data.datos[0];
                        if($scope.existe2!= null){
                            $scope.inscripcion.validacionguardado=2;
                            alert("El usuario se ha inscrito previamente más no para este periodo, se actualizarán los datos y se guardaran los programas escogidos. Por favor termine de diligenciar los datos" + $scope.inscripcion.validacionguardado);

                        }
                        else{
                            $scope.inscripcion.validacionguardado=3;
                        }
                    });
                }
            });
        }
    }

    $scope.Guardar = function(){

        $scope.inscripcion.ASPI_FECHANACIMIENTO_S = comunService.fechaFormato('dd/mm/yyyy', $scope.inscripcion.ASPI_FECHANACIMIENTO);
        $scope.inscripcion.ESSE_FECHATERMINACION_S = comunService.fechaFormato('dd/mm/yyyy', $scope.inscripcion.ESSE_FECHATERMINACION);
        $scope.inscripcion.ESSE_FECHAPRESENTOPRUEBAS_S = comunService.fechaFormato('dd/mm/yyyy', $scope.inscripcion.ESSE_FECHAPRESENTOPRUEBAS);
        var json_inscripcion = JSON.stringify($scope.inscripcion);

        switch ($scope.inscripcion.validacionguardado) {
            case 1:
                alert("El usuario ya tiene una inscripcion activa para este periodo, no se guardara ninguna información");
                $scope.Limpiar();
                break;
            case 2:
                $scope.BuscarAspiId();
                break;
            case 3:
                $.ajax({
                    type: 'POST',
                    contentType: 'application/json',
                    url: 'api/insertar/aspirantenew',
                    dataType: "json",
                    data: json_inscripcion,
                    async:false,
                    success: function(data, textStatus, jqXHR){
                        console.dir(data);
                        $scope.BuscarAspiId();
                    },
                    error: function(jqXHR, textStatus, errorThrown){
                        alert('error: ' + textStatus);
                    }
                })
                break;
        }

<<<<<<< HEAD

    }

=======
>>>>>>> 8afb64ab4b43efdf36192482497eec1acd572b3b
    $scope.BuscarAspiId = function(){
        var documento = $scope.inscripcion.ASPI_NUMERODOCUMENTO;
        var nied_id= $scope.inscripcion.NIED_ID;
        if(documento!=null){
            $http.get('api/buscar/aspiid/'+documento+'/'+nied_id).then(function(response){
                $scope.aspiid = response.data.datos[0];
                $scope.inscripcion.ASPI_ID=$scope.aspiid.ASPI_ID;
                if($scope.inscripcion.validacionguardado == 2){
                    $scope.GuardarFormulario();
                    $scope.ActualizarCircunscripcion();
                }
                if($scope.inscripcion.validacionguardado == 3){
                    $scope.GuardarFormulario();
                    $scope.GuardarCaracterizacion();
                    $scope.GuardarEstudiosSecundarios();
                    $scope.GuardarInfoSocio();
                }
            });
        }else{
            $scope.aspiid = [];
        }
    }

    $scope.ActualizarCircunscripcion = function(){
        var circ_id = $scope.inscripcion.CIRC_ID;
        var aspi_id= $scope.inscripcion.ASPI_ID;
        if (circ_id!= null && aspi_id!= null){
            $http.get('api/actualizar/circunscripcion/'+circ_id+'/'+aspi_id).then(function(response){
            });
        }

    }

    $scope.GuardarFormulario = function(){
        var json_inscripcion = JSON.stringify($scope.inscripcion);
        $.ajax({
            type: 'POST',
            contentType: 'application/json',
            url: 'api/insertar/formularioinscripcionnew',
            dataType: "json",
            data: json_inscripcion,
            async:false,
            success: function(data, textStatus, jqXHR){
                console.dir(data);
                $scope.BuscarFoinid()
            },
            error: function(jqXHR, textStatus, errorThrown){
                alert('error: ' + textStatus);
            }
        })
    }



    $scope.BuscarFoinid = function(){
        var aspiid = $scope.inscripcion.ASPI_ID;
        if(aspiid!=null){
            $http.get('api/buscar/formulario/' + aspiid).then(function(response){
                $scope.foinid = response.data.datos[0];
                $scope.inscripcion.FOIN_ID=$scope.foinid.FOIN_ID;
                $scope.GuardarPrograma();
            });
        }else{
            $scope.aspiid2 = [];
        }
    }

    $scope.GuardarPrograma = function(){
        var json_inscripcion = JSON.stringify($scope.inscripcion);
        $.ajax({
            type: 'POST',
            contentType: 'application/json',
            url: 'api/insertar/programaxformulario',
            dataType: "json",
            data: json_inscripcion,
            async:false,
            success: function(data, textStatus, jqXHR){
                console.dir(data);
                $scope.FinalizarInscripcion();

            },
            error: function(jqXHR, textStatus, errorThrown){
                alert('error: ' + textStatus);
            }
        })
    }

    $scope.GuardarCaracterizacion = function(){
        var json_inscripcion = JSON.stringify($scope.inscripcion);
        $.ajax({
            type: 'POST',
            contentType: 'application/json',
            url: 'api/insertar/caracterizacionnew',
            dataType: "json",
            data: json_inscripcion,
            async:false,
            success: function(data, textStatus, jqXHR){
                console.dir(data);
            },
            error: function(jqXHR, textStatus, errorThrown){
                alert('error: ' + textStatus);
            }
        })
    }

    $scope.GuardarEstudiosSecundarios = function(){
        var json_inscripcion = JSON.stringify($scope.inscripcion);
        $.ajax({
            type: 'POST',
            contentType: 'application/json',
            url: 'api/insertar/estudiossecundariosnew',
            dataType: "json",
            data: json_inscripcion,
            async:false,
            success: function(data, textStatus, jqXHR){
                console.dir(data);
            },
            error: function(jqXHR, textStatus, errorThrown){
                alert('error: ' + textStatus);
            }
        })
    }

    $scope.GuardarInfoSocio = function(){
        var json_inscripcion = JSON.stringify($scope.inscripcion);
        $.ajax({
            type: 'POST',
            contentType: 'application/json',
            url: 'api/insertar/socioeconomica',
            dataType: "json",
            data: json_inscripcion,
            async:false,
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

    $scope.ListarNivelEducativo = function(){
        $scope.inscripcion.NIED_ID=null;
        $scope.inscripcion.PROG_ID=null;
        $scope.inscripcion.PROG_ID2=null;
        var meto_id= $scope.inscripcion.METO_ID;
        $http.get('api/niveleducativo/listar/'+meto_id).then(function(response){
            $scope.niveleducativo = response.data.datos;
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
                $scope.CamposAdicionales2();
            });
        }else{
            $scope.adicional = [];
        }

    }

    $scope.CamposAdicionales2 = function(){
        var prog2 = $scope.inscripcion.PROG_ID2;
        if(prog2!=null){
            $http.get('api/programas/adicional/' + prog2).then(function(response){
                $scope.adicional2 = response.data.datos[0];
                $scope.inscripcion.SEPE_ID2=$scope.adicional2.SEPE_ID;
                $scope.inscripcion.UNPR_ID2=$scope.adicional2.UNPR_ID;
                $scope.inscripcion.COIN_ID2=$scope.adicional2.COIN_ID;
                $scope.inscripcion.CIRC_ID2=$scope.adicional2.CIRC_ID;
                $scope.Guardar();
            });
        }else{
            $scope.adicional2 = [];
        }
    }

    $scope.ListarProgramas = function(){
        var meto_id = $scope.inscripcion.METO_ID;
        var nied_id = $scope.inscripcion.NIED_ID;
        if(meto_id!=null && nied_id!=null){
            $http.get('api/programas/listar/' + meto_id+'/'+nied_id).then(function(response){
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

    $scope.FinalizarInscripcion = function(){
         $scope.Limpiar();
         $('#ventanaFinalizaInscripcion').modal('show');
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
