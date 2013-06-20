<?php

//Insertar en Tabla ESTUDIOSSECUNDARIOS
function InsertarExperienciaProfesional(){
    $request = Slim::getInstance()->request();
    $inscripcion = json_decode($request->getBody());
    $fecha=date("d/m/Y");

    try{
        $conexion = new conexionBD();
        $conn = $conexion->conectar();
        $sql = "INSERT INTO ACADEMICO.EXPERIENCIAPROFESIONAL (ASPI_ID,EXPR_INSTITUCION,EXPR_CARGO,EXPR_FECHACAMBIO,EXPR_REGISTRADOPOR,EXPR_TELEFONOTRABAJO) VALUES(".$inscripcion->ASPI_ID.",'".$inscripcion->EXPR_INSTITUCION."','".$inscripcion->EXPR_CARGO."',TO_DATE('".$fecha."','DD/MM/RRRR'),'".$inscripcion->ASPI_NUMERODOCUMENTO."','".$inscripcion->EXPR_TELEFONOTRABAJO."')";
        //echo utf8_encode('{"datos5": ' . json_encode($sql) . '}');
        $query =OCIParse($conn, $sql);
        OCIExecute($query, OCI_DEFAULT);
        OCICommit($conn);
        OCILogoff($conn);
        echo '{"mensaje: ":"ExitoExpePro"}';
    }
    catch(Exception $e){
        OCILogoff($conn);
        echo '{"error: ":' . $e->getMessage() . '}';
    }
}