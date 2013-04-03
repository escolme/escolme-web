<?php

//Listar Pais
function paisListar(){
    try{
        $resultados = array();
        $conexion = new conexionBD();
        $conn = $conexion->conectar();
        $sql = "SELECT GENERAL.PAISGENERAL.PAGE_ID, GENERAL.PAISGENERAL.PAGE_NOMBRE FROM GENERAL.PAISGENERAL ORDER BY GENERAL.PAISGENERAL.PAGE_NOMBRE";
        $query =OCIParse($conn, $sql);
        OCIExecute($query, OCI_DEFAULT);
        while (OCIFetch($query))
        {
            $fila = array(
                "PAGE_ID" => ociresult($query, "PAGE_ID"),
                "PAGE_NOMBRE" => ociresult($query, "PAGE_NOMBRE")
            );
            array_push($resultados, $fila);
        }

        echo utf8_encode('{"datos": ' . json_encode($resultados) . '}');

        OCILogoff($conn);
    }
    catch(Exception $e){
        OCILogoff($conn);
        echo '{"error: ":' . $e->getMessage() . '}';
    }
}