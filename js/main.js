var httpheaders = "application/json; charset=utf-8";
var escolmeWeb = angular.module('escolmeWeb',[]).config(['$routeProvider', function ($routeProvider,$locationProvider) {
    $routeProvider.
        when('/', { templateUrl: 'vistas/index.html', controller: IndexCtrl }).
        when('/inscripcion', { templateUrl: 'vistas/inscripcion.html', controller: InscripcionCtrl }).
        when('/inventarios', { templateUrl: 'vistas/inventarios.html',controller:InventariosCtrl}).
        otherwise({ redirectTo: '/' });
}]);