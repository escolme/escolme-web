
function PedidosCtrl($scope,$http,sessionService,comunService){

  //  sessionService.validar();

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
        $http.get('api/pedido/cantidad/'+ $scope.pedido.id_producto).then (function(response){
            $scope.cantidad3=response.data.datoscantidad[0];
            var cantinicial = $scope.cantidad3.cant_stock - $scope.pedido.cantidad;
            console.dir(cantinicial)
           if(cantinicial<1){
               alert("Cantidad pedida no aceptada") ;
           }
           else{
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



    $scope.abrirventanaPedido= function(){
        $('#pedidoFinal').modal('show');
    }


    $scope.GuardarPedido = function(){
        if($scope.pedidoFinal[0]!=null){
            $http.get('api/pedido/maximo').then(function(response){
                $scope.maximo = response.data.datos;
                var num = parseInt($scope.maximo) +1;
                var pedido = {
                    id_usuario : sessionStorage.getItem("usua_id"),
                    maximo : num
                   // pedido: $scope.pedidoFinal
                }
                var json_pedido = JSON.stringify(pedido);
                $.ajax({
                    type: 'POST',
                    contentType: 'application/json',
                    url: 'api/pedido/guardar',
                    dataType: "json",
                    data: json_pedido,
                    async:false,
                    success: function(data, textStatus, jqXHR){
                    console.dir(data);
                    $scope.GuardarProducto()  // llamado a la funcion guardar producto
                    $scope.DisminuirStock() // llamado a la funcion disminuir stock
                    alert("Pedido exitoso") ;
                    },
                    error: function(jqXHR, textStatus, errorThrown){
                        alert('error: ' + textStatus);
                    }
                })
            });
        }
        else {
            alert("Ingrese al menos un producto a la lista")
        }
       }




    $scope.CancelarPedido = function(){
           $scope.pedidoFinal=null
      }



    $scope.GuardarProducto = function(){
        var num = parseInt($scope.maximo) +1;
        var pedido2 ={
            pedido2:$scope.pedidoFinal,
            maximo:num
        }
        var json_pedido = JSON.stringify(pedido2);
            $.ajax({
                type: 'POST',
                contentType: 'application/json',
                url: 'api/pedido/guardarproducto',
                dataType: "json",
                data: json_pedido,
                async:false,
                success: function(data, textStatus, jqXHR){
                    console.dir(data);
                },
                error: function(jqXHR, textStatus, errorThrown){
                    alert('error: ' + textStatus);
                }
            })
    }

    $scope.DisminuirStock = function(){
        angular.forEach($scope.pedidoFinal,function(c){
         $http.get('api/pedido/cantidad/'+ c.id_producto).then (function(response){
             $scope.cantidad=response.data.datoscantidad[0];
            var cant = $scope.cantidad.cant_stock - c.cantidad;
             console.dir(cant)
             console.dir($scope.cantidad)
                $http.post('api/pedido/disminuirstock/' + cant+'/' + c.id_producto).then(function(response){ // funcion de update que es llamada en el api
                });
        });
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

        $scope.ordenarInventario = function(){
            $scope.inventario= []
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
                    alert("Producto almacenado con exito") ;
                    $scope.limpiar3();

                },
                error: function(jqXHR, textStatus, errorThrown){
                    alert('error: ' + textStatus);
                }
            })
        }

        $scope.Cancelar = function(){
            $scope.insertarproductos=null
        }

     $scope.limpiar3();
    }


    function ModificarCtrl($scope,$http){

    if(!angular.equals(sessionStorage.getItem("usua_usuario"),null)){
        $('#divBarraUsuario').show();
        $('#linkUsuario').html('<i class="icon-user"></i> ' + sessionStorage.getItem("usua_nombre") + ' <span class="caret"></span>');
        $("#divContenidos").css("width"," 74.35897435897436%");
    }
    else{
        $("#divContenidos").css("width","100%");
    }
        $scope.limpiar3 = function(){
            $scope.filtros = { producto:''};
            $scope.ListarProductos2 = function(){
                $http.get('api/modificar/productos/listar').then(function(response){
                    $scope.productos2 = response.data.datos;
                    //console.dir($scope.productos2);
                });
            }
            $scope.ListarProductos2();
        }

        $scope.ordenarInventario2 = function(){
            $scope.inventario2= []
        }

        $scope.ListarProductos3 = function($event){
            if($scope.filtros.producto != ''){
                $http.get('api/modificar/allproductos/listarporfiltro/' + $scope.filtros.producto).then(function(response){
                    $scope.productos2= response.data.datos;
                    console.dir($scope.productos2)
                });

                $event.preventDefault();
            }
            else
            {
            $scope.ListarProductos2();
            }
        }



        $scope.ModificarStock = function(){
           // console.dir($scope.modistock)
            var cant = parseInt($scope.modistock.cant_stock) + parseInt($scope.modistock.cantsumar);
            console.dir(cant)
           $http.post('api/modificar/modificarstock/' + cant+'/' + $scope.modistock.id_producto).then(function(response){ // funcion de update que es llamada en el api
                   });

        }


        $scope.abrirventanaimprimirpedido= function(c){
            $('#imprimirpedido').modal('show');
            $scope.modistock = {
                id_producto:c.id_producto,
                cant_stock : c.cant_stock,
                cantsumar: null,
                nom_producto:c.nom_producto
            };
        }
        $scope.limpiar3();
}








    function OrdenPedidoCtrl($scope,$http){

    if(!angular.equals(sessionStorage.getItem("usua_usuario"),null)){
        $('#divBarraUsuario').show();
        $('#linkUsuario').html('<i class="icon-user"></i> ' + sessionStorage.getItem("usua_nombre") + ' <span class="caret"></span>');
        $("#divContenidos").css("width"," 74.35897435897436%");
    }
    else{
        $("#divContenidos").css("width","100%");
    }


        $scope.limpiar2 = function(){
            $scope.insertarobservaciones ={
              descripcion:null,id_pedido_usuario:null,pedidoentregado:null
            }
            $scope.ordenpedido={
                id_pedido_usuario:null
            }
            $scope.ListarPedidos = function(){
                $http.get('api/ordenpedido/pedidos/listar').then(function(response){
                    $scope.pedidos = response.data.datos;
                  angular.forEach($scope.pedidos,function(c)  {
                      $http.get('api/ordenpedido/usuarios/usuario/'+ c.id_usuario).then(function(response){
                         $scope.nombre  = response.data.datos[0];
                          c.usua_nombre=$scope.nombre.usua_nombre;
                      });
                    });
                });
            }
        }

        $scope.limpiar2();
        $scope.ListarPedidos();


        $scope.AbrirPedido = function(c){
            $('#pedidoFinal').modal('show');
            $scope.insertarobservaciones.id_pedido_usuario= c.id_pedido_usuario;
            var ped_id = c.id_pedido_usuario;
            if(ped_id!=null) {
            $http.get('api/ordenpedido/pedidofinal/listar/'+ ped_id).then(function(response){
                $scope.pedidomodal = response.data.datos;
                console.dir($scope.pedidomodal)
            });
            }
            else{
              $scope.pedidomodal = [];
                }
    }

        $scope.CerrarPedido = function(){
            elem=document.getElementsByName('entregado');
            for(i=0;i<elem.length;i++)
                if (elem[i].checked) {
                    valor = elem[i].value;
                    $scope.insertarobservaciones.pedidoentregado= valor;
                }
            console.dir($scope.insertarobservaciones);
           var json_insertarobservaciones = JSON.stringify($scope.insertarobservaciones);
            $.ajax({
                type: 'POST',
                contentType: 'application/json',
                url: 'api/ordenpedido/descripcion',
                dataType: "json",
                data: json_insertarobservaciones,
                async:false,
                success: function(data, textStatus, jqXHR){
                    console.dir(data);
                },
                error: function(jqXHR, textStatus, errorThrown){
                    alert('error: ' + textStatus);
                }
            })
            $scope.ListarPedidos();
        }
    }



 function ImprimirPedidoCtrl ($scope,$http){
     if(!angular.equals(sessionStorage.getItem("usua_usuario"),null)){
         $('#divBarraUsuario').show();
         $('#linkUsuario').html('<i class="icon-user"></i> ' + sessionStorage.getItem("usua_nombre") + ' <span class="caret"></span>');
         $("#divContenidos").css("width"," 74.35897435897436%");
     }
     else{
         $("#divContenidos").css("width","100%");
     }
     $scope.limpiar2 = function(){
         $scope.ListarPedidos = function(){
             $http.get('api/imprimirpedido/pedidos/listar').then(function(response){
                 $scope.pedidos = response.data.datos;
                 angular.forEach($scope.pedidos,function(c)  {
                     $http.get('api/imprimirpedido/usuarios/usuario/'+ c.id_usuario).then(function(response){
                         $scope.nombre  = response.data.datos[0];
                         c.usua_nombre=$scope.nombre.usua_nombre;
                     });
                 });
             });
         }
     }
     $scope.limpiar2();
     $scope.ListarPedidos();


     $scope.ImprimirPedidoFinal= function(c){
         $('#pedidoImprimir').modal('show');
         $scope.factura={
             id_pedido:c.id_pedido_usuario,
             fecha:c.fecha
         }
         $http.get('api/imprimirpedido/usuarios/usuario/'+ c.id_usuario).then(function(response){
             $scope.nombre = response.data.datos[0];
         });
        // console.dir(c);
         var ped_id2 = $scope.factura.id_pedido;
         //console.dir(ped_id2);
         if(ped_id2!=null) {
             $http.get('api/imprimirpedido/pedidofinal/listar/'+ ped_id2).then(function(response){
                 $scope.pedidomodal2 = response.data.datos;
               //  console.dir($scope.pedidomodal2);
             });
         }
         else{
             $scope.pedidomodal2 = [];
         }
     }

     $scope.Imprimir=function(){
         $('#vistapreviaimprimir').print
     }
 }


