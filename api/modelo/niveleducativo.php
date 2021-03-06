<?php

//Listar Nivel Educativo
function niveleducativoListar($METO_ID){
    try{
        $resultados = array();
        $conexion = new conexionBD();
        $conn = $conexion->conectar();
        $sql = "SELECT ACADEMICO.CONVOCATORIAINSCRIPCION.COIN_ESTADO, ACADEMICO.NIVELEDUCATIVO.NIED_ID, ACADEMICO.NIVELEDUCATIVO.NIED_DESCRIPCION, ACADEMICO.METODOLOGIA.METO_ID FROM ((ACADEMICO.SERVICIOPERIODO INNER JOIN (ACADEMICO.SERVICIOPROGRAMA INNER JOIN ACADEMICO.PERIODOPROGRAMAUNIDAD ON ACADEMICO.SERVICIOPROGRAMA.PEPU_ID = ACADEMICO.PERIODOPROGRAMAUNIDAD.PEPU_ID) ON ACADEMICO.SERVICIOPERIODO.SEPE_ID = ACADEMICO.SERVICIOPROGRAMA.SEPE_ID) INNER JOIN (ACADEMICO.PERIODOUNIVERSIDAD INNER JOIN ((ACADEMICO.CONVOCATORIAINSCRIPCION INNER JOIN (((ACADEMICO.UNIDADPROGRAMA INNER JOIN ACADEMICO.PROGRAMA ON ACADEMICO.UNIDADPROGRAMA.PROG_ID = ACADEMICO.PROGRAMA.PROG_ID) INNER JOIN ACADEMICO.METODOLOGIA ON ACADEMICO.PROGRAMA.METO_ID = ACADEMICO.METODOLOGIA.METO_ID) INNER JOIN ACADEMICO.MODALIDAD ON ACADEMICO.PROGRAMA.MODA_ID = ACADEMICO.MODALIDAD.MODA_ID) ON ACADEMICO.CONVOCATORIAINSCRIPCION.UNPR_ID = ACADEMICO.UNIDADPROGRAMA.UNPR_ID) INNER JOIN (ACADEMICO.CIRCUNSCRIPCIONXUNIDADPROGRAMA INNER JOIN ACADEMICO.CIRCUNSCRIPCION ON ACADEMICO.CIRCUNSCRIPCIONXUNIDADPROGRAMA.CIRC_ID = ACADEMICO.CIRCUNSCRIPCION.CIRC_ID) ON ACADEMICO.CONVOCATORIAINSCRIPCION.COIN_ID = ACADEMICO.CIRCUNSCRIPCIONXUNIDADPROGRAMA.COIN_ID) ON ACADEMICO.PERIODOUNIVERSIDAD.PEUN_ID = ACADEMICO.CONVOCATORIAINSCRIPCION.PEUN_ID) ON (ACADEMICO.SERVICIOPERIODO.PEUN_ID = ACADEMICO.PERIODOUNIVERSIDAD.PEUN_ID) AND (ACADEMICO.PERIODOPROGRAMAUNIDAD.UNPR_ID = ACADEMICO.UNIDADPROGRAMA.UNPR_ID)) INNER JOIN ACADEMICO.NIVELEDUCATIVO ON ACADEMICO.MODALIDAD.NIED_ID = ACADEMICO.NIVELEDUCATIVO.NIED_ID GROUP BY ACADEMICO.CONVOCATORIAINSCRIPCION.COIN_ESTADO, ACADEMICO.NIVELEDUCATIVO.NIED_ID, ACADEMICO.NIVELEDUCATIVO.NIED_DESCRIPCION, ACADEMICO.METODOLOGIA.METO_ID HAVING (((ACADEMICO.CONVOCATORIAINSCRIPCION.COIN_ESTADO)='ABIERTA') AND ((ACADEMICO.METODOLOGIA.METO_ID)=".$METO_ID."))";
        $query =OCIParse($conn, $sql);
        OCIExecute($query, OCI_DEFAULT);
        while (OCIFetch($query))
        {
            $fila = array(
                "NIED_ID" => ociresult($query, "NIED_ID"),
                "NIED_DESCRIPCION" => ociresult($query, "NIED_DESCRIPCION")
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