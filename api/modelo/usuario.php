<?php
//Buscar Usuarios
function BuscarUsuario($usua_usuario, $usua_contraseña){
    try{
        $resultados = array();
        $conexion = new conexionBD();
        $conn = $conexion->conectarPosgresql();
        $sql = "SELECT usuario.usua_id, usuario.usua_documento, usuario.pege_id, usuario.usua_nombre, usuario.usua_usuario, usuario.usua_contrasena, usuariorol.rol_id FROM (vortal.rol INNER JOIN vortal.usuariorol ON vortal.rol.rol_id = vortal.usuariorol.rol_id) INNER JOIN general.usuario ON vortal.usuariorol.usua_id = general.usuario.usua_id WHERE (((usuario.usua_usuario)='".$usua_usuario."') AND ((usuario.usua_contrasena)='".$usua_contraseña."') AND ((usuariorol.rol_id)=124));";
        $result =pg_query ($conn, $sql);
        //echo utf8_encode('{"datos": ' . json_encode($sql) . '}');
        if (pg_num_rows($result)>0) {
            while ($row = pg_fetch_array($result)) {
                $fila = array(
                    "usua_id" => $row["usua_id"],
                    "pege_id" => $row["pege_id"],
                    "usua_nombre" => $row["usua_nombre"],
                    "usua_usuario" => $row["usua_usuario"],
                    "usua_contrasena" => $row["usua_contrasena"]

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