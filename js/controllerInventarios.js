
     function PedidosCtrl($scope,$http){
        $scope.categoriaListar= function(){
            $http.get('api/pedidos/categoria/listar').then(function(response){
                $scope.categoria = response.data.datos;
            });
        }
          $scope.categoriaListar();
    }

    function InventariosCtrl($scope,$http){

        $scope.ListarProductos = function(){
            $http.get('api/inventarios/productos/listar').then(function(response){
                $scope.productos = response.data.datos;
            });
        }


        $scope.ListarProductos();





    }

function RegistroCtrl($scope,$http){

}
