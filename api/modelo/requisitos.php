<?php
//Buscar existe aspirante
function ListarRequisitos($clasifi){
    try{
        $resultados = array();
        $conexion = new conexionBD();
        $conn = $conexion->conectar();
        $sql = "SELECT ACADEMICO.REQUISITONEW.REQU_ID, ACADEMICO.REQUISITONEW.REQU_DESCRIPCION, ACADEMICO.REQUISITONEW.REQU_CLASIFICACION FROM ACADEMICO.REQUISITONEW WHERE ACADEMICO.REQUISITONEW.REQU_CLASIFICACION=".$clasifi."ORDER BY ACADEMICO.REQUISITONEW.REQU_ID";
        $query =OCIParse($conn, $sql);
        OCIExecute($query, OCI_DEFAULT);
        while (OCIFetch($query))
        {
            $fila = array(
                "REQU_ID" => ociresult($query, "REQU_ID"),
                "REQU_DESCRIPCION" => ociresult($query, "REQU_DESCRIPCION"),
                "REQU_ENTREGADO" => false
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

function InsertarRequisitoAspirante(){
    $request = Slim::getInstance()->request();
    $clasificacion = json_decode($request->getBody());
    $fecha=date("d/m/Y");
    try{
        $conexion = new conexionBD();
        $conn = $conexion->conectar();
        $sql = "INSERT INTO REQUISITOASPIRANTENEW (REAS_ID,REAS_OBSERVACIONES,FOIN_ID,REAS_CLASIFICACION,USUA_ID,REAS_FECHAREGISTRO) VALUES(".$clasificacion->FOIN_ID.",'".$clasificacion->REAS_OBSERVACIONES."',".$clasificacion->FOIN_ID.",".$clasificacion->REQU_CLASIFICACION.",".$clasificacion->USUA_ID.",TO_DATE('".$fecha."','DD/MM/RRRR'))";
        //echo utf8_encode('{"insertInRe": ' . json_encode($sql) . '}');
        $query =OCIParse($conn, $sql);
        OCIExecute($query, OCI_DEFAULT);
        OCICommit($conn);
        OCILogoff($conn);
        echo '{"mensaje: ":"ExitoRequisito"}';
    }
    catch(Exception $e){
        OCILogoff($conn);
        echo '{"error: ":' . $e->getMessage() . '}';
    }
}

function InsertarRequisitosEntregados(){
    $request = Slim::getInstance()->request();
    $clasificacion = json_decode($request->getBody());
    //echo utf8_encode('{"dato": ' . json_encode($clasificacion->REEN_ENTREGRADO) . '}');
    try{
        $conexion = new conexionBD();
        $conn = $conexion->conectar();
        $sql = "INSERT INTO REQUISITOSENTREGADOSNEW (REAS_ID, REEN_ENTREGADO, REQU_ID, REEN_ID) VALUES(".$clasificacion->FOIN_ID.",".$clasificacion->REEN_ENTREGADO.",".$clasificacion->REQU_ID.",".$clasificacion->REEN_ID.")";
        //echo utf8_encode('{"insertInReEntre": ' . json_encode($sql) . '}');
        $query =OCIParse($conn, $sql);
        OCIExecute($query, OCI_DEFAULT);
        OCICommit($conn);
        OCILogoff($conn);
        echo '{"mensaje: ":"ExitoRequisitoEntre"}';
    }
    catch(Exception $e){
        OCILogoff($conn);
        echo '{"error: ":' . $e->getMessage() . '}';
    }
}

function ListarAspiranteRequisitos(){
    try{
        $resultados = array();
        $conexion = new conexionBD();
        $conn = $conexion->conectar();
        $sql = "SELECT ACADEMICO.FORMULARIOINSCRIPCION.FOIN_ID, ACADEMICO.FORMULARIOINSCRIPCION.FOIN_ESTADOADMISION, ACADEMICO.ASPIRANTE.ASPI_PRIMERAPELLIDO, ACADEMICO.ASPIRANTE.ASPI_SEGUNDOAPELLIDO, ACADEMICO.ASPIRANTE.ASPI_PRIMERNOMBRE, ACADEMICO.ASPIRANTE.ASPI_SEGUNDONOMBRE, ACADEMICO.ASPIRANTE.ASPI_NUMERODOCUMENTO, ACADEMICO.PROGRAMAXFORMULARIO.PRXF_PRIORIDAD, ACADEMICO.PROGRAMA.PROG_NOMBRE, ACADEMICO.PERIODOUNIVERSIDAD.PEUN_ANO, ACADEMICO.PERIODOUNIVERSIDAD.PEUN_PERIODO, ACADEMICO.CONVOCATORIAINSCRIPCION.COIN_ESTADO FROM ACADEMICO.REQUISITOSENTREGADOSNEW INNER JOIN (ACADEMICO.PERIODOUNIVERSIDAD INNER JOIN (((((ACADEMICO.FORMULARIOINSCRIPCION INNER JOIN ACADEMICO.ASPIRANTE ON ACADEMICO.FORMULARIOINSCRIPCION.ASPI_ID = ACADEMICO.ASPIRANTE.ASPI_ID) INNER JOIN ACADEMICO.PROGRAMAXFORMULARIO ON ACADEMICO.FORMULARIOINSCRIPCION.FOIN_ID = ACADEMICO.PROGRAMAXFORMULARIO.FOIN_ID) INNER JOIN ACADEMICO.UNIDADPROGRAMA ON ACADEMICO.PROGRAMAXFORMULARIO.UNPR_ID = ACADEMICO.UNIDADPROGRAMA.UNPR_ID) INNER JOIN ACADEMICO.PROGRAMA ON ACADEMICO.UNIDADPROGRAMA.PROG_ID = ACADEMICO.PROGRAMA.PROG_ID) INNER JOIN ACADEMICO.CONVOCATORIAINSCRIPCION ON ACADEMICO.UNIDADPROGRAMA.UNPR_ID = ACADEMICO.CONVOCATORIAINSCRIPCION.UNPR_ID) ON ACADEMICO.PERIODOUNIVERSIDAD.PEUN_ID = ACADEMICO.CONVOCATORIAINSCRIPCION.PEUN_ID) ON ACADEMICO.REQUISITOSENTREGADOSNEW.REAS_ID = ACADEMICO.FORMULARIOINSCRIPCION.FOIN_ID GROUP BY ACADEMICO.FORMULARIOINSCRIPCION.FOIN_ID, ACADEMICO.FORMULARIOINSCRIPCION.FOIN_ESTADOADMISION, ACADEMICO.ASPIRANTE.ASPI_PRIMERAPELLIDO, ACADEMICO.ASPIRANTE.ASPI_SEGUNDOAPELLIDO, ACADEMICO.ASPIRANTE.ASPI_PRIMERNOMBRE, ACADEMICO.ASPIRANTE.ASPI_SEGUNDONOMBRE, ACADEMICO.ASPIRANTE.ASPI_NUMERODOCUMENTO, ACADEMICO.PROGRAMAXFORMULARIO.PRXF_PRIORIDAD, ACADEMICO.PROGRAMA.PROG_NOMBRE, ACADEMICO.PERIODOUNIVERSIDAD.PEUN_ANO, ACADEMICO.PERIODOUNIVERSIDAD.PEUN_PERIODO, ACADEMICO.CONVOCATORIAINSCRIPCION.COIN_ESTADO HAVING (((ACADEMICO.FORMULARIOINSCRIPCION.FOIN_ESTADOADMISION)='ADMITIDO') AND ((ACADEMICO.PROGRAMAXFORMULARIO.PRXF_PRIORIDAD)='1') AND ((ACADEMICO.CONVOCATORIAINSCRIPCION.COIN_ESTADO)='ABIERTA')) ORDER BY ACADEMICO.PROGRAMA.PROG_NOMBRE";
        $query =OCIParse($conn, $sql);
        OCIExecute($query, OCI_DEFAULT);
        while (OCIFetch($query))
        {
            $fila = array(
                "FOIN_ID" => ociresult($query, "FOIN_ID"),
                "ASPI_PRIMERAPELLIDO" => ociresult($query, "ASPI_PRIMERAPELLIDO"),
                "ASPI_SEGUNDOAPELLIDO" => ociresult($query, "ASPI_SEGUNDOAPELLIDO"),
                "ASPI_PRIMERNOMBRE" => ociresult($query, "ASPI_PRIMERNOMBRE"),
                "ASPI_SEGUNDONOMBRE" => ociresult($query, "ASPI_SEGUNDONOMBRE"),
                "ASPI_NUMERODOCUMENTO" => ociresult($query, "ASPI_NUMERODOCUMENTO"),
                "PROG_NOMBRE" => ociresult($query, "PROG_NOMBRE")

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