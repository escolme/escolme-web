
function PedidosCtrl($scope,$http){

    $scope.limpiar = function(){
       $scope.pedido={
           id_categoria_producto:null,
           cantidad:1
       };
       $scope.pedidoFinal = [];
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

    $scope.AgregarProducto = function(){
        $http.get('api/productos/cargarporid/'+ $scope.pedido.id_producto).then(function(response){
            producto = response.data.datos[0];
            var existe = false;
            angular.forEach($scope.pedidoFinal, function(c) {
                if(c.id_producto == $scope.pedido.id_producto){
                    existe = true;
                    c.cantidad = c.cantidad + $scope.pedido.cantidad;
                }
            });

            if(!existe){
                var item = {
                    id_producto : $scope.pedido.id_producto,
                    nom_producto : producto.nom_producto,
                    cantidad : $scope.pedido.cantidad
                }

                $scope.pedidoFinal.push(item);
            }
        });
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
