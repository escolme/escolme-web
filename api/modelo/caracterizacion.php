<?php

//Insertar en Tabla CARACTERIZACION
function InsertarCaracterizacion(){
    $request = Slim::getInstance()->request();
    $inscripcion = json_decode($request->getBody());
    $fecha=date("d-m-Y");
    try{
        $conexion = new conexionBD();
        $conn = $conexion->conectar();
        $sql = "INSERT INTO ACADEMICO.CARACTERIZACION (ASPI_ID, CARA_REGISTRADOPOR, CARA_FECHACAMBIO) VALUES(".$inscripcion->ASPI_ID.",'".$inscripcion->ASPI_NUMERODOCUMENTO."','".$fecha."')";
        //echo utf8_encode('{"datos4": ' . json_encode($sql) . '}');
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
