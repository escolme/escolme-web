<?php

//Listar Estado Civil
function estadocivilListar(){
    try{
        $resultados = array();
        $conexion = new conexionBD();
        $conn = $conexion->conectar();
        $sql = "SELECT GENERAL.ESTADOCIVILGENERAL.ESCG_ID, GENERAL.ESTADOCIVILGENERAL.ESCG_DESCRIPCION FROM GENERAL.ESTADOCIVILGENERAL";
        $query =OCIParse($conn, $sql);
        OCIExecute($query, OCI_DEFAULT);
        while (OCIFetch($query))
        {
            $fila = array(
                "ESCG_ID" => ociresult($query, "ESCG_ID"),
                "ESCG_DESCRIPCION" => ociresult($query, "ESCG_DESCRIPCION")
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