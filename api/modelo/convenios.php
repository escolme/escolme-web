<?php
function InsertarConvenio(){
    $request = Slim::getInstance()->request();
    $convenio = json_decode($request->getBody());
    $fecha=date("d/m/Y");
    //echo utf8_encode('{"datos1": ' . json_encode($inscripcion) . '}');
    try{
        $conexion = new conexionBD();
        $conn = $conexion->conectar();
        $sql = "INSERT INTO ACADEMICO.CONVENIONEW (CONV_NOMBRE,CONV_REGION,PROG_ID,METO_ID,CONV_CANTIDAD,CATE_ID,CONV_FECHAACTUALIZACION,PEUN_ID)VALUES('".$convenio->CONV_NOMBRE."','".$convenio->CONV_REGION."',".$convenio->PROG_ID.",".$convenio->METO_ID.",".$convenio->CONV_CANTIDAD.",".$convenio->CATE_ID.",TO_DATE('".$fecha."','DD/MM/RRRR'),".$convenio->PEUN_ID.")";
        //echo utf8_encode('{"datos": ' . json_encode($sql) . '}');
        $query =OCIParse($conn, $sql);
        OCIExecute($query, OCI_DEFAULT);
        OCICommit($conn);
        OCILogoff($conn);
        echo '{"mensaje: ":"ExitoConvenio"}';
    }
    catch(Exception $e){
        OCILogoff($conn);
        echo '{"error: ":' . $e->getMessage() . '}';
    }
}

function BuscarProgramaConvenio(){
    try{
        $resultados = array();
        $conexion = new conexionBD();
        $conn = $conexion->conectar();
        $sql = "SELECT ACADEMICO.PROGRAMA.PROG_ID,ACADEMICO.PROGRAMA.PROG_NOMBRE, ACADEMICO.PROGRAMA.PROG_CODIGOPROGRAMA, ACADEMICO.PROGRAMA.PROG_FECHAAPROBACIONICFES FROM ACADEMICO.PROGRAMA WHERE ACADEMICO.PROGRAMA.PROG_ESTADO=1 ORDER BY PROG_NOMBRE";
        $query =OCIParse($conn, $sql);
        OCIExecute($query, OCI_DEFAULT);
        while (OCIFetch($query))
        {
            $fila = array(
                "PROG_ID" => ociresult($query, "PROG_ID"),
                "PROG_NOMBRE" => ociresult($query, "PROG_NOMBRE"),
                "PROG_CODIGOPROGRAMA" => ociresult($query, "PROG_CODIGOPROGRAMA")
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

function BuscarPeriodoConvenio(){
    try{
        $resultados = array();
        $conexion = new conexionBD();
        $conn = $conexion->conectar();
        $sql = "SELECT ACADEMICO.PERIODOUNIVERSIDAD.PEUN_ID, ACADEMICO.PERIODOUNIVERSIDAD.PEUN_ANO ||'-'|| ACADEMICO.PERIODOUNIVERSIDAD.PEUN_PERIODO ||' '||ACADEMICO.TIPOPERIODOACADEMICO.TPPA_DESCRIPCION as PERIODO FROM (ACADEMICO.MATRICULAACADEMICA INNER JOIN ACADEMICO.PERIODOUNIVERSIDAD ON ACADEMICO.MATRICULAACADEMICA.PEUN_ID = ACADEMICO.PERIODOUNIVERSIDAD.PEUN_ID) INNER JOIN ACADEMICO.TIPOPERIODOACADEMICO ON ACADEMICO.PERIODOUNIVERSIDAD.TPPA_ID = ACADEMICO.TIPOPERIODOACADEMICO.TPPA_ID GROUP BY ACADEMICO.PERIODOUNIVERSIDAD.PEUN_ID, ACADEMICO.PERIODOUNIVERSIDAD.PEUN_ANO, ACADEMICO.PERIODOUNIVERSIDAD.PEUN_PERIODO, ACADEMICO.TIPOPERIODOACADEMICO.TPPA_DESCRIPCION";
        $query =OCIParse($conn, $sql);
        OCIExecute($query, OCI_DEFAULT);
        while (OCIFetch($query))
        {
            $fila = array(
                "PEUN_ID" => ociresult($query, "PEUN_ID"),
                "PERIODO" => ociresult($query, "PERIODO")
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

function ListarConvenios(){
    try{
        $resultados = array();
        $conexion = new conexionBD();
        $conn = $conexion->conectar();
        $sql = "SELECT ACADEMICO.CONVENIONEW.CONV_ID, ACADEMICO.CONVENIONEW.CONV_NOMBRE, ACADEMICO.CONVENIONEW.CONV_REGION, ACADEMICO.CONVENIONEW.CONV_CANTIDAD, ACADEMICO.PROGRAMA.PROG_NOMBRE, ACADEMICO.METODOLOGIA.METO_DESCRIPCION, ACADEMICO.CATEGORIA.CATE_DESCRIPCION, ACADEMICO.CONVENIONEW.CONV_FECHAACTUALIZACION FROM ACADEMICO.MATRICULAACADEMICA INNER JOIN (ACADEMICO.CATEGORIA INNER JOIN ((ACADEMICO.PROGRAMA INNER JOIN ACADEMICO.CONVENIONEW ON ACADEMICO.PROGRAMA.PROG_ID = ACADEMICO.CONVENIONEW.PROG_ID) INNER JOIN ACADEMICO.METODOLOGIA ON ACADEMICO.CONVENIONEW.METO_ID = ACADEMICO.METODOLOGIA.METO_ID) ON ACADEMICO.CATEGORIA.CATE_ID = ACADEMICO.CONVENIONEW.CATE_ID) ON ACADEMICO.MATRICULAACADEMICA.PEUN_ID = ACADEMICO.CONVENIONEW.PEUN_ID GROUP BY ACADEMICO.CONVENIONEW.CONV_ID, ACADEMICO.CONVENIONEW.CONV_NOMBRE, ACADEMICO.CONVENIONEW.CONV_REGION, ACADEMICO.CONVENIONEW.CONV_CANTIDAD, ACADEMICO.PROGRAMA.PROG_NOMBRE, ACADEMICO.METODOLOGIA.METO_DESCRIPCION, ACADEMICO.CATEGORIA.CATE_DESCRIPCION, ACADEMICO.CONVENIONEW.CONV_FECHAACTUALIZACION";
        $query =OCIParse($conn, $sql);
        OCIExecute($query, OCI_DEFAULT);
        while (OCIFetch($query))
        {
            $fila = array(
                "CONV_ID" => ociresult($query, "CONV_ID"),
                "CONV_NOMBRE" => ociresult($query, "CONV_NOMBRE"),
                "CONV_REGION" => ociresult($query, "CONV_REGION"),
                "CONV_CANTIDAD" => ociresult($query, "CONV_CANTIDAD"),
                "PROG_NOMBRE" => ociresult($query, "PROG_NOMBRE"),
                "METO_DESCRIPCION" => ociresult($query, "METO_DESCRIPCION"),
                "CATE_DESCRIPCION" => ociresult($query, "CATE_DESCRIPCION"),
                "CONV_FECHAACTUALIZACION" => ociresult($query, "CONV_FECHAACTUALIZACION"),
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