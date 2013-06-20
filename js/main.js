var httpheaders = "application/json; charset=utf-8";

var escolmeWeb = angular.module('escolmeWeb',['ui']).config(['$routeProvider', function ($routeProvider,$locationProvider) {
    $routeProvider.
        when('/', { templateUrl: 'vistas/index.html', controller: IndexCtrl }).
        when('/principal', { templateUrl: 'vistas/principal.html', controller: PrincipalCtrl }).
        when('/admin', { templateUrl: 'vistas/index_admin.html', controller: IndexAdminCtrl }).
        when('/inscripciones/inscripcion', { templateUrl: 'vistas/inscripciones/inscripcion.html', controller: InscripcionCtrl }).
        when('/inscripciones/gestion', { templateUrl: 'vistas/inscripciones/gestionarinscripcion.html', controller: GestionarInsCtrl}).
        when('/reportes/informeprogramaestado', { templateUrl: 'vistas/reportes/informeprogramaestado.html', controller: ReportesCtrl}).
        when('/reportes/informematricula', { templateUrl: 'vistas/reportes/informematricula.html', controller: ReportesMatriculaCtrl}).
        when('/inscripciones/imprimir', { templateUrl: 'vistas/inscripciones/imprimirinscripcion.html', controller: ImprimirInsCtrl}).
        when('/login', { templateUrl: 'vistas/login.html', controller: LoginCtrl }).
        when('/inventarios/admin', { templateUrl: 'vistas/inventarios/inventarios.html', controller: InventariosCtrl }).
        when('/inventarios/imprimirpedido', { templateUrl: 'vistas/inventarios/imprimirpedido.html', controller: ImprimirPedidoCtrl }).
        when('/inventarios/pedidos', { templateUrl: 'vistas/inventarios/pedidos.html', controller: PedidosCtrl }).
        when('/inventarios/registro', { templateUrl: 'vistas/inventarios/registro.html', controller: RegistroCtrl}).
        when('/inventarios/modificar', { templateUrl: 'vistas/inventarios/modificar.html', controller: ModificarCtrl}).
        when('/inventarios/ordenpedido', { templateUrl: 'vistas/inventarios/ordenpedido.html', controller: OrdenPedidoCtrl}).
        when('/gestionar/inscripcion', { templateUrl: 'vistas/gestionarinscripcion.html', controller: GestionarInsCtrl}).
<<<<<<< HEAD
        when('/convenio/ingresarconvenio', { templateUrl: 'vistas/convenio/ingresarconvenio.html', controller: ConvenioCtrl}).


        when('/liquidacion/nuevos', { templateUrl: 'vistas/liquidacionnuevos/liquidacion.html', controller: LiquidacionNuevosCtrl}).
        when('/entrevista/gestion', { templateUrl: 'vistas/entrevista/gestionarentrevista.html', controller: EntrevistaCtrl}).
        when('/entrevista/imprimir', { templateUrl: 'vistas/entrevista/imprimirentrevista.html', controller: ImprimirEntrevistaCtrl}).
=======
        when('/liquidacion/nuevos', { templateUrl: 'vistas/liquidacionnuevos/liquidacion.html', controller: LiquidacionNuevosCtrl}).
        when('/entrevista/gestion', { templateUrl: 'vistas/entrevista/gestionarentrevista.html', controller: EntrevistaCtrl}).
        when('/entrevista/imprimir', { templateUrl: 'vistas/entrevista/imprimirentrevista.html', controller: ImprimirEntrevistaCtrl}).

>>>>>>> 9db1cca8277413e9845c6df65c609b84ef897e61
        otherwise({ redirectTo: '/' });
}]);

escolmeWeb.value('ui.config', {
	date: {
		changeMonth: true,changeYear: true,regional:'es',dateFormat:'dd/mm/yy'
	}
});


//Directiva para agregar la funcionalidad onBlur a un input
escolmeWeb.directive('ngBlur', function() {
  return function( scope, elem, attrs ) {
    elem.bind('blur', function() {
      scope.$apply(attrs.ngBlur);
    });
  };
});

var Salir = function(){
    sessionStorage.clear();
    $('#divBarraUsuario').hide();
    $('#divMenu').hide();
    $("#divContenidos").css("width","100%");
}

