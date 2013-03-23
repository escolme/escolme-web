<?php

//Listar programas por metologia
function programasListar($METO_ID){
    try{
        $resultados = array();
        $conexion = new conexionBD();
        $conn = $conexion->conectar();
        $sql = "SELECT ACADEMICO.CIRCUNSCRIPCION.CIRC_ID, ACADEMICO.CIRCUNSCRIPCIONXUNIDADPROGRAMA.COIN_ID, ACADEMICO.CONVOCATORIAINSCRIPCION.COIN_ESTADO, ACADEMICO.PERIODOUNIVERSIDAD.PEUN_ID, ACADEMICO.UNIDADPROGRAMA.UNPR_ID, ACADEMICO.PROGRAMA.PROG_ID, ACADEMICO.PROGRAMA.PROG_NOMBRE, ACADEMICO.PERIODOUNIVERSIDAD.PEUN_ANO, ACADEMICO.PERIODOUNIVERSIDAD.PEUN_PERIODO, ACADEMICO.PROGRAMA.MODA_ID, ACADEMICO.MODALIDAD.MODA_DESCRIPCION, ACADEMICO.PROGRAMA.METO_ID, ACADEMICO.METODOLOGIA.METO_DESCRIPCION FROM ACADEMICO.PERIODOUNIVERSIDAD INNER JOIN ((ACADEMICO.CONVOCATORIAINSCRIPCION INNER JOIN (((ACADEMICO.UNIDADPROGRAMA INNER JOIN ACADEMICO.PROGRAMA ON ACADEMICO.UNIDADPROGRAMA.PROG_ID = ACADEMICO.PROGRAMA.PROG_ID) INNER JOIN ACADEMICO.METODOLOGIA ON ACADEMICO.PROGRAMA.METO_ID = ACADEMICO.METODOLOGIA.METO_ID) INNER JOIN ACADEMICO.MODALIDAD ON ACADEMICO.PROGRAMA.MODA_ID = ACADEMICO.MODALIDAD.MODA_ID) ON ACADEMICO.CONVOCATORIAINSCRIPCION.UNPR_ID = ACADEMICO.UNIDADPROGRAMA.UNPR_ID) INNER JOIN (ACADEMICO.CIRCUNSCRIPCIONXUNIDADPROGRAMA INNER JOIN ACADEMICO.CIRCUNSCRIPCION ON ACADEMICO.CIRCUNSCRIPCIONXUNIDADPROGRAMA.CIRC_ID = ACADEMICO.CIRCUNSCRIPCION.CIRC_ID) ON ACADEMICO.CONVOCATORIAINSCRIPCION.COIN_ID = ACADEMICO.CIRCUNSCRIPCIONXUNIDADPROGRAMA.COIN_ID) ON ACADEMICO.PERIODOUNIVERSIDAD.PEUN_ID = ACADEMICO.CONVOCATORIAINSCRIPCION.PEUN_ID WHERE (((ACADEMICO.CONVOCATORIAINSCRIPCION.COIN_ESTADO)='ABIERTA')) AND ACADEMICO.METODOLOGIA.METO_ID=".$METO_ID." ORDER BY ACADEMICO.PERIODOUNIVERSIDAD.PEUN_ANO";
        $query =OCIParse($conn, $sql);
        OCIExecute($query, OCI_DEFAULT);
        while (OCIFetch($query))
        {
            $fila = array(
                "PROG_ID" => ociresult($query, "PROG_ID"),
                "PROG_NOMBRE" => ociresult($query, "PROG_NOMBRE")
            );
            array_push($resultados, $fila);
        }

        echo '{"datos": ' . json_encode($resultados) . '}';

        OCICommit($conn);
        OCILogoff($conn);

    }
    catch(Exception $e){
        OCILogoff($conn);
        echo '{"error: ":' . $e->getMessage() . '}';
    }

}