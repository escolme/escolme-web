function ReportesCtrl (comunService,uiService, sessionService,$scope,$http){

    sessionService.validar();
    $scope.IniciarReportes = function(){
        uiService.configuracionGraficas();
        $scope.CargarListaProgramas();

    }


    $scope.CargarListaProgramas = function(){
        $scope.contadores = {
            contpre: null,contins:null, contadm:null

        };
        var contpre, contins, contadm = 0;

        $http.get('api/programas/organizar/reportes').then(function(response){
            $scope.programaslista= response.data.datos;
            //console.dir($scope.programaslista);

            $http.get('api/preinscritos/contar/reportes').then(function(response){
                $scope.preinscritoscontar= response.data.datos;
                //console.dir($scope.preinscritoscontar);

                        $http.get('api/inscritos/contar/reportes').then(function(response){
                            $scope.inscritoscontar= response.data.datos;

                           $http.get('api/admitidos/contar/reportes').then(function(response){
                                $scope.admitidoscontar= response.data.datos;

                                    angular.forEach($scope.programaslista, function(i) {
                                            //console.dir(i);

                                        angular.forEach($scope.preinscritoscontar, function(j) {
                                                //console.dir(j);
                                            if (i.PROG_ID == j.PROG_ID){
                                                i.PREINSCRITOS = parseInt(j.CUENTAPROG_ID);
                                            }
                                            contpre= contpre+parseInt(j.CUENTAPROG_ID)

                                            angular.forEach($scope.inscritoscontar, function(k) {
                                                if (i.PROG_ID == k.PROG_ID){
                                                    i.INSCRITOS = parseInt(k.CUENTAPROG_ID);
                                                }
                                                contins= contins+parseInt(k.CUENTAPROG_ID)

                                                angular.forEach($scope.admitidoscontar, function(l) {
                                                    if (i.PROG_ID == l.PROG_ID){
                                                        i.ADMITIDOS = parseInt(l.CUENTAPROG_ID);
                                                    }
                                                    contadm = contadm + parseInt(l.CUENTAPROG_ID)
                                                });

                                                $scope.contadores.contadm=  contadm;
                                                //console.dir(contadm + " " + $scope.contadores.contadm);
                                                contadm=0;
                                            });
                                            $scope.contadores.contins=  contins;
                                            contins=0;
                                        });
                                        $scope.contadores.contpre=contpre;
                                        contpre=0;
                                    });

                               $scope.GenerarGraficaInscripciones();
                            });
                        });

            });
        //console.dir($scope.programaslista);
       });

    }

    $scope.GenerarGraficaInscripciones = function(){

        var categorias = [];
        var inscritos = [];
        var preinscriptos = [];
        var admitidos = [];

        angular.forEach($scope.programaslista, function(c) {
            categorias.push(c.PROG_NOMBRE);
            inscritos.push(c.INSCRITOS);
            preinscriptos.push(c.PREINSCRITOS);
            admitidos.push(c.ADMITIDOS);
        });

        $('#graficasinscripcion2').highcharts({
            chart: {
                type: 'bar'
            },
            title: {
                text: 'INSCRIPCIONES'
            },
            credits: {
                enabled :false
            },
            xAxis: {
                categories: categorias
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Cantidad'
                }
            },
            legend: {
                backgroundColor: '#FFFFFF',
                reversed: true
            },
            plotOptions: {
                series: {
                    stacking: 'normal'
                }
            },
            series: [{
                name: 'Admitidos',
                data: admitidos
            }, {
                name: 'Inscritos',
                data: inscritos
            }, {
                name: 'PreInscritos',
                data: preinscriptos
            }]
        });



    }

    $scope.abrirventanadetalle = function(c,estado){
        //console.dir(c);
        //console.dir(estado);
        $http.get('api/programaestado/reportes/'+ c.PROG_ID + '/' + estado).then(function(response){
            $scope.programadetalle= response.data.datos;
            //console.dir($scope.programadetalle);

        });

        $http.get('api/programaestadolistar/reportes/'+ c.PROG_ID + '/' + estado).then(function(response){
            $scope.listadodetalle= response.data.datos;
            //console.dir($scope.listadodetalle);

            angular.forEach($scope.listadodetalle, function(i) {
                //console.dir(i);
                if(estado === 'PREINSCRITO'){
                    i.FECHA = i.FOIN_FECHACAMBIO;
                }
                else
                {
                    if(estado === 'INSCRITO'){
                        i.FECHA = i.REAS_FECHAREGISTRO;
                    }
                    else{
                        if(estado === 'ADMITIDO'){
                            i.FECHA = i.ENTRE_FECHA;
                        }
                    }
                }

                });
        });
        $('#ventanadetalle').modal('show');
    }

    $scope.ImprimirTabla= function(){
        $("#divVistaPreviaTabla").printElement();
    }

    $scope.ImprimirDetalle = function(){
        $("#divVistaPreviaDetalle").printElement();
    }

    $scope.IniciarReportes();

}

