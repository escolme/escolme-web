
         function PedidosCtrl($scope,$http){
           $scope.limpiar = function(){
               $scope.pedido={
                   id_categoria_producto:null
               };
               $scope.categoriaListar();
        }
             $scope.categoriaListar= function(){
            $http.get('api/pedidos/categoria/listar').then(function(response)
            {
                $scope.categoria = response.data.datos;
            });
        }
             $scope.productosCategoria= function(){
                 var cat_id = $scope.pedido.id_categoria_producto;
                 if(cat_id!=null){
                 $http.get('api/pedidos/proxcate/listar/'+ cat_id).then(function(response){
                     $scope.proxcate = response.data.datos;
                     });
                 }else{
                    $scope.proxcate = [];
                 }
             }

        $scope.limpiar();
    }

    function InventariosCtrl($scope,$http){
        $scope.limpiar2 = function(){
        $scope.ListarProductos = function(){
            $http.get('api/inventarios/productos/listar').then(function(response){
                $scope.productos = response.data.datos;
            });
        }
            $scope.ListarProductos();
        }
        $scope.limpiar2();







    }

function RegistroCtrl($scope,$http){

}
