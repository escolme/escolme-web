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
        $query =OCIParse($conn, $sql);
        OCIExecute($query, OCI_DEFAULT);
        OCICommit($conn);
        OCILogoff($conn);
        echo '{"mensaje: ":"ExitoEstuSecun"}';
    }
    catch(Exception $e){
        OCILogoff($conn);
        echo '{"error: ":' . $e->getMessage() . '}';
    }
}