function ReportesMatriculaCtrl (comunService,uiService, sessionService,$scope,$http){

    sessionService.validar();
    $scope.IniciarReportes = function(){
        uiService.configuracionGraficas();
        $scope.CargarListaProgramas();

    }

    $scope.CargarListaProgramas = function(){
        $scope.contadores = {
            contnuevos: null,contanti:null, contrein:null

        };
        var contnuevos, contanti, contrein = 0;

        $http.get('api/programasmatricula/listar/reportes').then(function(response){
            $scope.programaslista= response.data.datos;
            //console.dir($scope.programaslista);

            $http.get('api/nuevos/matricula/reportes').then(function(response){
                $scope.nuevoscontar= response.data.datos;
                //console.dir($scope.nuevoscontar);

                $http.get('api/antiguos/matricula/reportes').then(function(response){
                    $scope.antiguoscontar= response.data.datos;
                    //console.dir($scope.antiguoscontar);

                    $http.get('api/reingresos/matricula/reportes').then(function(response){
                        $scope.reingresoscontar= response.data.datos;
                        //console.dir($scope.reingresoscontar);

                        angular.forEach($scope.programaslista, function(i) {
                            //console.dir(i);

                            angular.forEach($scope.nuevoscontar, function(j) {
                                //console.dir(j);
                                if (i.PROG_ID == j.PROG_ID){
                                    i.NUEVOS = parseInt(j.CUENTA);
                                }
                                contnuevos= contnuevos+parseInt(j.CUENTA)

                                angular.forEach($scope.antiguoscontar, function(k) {
                                    if (i.PROG_ID == k.PROG_ID){
                                        i.ANTIGUOS = parseInt(k.CUENTA);
                                    }
                                    contanti= contanti+parseInt(k.CUENTA)

                                    angular.forEach($scope.reingresoscontar, function(l) {
                                        if (i.PROG_ID == l.PROG_ID){
                                            i.REINGRESOS = parseInt(l.CUENTA);
                                        }
                                        contrein = contrein + parseInt(l.CUENTA)
                                    });

                                    $scope.contadores.contrein=  contrein;
                                    //console.dir(contadm + " " + $scope.contadores.contadm);
                                    contrein=0;
                                });
                                $scope.contadores.contanti=  contanti;
                                contanti=0;
                            });
                            $scope.contadores.contnuevos=contnuevos;
                            contnuevos=0;
                        });

                        $scope.GenerarGraficaMatriculas();
                    });
                });

            });
            //console.dir($scope.programaslista);
        });

    }

    $scope.GenerarGraficaMatriculas = function(){

        var categorias = [];
        var nuevos = [];
        var antiguos = [];
        var reingresos = [];

        angular.forEach($scope.programaslista, function(c) {
            categorias.push(c.PROG_NOMBRE);
            nuevos.push(c.NUEVOS);
            antiguos.push(c.ANTIGUOS);
            reingresos.push(c.REINGRESOS);
        });

        $('#graficasMatricula').highcharts({
            chart: {
                type: 'bar'
            },
            title: {
                text: 'MATRICULA'
            },
            credits: {
                enabled :false
            },
            xAxis: {
                categories: categorias
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Cantidad'
                }
            },
            legend: {
                backgroundColor: '#FFFFFF',
                reversed: true
            },
            plotOptions: {
                series: {
                    stacking: 'normal'
                }
            },
            series: [{
                name: 'Reingresos',
                data: reingresos
            }, {
                name: 'Antiguos',
                data: antiguos
            }, {
                name: 'Nuevos',
                data: nuevos
            }]
        });
    }

    $scope.ImprimirTablaMatri= function(){
        $("#divVistaPreviaTablaMatri").printElement();
    }

    $scope.abrirventanadetallematri = function(prog,cate){
        $('#ventanadetallematri').modal('show');

        //console.dir(prog);
        //console.dir(cate);
        $http.get('api/detalle/matricula/reportes/'+ prog + '/' + cate).then(function(response){
            $scope.matriculadetalle= response.data.datos;
            //console.dir($scope.matriculadetalle);

        });

    }

    $scope.ImprimirDetalleMatri= function(){
        $("#divVistaPreviaDetalleMatri").printElement();
    }

    $scope.IniciarReportes();
}