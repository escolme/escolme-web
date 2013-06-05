<?php

    function productosListar(){
        $resultados = array();
        $conexion = new conexionBD();
            try
              {
                $conectar = $conexion->conectarInventarios();
                $result = mysqli_query($conectar,"SELECT id_producto,nom_producto,cant_stock,fecha_mod,categoria FROM tbl_productos JOIN  tbl_categoria_productos  ON  tbl_productos.id_categoria_producto= tbl_categoria_productos.id_categoria_producto");
                while($row = mysqli_fetch_array($result))
                {
                    $fila = array(
                        "id_producto" => $row['id_producto'],
                        "nom_producto" => $row['nom_producto'],
                        "categoria"=> $row ['categoria'],
                        "cant_stock" => $row['cant_stock'],
                        "fecha_mod" => $row['fecha_mod'],
                    );
                    array_push($resultados, $fila);
                }

                echo utf8_encode('{"datos": ' . json_encode($resultados) . '}');
                mysqli_close($conectar);
            }
            catch(Exception $e){
                echo utf8_encode('{"error: ":' . $e->getMessage() . '}');
            }
    }

    function productosCargarPorId($id_producto){
        $resultados = array();

        try
        {
            $conexion = new conexionBD();
            $conectar = $conexion->conectarInventarios();
            $result = mysqli_query($conectar,"SELECT id_producto,nom_producto FROM tbl_productos WHERE id_producto=$id_producto");

            while($row = mysqli_fetch_array($result))
            {
                $fila = array(
                    "id_producto" => $row['id_producto'],
                    "nom_producto" => $row['nom_producto'],

                );
                array_push($resultados, $fila);
            }

            echo utf8_encode('{"datos": ' . json_encode($resultados) . '}');
            mysqli_close($conectar);
        }
        catch(Exception $e){
            mysqli_close($conectar);
            echo utf8_encode('{"error: ":' . $e->getMessage() . '}');
        }
    }

        function productosQuitarPorId($id_producto){
            $resultados = array();

            try
            {
                $conexion = new conexionBD();
                $conectar = $conexion->conectarInventarios();
                $result = mysqli_query($conectar,"SELECT id_producto,nom_producto FROM tbl_productos WHERE id_producto=$id_producto");

                while($row = mysqli_fetch_array($result))
                {
                    $fila = array(
                        "id_producto" => $row['id_producto'],
                        "nom_producto" => $row['nom_producto'],

                    );
                    array_push($resultados, $fila);
                }

                echo utf8_encode('{"datos": ' . json_encode($resultados) . '}');
                mysqli_close($conectar);
            }
            catch(Exception $e){
                mysqli_close($conectar);
                echo utf8_encode('{"error: ":' . $e->getMessage() . '}');
            }
        }

    function productosCategoria($id_categoria_producto){
        $resultados = array();
        try
        {
            $conexion = new conexionBD();
            $conectar = $conexion->conectarInventarios();
            $result = mysqli_query($conectar,"SELECT id_producto,nom_producto FROM tbl_productos WHERE id_categoria_producto=$id_categoria_producto");
            //  $result_type= MYSQLI_BOTH;
             //echo ($result);
            while($row = mysqli_fetch_array($result))
            {
                $fila = array(
                    "id_producto" => $row['id_producto'],
                    "nom_producto" => $row['nom_producto'],

                );
                array_push($resultados, $fila);
            }

            echo utf8_encode('{"datos": ' . json_encode($resultados) . '}');
            mysqli_close($conectar);
        }
        catch(Exception $e){
            mysqli_close($conectar);
            echo utf8_encode('{"error: ":' . $e->getMessage() . '}');
        }
    }

function productosCategoria2($id_categoria_producto){
    $resultados = array();
    try
    {
        $conexion = new conexionBD();
        $conectar = $conexion->conectarInventarios();
        $result = mysqli_query($conectar,"SELECT id_producto,nom_producto FROM tbl_productos WHERE id_categoria_producto=$id_categoria_producto");
        //  $result_type= MYSQLI_BOTH;
        //echo ($result);
        while($row = mysqli_fetch_array($result))
        {
            $fila = array(
                "id_producto" => $row['id_producto'],
                "nom_producto" => $row['nom_producto'],

            );
            array_push($resultados, $fila);
        }

        echo utf8_encode('{"datos": ' . json_encode($resultados) . '}');
        mysqli_close($conectar);
    }
    catch(Exception $e){
        mysqli_close($conectar);
        echo utf8_encode('{"error: ":' . $e->getMessage() . '}');
    }
}




