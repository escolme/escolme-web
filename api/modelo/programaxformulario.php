<?php
//Insertar en Tabla PROGRAMAXFORMULARIO
function InsertarPrograma(){
    $request = Slim::getInstance()->request();
    $inscripcion = json_decode($request->getBody());
    $fecha=date("d-m-Y");
    //echo utf8_encode('{"datos3": ' . json_encode($inscripcion) . '}');
    try{
        $conexion = new conexionBD();
        $conn = $conexion->conectar();
        $sql = "INSERT INTO PROGRAMAXFORMULARIO (PRXF_PRIORIDAD, FOIN_ID, PRXF_PUNTAJEOBTENIDO, PRXF_PUESTO, PRXF_FECHACAMBIO,UNPR_ID, COIN_ID, PRXF_REGISTRADOPOR)
        VALUES('1',".$inscripcion->FOIN_ID.",0,0,'".$fecha."',".$inscripcion->UNPR_ID.",".$inscripcion->COIN_ID.",'".$inscripcion->ASPI_NUMERODOCUMENTO."')";
        //$query =OCIParse($conn, $sql);
        //OCIExecute($query, OCI_DEFAULT);
       //OCICommit($conn);
        OCILogoff($conn);

        $sql = "INSERT INTO PROGRAMAXFORMULARIO (PRXF_PRIORIDAD, FOIN_ID, PRXF_PUNTAJEOBTENIDO, PRXF_PUESTO, PRXF_FECHACAMBIO, UNPR_ID, COIN_ID, PRXF_REGISTRADOPOR,JORN_ID,JORND_ID2)
        VALUES('2',".$inscripcion->FOIN_ID.",0,0,'".$fecha."',".$inscripcion->UNPR_ID2.",".$inscripcion->COIN_ID2.",'".$inscripcion->ASPI_NUMERODOCUMENTO."',".$inscripcion->JORN_ID.",".$inscripcion->JORN_ID2.")";
        $conn = $conexion->conectar();
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