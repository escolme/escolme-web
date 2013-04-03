<?php

//Listar Dpto
function departamentoListar($PAGE_ID){
    try{
        $resultados = array();
        $conexion = new conexionBD();
        $conn = $conexion->conectar();
        $sql = "SELECT GENERAL.PAISGENERAL.PAGE_ID, GENERAL.DEPARTAMENTOGENERAL.DEGE_ID, GENERAL.DEPARTAMENTOGENERAL.DEGE_NOMBRE FROM  GENERAL.DEPARTAMENTOGENERAL INNER JOIN GENERAL.PAISGENERAL ON GENERAL.DEPARTAMENTOGENERAL.PAGE_ID = GENERAL.PAISGENERAL.PAGE_ID WHERE GENERAL.PAISGENERAL.PAGE_ID='".$PAGE_ID."' ORDER BY GENERAL.DEPARTAMENTOGENERAL.DEGE_NOMBRE";
        $query =OCIParse($conn, $sql);
        OCIExecute($query, OCI_DEFAULT);
        while (OCIFetch($query))
        {
            $fila = array(
                "DEGE_ID" => ociresult($query, "DEGE_ID"),
                "DEGE_NOMBRE" => ociresult($query, "DEGE_NOMBRE")
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