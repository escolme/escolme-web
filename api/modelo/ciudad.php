<?php

//Listar Mpio
function ciudadListar($DEGE_ID){
    try{
        $resultados = array();
        $conexion = new conexionBD();
        $conn = $conexion->conectar();
        $sql = "SELECT GENERAL.DEPARTAMENTOGENERAL.DEGE_ID, GENERAL.CIUDADGENERAL.CIGE_ID, GENERAL.CIUDADGENERAL.CIGE_NOMBRE FROM GENERAL.CIUDADGENERAL INNER JOIN GENERAL.DEPARTAMENTOGENERAL ON GENERAL.CIUDADGENERAL.DEGE_ID = GENERAL.DEPARTAMENTOGENERAL.DEGE_ID WHERE GENERAL.DEPARTAMENTOGENERAL.DEGE_ID='".$DEGE_ID."' ORDER BY GENERAL.CIUDADGENERAL.CIGE_NOMBRE";
        $query =OCIParse($conn, $sql);
        OCIExecute($query, OCI_DEFAULT);
        while (OCIFetch($query))
        {
            $fila = array(
                "CIGE_ID" => ociresult($query, "CIGE_ID"),
                "CIGE_NOMBRE" => ociresult($query, "CIGE_NOMBRE")
            );
            array_push($resultados, $fila);
        }

        echo utf8_encode('{"datos": ' . json_encode($resultados) . '}');

        OCILogoff($conn);
    }
    catch(Exception $e){
        OCILogoff($conn);
        echo utf8_encode('{"error: ":' . $e->getMessage() . '}');
    }
}