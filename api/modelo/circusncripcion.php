<?php
//ACTUALIZAR TABLA CIRCUNSCRIPCION
function ActualizarCircunscripcion($CIRC_ID, $ASPI_ID){
    $request = Slim::getInstance()->request();
    $inscripcion = json_decode($request->getBody());
    try{
        $conexion = new conexionBD();
        $conn = $conexion->conectar();
        $sql = "UPDATE ACADEMICO.ASPIRANTE SET CIRC_ID=".$CIRC_ID." WHERE ASPI_ID=".$ASPI_ID;
        //echo utf8_encode('{"datos2-": ' . json_encode($sql) . '}');
        $query =OCIParse($conn, $sql);
        OCIExecute($query, OCI_DEFAULT);
        OCICommit($conn);
        OCILogoff($conn);
        echo '{"mensaje: ":"ExitoFormula"}';
    }
    catch(Exception $e){
        OCILogoff($conn);
        echo '{"error: ":' . $e->getMessage() . '}';
    }
}