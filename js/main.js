var httpheaders = "application/json; charset=utf-8";

var escolmeWeb = angular.module('escolmeWeb',['ui']).config(['$routeProvider', function ($routeProvider,$locationProvider) {
    $routeProvider.
        when('/', { templateUrl: 'vistas/index.html', controller: IndexCtrl }).
        when('/principal', { templateUrl: 'vistas/principal.html', controller: PrincipalCtrl }).
        when('/admin', { templateUrl: 'vistas/index_admin.html', controller: IndexAdminCtrl }).
        when('/inscripciones/inscripcion', { templateUrl: 'vistas/inscripciones/inscripcion.html', controller: InscripcionCtrl }).
        when('/inscripciones/gestion', { templateUrl: 'vistas/inscripciones/gestionarinscripcion.html', controller: GestionarInsCtrl}).
        when('/inscripciones/informeprogramaestado', { templateUrl: 'vistas/inscripciones/informeprogramaestado.html', controller: InfoProEstInsCtrl}).
        when('/login', { templateUrl: 'vistas/login.html', controller: LoginCtrl }).
        when('/inventarios/admin', { templateUrl: 'vistas/inventarios/inventarios.html', controller: InventariosCtrl }).
        when('/inventarios/pedidos', { templateUrl: 'vistas/inventarios/pedidos.html', controller: PedidosCtrl }).
        when('/inventarios/registro', { templateUrl: 'vistas/inventarios/registro.html', controller: RegistroCtrl}).
        when('/inventarios/modificar', { templateUrl: 'vistas/inventarios/modificar.html', controller: ModificarCtrl}).
        when('/gestionar/inscripcion', { templateUrl: 'vistas/gestionarinscripcion.html', controller: GestionarInsCtrl}).
<<<<<<< HEAD
=======

>>>>>>> 498d5376f1ea8bdb8e1034f5a7c0e4e2536af801
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

