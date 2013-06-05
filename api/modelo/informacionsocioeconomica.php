<?php

//Insertar en Tabla INFORMACIONSOCIOECONOMICA
function InsertarInformacionSocioeconomica(){
    $request = Slim::getInstance()->request();
    $inscripcion = json_decode($request->getBody());
    $fecha=date("d/m/Y");
    try{
        $conexion = new conexionBD();
        $conn = $conexion->conectar();
        $sql = "INSERT INTO ACADEMICO.INFORMACIONSOCIOECONOMICA(ASPI_ID, INSO_FECHACAMBIO, INSO_REGISTRADOPOR ,INSO_ESTRATO) VALUES(".$inscripcion->ASPI_ID.",TO_DATE('".$fecha."','DD/MM/RRRR'),'".$inscripcion->ASPI_NUMERODOCUMENTO."',".$inscripcion->ESTR_ID.")";
        //echo utf8_encode('{"datos1-": ' . json_encode($sql) . '}');
        $query =OCIParse($conn, $sql);
        OCIExecute($query, OCI_DEFAULT);
        OCICommit($conn);
        OCILogoff($conn);
        echo '{"mensaje: ":"ExitoSocio"}';
    }
    catch(Exception $e){
        OCILogoff($conn);
        echo '{"error: ":' . $e->getMessage() . '}';
    }
}