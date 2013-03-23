<?php

//Listar Tipo Documento
function tipodocumentoListar(){
    try{
        $resultados = array();
        $conexion = new conexionBD();
        $conn = $conexion->conectar();
        $sql = "SELECT GENERAL.TIPODOCUMENTOGENERAL.TIDG_ID, GENERAL.TIPODOCUMENTOGENERAL.TIDG_DESCRIPCION FROM GENERAL.TIPODOCUMENTOGENERAL ORDER BY GENERAL.TIPODOCUMENTOGENERAL.TIDG_ID";
        $query =OCIParse($conn, $sql);
        OCIExecute($query, OCI_DEFAULT);
        while (OCIFetch($query))
        {
            $fila = array(
                "TIDG_ID" => ociresult($query, "TIDG_ID"),
                "TIDG_DESCRIPCION" => ociresult($query, "TIDG_DESCRIPCION")
            );
            array_push($resultados, $fila);
        }

        echo '{"datos": ' . json_encode($resultados) . '}';

        OCILogoff($conn);

    }
    catch(Exception $e){
        OCILogoff($conn);
        echo '{"error: ":' . $e->getMessage() . '}';
    }
}