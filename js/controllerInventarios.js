function PedidosCtrl($scope,$http){


}

function InventariosCtrl($scope,$http){

	$scope.Listar = function(){
        $http.get('api/inventarios/productos/listar').then(function(response){
            $scope.productos = response.data.datos;
        });
	}


	$scope.Listar();





}

function RegistroCtrl($scope,$http){

}
