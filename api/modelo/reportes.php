<?php
//Buscar existe aspirante
function Preinscritos(){
    try{
        $resultados = array();
        $conexion = new conexionBD();
        $conn = $conexion->conectar();
        $sql = "";
        $query =OCIParse($conn, $sql);
        OCIExecute($query, OCI_DEFAULT);
        while (OCIFetch($query))
        {
            $fila = array(
                "ASPI_ID" => ociresult($query, "ASPI_ID"),
                "FOIN_ID" => ociresult($query, "FOIN_ID"),
                "ASPI_NUMERODOCUMENTO" => ociresult($query, "ASPI_NUMERODOCUMENTO")
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