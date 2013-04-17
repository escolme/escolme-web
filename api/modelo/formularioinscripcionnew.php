<?php
//Insertar en Tabla FORMULARIOINSCRIPCIONNEW
function InsertarFormulario($inscripcion){
    try{
        $conexion = new conexionBD();
        $conn = $conexion->conectar();
        $sql = "INSERT INTO FORMULARIOINSCRIPCIONNEW (ASPI_ID, FOIN_PROGRAMAADMITIDO, FOIN_MEDIOINSCRIPCION, FOIN_FECHAHORAVERIFICACION, FOIN_REGISTRADOPOR, FOIN_FECHACAMBIO, TIIN_ID, SEPE_ID) VALUES(:dato1, :dato2, :dato3, :dato4, :dato5, :dato6, :dato7, :dato8)";
        $query =OCIParse($conn, $sql);
        OCIBindByName($query, ":dato1",'');
        OCIBindByName($query, ":dato2",'');
        OCIBindByName($query, ":dato3",'');
        OCIBindByName($query, ":dato4",'');
        OCIBindByName($query, ":dato5",'');
        OCIBindByName($query, ":dato6",'');
        OCIBindByName($query, ":dato7",'');
        OCIBindByName($query, ":dato8",'');
        OCIExecute($query, OCI_DEFAULT);
        OCICommit($conn);
        OCILogoff($conn);
    }
    catch(Exception $e){
        OCILogoff($conn);
        echo '{"error: ":' . $e->getMessage() . '}';
    }
}