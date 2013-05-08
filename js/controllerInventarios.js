
function PedidosCtrl($scope,$http,sessionService,comunService){

    //sessionService.validar();

    if(!angular.equals(sessionStorage.getItem("usua_usuario"),null)){
        $('#divBarraUsuario').show();
        $('#linkUsuario').html('<i class="icon-user"></i> ' + sessionStorage.getItem("usua_nombre") + ' <span class="caret"></span>');
        $("#divContenidos").css("width"," 74.35897435897436%");
    }
    else{
        $("#divContenidos").css("width","100%");
    }

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

    $scope.EliminarItem = function(item){
        var temp =  $scope.pedidoFinal;
        $scope.pedidoFinal = [];
        angular.forEach(temp, function(c) {
            if(c.id_producto != item.id_producto){
                $scope.pedidoFinal.push(c);
            }
        });
    }

    $scope.QuitarProducto = function(){
        $http.get('api/productos/quitarporid/'+ $scope.pedido.id_producto).then(function(response){
            producto = response.data.datos[0];
            var existe = false;
            angular.forEach($scope.pedidoFinal, function(c) {
                if(c.id_producto == $scope.pedido.id_producto){
                    existe = true;
                    c.cantidad = c.cantidad - $scope.pedido.cantidad;
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

        if(!angular.equals(sessionStorage.getItem("usua_usuario"),null)){
            $('#divBarraUsuario').show();
            $('#linkUsuario').html('<i class="icon-user"></i> ' + sessionStorage.getItem("usua_nombre") + ' <span class="caret"></span>');
            $("#divContenidos").css("width"," 74.35897435897436%");
        }
        else{
            $("#divContenidos").css("width","100%");
        }

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

        if(!angular.equals(sessionStorage.getItem("usua_usuario"),null)){
            $('#divBarraUsuario').show();
            $('#linkUsuario').html('<i class="icon-user"></i> ' + sessionStorage.getItem("usua_nombre") + ' <span class="caret"></span>');
            $("#divContenidos").css("width"," 74.35897435897436%");
        }
        else{
            $("#divContenidos").css("width","100%");
        }

       $scope.limpiar3 = function(){
           $scope.insertarproductos = {
               id_producto:null,
               nom_producto:null, id_categoria_producto:null, categoria:null,
               id_usuario:null, nombre:null, apellido:null, cant_stock:null,
               cantidad_pedida:null, precio_producto:null
           }
           $scope.categoriaListar2();
       }

        $scope.categoriaListar2= function(){
            $http.get('api/registro/categoria2/listar').then(function(response)
            {
                $scope.categoria2 = response.data.datos;
            });
        }


        $scope.productosCategoria2= function(){

                $http.get('api/registro/proxcate2/listar').then(function(response){
                    $scope.proxcate2 = response.data.datos;
                });

        }


        $scope.Guardar = function(){
            var json_insertarproductos = JSON.stringify($scope.insertarproductos);
            $.ajax({
                type: 'POST',
                contentType: 'application/json',
                url: 'api/registro/productos',
                dataType: "json",
                data: json_insertarproductos,
                async:false,
                success: function(data, textStatus, jqXHR){
                    console.dir(data);

                },
                error: function(jqXHR, textStatus, errorThrown){
                    alert('error: ' + textStatus);
                }
            })
        }

     $scope.limpiar3();
    }