function insertarproductos()
{
    $request = Slim::getInstance()->request();
    $insertarproductos = json_decode($request->getBody());
    $fecha=date("Y-m-d");
    //echo   utf8_encode('{"datos": ' .json_encode($insertarproductos) . '}');
    //echo($sql);
 try {
     $conexion = new conexionBD();
     $conectar = $conexion->conectarInventarios();
     $sql= "INSERT INTO tbl_productos(nom_producto,cant_stock,precio_producto,cantidad_pedida,id_categoria_producto,fecha_mod) VALUES ('".$insertarproductos->nom_producto."',".$insertarproductos->cant_stock.",".$insertarproductos->precio_producto.",".$insertarproductos->cantidad_pedida.",".$insertarproductos->id_categoria_producto.",'".$fecha."')";
     //$sql= "INSERT INTO tbl_productos(id_producto,nom_producto,usu_asociado,categoria_producto,cant_stock,precio_producto) VALUES (".$insertarproductos->id_producto.",'".$insertarproductos->nom_producto."','".$insertarproductos->usu_asociado."',".$insertarproductos->categoria_producto.",".$insertarproductos->cant_stock.",".$insertarproductos->precio_producto.")";

     $result = mysqli_query($conectar,$sql);
     echo utf8_encode('{"datos": ' .json_encode($sql) . '}');
     }

        catch(Exception $e){
         mysqli_close($conectar);
         echo utf8_encode('{"error: ":' . $e->getMessage() . '}');
 }

}



function insertarpedido()
{
    $request = Slim::getInstance()->request();
    $pedido = json_decode($request->getBody());
    $fecha=date("Y-m-d");
    try {
        $conexion = new conexionBD();
        $conectar = $conexion->conectarInventarios();
        $sql= "INSERT INTO tbl_pedidos_usuarios(id_pedido_usuario,id_usuario,fecha) VALUES (".$pedido->maximo.",".$pedido->id_usuario.",'".$fecha."')";
        $result = mysqli_query($conectar,$sql);
        echo utf8_encode('{"datos": ' .json_encode($sql) . '}');
    }
    catch(Exception $e){
        mysqli_close($conectar);
        echo utf8_encode('{"error: ":' . $e->getMessage() . '}');
    }
}

function insertarpedido2()
{
    $request = Slim::getInstance()->request();
    $pedido= json_decode($request->getBody());
  try {
        $conexion = new conexionBD();
        $conectar = $conexion->conectarInventarios();

        for($i = 0;$i<count($pedido->pedido2);$i++){
            $sql= "INSERT INTO tbl_pedido_producto(id_pedido_usuario,id_producto,cantidad_pedida) VALUES (".$pedido->maximo.",'".$pedido->pedido2[$i]->id_producto."',".$pedido->pedido2[$i]->cantidad.")";
            $result = mysqli_query($conectar,$sql);
        }
        echo utf8_encode('{"datos": ' .json_encode($sql) . '}');
    }
         catch(Exception $e){
            mysqli_close($conectar);
            echo utf8_encode('{"error: ":' . $e->getMessage() . '}');
    }
}


function idmaximo(){
    try
    {
        $conexion = new conexionBD();
        $conectar = $conexion->conectarInventarios();
        $result = mysqli_fetch_array(mysqli_query($conectar,"SELECT max(id_pedido_usuario) as maximo FROM tbl_pedidos_usuarios"));
        $valor = $result['maximo'];
        echo utf8_encode('{"datos": ' . json_encode($valor) . '}');
        mysqli_close($conectar);
    }
    catch(Exception $e){
        mysqli_close($conectar);
        echo utf8_encode('{"error: ":' . $e->getMessage() . '}');
    }
}


