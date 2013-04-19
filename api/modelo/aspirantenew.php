<?php
//Buscar existe aspirante
function BuscarExisteAspirante($ASPI_NUMERODOCUMENTO){
    try{
        $resultados = array();
        $conexion = new conexionBD();
        $conn = $conexion->conectar();
        $sql = "SELECT ACADEMICO.ASPIRANTE.ASPI_NUMERODOCUMENTO, ACADEMICO.ASPIRANTE.ASPI_ID FROM ACADEMICO.ASPIRANTE WHERE ASPI_NUMERODOCUMENTO='".$ASPI_NUMERODOCUMENTO."'";
        $query =OCIParse($conn, $sql);
        OCIExecute($query, OCI_DEFAULT);
        while (OCIFetch($query))
        {
            $fila = array(
                "ASPI_NUMERODOCUMENTO" => ociresult($query, "ASPI_NUMERODOCUMENTO"),
                "ASPI_ID" => ociresult($query, "ASPI_ID")
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
/*function BuscarExisteInscripcion(){
    try{
        $resultados = array();
        $conexion = new conexionBD();
        $conn = $conexion->conectar();
        $sql = "SELECT ACADEMICO.FORMULARIOINSCRIPCION.ASPI_ID, ACADEMICO.FORMULARIOINSCRIPCION.FOIN_ID, ACADEMICO.PROGRAMAXFORMULARIO.PRXF_ID, ACADEMICO.PROGRAMAXFORMULARIO.COIN_ID FROM ACADEMICO.FORMULARIOINSCRIPCION INNER JOIN ACADEMICO.PROGRAMAXFORMULARIO ON ACADEMICO.FORMULARIOINSCRIPCION.FOIN_ID = ACADEMICO.PROGRAMAXFORMULARIO.FOIN_ID";
        $query =OCIParse($conn, $sql);
        OCIExecute($query, OCI_DEFAULT);
        while (OCIFetch($query))
        {
            $fila = array(
                "ASPI_ID" => ociresult($query, "ASPI_ID")
            );
            array_push($resultados, $fila);
        }
        //echo utf8_encode('{"datos": ' . json_encode($resultados) . '}');
        OCILogoff($conn);
    }
    catch(Exception $e){
        OCILogoff($conn);
        echo '{"error: ":' . $e->getMessage() . '}';
    }
}*/

//Insertar en Tabla ASPIRANTE
function InsertarAspirante(){
    $request = Slim::getInstance()->request();
    $inscripcion = json_decode($request->getBody());
    $fecha=date("d-m-Y");
    //echo utf8_encode('{"datos1": ' . json_encode($inscripcion) . '}');
    try{
        $conexion = new conexionBD();
        $conn = $conexion->conectar();
        $sql = "INSERT INTO ACADEMICO.ASPIRANTE (ASPI_PRIMERAPELLIDO,ASPI_SEGUNDOAPELLIDO,ASPI_PRIMERNOMBRE,ASPI_SEGUNDONOMBRE,ASPI_TIPODOCUMENTO, ASPI_NUMERODOCUMENTO,ASPI_SEXO,ASPI_PAISRESIDENCIA,ASPI_DPTORESIDENCIA,ASPI_MPIORESIDENCIA,ASPI_TELEFONORESIDENCIA,ASPI_TELEFONOCELULAR,ASPI_EMAIL,ASPI_FECHANACIMIENTO,ASPI_PAISNACIMIENTO,ASPI_DPTONACIMIENTO,ASPI_MPIONACIMIENTO,ASPI_FECHACAMBIO,ESCG_ID,ASPI_REGISTRADOPOR,MEDI_IDCONOCEINSTITUCION,CIRC_ID,NIED_ID)
        VALUES('".$inscripcion->ASPI_PRIMERAPELLIDO."','".$inscripcion->ASPI_SEGUNDOAPELLIDO."','".$inscripcion->ASPI_PRIMERNOMBRE."','".$inscripcion->ASPI_SEGUNDONOMBRE."',".$inscripcion->TIDG_ID.
        ",'".$inscripcion->ASPI_NUMERODOCUMENTO."','".$inscripcion->ASPI_SEXO."','".$inscripcion->PAGE_ID2."','".$inscripcion->DEGE_ID2."','".$inscripcion->CIGE_ID2."','".$inscripcion->ASPI_TELEFONORESIDENCIA.
        "','".$inscripcion->ASPI_TELEFONOCELULAR."','".$inscripcion->ASPI_EMAIL."','".$inscripcion->ASPI_FECHANACIMIENTO_S."','".$inscripcion->PAGE_ID."','".$inscripcion->DEGE_ID."','".$inscripcion->CIGE_ID.
        "','".$fecha."',".$inscripcion->ESCG_ID.",'".$inscripcion->ASPI_NUMERODOCUMENTO."',".$inscripcion->OMED_ID.",".$inscripcion->CIRC_ID.",".$inscripcion->NIED_ID.")";
        //echo utf8_encode('{"datos1-": ' . json_encode($sql) . '}');
        //$query =OCIParse($conn, $sql);
        //OCIExecute($query, OCI_DEFAULT);
        //OCICommit($conn);
        OCILogoff($conn);
        echo '{"mensaje: ":"Exito"}';
    }
    catch(Exception $e){
        OCILogoff($conn);
        echo '{"error: ":' . $e->getMessage() . '}';
    }
}