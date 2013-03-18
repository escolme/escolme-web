var httpheaders = "application/json; charset=utf-8";

var escolmeWeb = angular.module('escolmeWeb',[]).config(['$routeProvider', function ($routeProvider,$locationProvider) {
    $routeProvider.
        when('/', { templateUrl: 'vistas/inscripcion.html', controller: IndexCtrl }).
        when('/inscripcion', { templateUrl: 'vistas/inscripcion.html', controller: InscripcionCtrl }).
        otherwise({ redirectTo: '/' });
}]);