function disminuirstock($cantidad,$id_producto){
    try
    {
        $conexion = new conexionBD();
        $conectar = $conexion->conectarInventarios();
        $result = mysqli_query($conectar,"UPDATE tbl_productos SET cant_stock=".$cantidad."
                 WHERE id_producto=".$id_producto);

        echo utf8_encode('{"datos": ' . json_encode($result) . '}');
        mysqli_close($conectar);
    }
    catch(Exception $e){
        mysqli_close($conectar);
        echo utf8_encode('{"error: ":' . $e->getMessage() . '}');
    }
}


function cantidadenstock($id_producto){
    $resultados = array();
    try
    {
        $conexion = new conexionBD();
        $conectar = $conexion->conectarInventarios();
        $result = mysqli_query($conectar,"SELECT id_producto,cant_stock FROM tbl_productos WHERE id_producto=$id_producto");
        while($row = mysqli_fetch_array($result))
        {
            $fila = array(
            "id_producto" => $row['id_producto'],
            "cant_stock" => $row['cant_stock'],
            );
            array_push($resultados, $fila);
        }

        echo utf8_encode('{"datoscantidad": ' . json_encode($resultados) . '}');
        mysqli_close($conectar);
    }
    catch(Exception $e){
        mysqli_close($conectar);
        echo utf8_encode('{"error: ":' . $e->getMessage() . '}');
    }
}


function pedidosListar(){
    $resultados = array();
    $conexion = new conexionBD();
    try
    {
        $conectar = $conexion->conectarInventarios();
        $result = mysqli_query($conectar,"SELECT id_pedido_usuario,id_usuario,fecha FROM tbl_pedidos_usuarios where tbl_pedidos_usuarios.entregado=0");
        while($row = mysqli_fetch_array($result))
        {
            $fila = array(
                "id_pedido_usuario" => $row['id_pedido_usuario'],
                "id_usuario" => $row['id_usuario'],
                "usua_nombre"=>'',
                "fecha"=> $row ['fecha'],
            );
            array_push($resultados, $fila);
        }
        echo utf8_encode('{"datos": ' . json_encode($resultados) . '}');
        mysqli_close($conectar);
    }
    catch(Exception $e){
        echo utf8_encode('{"error: ":' . $e->getMessage() . '}');
    }
}


function ordenpedido($id_pedido_usuario){
    $resultados = array();
    try
    {
        $conexion = new conexionBD();
        $conectar = $conexion->conectarInventarios();
        $result = mysqli_query($conectar,"SELECT id_pedido_usuario,tbl_pedido_producto.cantidad_pedida,nom_producto FROM tbl_productos JOIN tbl_pedido_producto ON tbl_pedido_producto.id_producto=tbl_productos.id_producto WHERE id_pedido_usuario=$id_pedido_usuario");
        while($row = mysqli_fetch_array($result))
        {
            $fila = array(
                "id_pedido_usuario"=>$row['id_pedido_usuario'],
                "nom_producto" => $row['nom_producto'],
                "cantidad_pedida" => $row['cantidad_pedida'],
            );
            array_push($resultados, $fila);
        }
        echo utf8_encode('{"datos": ' . json_encode($resultados) . '}');
        mysqli_close($conectar);
    }
    catch(Exception $e){
        mysqli_close($conectar);
        echo utf8_encode('{"error: ":' . $e->getMessage() . '}');
    }
}



function buscarnombreUsuario($usua_id){
    try{
        $resultados = array();
        $conexion = new conexionBD();
        $conn = $conexion->conectarPosgresql();
        $sql = " SELECT usua_id, usua_nombre FROM general.usuario where usuario.usua_id = $usua_id;";
        $result =pg_query ($conn, $sql);
        //echo utf8_encode('{"datos": ' . json_encode($sql) . '}');
        if (pg_num_rows($result)>0) {
            while ($row = pg_fetch_array($result)) {
                $fila = array(
                    "usua_nombre" => $row["usua_nombre"],
                );
                array_push($resultados, $fila);
            }
        }
        echo utf8_encode('{"datos": ' . json_encode($resultados) . '}');
        pg_close($conn);
    }
    catch(Exception $e){
        pg_close($conn);
        echo utf8_encode('{"error: ":' . $e->getMessage() . '}');
    }
}



function insertarobservaciones()
{
    $request = Slim::getInstance()->request();
    $insertarobservaciones = json_decode($request->getBody());
    try {
        $conexion = new conexionBD();
        $conectar = $conexion->conectarInventarios();
        $sql = mysqli_query($conectar,"UPDATE tbl_pedidos_usuarios SET descripcion='".$insertarobservaciones->descripcion."', entregado=".$insertarobservaciones->pedidoentregado." WHERE id_pedido_usuario=".$insertarobservaciones->id_pedido_usuario);
        echo utf8_encode('{"datos": ' .json_encode($sql) . '}');
        $result = mysqli_query($conectar,$sql);
       /* echo utf8_encode('{"datos": ' .json_encode($sql) . '}');*/
    }

    catch(Exception $e){
        mysqli_close($conectar);
        echo utf8_encode('{"error: ":' . $e->getMessage() . '}');
    }

}











