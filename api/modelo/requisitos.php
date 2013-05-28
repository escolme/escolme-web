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