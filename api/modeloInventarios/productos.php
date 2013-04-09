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
                "nom_producto" => $row['nom_producto'],
                "categoria_producto" => $row['categoria_producto'],
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

function incertarproductos()
{
    try {
        $conexion = new conexionBD();
        $conectar = $conexion->conectarInventarios();
        $result = mysqli_query($conectar,"INSERT INTO tbl_productos(codigo,nombre,tipo,unidad de uso,stock,usuario asociado,cantidad pedida,precio,imagen producto,fecha de modicación,) VALUES (".$id_producto.",'".$nom_producto."',".$categoria_producto.",".$unidad_uso.",".$cant_stock.",".$usu_asociado.",".$precio_producto.",".$img_producto.",".$fecha_mod.");";);
        }

           catch(Exception $e){
            mysqli_close($conectar);
            echo utf8_encode('{"error: ":' . $e->getMessage() . '}');
    }

}


