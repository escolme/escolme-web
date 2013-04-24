<?php
/**
 * Created by JetBrains PhpStorm.
 * User: samuel1189
 * Date: 4/04/13
 * Time: 10:27 AM
 * To change this template use File | Settings | File Templates.
 */

    function productosListar(){

        $resultados = array();
       // FROM table1   LEFT JOIN table2 ON table1.id=table2.id
            try
              {
                $conexion = new conexionBD();
                $conectar = $conexion->conectarInventarios();
                $result = mysqli_query($conectar,"SELECT id_producto,nom_producto,cant_stock,fecha_mod,categoria FROM tbl_productos JOIN  tbl_categoria_productos  ON  tbl_productos.id_categoria_producto= tbl_categoria_productos.id_categoria_producto");
              //  $result_type= MYSQLI_BOTH;
                while($row = mysqli_fetch_array($result))
                {
                    $fila = array(
                        "id_producto" => $row['id_producto'],
                        "nom_producto" => $row['nom_producto'],
                        "categoria"=>$row ['categoria'],
                        "cant_stock" => $row['cant_stock'],
                        "fecha_mod" => $row['fecha_mod'],
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









  /*
function insertarproductos()
{
 try {
     $conexion = new conexionBD();
     $conectar = $conexion->conectarInventarios();
     $result = mysqli_query($conectar,"INSERT INTO tbl_productos(codigo,nombre,tipo,unidad de uso,stock,usuario asociado,cantidad pedida,precio,imagen producto,fecha de modicación,) VALUES (".$id_producto.",'".$nom_producto."','".$categoria_producto."',".$unidad_uso.",".$cant_stock.",'".$usu_asociado."',".$cantidad_pedida.",".$precio_producto.",".$img_producto.",".$fecha_mod.");";);
     }

        catch(Exception $e){
         mysqli_close($conectar);
         echo utf8_encode('{"error: ":' . $e->getMessage() . '}');
 }

}


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
   try {
       $conexion = new conexionBD();
       $conectar = $conexion->conectarInventarios();
       $result= mysqli_query($conectar,"DELETE FROM tabla WHERE columna='valor'");
   }
       catch(Exception $e){
       mysqli_close($conectar);
       echo utf8_encode('{"error: ":' . $e->getMessage() . '}');
}
}*/

