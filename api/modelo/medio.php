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
        //$cont=1;
        while (OCIFetch($query))
        {
            if (ociresult($query,"OMED_DESCRIPCION") <> 'OTRO')
                {
                    $fila = array(
                        "OMED_ID" => ociresult($query, "OMED_ID"),
                        "OMED_DESCRIPCION" => ociresult($query, "OMED_DESCRIPCION")
                    );
                    array_push($resultados, $fila);
                    //$cont=$cont+1;
                }

            else{
                $temp = array(
                    "OMED_ID" => ociresult($query, "OMED_ID"),
                    "OMED_DESCRIPCION" => ociresult($query, "OMED_DESCRIPCION")
                );
            }
        }
        array_push($resultados,$temp);
        echo utf8_encode('{"datos": ' . json_encode($resultados) . '}');
        //echo '{"datos": "contraseña"}';

        OCILogoff($conn);

    }
    catch(Exception $e){
        OCILogoff($conn);
        echo '{"error: ":' . $e->getMessage() . '}';
    }
}