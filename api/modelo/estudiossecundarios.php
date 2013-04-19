<?php

//Insertar en Tabla ESTUDIOSSECUNDARIOS
function InsertarEstudiosSecundarios(){
    $request = Slim::getInstance()->request();
    $inscripcion = json_decode($request->getBody());
    $fecha=date("d-m-Y");

    try{
        $conexion = new conexionBD();
        $conn = $conexion->conectar();
        $sql = "INSERT INTO ESTUDIOSSECUNDARIOS (ASPI_ID, INST_CODIGOSNP, ESSE_FECHATERMINACION, ESSE_SNP, ESSE_PUNTAJEOBTENIDO,
        ESSE_FECHAPRESENTOPRUEBAS, ESSE_FECHACAMBIO, ESSE_REGISTRADOPOR)
        VALUES(".$inscripcion->ASPI_ID.",'".$inscripcion->INST_CODIGOSNP."','".$inscripcion->ESSE_FECHATERMINACION_S."','".$inscripcion->ESSE_SNP."',".$inscripcion->ESSE_PUNTAJEOBTENIDO.",'".$inscripcion->ESSE_FECHAPRESENTOPRUEBAS_S."','".$fecha."','".$inscripcion->ASPI_NUMERODOCUMENTO."')";
        //echo utf8_encode('{"datos5": ' . json_encode($sql) . '}');
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

/*function InsertarAspirante(){
    $request = Slim::getInstance()->request();
    $inscripcion = json_decode($request->getBody());
    $fecha=date("d-m-Y");
    echo utf8_encode('{"datos1": ' . json_encode($inscripcion) . '}');
    try{
        $conexion = new conexionBD();
        $conn = $conexion->conectar();
        $sql = "INSERT INTO ACADEMICO.ASPIRANTE (ASPI_PRIMERAPELLIDO,ASPI_SEGUNDOAPELLIDO,ASPI_PRIMERNOMBRE,ASPI_SEGUNDONOMBRE,ASPI_TIPODOCUMENTO, ASPI_NUMERODOCUMENTO,ASPI_SEXO,ASPI_PAISRESIDENCIA,ASPI_DPTORESIDENCIA,ASPI_MPIORESIDENCIA,ASPI_TELEFONORESIDENCIA,ASPI_TELEFONOCELULAR,ASPI_EMAIL,ASPI_FECHANACIMIENTO,ASPI_PAISNACIMIENTO,ASPI_DPTONACIMIENTO,ASPI_MPIONACIMIENTO,ASPI_FECHACAMBIO,ESCG_ID,ASPI_REGISTRADOPOR,MEDI_IDCONOCEINSTITUCION,JORN_ID,JORN_ID2, CIRC_ID,NIED_ID)
        VALUES('".$inscripcion->ASPI_PRIMERAPELLIDO."','".$inscripcion->ASPI_SEGUNDOAPELLIDO."','".$inscripcion->ASPI_PRIMERNOMBRE."','".$inscripcion->ASPI_SEGUNDONOMBRE."',".$inscripcion->TIDG_ID.
            ",'".$inscripcion->ASPI_NUMERODOCUMENTO."','".$inscripcion->ASPI_SEXO."','".$inscripcion->PAGE_ID2."','".$inscripcion->DEGE_ID2."','".$inscripcion->CIGE_ID2."','".$inscripcion->ASPI_TELEFONORESIDENCIA.
            "','".$inscripcion->ASPI_TELEFONOCELULAR."','".$inscripcion->ASPI_EMAIL."','".$inscripcion->ASPI_FECHANACIMIENTO_S."','".$inscripcion->PAGE_ID."','".$inscripcion->DEGE_ID."','".$inscripcion->CIGE_ID.
            "','".$fecha."',".$inscripcion->ESCG_ID.",'".$inscripcion->ASPI_NUMERODOCUMENTO."',".$inscripcion->OMED_ID.",".$inscripcion->JORN_ID.",".$inscripcion->JORN_ID2.",".$inscripcion->CIRC_ID.",".$inscripcion->NIED_ID.")";
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
    }*/