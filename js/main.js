var httpheaders = "application/json; charset=utf-8";

var escolmeWeb = angular.module('escolmeWeb',['ui']).config(['$routeProvider', function ($routeProvider,$locationProvider) {
    $routeProvider.
        when('/', { templateUrl: 'vistas/inscripcion.html', controller: InscripcionCtrl }).
        when('/inscripcion', { templateUrl: 'vistas/inscripcion.html', controller: InscripcionCtrl }).
        otherwise({ redirectTo: '/' });
}]);

escolmeWeb.value('ui.config', {
	date: {
		changeMonth: true,changeYear: true
	}
});