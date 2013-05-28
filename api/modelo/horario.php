<?php

//Listar Horario
function horarioListar(){
    try{
        $resultados = array();
        $conexion = new conexionBD();
        $conn = $conexion->conectar();
        $sql = "SELECT JORN_ID, JORN_DESCRIPCION FROM JORNADANEW";
        $query =OCIParse($conn, $sql);
        OCIExecute($query, OCI_DEFAULT);
        while (OCIFetch($query))
        {
            $fila = array(
                "JORN_ID" => ociresult($query, "JORN_ID"),
                "JORN_DESCRIPCION" => ociresult($query, "JORN_DESCRIPCION")
            );
            array_push($resultados, $fila);
        }

        echo utf8_encode('{"datos": ' . json_encode($resultados) . '}');
        //echo '{"datos": "contraseña"}';

        OCILogoff($conn);

    }
    catch(Exception $e){
        OCILogoff($conn);
        echo '{"error: ":' . $e->getMessage() . '}';
    }
}