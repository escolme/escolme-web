<?php
//Insertar en Tabla FORMULARIOINSCRIPCION
function InsertarFormulario(){
    $request = Slim::getInstance()->request();
    $inscripcion = json_decode($request->getBody());
    //echo utf8_encode('{"datos2": ' . json_encode($inscripcion) . '}');
    $fecha=date("d-m-Y");
    try{
        $conexion = new conexionBD();
        $conn = $conexion->conectar();
        $sql = "INSERT INTO ACADEMICO.FORMULARIOINSCRIPCION (ASPI_ID, FOIN_PROGRAMAADMITIDO, FOIN_MEDIOINSCRIPCION,FOIN_FECHAHORAVERIFICACION, FOIN_REGISTRADOPOR, FOIN_FECHACAMBIO, TIIN_ID,FOIN_ESTADOADMISION ,SEPE_ID)VALUES(".$inscripcion->ASPI_ID.",'0','ON LINE','".$fecha."','".$inscripcion->ASPI_NUMERODOCUMENTO."','".$fecha."',1,'PREINSCRITO',".$inscripcion->SEPE_ID.")";
        //echo utf8_encode('{"datos2-": ' . json_encode($sql) . '}');
        $query =OCIParse($conn, $sql);
        OCIExecute($query, OCI_DEFAULT);
        OCICommit($conn);
        OCILogoff($conn);
        echo '{"mensaje: ":"ExitoFormula"}';
    }
    catch(Exception $e){
        OCILogoff($conn);
        echo '{"error: ":' . $e->getMessage() . '}';
    }
}

function BuscarExisteFormulario($ASPI_ID){
        try{
        $resultados = array();
        $conexion = new conexionBD();
        $conn = $conexion->conectar();
        $sql = "SELECT ACADEMICO.ASPIRANTE.ASPI_ID, ACADEMICO.ASPIRANTE.ASPI_NUMERODOCUMENTO, ACADEMICO.CONVOCATORIAINSCRIPCION.COIN_ESTADO, ACADEMICO.FORMULARIOINSCRIPCION.FOIN_ESTADOADMISION, ACADEMICO.FORMULARIOINSCRIPCION.FOIN_ID FROM (ACADEMICO.CONVOCATORIAINSCRIPCION INNER JOIN (((ACADEMICO.FORMULARIOINSCRIPCION INNER JOIN ACADEMICO.ASPIRANTE ON ACADEMICO.FORMULARIOINSCRIPCION.ASPI_ID = ACADEMICO.ASPIRANTE.ASPI_ID) INNER JOIN ACADEMICO.SERVICIOPERIODO ON ACADEMICO.FORMULARIOINSCRIPCION.SEPE_ID = ACADEMICO.SERVICIOPERIODO.SEPE_ID) INNER JOIN ACADEMICO.PERIODOUNIVERSIDAD ON ACADEMICO.SERVICIOPERIODO.PEUN_ID = ACADEMICO.PERIODOUNIVERSIDAD.PEUN_ID) ON ACADEMICO.CONVOCATORIAINSCRIPCION.PEUN_ID = ACADEMICO.PERIODOUNIVERSIDAD.PEUN_ID) INNER JOIN ACADEMICO.CIRCUNSCRIPCION ON ACADEMICO.ASPIRANTE.CIRC_ID = ACADEMICO.CIRCUNSCRIPCION.CIRC_ID GROUP BY ACADEMICO.ASPIRANTE.ASPI_ID, ACADEMICO.ASPIRANTE.ASPI_NUMERODOCUMENTO, ACADEMICO.CONVOCATORIAINSCRIPCION.COIN_ESTADO, ACADEMICO.FORMULARIOINSCRIPCION.FOIN_ESTADOADMISION, ACADEMICO.FORMULARIOINSCRIPCION.FOIN_ID HAVING (((ACADEMICO.CONVOCATORIAINSCRIPCION.COIN_ESTADO)='ABIERTA') AND ((ACADEMICO.ASPIRANTE.ASPI_ID)=".$ASPI_ID."))";
        $query =OCIParse($conn, $sql);
        OCIExecute($query, OCI_DEFAULT);
        while (OCIFetch($query))
        {
            $fila = array(
                "ASPI_ID" => ociresult($query, "ASPI_ID"),
                "FOIN_ID" => ociresult($query, "FOIN_ID")
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

function ActualizarEstadoFormulario($FOIN_ID){
    try{
        $conexion = new conexionBD();
        $conn = $conexion->conectar();
        $sql = "UPDATE ACADEMICO.FORMULARIOINSCRIPCION SET FOIN_ESTADOADMISION='INSCRITO' WHERE ACADEMICO.FORMULARIOINSCRIPCION.FOIN_ID=".$FOIN_ID;
        //echo utf8_encode('{"update": ' . json_encode($sql) . '}');
        $query =OCIParse($conn, $sql);
        OCIExecute($query, OCI_DEFAULT);
        OCICommit($conn);
        OCILogoff($conn);
        echo '{"mensaje: ":"ExitoUpdate"}';
    }
    catch(Exception $e){
        OCILogoff($conn);
        echo '{"error: ":' . $e->getMessage() . '}';
    }
}

function ActualizarFormularioEntrevista($LLAMADO, $FOIN_ID2){
    try{
        $conexion = new conexionBD();
        $conn = $conexion->conectar();
        $sql = "UPDATE ACADEMICO.FORMULARIOINSCRIPCION SET LLAM_ID=".$LLAMADO.", FOIN_ESTADOADMISION='ADMITIDO' WHERE FOIN_ID=".$FOIN_ID2;
        //echo utf8_encode('{"datos": ' . json_encode($sql) . '}');
        $query =OCIParse($conn, $sql);
        OCIExecute($query, OCI_DEFAULT);
        OCICommit($conn);
        OCILogoff($conn);
        echo '{"mensaje: ":"ExitoFormEntrevista"}';
    }
    catch(Exception $e){
        OCILogoff($conn);
        echo '{"error: ":' . $e->getMessage() . '}';
    }
}