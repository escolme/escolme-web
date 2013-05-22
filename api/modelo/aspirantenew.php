<?php
//Buscar existe aspirante
function BuscarExisteAspirante($ASPI_NUMERODOCUMENTO, $NIED_ID){
    try{
        $resultados = array();
        $conexion = new conexionBD();
        $conn = $conexion->conectar();
        $sql = "SELECT ACADEMICO.ASPIRANTE.ASPI_NUMERODOCUMENTO, ACADEMICO.ASPIRANTE.ASPI_ID,ACADEMICO.ASPIRANTE.NIED_ID FROM ACADEMICO.ASPIRANTE WHERE ASPI_NUMERODOCUMENTO='".$ASPI_NUMERODOCUMENTO."' AND NIED_ID=".$NIED_ID;
        $query =OCIParse($conn, $sql);
        OCIExecute($query, OCI_DEFAULT);
        while (OCIFetch($query))
        {
            $fila = array(
                "ASPI_ID" => ociresult($query, "ASPI_ID"),
                "ASPI_NUMERODOCUMENTO" => ociresult($query, "ASPI_NUMERODOCUMENTO"),
                "NIED_ID" => ociresult($query, "NIED_ID")
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
//Buscar existe inscripcion
function BuscarExisteInscripcion($ASPI_NUMERODOCUMENTO){
    try{
        $resultados = array();
        $conexion = new conexionBD();
        $conn = $conexion->conectar();
        $sql = "SELECT ACADEMICO.ASPIRANTE.ASPI_ID, ACADEMICO.ASPIRANTE.ASPI_NUMERODOCUMENTO, ACADEMICO.CONVOCATORIAINSCRIPCION.COIN_ESTADO, ACADEMICO.FORMULARIOINSCRIPCION.FOIN_ESTADOADMISION FROM (ACADEMICO.CIRCUNSCRIPCIONXUNIDADPROGRAMA INNER JOIN ACADEMICO.CONVOCATORIAINSCRIPCION ON ACADEMICO.CIRCUNSCRIPCIONXUNIDADPROGRAMA.COIN_ID = ACADEMICO.CONVOCATORIAINSCRIPCION.COIN_ID) INNER JOIN ((((((ACADEMICO.PROGRAMAXFORMULARIO INNER JOIN ACADEMICO.FORMULARIOINSCRIPCION ON ACADEMICO.PROGRAMAXFORMULARIO.FOIN_ID = ACADEMICO.FORMULARIOINSCRIPCION.FOIN_ID) INNER JOIN (ACADEMICO.ASPIRANTE INNER JOIN ACADEMICO.CIRCUNSCRIPCION ON ACADEMICO.ASPIRANTE.CIRC_ID = ACADEMICO.CIRCUNSCRIPCION.CIRC_ID) ON ACADEMICO.FORMULARIOINSCRIPCION.ASPI_ID = ACADEMICO.ASPIRANTE.ASPI_ID) INNER JOIN ACADEMICO.UNIDADPROGRAMA ON ACADEMICO.PROGRAMAXFORMULARIO.UNPR_ID = ACADEMICO.UNIDADPROGRAMA.UNPR_ID) INNER JOIN ACADEMICO.PROGRAMA ON ACADEMICO.UNIDADPROGRAMA.PROG_ID = ACADEMICO.PROGRAMA.PROG_ID) INNER JOIN ACADEMICO.SERVICIOPERIODO ON ACADEMICO.FORMULARIOINSCRIPCION.SEPE_ID = ACADEMICO.SERVICIOPERIODO.SEPE_ID) INNER JOIN ACADEMICO.PERIODOUNIVERSIDAD ON ACADEMICO.SERVICIOPERIODO.PEUN_ID = ACADEMICO.PERIODOUNIVERSIDAD.PEUN_ID) ON (ACADEMICO.CONVOCATORIAINSCRIPCION.UNPR_ID = ACADEMICO.UNIDADPROGRAMA.UNPR_ID) AND (ACADEMICO.CIRCUNSCRIPCIONXUNIDADPROGRAMA.CIRC_ID = ACADEMICO.CIRCUNSCRIPCION.CIRC_ID) AND (ACADEMICO.CONVOCATORIAINSCRIPCION.PEUN_ID = ACADEMICO.PERIODOUNIVERSIDAD.PEUN_ID) GROUP BY ACADEMICO.ASPIRANTE.ASPI_ID, ACADEMICO.ASPIRANTE.ASPI_NUMERODOCUMENTO, ACADEMICO.CONVOCATORIAINSCRIPCION.COIN_ESTADO, ACADEMICO.FORMULARIOINSCRIPCION.FOIN_ESTADOADMISION HAVING (((ACADEMICO.CONVOCATORIAINSCRIPCION.COIN_ESTADO)='ABIERTA') AND ((ACADEMICO.ASPIRANTE.ASPI_NUMERODOCUMENTO)='".$ASPI_NUMERODOCUMENTO."'))";
        $query =OCIParse($conn, $sql);
        OCIExecute($query, OCI_DEFAULT);
        while (OCIFetch($query))
        {
            $fila = array(
                "ASPI_ID" => ociresult($query, "ASPI_ID"),
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

//Insertar en Tabla ASPIRANTE
function InsertarAspirante(){
    $request = Slim::getInstance()->request();
    $inscripcion = json_decode($request->getBody());
    $fecha=date("d/m/Y");
    //echo utf8_encode('{"datos1": ' . json_encode($inscripcion) . '}');
    try{
        $conexion = new conexionBD();
        $conn = $conexion->conectar();
        $sql = "INSERT INTO ACADEMICO.ASPIRANTE (ASPI_PRIMERAPELLIDO,ASPI_SEGUNDOAPELLIDO,ASPI_PRIMERNOMBRE,ASPI_SEGUNDONOMBRE,ASPI_TIPODOCUMENTO, ASPI_NUMERODOCUMENTO,ASPI_SEXO,ASPI_PAISRESIDENCIA,ASPI_DPTORESIDENCIA,ASPI_MPIORESIDENCIA,ASPI_TELEFONORESIDENCIA,ASPI_TELEFONOCELULAR,ASPI_EMAIL,ASPI_FECHANACIMIENTO,ASPI_PAISNACIMIENTO,ASPI_DPTONACIMIENTO,ASPI_MPIONACIMIENTO,ASPI_FECHACAMBIO,ESCG_ID,ASPI_REGISTRADOPOR,MEDI_IDCONOCEINSTITUCION,CIRC_ID,NIED_ID) VALUES('".$inscripcion->ASPI_PRIMERAPELLIDO."','".$inscripcion->ASPI_SEGUNDOAPELLIDO."','".$inscripcion->ASPI_PRIMERNOMBRE."','".$inscripcion->ASPI_SEGUNDONOMBRE."',".$inscripcion->TIDG_ID.",'".$inscripcion->ASPI_NUMERODOCUMENTO."','".$inscripcion->ASPI_SEXO."','".$inscripcion->PAGE_ID2."','".$inscripcion->DEGE_ID2."','".$inscripcion->CIGE_ID2."','".$inscripcion->ASPI_TELEFONORESIDENCIA."','".$inscripcion->ASPI_TELEFONOCELULAR."','".$inscripcion->ASPI_EMAIL."','".$inscripcion->ASPI_FECHANACIMIENTO_S."','".$inscripcion->PAGE_ID."','".$inscripcion->DEGE_ID."','".$inscripcion->CIGE_ID."','".$fecha."',".$inscripcion->ESCG_ID.",'".$inscripcion->ASPI_NUMERODOCUMENTO."',".$inscripcion->OMED_ID.",".$inscripcion->CIRC_ID.",".$inscripcion->NIED_ID.")";
        echo utf8_encode('{"datos": ' . json_encode($sql) . '}');
        $query =OCIParse($conn, $sql);
        OCIExecute($query, OCI_DEFAULT);
        OCICommit($conn);
        OCILogoff($conn);
        //echo '{"mensaje: ":"ExitoAspirante"}';
    }
    catch(Exception $e){
        OCILogoff($conn);
        echo '{"error: ":' . $e->getMessage() . '}';
    }
}