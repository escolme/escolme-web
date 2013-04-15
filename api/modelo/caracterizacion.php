<?php

//Insertar en Tabla CARACTERIZACION
function InsertarCaracterizacion($inscripcion){
    try{
        $conexion = new conexionBD();
        $conn = $conexion->conectar();
        $sql = "INSERT INTO CARACTERIZACIONNEW (ASPI_ID, CARA_REGISTRADOPOR, CARA_FECHACAMBIO) VALUES(:dato1, :dato2, :dato3)";
        $query =OCIParse($conn, $sql);
        OCIBindByName($query, ":dato1",'');
        OCIBindByName($query, ":dato2",'');
        OCIBindByName($query, ":dato3",'');
        OCIExecute($query, OCI_DEFAULT);
        OCICommit($conn);
        OCILogoff($conn);
    }
    catch(Exception $e){
        OCILogoff($conn);
        echo '{"error: ":' . $e->getMessage() . '}';
    }
}