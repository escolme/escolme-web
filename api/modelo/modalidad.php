<?php
/**
 * User: Jose Luis Orozco
 * Date: 15/03/13
 * Time: 11:23
 * Funciones de Acceso a Datos con la tabla modalidad del esquema modelo
 */

function modalidadListar(){
    $user="ACADEMICO";
    $pass="ACA0369";
    $db = "(DESCRIPTION=(ADDRESS_LIST = (ADDRESS = (PROTOCOL = TCP)(HOST = 10.10.1.12)(PORT = 1521)))(CONNECT_DATA=(SID=ESCOLME)))";
    $conn=OCILogon($user, $pass, $db);
    if (!$conn){
        echo "Conexion es invalida" . var_dump (OCIError());
        die();
    }

    $query = "SELECT ACADEMICO.CONVOCATORIAINSCRIPCION.COIN_ESTADO, ACADEMICO.PROGRAMA.METO_ID, ACADEMICO.METODOLOGIA.METO_DESCRIPCION " +
"FROM ACADEMICO.PERIODOUNIVERSIDAD INNER JOIN ((ACADEMICO.CONVOCATORIAINSCRIPCION INNER JOIN (((ACADEMICO.UNIDADPROGRAMA INNER JOIN ACADEMICO.PROGRAMA ON ACADEMICO.UNIDADPROGRAMA.PROG_ID=ACADEMICO.PROGRAMA.PROG_ID) INNER JOIN ACADEMICO.METODOLOGIA ON ACADEMICO.PROGRAMA.METO_ID=ACADEMICO.METODOLOGIA.METO_ID) INNER JOIN ACADEMICO.MODALIDAD ON ACADEMICO.PROGRAMA.MODA_ID=ACADEMICO.MODALIDAD.MODA_ID) ON ACADEMICO.CONVOCATORIAINSCRIPCION.UNPR_ID=ACADEMICO.UNIDADPROGRAMA.UNPR_ID) INNER JOIN (ACADEMICO.CIRCUNSCRIPCIONXUNIDADPROGRAMA INNER JOIN ACADEMICO.CIRCUNSCRIPCION ON ACADEMICO.CIRCUNSCRIPCIONXUNIDADPROGRAMA.CIRC_ID=ACADEMICO.CIRCUNSCRIPCION.CIRC_ID) ON ACADEMICO.CONVOCATORIAINSCRIPCION.COIN_ID=ACADEMICO.CIRCUNSCRIPCIONXUNIDADPROGRAMA.COIN_ID) ON ACADEMICO.PERIODOUNIVERSIDAD.PEUN_ID=ACADEMICO.CONVOCATORIAINSCRIPCION.PEUN_ID " +
"GROUP BY ACADEMICO.CONVOCATORIAINSCRIPCION.COIN_ESTADO, ACADEMICO.PROGRAMA.METO_ID, ACADEMICO.METODOLOGIA.METO_DESCRIPCION " +
"HAVING (((ACADEMICO.CONVOCATORIAINSCRIPCION.COIN_ESTADO)='ABIERTA'));";

    OCIExecute($query);

    $nrows = oci_fetch_all($query, $filas);

    echo '{"datos": ' . json_encode($filas) . '}';
    OCICommit($conn);
    OCILogoff($conn);
}