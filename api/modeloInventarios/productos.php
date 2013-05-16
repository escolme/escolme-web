<?php

    function productosListar(){

        $resultados = array();
        $conexion = new conexionBD();


       // FROM table1   LEFT JOIN table2 ON table1.id=table2.id
            try
              {

                $conectar = $conexion->conectarInventarios();
                $result = mysqli_query($conectar,"SELECT id_producto,nom_producto,cant_stock,fecha_mod,categoria FROM tbl_productos JOIN  tbl_categoria_productos  ON  tbl_productos.id_categoria_producto= tbl_categoria_productos.id_categoria_producto");
              //  $result_type= MYSQLI_BOTH;
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

               // mysqli_close($conectar);

              //  mysqli_close($conectar);

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



function insertarpedidousuario()
{
    $request = Slim::getInstance()->request();
    $pedido = json_decode($request->getBody());
    $fecha=date("Y-m-d");
    try {
        $conexion = new conexionBD();
        $conectar = $conexion->conectarInventarios();
        $sql= "INSERT INTO tbl_pedido_usuario(id_usuario) VALUES (1)";
        $result = mysqli_query($conectar,$sql);
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

       /*while($row = mysqli_fetch_array($result))
        {
            $fila = array(
                "maximo" => $row['maximo']
            );
            array_push($resultados, $fila);
        }*/
        //while($row = mysqli_affected_rows($valor))
        //{
        echo utf8_encode('{"datos": ' . json_encode($valor) . '}');
        //echo($valor);
        mysqli_close($conectar);
        //echo($valor);
        //}
    }
    catch(Exception $e){
        mysqli_close($conectar);
        echo utf8_encode('{"error: ":' . $e->getMessage() . '}');
    }
}














/*
function modificarproductos()
{
  try {
      $conexion = new conexionBD();
      $conectar = $conexion->conectarInventarios();
      $result = mysqli_query($conectar "UPDATE tabla SET columna= valor
                 WHERE columna='valor' AND columna='valor'");

  }
         catch(Exception $e){
          mysqli_close($conectar);
          echo utf8_encode('{"error: ":' . $e->getMessage() . '}');
  }
}


function borrarproductos()
{
    $request = Slim::getInstance()->request();
    $insertarproductos = json_decode($request->getBody());
    $fecha=date("Y-m-d");
   try {
       $conexion = new conexionBD();
       $conectar = $conexion->conectarInventarios();
       $sql="DELETE FROM tbl_productos WHERE id_producto=".$insertarproductos->id_producto.", nom_producto='".$insertarproductos->nom_producto."', cant_stock=".$insertarproductos->cant_stock.",
        ".$insertarproductos->precio_producto.",".$insertarproductos->cantidad_pedida.",".$insertarproductos->id_categoria_producto.",'".$fecha."'"
       $result= mysqli_query($conectar,"DELETE FROM tbl_productos WHERE columna='valor'");
   }
       catch(Exception $e){
       mysqli_close($conectar);
       echo utf8_encode('{"error: ":' . $e->getMessage() . '}');
}
}*/

