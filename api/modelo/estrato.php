<?php

//Listar Estrato
function estratoListar(){
    try{
        $resultados = array();
        $conexion = new conexionBD();
        $conn = $conexion->conectar();
        $sql = "SELECT ACADEMICO.ESTRATO.ESTR_ID, ACADEMICO.ESTRATO.ESTR_DESCRIPCION FROM ACADEMICO.ESTRATO ORDER BY ESTR_ID";
        $query =OCIParse($conn, $sql);
        OCIExecute($query, OCI_DEFAULT);
        while (OCIFetch($query))
        {
            $fila = array(
                "ESTR_ID" => ociresult($query, "ESTR_ID"),
                "ESTR_DESCRIPCION" => ociresult($query, "ESTR_DESCRIPCION")
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