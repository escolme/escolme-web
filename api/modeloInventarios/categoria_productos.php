<?php
/**
 * Created by JetBrains PhpStorm.
 * User: samuel1189
 * Date: 4/04/13
 * Time: 10:27 AM
 * To change this template use File | Settings | File Templates.
 */

function categoriaListar(){

	$resultados = array();
	try{
		$conexion = new conexionBD();
		$conectar = $conexion->conectarInventarios();
		$result = mysqli_query($conectar,"SELECT * FROM tbl_categoria_productos");//WHERE id_categoria_producto=".$id_categoria_producto.";");
		while($row = mysqli_fetch_array($result))
        {
            $fila = array(
                "categoria" => $row['categoria'],
                "id_categoria_producto" => $row['id_categoria_producto'],
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


function categoriaListar2(){

    $resultados = array();
    try{
        $conexion = new conexionBD();
        $conectar = $conexion->conectarInventarios();
        $result = mysqli_query($conectar,"SELECT * FROM tbl_categoria_productos");//WHERE id_categoria_producto=".$id_categoria_producto.";");
        while($row = mysqli_fetch_array($result))
        {
            $fila = array(
                "categoria" => $row['categoria'],
                "id_categoria_producto" => $row['id_categoria_producto'],
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