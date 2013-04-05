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
	try{
		$conexion = new conexionBD();
		$conectar = $conexion->conectarInventarios();
		$result = mysqli_query($conectar,"SELECT * FROM tbl_productos");
		while($row = mysqli_fetch_array($result))
        {
            $fila = array(
                "id_producto" => $row['id_producto'],
                "nom_producto" => $row['nom_producto']
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