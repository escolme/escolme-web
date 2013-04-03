<?php

//Listar Medio Conocio Institución
function medioListar(){
    try{
        $resultados = array();
        $conexion = new conexionBD();
        $conn = $conexion->conectar();
        $sql = "SELECT ACADEMICO.OTROMEDIODIVULGACION.OMED_ID, ACADEMICO.OTROMEDIODIVULGACION.OMED_DESCRIPCION FROM ACADEMICO.OTROMEDIODIVULGACION ORDER BY OMED_DESCRIPCION";
        $query =OCIParse($conn, $sql);
        OCIExecute($query, OCI_DEFAULT);
        while (OCIFetch($query))
        {
            $fila = array(
                "OMED_ID" => ociresult($query, "OMED_ID"),
                "OMED_DESCRIPCION" => ociresult($query, "OMED_DESCRIPCION")
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